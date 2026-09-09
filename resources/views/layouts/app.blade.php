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

    <link rel="stylesheet" href="{{ asset('css/responsive-admin.css') }}">

    <style>
        :root {
            --toska-dark: #0f766e;
            --toska-primary: #0d9488;
            --toska-light: #14b8a6;
            --toska-subtle: #ccfbf1;
            
            --body-bg: #f8fafc;
            --white: #ffffff;
            --text-dark: #0f172a;
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a { text-decoration: none; }

        /**********************
        NAVBAR - GRADIENT HIJAU TOSKA
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

        .navbar-brand span { color: #fef08a; }

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

        .nav-link.active {
            background: var(--white) !important;
            color: var(--toska-dark) !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /**********************
        USER PROFILE DROPDOWN
        **********************/
        .user-dropdown-btn {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(5px);
            padding: 6px 16px 6px 10px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-dropdown-btn:hover, .user-dropdown-btn:focus {
            background: rgba(255, 255, 255, 0.28);
            color: var(--white);
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

        .dropdown-menu-end {
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 8px;
            min-width: 220px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 9px 14px;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background: var(--toska-subtle);
            color: var(--toska-dark);
        }

        .dropdown-item.text-danger:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /**********************
        CONTENT WRAPPER & FOOTER
        **********************/
        .content {
            padding: 30px;
            flex: 1;
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 24px;
            color: var(--text-dark);
        }

        .main-footer {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
            color: var(--white);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 24px 0;
            margin-top: auto;
            box-shadow: 0 -4px 20px rgba(13, 148, 136, 0.15);
        }

        .footer-brand {
            font-size: 20px;
            font-weight: 800;
        }

        .footer-brand span { color: #fef08a; }

        .footer-text-muted {
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 13px;
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
                @auth
                    {{-- MENU KHUSUS ADMIN --}}
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-grid-fill"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.datapetugas*') ? 'active' : '' }}" href="{{ route('admin.datapetugas.index') }}">
                                <i class="bi bi-people-fill"></i> Data Petugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.kegiatan*') ? 'active' : '' }}" href="{{ route('admin.kegiatan.index') }}">
                                <i class="bi bi-calendar-event-fill"></i> Kegiatan Liputan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.folder*') ? 'active' : '' }}" href="{{ route('admin.folder.index') }}">
                                <i class="bi bi-folder-fill"></i> Folder Dokumentasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.activity-logs*') ? 'active' : '' }}" href="{{ route('admin.activity-logs.index') }}">
                                <i class="bi bi-clock-history"></i> Log Aktivitas
                            </a>
                        </li>

                    {{-- MENU KHUSUS PIMPINAN --}}
                    @elseif(Auth::user()->role == 'pimpinan')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}" href="{{ route('pimpinan.dashboard') }}">
                                <i class="bi bi-grid-fill"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pimpinan.kurasi*') ? 'active' : '' }}" href="{{ route('pimpinan.kurasi.index') }}">
                                <i class="bi bi-check2-square"></i> Kurasi / Disposisi
                            </a>
                        </li>

                    {{-- MENU KHUSUS EDITOR --}}
                    @elseif(Auth::user()->role == 'editor')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}" href="{{ route('editor.dashboard') }}">
                                <i class="bi bi-grid-fill"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('editor.tugas*') ? 'active' : '' }}" href="{{ route('editor.tugas.index') }}">
                                <i class="bi bi-film"></i> Tugas Editing
                            </a>
                        </li>

                    {{-- MENU KHUSUS PETUGAS --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
                                <i class="bi bi-grid-fill"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('petugas.kegiatan*') ? 'active' : '' }}" href="{{ route('petugas.kegiatan.index') }}">
                                <i class="bi bi-calendar-event-fill"></i> Data Kegiatan 
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- PROFIL USER & LOGOUT DROPDOWN -->
            <div class="user-area">
                @auth
                    <div class="dropdown">
                        <button class="btn user-dropdown-btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="text-start me-1">
                                <div class="fw-bold fs-6 style-name" style="font-size: 13px !important; line-height: 1;">{{ auth()->user()->name }}</div>
                                <small style="font-size: 11px; color: #ccfbf1;">{{ ucfirst(auth()->user()->role) }}</small>
                            </div>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="bi bi-person-circle text-primary me-2"></i> Profil Saya & 2FA
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger w-100 border-0 bg-transparent">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar / Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
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

<!-- FOOTER UTAMA -->
<footer class="main-footer text-center">
    <div class="container">
        <div class="fw-bold footer-brand mb-1">
            SIPE<span>DOK</span>
        </div>
        <div class="footer-text-muted mb-0">
            Sistem Pengelolaan dan Dokumentasi Liputan
        </div>
        <div class="footer-text-muted mt-2" style="font-size: 12px; opacity: 0.9;">
            &copy; {{ date('Y') }} <strong>SIPEDOK</strong>. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>