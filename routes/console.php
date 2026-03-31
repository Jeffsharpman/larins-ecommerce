<?php

use App\Mail\LowStockAlert;
use App\Models\ProductVariant;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $items = ProductVariant::getLowStockReport();

    if ($items->isNotEmpty()) {
        $adminEmail = config('mail.from.address');

        Mail::to($adminEmail)->send(new LowStockAlert($items));
    }
})->dailyAt('08:00'); // Runs every morning at 8:00 AM
