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

];
