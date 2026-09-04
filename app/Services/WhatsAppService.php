<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public static function sendMagicLink($noHp, $namaPimpinan, $namaFolder, $magicUrl)
    {
        $target = $noHp;
        $message = "Yth. Bapak/Ibu *{$namaPimpinan}*,\n\n";
        $message .= "Petugas telah mengunggah mentahan dokumentasi baru pada folder:\n";
        $message .= "📁 *{$namaFolder}*\n\n";
        $message .= "Mohon kesediaan Bapak/Ibu untuk memilih foto/video mentah yang akan diteruskan ke tim Editor melalui link berikut:\n\n";
        $message .= "🔗 {$magicUrl}\n\n";
        $message .= "_Pesan otomatis dari SIPEDOK_";

        // Integrasi API Provider WA (Contoh Fonnte)
        Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN', 'YOUR_TOKEN_HERE'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
        ]);
    }
}