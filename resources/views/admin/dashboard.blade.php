@extends('layouts.app')

@section('title', 'Dashboard Admin - SIPEDOK')

@section('content')
<!-- GOOGLE FONTS & BOOTSTRAP ICONS -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- TEMA HIJAU TOSKA - HIGH CONTRAST & READABILITY -->
<style>
    :root {
        /* Palette Hijau Toska */
        --toska-primary: #0d9488;      /* Toska Utama */
        --toska-dark: #0f766e;         /* Toska Gelap */
        --toska-light: #14b8a6;        /* Toska Terang */
        --toska-accent: #2dd4bf;       /* Toska Neon/Aksen */
        --toska-subtle: #ccfbf1;       /* Soft Toska Background */
        
        /* Kontras Teks & Latar Belakang */
        --bg-body: #f1f5f9;            /* Abu-abu terang bersih */
        --card-bg: #ffffff;            /* Putih bersih */
        --text-dark: #0f172a;          /* Hitam Slate Pekat */
        --text-muted: #475569;         /* Abu-abu Sedang */
        --border-color: #cbd5e1;       /* Garis tepi tegas */
    }

    body {
        background-color: var(--bg-body) !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-dark);
    }

    /* Cards Putih Bersih & Kontras */
    .toska-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease-in-out;
    }

    .toska-card-hover:hover {
        transform: translateY(-4px);
        border-color: var(--toska-primary);
        box-shadow: 0 10px 20px rgba(13, 148, 136, 0.15);
    }

    /* Banner Gradient Toska */
    .toska-banner {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.3);
    }

    /* Badges Custom */
    .badge-toska {
        background-color: var(--toska-subtle);
        color: var(--toska-dark);
        font-weight: 700;
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 8px;
        padding: 6px 12px;
    }

    .badge-amber {
        background-color: #fef3c7;
        color: #92400e;
        font-weight: 700;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 6px 12px;
    }

    .badge-rose {
        background-color: #ffe4e6;
        color: #9f1239;
        font-weight: 700;
        border: 1px solid #fecdd3;
        border-radius: 8px;
        padding: 6px 12px;
    }

    .badge-cyan {
        background-color: #e0f2fe;
        color: #075985;
        font-weight: 700;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 6px 12px;
    }

    .badge-purple {
        background-color: #f3e8ff;
        color: #6b21a8;
        font-weight: 700;
        border: 1px solid #e9d5ff;
        border-radius: 8px;
        padding: 6px 12px;
    }

    /* Search Box High Contrast */
    .search-toska {
        background: #ffffff;
        border: 2px solid #ffffff;
        border-radius: 30px;
        padding: 4px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .search-toska input {
        background: transparent;
        border: none;
        color: var(--text-dark);
        font-weight: 600;
    }

    .search-toska input::placeholder {
        color: #64748b;
    }

    .search-toska input:focus {
        background: transparent;
        color: var(--text-dark);
        box-shadow: none;
    }

    /* Tabel dengan Tulisan Jelas */
    .table-toska {
        color: var(--text-dark) !important;
    }

    .table-toska th {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
        font-weight: 700;
    }

    .table-toska td {
        color: #0f172a !important;
        vertical-align: middle;
    }

    /* Indicator Status Online */
    .online-indicator {
        width: 10px;
        height: 10px;
        background-color: #22c55e;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 2px #ffffff, 0 0 8px #22c55e;
    }

    /* Custom Style untuk Icon Fitur */
    .feature-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
</style>

<div class="container-fluid pb-5 pt-3">

    <!-- 1. WELCOME BANNER UTAMA -->
    <div class="toska-banner p-4 p-lg-5 text-white mb-4 position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <span class="badge bg-white text-dark fw-bold px-3 py-2 rounded-pill mb-3 shadow-sm" style="color: var(--toska-dark) !important;">
                    <i class="bi bi-shield-check me-1 text-success"></i> Admin Panel Diskominfo
                </span>
                <h2 class="fw-extrabold mb-2 display-6 text-white" style="font-weight: 800;">
                    Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}! 👋
                </h2>
                <p class="fs-6 mb-0" style="color: #e6fffa; font-weight: 500;">
                    Pusat pemantauan dan pengelolaan dokumentasi media terpadu Kabupaten Pringsewu.
                </p>
            </div>

            <!-- SEARCH & SHORTCUT -->
            <div class="col-lg-6">
                <div class="d-flex flex-column align-items-lg-end">
                    <form action="{{ route('admin.kegiatan.index') }}" method="GET" class="w-100 mb-3" style="max-width: 420px;">
                        <div class="search-toska d-flex align-items-center">
                            <i class="bi bi-search me-2 ms-3" style="color: var(--toska-dark); font-size: 18px;"></i>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kegiatan, lokasi, petugas...">
                            <button class="btn btn-sm text-white fw-bold rounded-pill px-4 py-2" type="submit" style="background: var(--toska-dark);">CARI</button>
                        </div>
                    </form>

                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-light rounded-pill px-3 py-2 fw-bold text-dark shadow-sm">
                            <i class="bi bi-eye text-success me-1"></i> Pantau Kegiatan
                        </a>
                    
                        <a href="{{ route('admin.datapetugas.index') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-bold">
                            <i class="bi bi-people me-1"></i> Kelola Petugas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PENJELASAN FITUR UTAMA DASHBOARD -->
    <div class="toska-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h6 class="fw-bold mb-1" style="color: #0f172a; font-size: 16px;">
                    <i class="bi bi-grid-fill me-2" style="color: var(--toska-primary);"></i>Panduan Fitur Dashboard
                </h6>
                <small style="color: #64748b;">Ringkasan fungsi dan modul yang dapat digunakan dalam sistem SIPEDOK.</small>
            </div>
            <span class="badge-toska"><i class="bi bi-info-circle me-1"></i> Pusat Bantuan</span>
        </div>

        <div class="row g-3">
            <!-- Fitur 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="p-3 border rounded-3 bg-light h-100 d-flex align-items-start">
                    <div class="feature-icon-box me-3 text-white" style="background: var(--toska-dark);">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Statistik & Ringkasan Berkas</h6>
                        <p class="small text-muted mb-0">Memantau jumlah total petugas, kegiatan liputan, folder, serta berkas foto dan video secara terpusat.</p>
                    </div>
                </div>
            </div>

            <!-- Fitur 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="p-3 border rounded-3 bg-light h-100 d-flex align-items-start">
                    <div class="feature-icon-box me-3 bg-primary text-white">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Analistik & Grafik Media</h6>
                        <p class="small text-muted mb-0">Visualisasi grafis aktivitas unggahan bulanan dan komparasi persentase antara berkas foto dan video.</p>
                    </div>
                </div>
            </div>

            <!-- Fitur 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="p-3 border rounded-3 bg-light h-100 d-flex align-items-start">
                    <div class="feature-icon-box me-3 bg-warning text-dark">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Monitoring Agenda Kegiatan</h6>
                        <p class="small text-muted mb-0">Melihat daftar kegiatan liputan terbaru, status pengerjaan (Pending/Proses/Selesai), serta petugas penanggung jawab.</p>
                    </div>
                </div>
            </div>

            <!-- Fitur 4 -->
            <div class="col-lg-4 col-md-6">
                <div class="p-3 border rounded-3 bg-light h-100 d-flex align-items-start">
                    <div class="feature-icon-box me-3 bg-purple text-purple" style="background: #f3e8ff; color: #6b21a8;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Manajemen Petugas</h6>
                        <p class="small text-muted mb-0">Pengelolaan data pengguna sistem, pembagian tugas liputan, serta hak akses untuk petugas dan staf.</p>
                    </div>
                </div>
            </div>

            <!-- Fitur 5 -->
            <div class="col-lg-4 col-md-6">
                <div class="p-3 border rounded-3 bg-light h-100 d-flex align-items-start">
                    <div class="feature-icon-box me-3 bg-danger text-white">
                        <i class="bi bi-folder-symlink"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Manajemen Direktori Folder</h6>
                        <p class="small text-muted mb-0">Pengelompokan dokumentasi media berdasarkan kategori kegiatan agar terstruktur dan mudah dicari.</p>
                    </div>
                </div>
            </div>

            <!-- Fitur 6 -->
            <div class="col-lg-4 col-md-6">
                <div class="p-3 border rounded-3 bg-light h-100 d-flex align-items-start">
                    <div class="feature-icon-box me-3 bg-success text-white">
                        <i class="bi bi-broadcast"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Aktivitas Tim Real-Time</h6>
                        <p class="small text-muted mb-0">Memantau status login (online/offline) anggota tim serta catatan aktivitas (log) terakhir yang dilakukan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- 2. METRICS STATISTIK DINAMIS -->
<div class="row g-3 mb-4">
    <!-- Total Petugas -->
    <div class="col-xl col-md-4 col-6">
        <div class="toska-card toska-card-hover p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small" style="color: #475569;">PETUGAS</span>
                <div class="p-2 rounded-3" style="background: #f3e8ff;">
                    <i class="bi bi-people-fill fs-5" style="color: #7c3aed;"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalPetugas ?? 0 }}</h2>
            <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Pengguna Aktif</span>
        </div>
    </div>

    <!-- Total Kegiatan -->
    <div class="col-xl col-md-4 col-6">
        <div class="toska-card toska-card-hover p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small" style="color: #475569;">KEGIATAN</span>
                <div class="p-2 rounded-3" style="background: var(--toska-subtle);">
                    <i class="bi bi-calendar-event-fill fs-5" style="color: var(--toska-dark);"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalKegiatan ?? 0 }}</h2>
            <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Agenda Liputan</span>
        </div>
    </div>

    <!-- Total Folder -->
    <div class="col-xl col-md-4 col-6">
        <div class="toska-card toska-card-hover p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small" style="color: #475569;">FOLDER</span>
                <div class="p-2 rounded-3" style="background: #fef3c7;">
                    <i class="bi bi-folder-fill fs-5 text-warning"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalFolder ?? 0 }}</h2>
            <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Direktori File</span>
        </div>
    </div>

    <!-- Total Foto -->
    <div class="col-xl col-md-4 col-6">
        <div class="toska-card toska-card-hover p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small" style="color: #475569;">FOTO</span>
                <div class="p-2 rounded-3" style="background: #ffe4e6;">
                    <i class="bi bi-image-fill fs-5 text-danger"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalFoto ?? 0 }}</h2>
            <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Berkas Gambar</span>
        </div>
    </div>

    <!-- Total Video -->
    <div class="col-xl col-md-4 col-6">
        <div class="toska-card toska-card-hover p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small" style="color: #475569;">VIDEO</span>
                <div class="p-2 rounded-3" style="background: #e0f2fe;">
                    <i class="bi bi-camera-video-fill fs-5" style="color: #0284c7;"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalVideo ?? 0 }}</h2>
            <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Rekaman Video</span>
        </div>
    </div>
</div>

        <!-- Progress Upload -->
       

    <!-- 3. GRAFIK ANALISTIK -->
    <div class="row g-4 mb-4">
        <!-- Bar Chart -->
        <div class="col-lg-8">
            <div class="toska-card h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="color: #0f172a; font-size: 16px;">
                        <i class="bi bi-bar-chart-line-fill me-2" style="color: var(--toska-primary);"></i>Aktivitas Upload Bulanan
                    </h6>
                    <span class="badge-toska">TAHUN {{ date('Y') }}</span>
                </div>
                <div style="height: 230px; position: relative;">
                    <canvas id="uploadChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="col-lg-4">
            <div class="toska-card h-100 p-4">
                <h6 class="fw-bold mb-3" style="color: #0f172a; font-size: 16px;">
                    <i class="bi bi-pie-chart-fill me-2 text-warning"></i>Proporsi Foto vs Video
                </h6>
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div style="width: 180px; height: 180px;">
                        <canvas id="pieChartMedia"></canvas>
                    </div>
                    <div class="d-flex justify-content-center gap-4 mt-3 small fw-bold">
                        <span class="text-danger"><i class="bi bi-square-fill me-1"></i> Foto ({{ $totalFoto ?? 0 }})</span>
                        <span style="color: #0284c7;"><i class="bi bi-square-fill me-1"></i> Video ({{ $totalVideo ?? 0 }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- 4. MONITORING KEGIATAN TERBARU & SIDEBAR -->
<div class="row g-4 mb-4">
    <!-- TABEL MONITORING KEGIATAN TERBARU (TANPA KOLOM STATUS) -->
    <div class="col-lg-8">
        <div class="toska-card h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white" style="border-radius: 16px 16px 0 0;">
                <h6 class="fw-bold mb-0" style="color: #0f172a; font-size: 16px;">
                    <i class="bi bi-calendar-check-fill me-2" style="color: var(--toska-primary);"></i>Monitoring Kegiatan Terbaru
                </h6>
                <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold" style="font-size: 12px;">
                    Lihat Semua Kegiatan <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-toska align-middle mb-0" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th class="ps-4 py-3">NAMA KEGIATAN</th>
                                <th>PETUGAS LAPANGAN</th>
                                <th>FOLDER</th>
                                <th class="text-center">DETAIL</th>
                            </tr>
                        </thead>
                        <tbody>
    @forelse($kegiatanTerbaru ?? [] as $kegiatan)
    @php
        // Mengambil nama petugas dari user folder pertama yang mengunggah berkas, atau fallback ke createdBy
        $petugasUploader = $kegiatan->folder->user->name 
                        ?? $kegiatan->createdBy->name 
                        ?? 'Belum Ada Upload';
    @endphp
    <tr>
        <td class="ps-4 py-3">
            <div class="fw-bold" style="color: #0f172a;">{{ $kegiatan->nama_kegiatan }}</div>
            <small style="color: #64748b;">
                <i class="bi bi-calendar3 me-1"></i>{{ $kegiatan->tanggal_kegiatan ? \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y') : '-' }}
            </small>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <div class="rounded-circle me-2 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 28px; height: 28px; background: var(--toska-dark); font-size: 12px;">
                    {{ strtoupper(substr($petugasUploader, 0, 1)) }}
                </div>
                <span class="fw-semibold" style="color: #334155;">{{ $petugasUploader }}</span>
            </div>
        </td>
        <td>
            @if(($kegiatan->folders_count ?? ($kegiatan->folder ? 1 : 0)) > 0)
                <span class="badge-toska"><i class="bi bi-folder-check me-1"></i> {{ $kegiatan->folders_count ?? 1 }} Folder</span>
            @else
                <span class="badge-rose"><i class="bi bi-folder-x me-1"></i> Folder</span>
            @endif
        </td>
        <td class="text-center">
            <a href="{{ route('admin.kegiatan.show', $kegiatan->id) }}" class="btn btn-sm btn-light border text-dark fw-bold rounded-pill px-3">
                <i class="bi bi-eye text-primary me-1"></i> Lihat
            </a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="text-center py-4 text-muted">
            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
            Belum ada data kegiatan terbaru.
        </td>
    </tr>
    @endforelse
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Sidebar: Folder Terbaru & Aktivitas Hari Ini -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                
                <!-- Card 1: Folder Terbaru Dinamis -->
                <div class="toska-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold mb-0" style="color: #0f172a; font-size: 15px;">
                            <i class="bi bi-folder-symlink-fill me-2 text-warning"></i>Folder Terbaru
                        </h6>
                        <a href="{{ route('admin.folder.index') }}" class="small fw-bold text-decoration-none" style="color: var(--toska-dark);">
                            Semua <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                    
                    <div class="d-flex flex-column gap-3">
                        @forelse($folderTerbaru ?? [] as $folder)
                        <div class="p-2 rounded-3 bg-light border">
                            <div class="fw-bold text-truncate" style="color: #0f172a; font-size: 14px;">
                                <i class="bi bi-folder2-open text-warning me-1"></i> {{ $folder->nama_folder }}
                            </div>
                            <div class="d-flex gap-2 mt-1" style="font-size: 11px;">
                                <span class="badge-rose"><i class="bi bi-image me-1"></i> {{ $folder->foto_count ?? 0 }} Foto</span>
                                <span class="badge-cyan"><i class="bi bi-camera-video me-1"></i> {{ $folder->video_count ?? 0 }} Video</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-folder-x fs-4 d-block mb-1"></i>
                            <small>Belum ada folder terbaru</small>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Card 2: Aktivitas Hari Ini Dinamis -->
                <div class="toska-card p-4">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color: #0f172a; font-size: 15px;">
                        <i class="bi bi-activity me-2" style="color: var(--toska-primary);"></i>Aktivitas Hari Ini
                    </h6>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2" style="font-size: 14px; color: #334155;">
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2 fs-6"></i>
                            <span><strong style="color: #0f172a;">{{ $folderHariIni ?? 0 }}</strong> Folder dibuat</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2 fs-6"></i>
                            <span><strong style="color: #0f172a;">{{ $fotoHariIni ?? 0 }}</strong> Foto diupload</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2 fs-6"></i>
                            <span><strong style="color: #0f172a;">{{ $videoHariIni ?? 0 }}</strong> Video diupload</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2 fs-6"></i>
                            <span><strong style="color: #0f172a;">{{ $kegiatanSelesaiHariIni ?? 0 }}</strong> Kegiatan selesai</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- 5. STATUS & AKTIVITAS TIM AKTIF -->
    <div class="toska-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
                <h6 class="fw-bold mb-1" style="color: #0f172a; font-size: 16px;">
                    <i class="bi bi-person-lines-fill me-2" style="color: var(--toska-primary);"></i>Status & Aktivitas Tim Aktif
                </h6>
                <small style="color: #64748b;">Pantau ketersediaan dan tindakan terkini dari Petugas, Editor, serta Pimpinan.</small>
            </div>
            <span class="badge-toska"><i class="bi bi-broadcast me-1 text-danger"></i> Log Real-time</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-toska align-middle mb-0" style="font-size: 14px;">
                <thead>
                    <tr class="text-muted fw-bold fs-7 text-uppercase">
                        <th class="ps-3 py-3">PENGGUNA / USER</th>
                        <th>PERAN / ROLE</th>
                        <th>STATUS LOGIN</th>
                        <th>AKTIVITAS TERAKHIR</th>
                        <th class="text-end pe-3">WAKTU</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivities ?? [] as $log)
                        @php
                            $isOnline = $log->created_at ? \Carbon\Carbon::parse($log->created_at)->gt(\Carbon\Carbon::now('Asia/Jakarta')->subMinutes(5)) : false;
                            $deskripsiAktivitas = $log->description ?? $log->activity ?? $log->aktivitas ?? $log->keterangan ?? 'Melakukan aktivitas sistem';
                        @endphp
                        <tr>
                            <td class="ps-3 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-2 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; background: var(--toska-dark); font-size: 13px;">
                                        {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-bold">{{ $log->user->name ?? 'User Terhapus' }}</span>
                                        <small class="text-muted fs-7">{{ $log->user->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light-secondary text-dark border">
                                    {{ ucfirst($log->user->role ?? 'User') }}
                                </span>
                            </td>
                            <td>
                                @if($isOnline)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 fw-bold" style="font-size: 12px;">
                                        <span class="online-indicator me-1"></span> Online
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-2 py-1 fw-bold" style="font-size: 12px;">
                                        Offline
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-dark fs-7 fw-medium">
                                    {{ $deskripsiAktivitas }}
                                </span>
                            </td>
                            <td class="text-end pe-3" style="color: #64748b; font-weight: 500;">
                                <span>
                                    {{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->locale('id')->settings(['timezone' => 'Asia/Jakarta'])->diffForHumans() : '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        @forelse($userStatusList ?? [] as $user)
                            <tr>
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; background: var(--toska-dark); font-size: 13px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold">{{ $user->name }}</span>
                                            <small class="text-muted fs-7">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light-secondary text-dark border">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td class="text-end pe-3">-</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-people fs-3 d-block mb-2"></i>
                                    Belum ada aktivitas tim tercatat.
                                </td>
                            </tr>
                        @endforelse
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    Chart.defaults.color = '#334155';
    Chart.defaults.font.weight = '600';

    // 1. Bar Chart (Aktivitas Upload Bulanan Dinamis)
    const ctxBar = document.getElementById('uploadChart');
    if(ctxBar){
        const uploadData = @json($dataUploadBulanan ?? array_fill(0, 12, 0));
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                datasets: [{
                    label: 'Upload Dokumentasi',
                    data: uploadData,
                    backgroundColor: '#0d9488',
                    borderRadius: 6,
                    hoverBackgroundColor: '#0f766e'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#e2e8f0' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Pie Chart (Proporsi Foto vs Video)
    const ctxPie = document.getElementById('pieChartMedia');
    if(ctxPie){
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Foto', 'Video'],
                datasets: [{
                    data: [{{ $totalFoto ?? 0 }}, {{ $totalVideo ?? 0 }}],
                    backgroundColor: ['#e11d48', '#0284c7'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '70%'
            }
        });
    }
</script>
@endpush