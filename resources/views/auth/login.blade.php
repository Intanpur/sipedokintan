<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPEDOK Kab. Pringsewu</title>
    
    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --neon-cyan: #00f5d4;
            --neon-cyan-dark: #00a896;
            --cyan-glow: rgba(0, 245, 212, 0.25);
            --border-cyan: rgba(0, 245, 212, 0.4);
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Latar Belakang baground.jpg */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset("assets/images/baground.jpg") }}') center center / cover no-repeat fixed;
            background-color: #0b1329;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(
                circle at center,
                rgba(15, 23, 42, 0.3) 0%,
                rgba(5, 10, 20, 0.7) 100%
            );
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
        }

        /* Header Logo */
        .brand-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 35, 45, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-cyan);
            padding: 12px;
            border-radius: 24px;
            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.4),
                0 0 15px var(--cyan-glow);
        }

        .logo-out {
            width: 65px;
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }

        /* Kartu Login Transparan Sesuai Gambar Logo (Dark Teal Glass) */
        .login-card {
            background: rgba(12, 32, 42, 0.68);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid var(--border-cyan);
            border-radius: 28px;
            padding: 32px 28px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.5),
                0 0 25px rgba(0, 245, 212, 0.12),
                inset 0 1px 1px rgba(255, 255, 255, 0.1);
            text-align: left;
        }

        .badge-system {
            background-color: rgba(0, 245, 212, 0.12);
            color: var(--neon-cyan);
            border: 1px solid rgba(0, 245, 212, 0.3);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        /* Garis Divider Muted Transparan Ujung ke Ujung */
        .line-divider {
            height: 1px;
            width: calc(100% + 56px);
            margin-left: -28px;
            margin-bottom: 22px;
            background-color: rgba(255, 255, 255, 0.12);
        }

        .form-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 6px;
        }

        /* Input Group Transparan Gelap dengan Cahaya Glow Konsisten */
        .input-group {
            background: rgba(15, 23, 42, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .input-group:focus-within {
            border-color: var(--neon-cyan);
            box-shadow: 0 0 12px var(--cyan-glow);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--neon-cyan);
            font-size: 1rem;
            padding: 10px 14px;
        }

        .form-control {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 10px 14px 10px 10px;
        }

        .form-control::placeholder {
            color: #64748b;
        }

        .form-control:focus {
            background: transparent;
            color: #ffffff;
            box-shadow: none;
        }

        .toggle-pw {
            cursor: pointer;
            background: transparent;
            color: #64748b;
            border: none;
            padding: 10px 14px;
            transition: color 0.2s;
        }

        .toggle-pw:hover {
            color: var(--neon-cyan);
        }

        /* Tombol Login Cyan Neon */
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(
                135deg,
                #00f5d4 0%,
                #00a896 100%
            );
            color: #002b26;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.9rem;
            margin-top: 6px;
            cursor: pointer;
            box-shadow: 0 6px 20px var(--cyan-glow);
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 10px 24px var(--cyan-glow);
            color: #000000;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .footer-note {
            text-align: center;
            font-size: 0.75rem;
            margin-top: 20px;
            color: #94a3b8;
            font-weight: 500;
        }

        .footer-note a {
            color: var(--neon-cyan);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.82rem;
            padding: 10px 14px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
        }

        /* Container reCAPTCHA */
        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin: 16px 0;
            transform: scale(0.92);
            transform-origin: center;
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    {{-- Header Logo --}}
    <div class="brand-header">
        <div class="logo-box">
            <img
                src="{{ asset('assets/images/logo-pringsewu.png') }}"
                class="logo-out"
                alt="Logo Pringsewu"
            >
        </div>
    </div>

    {{-- Form Card Transparan --}}
    <div class="login-card">

        <div class="text-center">
            <span class="badge-system">
                <i class="bi bi-shield-check me-1"></i>
                Diskominfo Pringsewu
            </span>

            <div class="title">
                Login SIPEDOK
            </div>

            <div class="subtitle">
                Sistem Informasi Pengelolaan Dokumentasi
            </div>
        </div>

        {{-- Garis Horizontal Muted Ujung ke Ujung --}}
        <div class="line-divider"></div>

        {{-- Alerts --}}
        @if(session('error'))
            <div class="alert mb-3">
                <i class="bi bi-exclamation-circle-fill me-1"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert mb-3" style="border-color: rgba(0, 245, 212, 0.3); background: rgba(0, 245, 212, 0.15); color: #00f5d4;">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Menampilkan Pesan Error Email (Termasuk Peringatan Akun Non-Aktif) --}}
        @if ($errors->has('email'))
            <div class="alert mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                {{ $errors->first('email') }}
            </div>
        @endif

        {{-- Error reCAPTCHA --}}
        @if ($errors->has('g-recaptcha-response'))
            <div class="alert mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                {{ $errors->first('g-recaptcha-response') }}
            </div>
        @endif

        {{-- Form Login --}}
        <form
            action="{{ route('login.post') }}"
            method="POST"
        >
            @csrf

            {{-- Input Email --}}
            <div class="mb-3">
                <label class="form-label">
                    Email / Username
                </label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope-fill"></i>
                    </span>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email Anda"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>
            </div>

            {{-- Input Password --}}
            <div class="mb-3">
                <label class="form-label">
                    Password
                </label>

                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>

                    <input
                        type="password"
                        name="password"
                        id="pw"
                        class="form-control"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <span
                        class="input-group-text toggle-pw"
                        onclick="togglePw()"
                    >
                        <i
                            class="bi bi-eye-fill"
                            id="eye-icon"
                        ></i>
                    </span>
                </div>
            </div>

            {{-- Google reCAPTCHA --}}
            <div class="recaptcha-container">
                <div
                    class="g-recaptcha"
                    data-theme="dark"
                    data-sitekey="{{ config('services.recaptcha.site_key') }}"
                >
                </div>
            </div>

            {{-- Submit Button --}}
            <button
                type="submit"
                class="btn-login"
            >
                <i class="bi bi-box-arrow-in-right me-1"></i>
                Masuk
            </button>
        </form>

        <div class="footer-note">
            Belum memiliki akses?
            <a href="#">
                Hubungi Administrator
            </a>
        </div>
    </div>
</div>

<script>
function togglePw() {
    const pw = document.getElementById('pw');
    const eye = document.getElementById('eye-icon');

    if (pw.type === 'password') {
        pw.type = 'text';
        eye.className = 'bi bi-eye-slash-fill';
    } else {
        pw.type = 'password';
        eye.className = 'bi bi-eye-fill';
    }
}
</script>

<script
    src="https://www.google.com/recaptcha/api.js"
    async
    defer
></script>

</body>
</html>