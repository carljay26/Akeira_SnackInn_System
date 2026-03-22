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

        $shopId = $request->user()->shop_id;

        $shopProductQuery = Product::query()->where('shop_id', $shopId);

        $totalProducts = (clone $shopProductQuery)->count();
        $lowStockCount = (clone $shopProductQuery)
            ->where('stock', '<=', $lowStockThreshold)
            ->count();
        $categoryCount = (int) Product::query()
            ->where('shop_id', $shopId)
            ->selectRaw('COUNT(DISTINCT category) as aggregate')
            ->value('aggregate');

        $products = Product::query()
            ->where('shop_id', $shopId)
            ->when($search, function ($query, $searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('category', 'like', "%{$searchTerm}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $maxStock = max((int) (clone $shopProductQuery)->max('stock'), 1);

        return view('product', compact(
            'products',
            'search',
            'lowStockThreshold',
            'totalProducts',
            'lowStockCount',
            'categoryCount',
            'maxStock'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->storeProductImage($request);
        }

        Product::create(array_merge($validated, [
            'shop_id' => $request->user()->shop_id,
        ]));

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'action' => ActivityLog::ACTION_PRODUCT_CREATED,
            'subject_label' => $validated['name'],
        ]);

        return back()->with('status', 'Product created successfully.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        if ($product->shop_id !== $request->user()->shop_id) {
            abort(404);
        }

        $validated = $this->validateProduct($request, true);

        if ($request->hasFile('image')) {
            $this->deleteProductImageFile($product);
            $validated['image_path'] = $this->storeProductImage($request);
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
        if ($product->shop_id !== $request->user()->shop_id) {
            abort(404);
        }

        $name = $product->name;

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'action' => ActivityLog::ACTION_PRODUCT_DELETED,
            'subject_label' => $name,
        ]);

        if ($request->user()) {
            SnackInnNotifier::notifyProductRemoved($request->user(), $name);
        }

        $this->deleteProductImageFile($product);

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

    private function productImageDisk(): string
    {
        return config('snack_inn.product_images_disk', 'public');
    }

    private function storeProductImage(Request $request): string
    {
        $disk = $this->productImageDisk();

        $path = Storage::disk($disk)->putFile(
            'products',
            $request->file('image'),
            ['visibility' => 'public']
        );

        if ($path === false) {
            throw new \RuntimeException('Could not store product image.');
        }

        return $path;
    }

    private function deleteProductImageFile(Product $product): void
    {
        if (! $product->image_path || preg_match('#\Ahttps?://#i', $product->image_path)) {
            return;
        }

        Storage::disk($this->productImageDisk())->delete($product->image_path);
    }
}
