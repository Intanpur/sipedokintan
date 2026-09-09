<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $token;
    protected string $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    /**
     * Format nomor HP ke standar Indonesia (628xxx)
     */
    public function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    /**
     * Kirim Pesan Teks Umum
     */
    public function sendMessage(string $target, string $message, ?string $urlLink = null): array
    {
        $formattedTarget = $this->formatPhoneNumber($target);

        $payload = [
            'target'  => $formattedTarget,
            'message' => $message,
        ];

        if ($urlLink) {
            $payload['url'] = $urlLink;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->apiUrl, $payload);

            $result = $response->json();

            if (!$response->successful()) {
                Log::error('Fonnte WA Error:', $result ?? []);
            }

            return $result ?? ['status' => false, 'reason' => 'No response'];
        } catch (\Exception $e) {
            Log::error('Fonnte Exception: ' . $e->getMessage());
            return ['status' => false, 'reason' => $e->getMessage()];
        }
    }

    /**
     * Kirim Magic Link ke Pimpinan
     * Return: bool (true jika berhasil, false jika gagal)
     */
    public function sendMagicLink(string $noHp, string $namaPimpinan, $folder, string $magicUrl): bool
    {
        // Hitung total file berdasarkan tipe_file
        $totalFoto  = $folder->dokumentasi->where('tipe_file', 'foto')->count();
        $totalVideo = $folder->dokumentasi->where('tipe_file', 'video')->count();
        $totalFile  = $folder->dokumentasi->count();

        $message  = "Yth. Bapak/Ibu *{$namaPimpinan}*,\n\n";
        $message .= "Melaporkan bahwa petugas telah selesai mengunggah seluruh dokumentasi kegiatan hari ini ke dalam sistem SIPEDOK.\n\n";
        $message .= "📌 *Detail Folder:* {$folder->nama_folder}\n";
        $message .= "📁 *Isi Folder:* {$totalFile} File ({$totalFoto} Foto, {$totalVideo} Video)\n";
        $message .= "📅 *Waktu Unggah:* " . now()->translatedFormat('d F Y (H:i WIB)') . "\n\n";
        $message .= "Mohon kesediaan Bapak/Ibu untuk meninjau serta memilih (menyeleksi) foto/video mentah yang akan diteruskan ke tim Editor untuk proses penyuntingan lebih lanjut.\n\n";
        $message .= "Tautan akses langsung halaman kurasi:\n";
        $message .= "🔗 {$magicUrl}\n\n";
        $message .= "Atas perhatian dan arahan Bapak/Ibu, kami ucapkan terima kasih.";

        $response = $this->sendMessage($noHp, $message);

        // Memastikan mengembalikan boolean true jika API Fonnte merespon sukses
        return isset($response['status']) && $response['status'] === true;
    }
}