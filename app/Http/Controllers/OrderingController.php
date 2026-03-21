<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderingController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $category = $request->string('category')->toString();

        $products = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->when($search, function ($query, $searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('category', 'like', "%{$searchTerm}%");
            })
            ->when($category && $category !== 'all', fn ($query) => $query->where('category', $category))
            ->latest()
            ->get();

        $categories = Product::query()->select('category')->distinct()->orderBy('category')->pluck('category');
        $cart = $request->session()->get('cart', []);

        return view('ordering', compact('products', 'categories', 'cart', 'search', 'category'));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $cart = $request->session()->get('cart', []);
        $existingQty = $cart[$product->id]['quantity'] ?? 0;
        $newQty = $existingQty + $validated['quantity'];

        if ($newQty > $product->stock) {
            return back()->withErrors(['cart' => 'Quantity exceeds available stock.']);
        }

        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'quantity' => $newQty,
            'image_path' => $product->image_path,
            'unit' => $product->unit,
        ];

        $request->session()->put('cart', $cart);

        return back()->with('status', 'Added to cart.');
    }

    public function removeFromCart(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('status', 'Removed from cart.');
    }

    public function decrementFromCart(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (! isset($cart[$product->id])) {
            return back();
        }

        $cart[$product->id]['quantity'] = max(0, ((int) $cart[$product->id]['quantity']) - 1);

        if ($cart[$product->id]['quantity'] <= 0) {
            unset($cart[$product->id]);
        }

        $request->session()->put('cart', $cart);

        return back();
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (count($cart) === 0) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        DB::transaction(function () use ($request, $cart) {
            $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
            $tax = 0.00;
            $total = round($subtotal, 2);

            $order = Order::create([
                'user_id' => $request->user()->id,
                'reference' => 'AKR-' . now()->format('YmdHis') . random_int(100, 999),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'ordered_at' => now(),
            ]);

            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);

                if ($item['quantity'] > $product->stock) {
                    throw new \RuntimeException("Insufficient stock for {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $item['price'] * $item['quantity'],
                ]);
            }

            Notification::create([
                'user_id' => $request->user()->id,
                'title' => 'Order placed',
                'message' => "Order {$order->reference} has been placed successfully.",
            ]);
        });

        $request->session()->forget('cart');

        return redirect()->route('order-queue.index')->with('status', 'Order placed successfully.');
    }
}
