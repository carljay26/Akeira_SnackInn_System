<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SnackInnNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderQueueController extends Controller
{
    public function index(Request $request): View
    {
        $userId = $request->user()->id;
        $search = $request->string('search')->toString();

        $pendingInQueue = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $pendingValue = (float) Order::where('user_id', $userId)->where('status', 'pending')->sum('total');

        $orders = Order::with(['items.product'])
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->when($search, fn ($q) => $q->where('reference', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $recentCompletedOrders = Order::query()
            ->with(['items.product'])
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->latest('completed_at')
            ->limit(5)
            ->get();

        $recentRemovedOrders = Order::query()
            ->with(['items.product'])
            ->where('user_id', $userId)
            ->where('status', 'removed')
            ->latest('removed_at')
            ->limit(5)
            ->get();

        $catalogProducts = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'unit', 'stock']);

        return view('order-queue', compact(
            'orders',
            'pendingInQueue',
            'pendingValue',
            'recentCompletedOrders',
            'recentRemovedOrders',
            'catalogProducts'
        ));
    }

    public function finishOrder(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()
                ->route('order-queue.index')
                ->with('status', 'This order is no longer in the queue.');
        }

        try {
            DB::transaction(function () use ($order, $request) {
                $order->load('items');
                foreach ($order->items as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item->product_id);
                    if ($item->quantity > $product->stock) {
                        throw new \RuntimeException(
                            "Cannot complete: not enough stock for “{$product->name}” (need {$item->quantity}, available {$product->stock})."
                        );
                    }
                    $product->decrement('stock', $item->quantity);
                    $product->refresh();
                    SnackInnNotifier::notifyLowStockIfNeeded($request->user(), $product);
                }

                $order->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            });
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('order-queue.index')
                ->withErrors(['stock' => $e->getMessage()]);
        }

        return redirect()
            ->route('order-queue.index')
            ->with('status', 'Order finished successfully.');
    }

    public function removeOrder(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($order->status === 'pending') {
            $order->update([
                'status' => 'removed',
                'removed_at' => now(),
            ]);
        }

        return redirect()
            ->route('order-queue.index')
            ->with('status', 'Order removed from queue. You can move it back anytime from Recent Removed.');
    }

    public function restoreOrder(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($order->status !== 'removed') {
            return redirect()->route('order-queue.index');
        }

        if ($order->items()->count() === 0) {
            return redirect()
                ->route('order-queue.index')
                ->withErrors(['restore' => 'This order no longer has line items and cannot be put back in the queue.']);
        }

        $order->update([
            'status' => 'pending',
            'removed_at' => null,
        ]);

        return redirect()
            ->route('order-queue.index')
            ->with('status', 'Order moved back to queue.');
    }

    public function addOrderItem(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()
                ->route('order-queue.index')
                ->withErrors(['add_item' => 'This order can no longer be modified.']);
        }

        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            DB::transaction(function () use ($order, $validated) {
                $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

                if (! $product->is_active || $product->stock < 1) {
                    throw new \RuntimeException('This product is not available.');
                }

                $addQty = (int) $validated['quantity'];
                $existing = OrderItem::query()
                    ->where('order_id', $order->id)
                    ->where('product_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    $newQty = (int) $existing->quantity + $addQty;
                    if ($newQty > (int) $product->stock) {
                        throw new \RuntimeException(
                            "Not enough stock for «{$product->name}». You already have {$existing->quantity} on this order; only {$product->stock} available."
                        );
                    }
                    $existing->quantity = $newQty;
                    $existing->line_total = round((float) $existing->unit_price * $newQty, 2);
                    $existing->save();
                } else {
                    if ($addQty > (int) $product->stock) {
                        throw new \RuntimeException("Not enough stock for «{$product->name}» (only {$product->stock} available).");
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $addQty,
                        'unit_price' => (float) $product->price,
                        'line_total' => round((float) $product->price * $addQty, 2),
                    ]);
                }

                $order->refresh()->load('items');
                $subtotal = (float) $order->items->sum('line_total');
                $order->subtotal = round($subtotal, 2);
                $order->tax = 0;
                $order->total = round($subtotal, 2);
                $order->save();
            });
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('order-queue.index')
                ->withErrors(['add_item' => $e->getMessage()]);
        }

        return redirect()
            ->route('order-queue.index')
            ->with('status', 'Item added to order.');
    }

    public function updateOrderItem(Request $request, Order $order, OrderItem $orderItem): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($orderItem->order_id !== $order->id) {
            abort(404);
        }

        if ($order->status !== 'pending') {
            return redirect()
                ->route('order-queue.index')
                ->withErrors(['quantity' => 'This order can no longer be edited.']);
        }

        $product = Product::query()->find($orderItem->product_id);
        if ($product === null) {
            return redirect()
                ->route('order-queue.index')
                ->withErrors(['quantity' => 'This product was removed from the catalog.']);
        }

        $maxQty = max(0, (int) $product->stock);
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $maxQty],
        ], [
            'quantity.max' => 'Quantity cannot exceed available stock ('.$maxQty.' for '.$product->name.').',
        ]);

        try {
            DB::transaction(function () use ($order, $orderItem, $validated) {
                $orderItem->quantity = $validated['quantity'];
                $orderItem->line_total = round((float) $orderItem->unit_price * (int) $orderItem->quantity, 2);
                $orderItem->save();

                $order->load('items');
                $subtotal = (float) $order->items->sum('line_total');
                $order->subtotal = round($subtotal, 2);
                $order->tax = 0;
                $order->total = round($subtotal, 2);
                $order->save();
            });
        } catch (\Throwable $e) {
            return redirect()
                ->route('order-queue.index')
                ->withErrors(['quantity' => 'Could not update line item. Please try again.']);
        }

        return redirect()
            ->route('order-queue.index')
            ->with('status', 'Item quantity updated.');
    }
}
