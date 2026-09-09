<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\ActivityLog; // Import model log kamu

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// OTO-HAPUS LOG > 30 HARI (Jalan otomatis setiap jam 12 malam)
Schedule::call(function () {
    ActivityLog::where('created_at', '<', now()->subDays(30))->delete();
})->daily();