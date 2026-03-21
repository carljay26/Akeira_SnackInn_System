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

];
