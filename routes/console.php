<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| Run the scheduler every minute (cron): * * * * * php /path/to/artisan schedule:run
| Digests: up to 10 notifications per category per user per Manila day (hourly 8:00–17:00).
*/
Schedule::command('snackinn:send-digests')
    ->timezone('Asia/Manila')
    ->hourly()
    ->between('8:00', '17:00');
