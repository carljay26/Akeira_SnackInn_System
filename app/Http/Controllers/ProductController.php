<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Product;
use App\Services\SnackInnNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $lowStockThreshold = (int) config('snack_inn.low_stock_threshold', 10);

        $products = Product::query()
            ->when($search, function ($query, $searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('category', 'like', "%{$searchTerm}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('product', compact('products', 'search', 'lowStockThreshold'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'action' => ActivityLog::ACTION_PRODUCT_CREATED,
            'subject_label' => $validated['name'],
        ]);

        return back()->with('status', 'Product created successfully.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, true);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'action' => ActivityLog::ACTION_PRODUCT_UPDATED,
            'subject_label' => $product->fresh()->name,
        ]);

        if ($request->user()) {
            SnackInnNotifier::notifyProductUpdated($request->user(), $product->fresh()->name);
            SnackInnNotifier::notifyLowStockIfNeeded($request->user(), $product->fresh());
        }

        return back()->with('status', 'Product updated successfully.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $name = $product->name;

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'action' => ActivityLog::ACTION_PRODUCT_DELETED,
            'subject_label' => $name,
        ]);

        if ($request->user()) {
            SnackInnNotifier::notifyProductRemoved($request->user(), $name);
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return back()->with('status', 'Product deleted successfully.');
    }

    private function validateProduct(Request $request, bool $isUpdate = false): array
    {
        $imageRules = $isUpdate ? ['nullable', 'image', 'max:3072'] : ['required', 'image', 'max:3072'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'image' => $imageRules,
        ]);
    }
}
