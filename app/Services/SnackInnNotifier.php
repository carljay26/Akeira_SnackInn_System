<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class SnackInnNotifier
{
    public const DIGEST_HISTORY_SALES = 'history_sales';

    public const DIGEST_TOP_SELLING = 'top_selling';

    public const DIGEST_LINE_ITEMS = 'line_items';

    public const DIGEST_CUSTOMER_ORDERS = 'customer_orders';

    public const DIGEST_TOTAL_UNITS = 'total_units';

    /** @return list<string> */
    public static function digestTypes(): array
    {
        return [
            self::DIGEST_HISTORY_SALES,
            self::DIGEST_TOP_SELLING,
            self::DIGEST_LINE_ITEMS,
            self::DIGEST_CUSTOMER_ORDERS,
            self::DIGEST_TOTAL_UNITS,
        ];
    }

    /** Sent on every successful login (including after logout). */
    public static function notifyLoginWelcome(User $user): void
    {
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Signed in to Akeira\'s Snack Inn',
            'message' => 'You\'re signed in — your snack shop dashboard is ready. Log out when you\'re done for the day.',
        ]);
    }

    public static function notifyProductCreated(User $user, string $productName): void
    {
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Product added',
            'message' => "A new product, \"{$productName}\", was added to your inventory and is ready for the ordering page.",
        ]);
    }

    public static function notifyProductUpdated(User $user, string $productName): void
    {
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Product updated',
            'message' => "Product \"{$productName}\" was updated — check Products if you changed price, stock, or photos.",
        ]);
    }

    public static function notifyProductRemoved(User $user, string $productName): void
    {
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Product removed',
            'message' => "Product \"{$productName}\" was removed from your catalog and will no longer appear for customers.",
        ]);
    }

    public static function notifyLowStockIfNeeded(User $user, Product $product): void
    {
        $threshold = (int) config('snack_inn.low_stock_threshold', 10);
        if ($product->stock > $threshold) {
            return;
        }

        $throttleKey = 'lowstock:'.$product->id.':'.Carbon::now('Asia/Manila')->toDateString();
        if (DB::table('snackinn_notification_throttles')->where('throttle_key', $throttleKey)->exists()) {
            return;
        }

        $unit = $product->unit ?: 'units';
        if ($product->stock <= 0) {
            $message = "\"{$product->name}\" is out of stock (0 {$unit}) — restock soon so guests can order it again.";
        } else {
            $message = "Low stock: \"{$product->name}\" has only {$product->stock} {$unit} left — consider restocking before it sells out.";
        }

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Inventory alert',
            'message' => $message,
        ]);

        DB::table('snackinn_notification_throttles')->insert([
            'throttle_key' => $throttleKey,
            'created_at' => now(),
        ]);
    }

    public static function digestCountToday(int $userId, string $type): int
    {
        $date = Carbon::now('Asia/Manila')->toDateString();

        return (int) DB::table('snackinn_digest_counters')
            ->where('user_id', $userId)
            ->where('digest_type', $type)
            ->where('bucket_date', $date)
            ->value('count');
    }

    public static function incrementDigestCount(int $userId, string $type): void
    {
        $date = Carbon::now('Asia/Manila')->toDateString();

        DB::transaction(function () use ($userId, $type, $date) {
            $row = DB::table('snackinn_digest_counters')
                ->where('user_id', $userId)
                ->where('digest_type', $type)
                ->where('bucket_date', $date)
                ->lockForUpdate()
                ->first();

            if ($row) {
                DB::table('snackinn_digest_counters')
                    ->where('id', $row->id)
                    ->update([
                        'count' => (int) $row->count + 1,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('snackinn_digest_counters')->insert([
                    'user_id' => $userId,
                    'digest_type' => $type,
                    'bucket_date' => $date,
                    'count' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public static function canSendDigest(int $userId, string $type, int $maxPerDay = 10): bool
    {
        return self::digestCountToday($userId, $type) < $maxPerDay;
    }
}
