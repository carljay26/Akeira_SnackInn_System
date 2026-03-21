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

];
