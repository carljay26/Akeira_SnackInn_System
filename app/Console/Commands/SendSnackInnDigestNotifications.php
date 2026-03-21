<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\SnackInnNotifier;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendSnackInnDigestNotifications extends Command
{
    protected $signature = 'snackinn:send-digests';

    protected $description = 'Send scheduled digest notifications (sales, top seller, orders, units) up to 10× per day each';

    public function handle(): int
    {
        $tz = 'Asia/Manila';

        foreach (User::query()->cursor() as $user) {
            $this->sendHistorySalesDigest($user, $tz);
            $this->sendTopSellingDigest($user, $tz);
            $this->sendLineItemsDigest($user, $tz);
            $this->sendCustomerOrdersDigest($user, $tz);
            $this->sendTotalUnitsDigest($user, $tz);
        }

        return self::SUCCESS;
    }

    /**
     * @return array{0: \Carbon\Carbon, 1: \Carbon\Carbon}
     */
    private function todayRangeUtc(string $tz = 'Asia/Manila'): array
    {
        $start = Carbon::now($tz)->startOfDay()->utc();
        $end = Carbon::now($tz)->endOfDay()->utc();

        return [$start, $end];
    }

    /**
     * @return list<int>
     */
    private function orderIdsToday(User $user, string $tz = 'Asia/Manila'): array
    {
        [$start, $end] = $this->todayRangeUtc($tz);

        return Order::query()
            ->where('user_id', $user->id)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('ordered_at', [$start, $end])
                    ->orWhereBetween('created_at', [$start, $end]);
            })
            ->pluck('id')
            ->all();
    }

    private function sendHistorySalesDigest(User $user, string $tz): void
    {
        if (! SnackInnNotifier::canSendDigest($user->id, SnackInnNotifier::DIGEST_HISTORY_SALES)) {
            return;
        }

        [$start, $end] = $this->todayRangeUtc($tz);

        $total = (float) Order::query()
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('ordered_at', [$start, $end])
                    ->orWhereBetween('created_at', [$start, $end]);
            })
            ->sum('total');

        $dateLabel = Carbon::now($tz)->format('M d, Y');
        $message = sprintf(
            'Today\'s completed sales total PHP %s — open History to review your orders and totals for %s.',
            number_format($total, 2),
            $dateLabel
        );

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Daily sales reminder',
            'message' => $message,
        ]);

        SnackInnNotifier::incrementDigestCount($user->id, SnackInnNotifier::DIGEST_HISTORY_SALES);
    }

    private function sendTopSellingDigest(User $user, string $tz): void
    {
        if (! SnackInnNotifier::canSendDigest($user->id, SnackInnNotifier::DIGEST_TOP_SELLING)) {
            return;
        }

        $orderIds = $this->orderIdsToday($user, $tz);
        $dateLabel = Carbon::now($tz)->format('M d, Y');

        if ($orderIds === []) {
            $message = "No orders yet today ({$dateLabel}) — once sales pick up, we'll highlight your hottest snack here; keep an eye on History.";
        } else {
            $top = OrderItem::query()
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->whereIn('order_items.order_id', $orderIds)
                ->select('products.name', DB::raw('SUM(order_items.quantity) as units_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('units_sold')
                ->first();

            if ($top) {
                $message = sprintf(
                    'Today\'s top-selling product is "%s" with %s units ordered — nice work; full details are in History for %s.',
                    $top->name,
                    number_format((int) $top->units_sold),
                    $dateLabel
                );
            } else {
                $message = "Orders exist today but no line items were found — check History for {$dateLabel} to verify your data.";
            }
        }

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Top seller today',
            'message' => $message,
        ]);

        SnackInnNotifier::incrementDigestCount($user->id, SnackInnNotifier::DIGEST_TOP_SELLING);
    }

    private function sendLineItemsDigest(User $user, string $tz): void
    {
        if (! SnackInnNotifier::canSendDigest($user->id, SnackInnNotifier::DIGEST_LINE_ITEMS)) {
            return;
        }

        $orderIds = $this->orderIdsToday($user, $tz);
        $dateLabel = Carbon::now($tz)->format('M d, Y');

        $lines = $orderIds === []
            ? 0
            : (int) OrderItem::query()->whereIn('order_id', $orderIds)->count();

        $message = sprintf(
            'So far today you have %s product line%s on orders — open History to see each item sold on %s.',
            number_format($lines),
            $lines === 1 ? '' : 's',
            $dateLabel
        );

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Items ordered today',
            'message' => $message,
        ]);

        SnackInnNotifier::incrementDigestCount($user->id, SnackInnNotifier::DIGEST_LINE_ITEMS);
    }

    private function sendCustomerOrdersDigest(User $user, string $tz): void
    {
        if (! SnackInnNotifier::canSendDigest($user->id, SnackInnNotifier::DIGEST_CUSTOMER_ORDERS)) {
            return;
        }

        $orderIds = $this->orderIdsToday($user, $tz);
        $dateLabel = Carbon::now($tz)->format('M d, Y');
        $count = count($orderIds);

        $message = sprintf(
            'Today\'s shop activity: %s customer order%s recorded — each order represents a visit; review them anytime in History (%s).',
            number_format($count),
            $count === 1 ? '' : 's',
            $dateLabel
        );

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Customers today',
            'message' => $message,
        ]);

        SnackInnNotifier::incrementDigestCount($user->id, SnackInnNotifier::DIGEST_CUSTOMER_ORDERS);
    }

    private function sendTotalUnitsDigest(User $user, string $tz): void
    {
        if (! SnackInnNotifier::canSendDigest($user->id, SnackInnNotifier::DIGEST_TOTAL_UNITS)) {
            return;
        }

        $orderIds = $this->orderIdsToday($user, $tz);
        $dateLabel = Carbon::now($tz)->format('M d, Y');

        $units = $orderIds === []
            ? 0
            : (int) OrderItem::query()->whereIn('order_id', $orderIds)->sum('quantity');

        $message = sprintf(
            'Unit movement today: %s total pieces ordered across all products — History has the full breakdown for %s.',
            number_format($units),
            $dateLabel
        );

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Units sold today',
            'message' => $message,
        ]);

        SnackInnNotifier::incrementDigestCount($user->id, SnackInnNotifier::DIGEST_TOTAL_UNITS);
    }
}
