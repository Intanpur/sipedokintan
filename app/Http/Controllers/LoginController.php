<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog; // Model ActivityLog ditambahkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            if (!data_get(Auth::user(), 'is_active')) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda sedang non-aktif. Silakan hubungi Admin.'
                ]);
            }

            return $this->redirectBasedOnRole($user->role);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'g-recaptcha-response' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA terlebih dahulu.',
        ]);

        $recaptchaSecret = config('services.recaptcha.secret_key');

        if (empty($recaptchaSecret)) {
            return back()
                ->withErrors([
                    'g-recaptcha-response' => 'Konfigurasi reCAPTCHA belum ditemukan.'
                ])
                ->withInput($request->only('email'));
        }

        try {
            $response = Http::asForm()->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'secret' => $recaptchaSecret,
                    'response' => $request->input('g-recaptcha-response'),
                    'remoteip' => $request->ip(),
                ]
            );

            $result = $response->json();
        } catch (\Throwable $e) {
            return back()
                ->withErrors([
                    'g-recaptcha-response' => 'Gagal menghubungi server reCAPTCHA. Silakan coba lagi.'
                ])
                ->withInput($request->only('email'));
        }

        if (!isset($result['success']) || $result['success'] !== true) {
            return back()
                ->withErrors([
                    'g-recaptcha-response' => 'reCAPTCHA tidak valid atau sudah kedaluwarsa. Silakan centang ulang.'
                ])
                ->withInput($request->only('email'));
        }

        $email = strtolower(trim((string) $request->input('email')));
        $password = (string) $request->input('password');

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Email atau Password salah.'
                ])
                ->withInput($request->only('email'));
        }

        /** @var User $user */
        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'Akun Anda sedang non-aktif. Silakan hubungi Admin.'
                ])
                ->withInput($request->only('email'));
        }

        // =========================================================================
        // PERBAIKAN DI SINI: PERBARUI WAKTU AKTIFAK USER & CATAT ACTIVITY LOG
        // =========================================================================
        
        // 1. Perbarui kolom updated_at milik user menjadi detik ini
        $user->touch();

        // 2. Buat log aktivitas login ke tabel activity_logs (jika tabel tersedia)
        try {
            ActivityLog::create([
                'user_id'     => $user->id,
                'activity'    => 'Login ke sistem', // atau 'description' => 'Login ke sistem'
                'description' => 'Login ke sistem',
            ]);
        } catch (\Throwable $e) {
            // Abaikan jika struktur kolom tabel activity_logs berbeda
        }

        // =========================================================================

        $request->session()->regenerate();

        return $this->redirectBasedOnRole($user->role);
    }

    protected function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'petugas':
                return redirect()->route('petugas.dashboard');

            case 'pimpinan':
                return redirect()->route('pimpinan.dashboard');

            case 'editor':
                return redirect()->route('editor.dashboard');

            default:
                Auth::logout();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Role pengguna tidak dikenali.'
                    ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Berhasil keluar dari sistem.');
    }
}