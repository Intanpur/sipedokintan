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
            --brand-teal: #00a896;
            --brand-teal-dark: #028090;
            --teal-light: rgba(0, 168, 150, 0.12);
            --border-color: rgba(0, 168, 150, 0.25);
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Latar Belakang Disesuaikan Ukurannya */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Menggunakan 100% 100% agar seluruh isi background muat dan kelihatan di layar */
            background-image: url('{{ asset("assets/images/background.png") }}');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
        }

        /* Responsive Background untuk layar HP / Tablet agar tidak gepeng */
        @media (max-width: 768px) {
            body {
                background-size: cover;
            }
        }

        /* Overlay transparan halus */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(1px);
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 380px;
        }

        /* Header Logo */
        .brand-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .logo-out {
            width: 55px;
            height: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        /* Kartu Login Glassmorphism */
        .login-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: 
                0 15px 35px rgba(0, 168, 150, 0.15),
                0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: left;
        }

        .badge-system {
            background-color: var(--teal-light);
            color: var(--brand-teal-dark);
            border: 1px solid rgba(0, 168, 150, 0.3);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: 0.78rem;
            color: #475569;
            margin-bottom: 12px;
        }

        /* Garis Divider */
        .line-divider {
            height: 1px;
            width: calc(100% + 48px);
            margin-left: -24px;
            margin-bottom: 18px;
            background-color: rgba(0, 168, 150, 0.15);
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 4px;
        }

        /* Input Group Transparan */
        .input-group {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .input-group:focus-within {
            border-color: var(--brand-teal);
            box-shadow: 0 0 0 3px rgba(0, 168, 150, 0.2);
            background: #ffffff;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--brand-teal);
            font-size: 0.95rem;
            padding: 8px 12px;
        }

        .form-control {
            background: transparent;
            border: none;
            color: #0f172a;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 8px 12px 8px 8px;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            background: transparent;
            color: #0f172a;
            box-shadow: none;
        }

        .toggle-pw {
            cursor: pointer;
            background: transparent;
            color: #94a3b8;
            border: none;
            padding: 8px 12px;
            transition: color 0.2s;
        }

        .toggle-pw:hover {
            color: var(--brand-teal);
        }

        /* Tombol Login */
        .btn-login {
            width: 100%;
            padding: 10px;
            background: linear-gradient(
                135deg,
                #00a896 0%,
                #028090 100%
            );
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            margin-top: 4px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 168, 150, 0.3);
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 168, 150, 0.4);
            color: #ffffff;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .footer-note {
            text-align: center;
            font-size: 0.72rem;
            margin-top: 16px;
            color: #475569;
            font-weight: 500;
        }

        .footer-note a {
            color: var(--brand-teal-dark);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            font-size: 0.78rem;
            padding: 8px 12px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            background: rgba(254, 242, 242, 0.9);
            color: #dc2626;
        }

        /* Container reCAPTCHA */
        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin: 12px 0;
            transform: scale(0.88);
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

    {{-- Form Card Glassmorphism --}}
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

        {{-- Garis Horizontal --}}
        <div class="line-divider"></div>

        {{-- Alerts --}}
        @if(session('error'))
            <div class="alert mb-3">
                <i class="bi bi-exclamation-circle-fill me-1"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert mb-3" style="border-color: rgba(0, 168, 150, 0.2); background: rgba(240, 253, 244, 0.9); color: #15803d;">
                <i class="bi bi-check-circle-fill me-1"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('email'))
            <div class="alert mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                {{ $errors->first('email') }}
            </div>
        @endif

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
                    data-theme="light"
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