<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderingController extends Controller
{
    public function index(Request $request): View
    {
        $shopId = $request->user()->shop_id;
        $search = $request->string('search')->toString();
        $category = $request->string('category')->toString();

        $products = Product::query()
            ->where('shop_id', $shopId)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->when($search, function ($query, $searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('category', 'like', "%{$searchTerm}%");
            })
            ->when($category && $category !== 'all', fn ($query) => $query->where('category', $category))
            ->latest()
            ->get();

        $categories = Product::query()
            ->where('shop_id', $shopId)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        $cart = $request->session()->get('cart', []);

        return view('ordering', compact('products', 'categories', 'cart', 'search', 'category'));
    }

    public function addToCart(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::query()
            ->where('shop_id', $request->user()->shop_id)
            ->findOrFail($validated['product_id']);
        $cart = $request->session()->get('cart', []);
        $existingQty = $cart[$product->id]['quantity'] ?? 0;
        $newQty = $existingQty + $validated['quantity'];

        if ($newQty > $product->stock) {
            if ($this->shouldReturnCartJson($request)) {
                return response()->json(['ok' => false, 'message' => 'Quantity exceeds available stock.'], 422);
            }

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

        if ($this->shouldReturnCartJson($request)) {
            return $this->cartJsonResponse($request, 'Added to cart.');
        }

        return back()->with('status', 'Added to cart.');
    }

    public function removeFromCart(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        if ($product->shop_id !== $request->user()->shop_id) {
            abort(404);
        }

        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        if ($this->shouldReturnCartJson($request)) {
            return $this->cartJsonResponse($request, 'Removed from cart.');
        }

        return back()->with('status', 'Removed from cart.');
    }

    public function decrementFromCart(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        if ($product->shop_id !== $request->user()->shop_id) {
            abort(404);
        }

        $cart = $request->session()->get('cart', []);

        if (! isset($cart[$product->id])) {
            if ($this->shouldReturnCartJson($request)) {
                return $this->cartJsonResponse($request);
            }

            return back();
        }

        $cart[$product->id]['quantity'] = max(0, ((int) $cart[$product->id]['quantity']) - 1);

        if ($cart[$product->id]['quantity'] <= 0) {
            unset($cart[$product->id]);
        }

        $request->session()->put('cart', $cart);

        if ($this->shouldReturnCartJson($request)) {
            return $this->cartJsonResponse($request);
        }

        return back();
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (count($cart) === 0) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        $shopId = $request->user()->shop_id;
        foreach ($cart as $item) {
            $belongs = Product::query()
                ->where('shop_id', $shopId)
                ->whereKey($item['id'])
                ->exists();
            if (! $belongs) {
                return back()->withErrors(['cart' => 'Your cart contains an item that is not available for your shop. Clear the cart and try again.']);
            }
        }

        DB::transaction(function () use ($request, $cart) {
            $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
            $tax = 0.00;
            $total = round($subtotal, 2);

            $order = Order::create([
                'shop_id' => $request->user()->shop_id,
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

    private function shouldReturnCartJson(Request $request): bool
    {
        return $request->expectsJson() || $request->ajax();
    }

    private function cartJsonResponse(Request $request, ?string $message = null): JsonResponse
    {
        $cart = $request->session()->get('cart', []);
        $cartItems = collect($cart);
        $itemCount = (int) $cartItems->sum('quantity');
        $subtotal = $cartItems->sum(fn ($item) => $item['price'] * $item['quantity']);
        $total = round((float) $subtotal, 2);

        $viewData = compact('cartItems', 'itemCount', 'subtotal', 'total');

        return response()->json([
            'ok' => true,
            'message' => $message,
            'itemCount' => $itemCount,
            'subtotal' => $subtotal,
            'total' => $total,
            'fragments' => [
                'mobile' => $itemCount > 0 ? view('partials.ordering-mobile-cart-float', $viewData)->render() : '',
                'desktop' => view('partials.ordering-cart-panel', array_merge($viewData, [
                    'cartScrollClass' => 'flex-1 min-h-0 overflow-y-auto',
                ]))->render(),
            ],
        ]);
    }
}
