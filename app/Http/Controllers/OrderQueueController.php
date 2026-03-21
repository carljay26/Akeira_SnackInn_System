<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

        return view('order-queue', compact(
            'orders',
            'pendingInQueue',
            'pendingValue',
            'recentCompletedOrders',
            'recentRemovedOrders'
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
}
