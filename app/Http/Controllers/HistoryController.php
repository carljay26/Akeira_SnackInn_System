<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(Request $request): View
    {
        $userId = $request->user()->id;
        $filterDate = $request->string('date')->toString();
        $search = $request->string('search')->toString();
        $businessTimezone = 'Asia/Manila';
        $dateRangeStart = null;
        $dateRangeEnd = null;

        $validDate = false;
        if ($filterDate !== '') {
            try {
                $filterDate = Carbon::createFromFormat('Y-m-d', $filterDate)->format('Y-m-d');
                $validDate = true;
                $dateRangeStart = Carbon::createFromFormat('Y-m-d', $filterDate, $businessTimezone)
                    ->startOfDay()
                    ->utc();
                $dateRangeEnd = Carbon::createFromFormat('Y-m-d', $filterDate, $businessTimezone)
                    ->endOfDay()
                    ->utc();
            } catch (\Throwable) {
                $filterDate = null;
            }
        } else {
            $filterDate = null;
        }

        $applyDateFilter = function ($query) use ($validDate, $dateRangeStart, $dateRangeEnd) {
            if (! $validDate || ! $dateRangeStart || ! $dateRangeEnd) {
                return $query;
            }

            return $query->where(function ($q) use ($dateRangeStart, $dateRangeEnd) {
                $q->whereBetween('ordered_at', [$dateRangeStart, $dateRangeEnd])
                    ->orWhereBetween('created_at', [$dateRangeStart, $dateRangeEnd]);
            });
        };

        $query = Order::with(['items.product'])
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->when($search, fn ($q) => $q->where('reference', 'like', "%{$search}%"));

        $query = $applyDateFilter($query);

        $orders = $query->latest()->paginate(10)->withQueryString();

        $totalOrdersQuery = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->when($search, fn ($q) => $q->where('reference', 'like', "%{$search}%"));
        $totalOrdersCount = $applyDateFilter($totalOrdersQuery)->count();

        $totalSalesQuery = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->when($search, fn ($q) => $q->where('reference', 'like', "%{$search}%"));
        $totalSales = (float) $applyDateFilter($totalSalesQuery)->sum('total');

        $soldItemsSummary = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.user_id', $userId)
            ->where('orders.status', 'completed')
            ->when($search, fn ($q) => $q->where('orders.reference', 'like', "%{$search}%"))
            ->when(
                $validDate && $dateRangeStart && $dateRangeEnd,
                fn ($q) => $q->where(function ($dateQuery) use ($dateRangeStart, $dateRangeEnd) {
                    $dateQuery->whereBetween('orders.ordered_at', [$dateRangeStart, $dateRangeEnd])
                        ->orWhereBetween('orders.created_at', [$dateRangeStart, $dateRangeEnd]);
                })
            )
            ->groupBy('products.id', 'products.name', 'products.image_path')
            ->select('products.name', 'products.image_path', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->orderByDesc('total_sold')
            ->limit(12)
            ->get();

        $ordersOnSelectedDay = $validDate ? $totalOrdersCount : null;

        return view('history', compact(
            'orders',
            'totalOrdersCount',
            'totalSales',
            'filterDate',
            'ordersOnSelectedDay',
            'validDate',
            'soldItemsSummary'
        ));
    }
}
