<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Low stock threshold
    |--------------------------------------------------------------------------
    |
    | When product stock is at or below this number (and not negative),
    | a low-stock notification may be sent (once per product per day).
    |
    */
    'low_stock_threshold' => (int) env('SNACK_INN_LOW_STOCK_THRESHOLD', 10),

    /*
    |--------------------------------------------------------------------------
    | Secret URL token: /setup-first-admin?token=...
    |--------------------------------------------------------------------------
    |
    | If empty, the route returns 404. Generate a long random string for Railway.
    |
    */
    'setup_admin_token' => env('SETUP_ADMIN_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Default shop for new users (optional)
    |--------------------------------------------------------------------------
    |
    | If set to a valid shops.id, every new registration joins that shop unless
    | they enter a different Team code on the register form. Use this when one
    | Snack Inn has several staff accounts sharing the same products and orders.
    |
    */
    'default_shop_id' => env('SNACK_INN_DEFAULT_SHOP_ID'),

    /*
    |--------------------------------------------------------------------------
    | Product image uploads (filesystem disk)
    |--------------------------------------------------------------------------
    |
    | Disk name from config/filesystems.php used when saving product photos.
    | Use "public" locally with `php artisan storage:link` (files live under
    | storage/app/public). On Railway, Render, etc., the filesystem is often
    | ephemeral — uploads disappear after a restart or idle sleep. Set this to
    | "s3" (or another cloud disk) and configure AWS_* / bucket so images persist.
    |
    */
    'product_images_disk' => env('PRODUCT_IMAGES_DISK', 'public'),

];
