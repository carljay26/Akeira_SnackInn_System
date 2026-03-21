<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $businessTz = 'Asia/Manila';
        $todayLocal = Carbon::now($businessTz)->format('Y-m-d');
        $todayStartUtc = Carbon::createFromFormat('Y-m-d', $todayLocal, $businessTz)->startOfDay()->utc();
        $todayEndUtc = Carbon::createFromFormat('Y-m-d', $todayLocal, $businessTz)->endOfDay()->utc();

        $todayRevenue = Order::query()
            ->where('status', 'completed')
            ->where(function ($q) use ($todayStartUtc, $todayEndUtc) {
                $q->whereBetween('ordered_at', [$todayStartUtc, $todayEndUtc])
                    ->orWhereBetween('created_at', [$todayStartUtc, $todayEndUtc]);
            })
            ->sum('total');
        $activeOrders = Order::where('status', 'pending')->count();
        $totalSales = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->sum('order_items.quantity');
        $lowStockThreshold = (int) config('snack_inn.low_stock_threshold', 10);
        $lowStockItems = Product::where('stock', '<=', $lowStockThreshold)->count();

        $popularProducts = OrderItem::query()
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->groupBy('products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $orderRows = Order::with('user')
            ->latest()
            ->limit(15)
            ->get()
            ->map(function (Order $order) {
                $at = $order->ordered_at ?? $order->created_at;

                return [
                    'kind' => 'order',
                    'at' => $at instanceof Carbon ? $at : Carbon::parse($at),
                    'order' => $order,
                    'log' => null,
                ];
            });

        $logRows = ActivityLog::with('user')
            ->latest()
            ->limit(15)
            ->get()
            ->map(function (ActivityLog $log) {
                return [
                    'kind' => 'product_log',
                    'at' => $log->created_at,
                    'order' => null,
                    'log' => $log,
                ];
            });

        $recentActivity = $orderRows
            ->concat($logRows)
            ->sortByDesc(fn (array $row) => $row['at']->timestamp)
            ->take(5)
            ->values();

        return view('dashboard', compact(
            'todayRevenue',
            'activeOrders',
            'totalSales',
            'lowStockItems',
            'popularProducts',
            'recentActivity'
        ));
    }
}
