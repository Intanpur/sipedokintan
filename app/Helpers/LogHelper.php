<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function record($activity, $dokumentasiId = null, $description = null)
    {
        try {
            ActivityLog::create([
                'user_id'        => Auth::id(),
                'dokumentasi_id' => $dokumentasiId,
                'activity'       => $activity,
                'description'    => $description,
                'ip'             => request()->ip(),
                'device'         => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error ke storage/logs/laravel.log jika gagal simpan
            \Illuminate\Support\Facades\Log::error('Gagal simpan ActivityLog: ' . $e->getMessage());
        }
    }
}