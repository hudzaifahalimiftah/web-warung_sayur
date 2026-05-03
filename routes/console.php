<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Batalkan pesanan pending yang sudah lebih dari 24 jam — cek setiap jam
Schedule::command('orders:cancel-expired')->hourly();
