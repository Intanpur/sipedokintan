<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIPEDOK')</title>

    <!-- BOOTSTRAP 5 & ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Palette Modern Hijau Toska */
            --toska-dark: #0f766e;       /* Toska Gelap Elegant */
            --toska-primary: #0d9488;    /* Toska Utama */
            --toska-light: #14b8a6;      /* Toska Terang */
            --toska-subtle: #ccfbf1;     /* Soft Toska Accent */
            
            --body-bg: #f8fafc;          /* Abu-abu Sangat Soft Bersih */
            --white: #ffffff;
            --text-dark: #0f172a;        /* Teks Slate Gelap Jelas */
            --text-muted: #64748b;
            --shadow: 0 10px 25px rgba(13, 148, 136, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--body-bg);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /**********************
        NAVBAR - GRADIENT HIJAU TOSKA SEGAR (TANPA WARNA HITAM)
        **********************/
        .navbar {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%) !important;
            padding: 12px 24px;
            box-shadow: 0 4px 20px rgba(13, 148, 136, 0.25);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: var(--white) !important;
        }

        .navbar-brand span {
            color: #fef08a; /* Aksen Kuning Soft untuk DOK */
        }

        .logo {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 12px;
            margin-right: 12px;
            background: var(--white);
            padding: 2px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* Nav Links Styling */
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px;
            font-weight: 600;
            padding: 9px 16px !important;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white) !important;
        }

        /* Menu Aktif Putih Kontras */
        .nav-link.active {
            background: var(--white) !important;
            color: var(--toska-dark) !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-toggler {
            border: none;
            box-shadow: none !important;
        }

        .navbar-toggler i {
            color: var(--white);
            font-size: 26px;
        }

        /**********************
        USER PROFILE & BUTTONS
        **********************/
        .user-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(5px);
            padding: 6px 14px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--toska-dark);
            font-weight: 800;
            font-size: 13px;
        }

        .user-info {
            line-height: 1.2;
        }

        .user-info strong {
            font-size: 13px;
            color: var(--white);
        }

        .user-info small {
            font-size: 11px;
            color: #ccfbf1;
        }

        /**********************
        CONTENT WRAPPER
        **********************/
        .content {
            padding: 30px;
            min-height: calc(100vh - 74px);
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 24px;
            color: var(--text-dark);
        }

        /**********************
        CARDS & TABLES GLOBAL (LEBIH CERAH)
        **********************/
        .card {
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            box-shadow: var(--shadow);
            background: var(--white);
        }

        .card-header {
            background: var(--white);
            font-weight: 700;
            font-size: 16px;
            border-bottom: 1px solid #f1f5f9;
            padding: 16px 20px;
            border-radius: 16px 16px 0 0 !important;
        }

        /* Table Header Soft Gray/Toska (Bukan Hitam) */
        .table thead {
            background-color: #e2e8f0;
            color: var(--text-dark);
        }

        .table thead th {
            font-weight: 700;
            border: none;
            padding: 12px 16px;
            color: var(--text-dark) !important;
        }

        /**********************
        BUTTONS & FORMS
        **********************/
        .btn-primary {
            background: var(--toska-primary);
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--toska-dark);
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.15);
            border-color: var(--toska-primary);
        }

        /**********************
        RESPONSIVE
        **********************/
        @media(max-width: 991px) {
            .content {
                padding: 20px 15px;
            }
            .page-title {
                font-size: 20px;
            }
            .navbar-nav {
                margin-top: 15px;
                gap: 4px;
            }
            .user-area {
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/images/logo-sipedok.png') }}" class="logo" alt="Logo SIPEDOK">
            SIPE<span>DOK</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            
            <ul class="navbar-nav me-auto">

                {{-- ========================= --}}
                {{-- MENU ADMIN --}}
                {{-- ========================= --}}
                @if(Auth::check() && Auth::user()->role == 'admin')

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.datapetugas*') ? 'active' : '' }}" href="{{ route('admin.datapetugas.index') }}">
                        <i class="bi bi-people-fill"></i>
                        Data Petugas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.kegiatan*') ? 'active' : '' }}" href="{{ route('admin.kegiatan.index') }}">
                        <i class="bi bi-calendar-event-fill"></i>
                        Kegiatan Liputan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.folder*') ? 'active' : '' }}" href="{{ route('admin.folder.index') }}">
                        <i class="bi bi-folder-fill"></i>
                        Folder Dokumentasi
                    </a>
                </li>

                @endif


                {{-- ================= PETUGAS ================= --}}
                @if(Auth::check() && Auth::user()->role == "petugas")
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.kegiatan*') ? 'active' : '' }}" href="{{ route('petugas.kegiatan.index') }}">
                        <i class="bi bi-calendar-check"></i> Data Kegiatan
                    </a>
                </li>
               {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.arsip*') ? 'active' : '' }}" href="{{ route('petugas.arsip') }}">
                        <i class="bi bi-archive"></i> Arsip Dokumentasi
                    </a>
                </li>--}}
                @endif


               {{-- ================= PIMPINAN ================= --}}
@if(Auth::check() && Auth::user()->role == "pimpinan")
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}" href="{{ route('pimpinan.dashboard') }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pimpinan.kegiatan*') || request()->routeIs('pimpinan.dokumentasi*') ? 'active' : '' }}" href="{{ route('pimpinan.kegiatan') }}">
            <i class="bi bi-folder-check"></i> Kurasi
        </a>
    </li>
    
@endif


                {{-- ================= EDITOR ================= --}}
                @if(Auth::check() && Auth::user()->role == "editor")
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}" href="{{ route('editor.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('editor.editing*') ? 'active' : '' }}" href="{{ route('editor.editing.index') }}">
                        <i class="bi bi-camera-video"></i> Proses Editing
                    </a>
                </li>
                @endif

            </ul>

            <!-- PROFIL USER & LOGOUT -->
            <div class="user-area d-flex align-items-center gap-3">
                @auth
                    <div class="user-box">
                        <div class="avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="user-info">
                            <strong>{{ auth()->user()->name }}</strong><br>
                            <small>{{ ucfirst(auth()->user()->role) }}</small>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark shadow-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light rounded-pill px-4 fw-bold text-dark shadow-sm">
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>

<div class="content">
    <h3 class="page-title">
        @yield('page-title')
    </h3>

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>