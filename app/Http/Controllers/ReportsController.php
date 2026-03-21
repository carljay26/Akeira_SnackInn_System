<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function index(Request $request): View
    {
        $selectedMonth = (int) $request->integer('month');
        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = 0;
        }

        $applyMonthFilter = function ($query) use ($selectedMonth) {
            if ($selectedMonth > 0) {
                $query->whereMonth('created_at', $selectedMonth);
            }

            return $query;
        };

        $totalRevenue = $applyMonthFilter(Order::where('status', 'completed'))->sum('total');
        $avgOrderValue = (float) $applyMonthFilter(Order::query())->avg('total');
        $newCustomers = $applyMonthFilter(Order::query())->count();

        $totalUnits = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->when($selectedMonth > 0, fn ($q) => $q->whereMonth('orders.created_at', $selectedMonth))
            ->sum('order_items.quantity');

        $monthlySales = $applyMonthFilter(Order::select(
            DB::raw('DATE_FORMAT(created_at, "%b") as month'),
            DB::raw('SUM(total) as amount')
        ))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b")'))
            ->orderByRaw('MIN(created_at)')
            ->limit(6)
            ->get();

        $soldProductsQuery = fn () => OrderItem::query()
            ->select(
                'products.name',
                'products.category',
                DB::raw('SUM(order_items.quantity) as units_sold'),
                DB::raw('SUM(order_items.line_total) as revenue')
            )
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->when($selectedMonth > 0, fn ($q) => $q->whereMonth('orders.created_at', $selectedMonth))
            ->groupBy('products.id', 'products.name', 'products.category')
            ->orderByDesc('units_sold');

        $topProducts = $soldProductsQuery()->limit(10)->get();
        $allSoldProducts = $soldProductsQuery()->get();

        return view('reports', compact(
            'totalRevenue',
            'totalUnits',
            'avgOrderValue',
            'newCustomers',
            'monthlySales',
            'topProducts',
            'allSoldProducts',
            'selectedMonth'
        ));
    }
}
