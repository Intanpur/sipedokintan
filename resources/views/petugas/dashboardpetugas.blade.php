@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

<style>
/* =========================================================
   VAR & GLOBAL DASHBOARD
========================================================= */
:root {
    --navbar-green: #11a394;
    --navbar-green-dark: #0e8a7d;
    --border-color: #e2e8f0;
    --card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    --card-shadow-hover: 0 12px 25px -5px rgba(17, 163, 148, 0.15);
}

.content-wrapper > h1, 
.content-wrapper > h2, 
main > h1, 
main > h2,
.page-title-outside {
    display: none !important;
}

.drive-dashboard {
    width: 100%;
    padding: 10px 4px 40px;
    color: #1e293b;
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
}

/* =========================================================
   PAPAN INFORMASI / BANNER
========================================================= */
.info-banner-cyan {
    background: linear-gradient(135deg, var(--navbar-green) 0%, var(--navbar-green-dark) 100%);
    border-radius: 20px;
    padding: 28px 32px;
    color: #ffffff;
    margin-bottom: 24px;
    box-shadow: 0 10px 25px -5px rgba(17, 163, 148, 0.3);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.banner-content {
    position: relative;
    z-index: 2;
}

.banner-dashboard-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(4px);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    margin-bottom: 10px;
    border: 1px solid rgba(255, 255, 255, 0.25);
}

.banner-title {
    font-size: 24px;
    font-weight: 800;
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: -0.3px;
}

.banner-subtitle {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.92);
    margin: 0;
    line-height: 1.5;
}

.banner-badge {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 10px 18px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

/* =========================================================
   PANDUAN FITUR PETUGAS
========================================================= */
.feature-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    background-color: var(--navbar-green-dark);
    color: #ffffff;
    flex-shrink: 0;
}

.row-cols-md-5 > * {
    flex: 0 0 auto;
    width: 20%;
}

@media (max-width: 992px) {
    .row-cols-md-5 > * { width: 50%; }
}

@media (max-width: 576px) {
    .row-cols-md-5 > * { width: 100%; }
}

/* =========================================================
   STATISTIK CARDS
========================================================= */
.stat-grid-4 {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card-box {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 18px;
    padding: 20px;
    box-shadow: var(--card-shadow);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.25s ease;
}

.stat-card-box:hover {
    transform: translateY(-2px);
    box-shadow: var(--card-shadow-hover);
}

.stat-card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.stat-card-title {
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 6px;
}

.stat-card-value {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
}

.stat-card-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.icon-yellow { background: #fef08a; color: #ca8a04; }
.icon-cyan   { background: #ccfbf1; color: var(--navbar-green-dark); }
.icon-green  { background: #dcfce7; color: #15803d; }
.icon-red    { background: #fecdd3; color: #e11d48; }

.stat-card-footer {
    margin-top: 16px;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11px;
    color: #64748b;
}

.badge-status-pill {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
}

.badge-status-pill.aktif { background: #f1f5f9; color: #334155; }
.badge-status-pill.ready { background: #dcfce7; color: #15803d; }

.storage-progress-container {
    width: 100%;
    margin-top: 14px;
}
.storage-bar-bg {
    width: 100%;
    height: 6px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
}
.storage-bar-fill {
    height: 100%;
    background: #e11d48;
    border-radius: 10px;
}

/* =========================================================
   LAYOUT UTAMA
========================================================= */
.dashboard-main-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 20px;
}

/* =========================================================
   QUICK UPLOAD HUB & STREAM
========================================================= */
.upload-hub-card {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 24px;
    box-shadow: var(--card-shadow);
    margin-bottom: 24px;
}

.hub-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.hub-title {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

.hub-subtitle {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
}

.btn-buat-folder {
    font-size: 12px;
    font-weight: 700;
    color: var(--navbar-green-dark);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    border-radius: 8px;
    transition: background 0.2s ease;
}

.btn-buat-folder:hover {
    background: #f0fdfa;
    color: var(--navbar-green);
}

.upload-dropzone-link {
    display: block;
    text-decoration: none;
}

.upload-dropzone {
    border: 2px dashed #99f6e4;
    background: #f0fdfa;
    border-radius: 16px;
    padding: 36px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
}

.upload-dropzone:hover {
    background: #ccfbf1;
    border-color: var(--navbar-green);
}

.upload-icon-circle {
    width: 44px;
    height: 44px;
    background: #0f172a;
    color: #ffffff;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
}

.dropzone-text-main {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}

.dropzone-text-sub {
    font-size: 11px;
    color: #64748b;
}

.stream-section-title {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
}

.folder-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}

.folder-card {
    display: flex;
    align-items: center;
    height: 56px;
    padding: 0 16px;
    border-radius: 14px;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    text-decoration: none;
    color: #0f172a;
    transition: all 0.2s ease;
}

.folder-card:hover {
    background: #e2e8f0;
    border-color: #eab308;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px -3px rgba(234, 179, 8, 0.25);
}

.folder-icon {
    font-size: 24px;
    color: #eab308;
    margin-right: 12px;
    display: flex;
    align-items: center;
    filter: drop-shadow(0 2px 4px rgba(234, 179, 8, 0.3));
}

.folder-name {
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

/* =========================================================
   RIGHT SIDEBAR & EXTRA WIDGETS
========================================================= */
.sidebar-widget-card {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 22px;
    box-shadow: var(--card-shadow);
    margin-bottom: 20px;
}

.widget-title {
    font-size: 14px;
    font-weight: 800;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.activity-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.activity-item {
    display: flex;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px dashed #f1f5f9;
    font-size: 11px;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #ccfbf1;
    color: var(--navbar-green-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 24px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #1e293b;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    margin-bottom: 8px;
}

.quick-action-btn:last-child {
    margin-bottom: 0;
}

.quick-action-btn:hover {
    background: #f0fdfa;
    border-color: var(--navbar-green);
    color: var(--navbar-green-dark);
}

@media (max-width: 1024px) {
    .dashboard-main-grid { grid-template-columns: 1fr; }
    .stat-grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 640px) {
    .info-banner-cyan { flex-direction: column; align-items: flex-start; gap: 14px; }
    .stat-grid-4 { grid-template-columns: 1fr; }
    .folder-grid { grid-template-columns: 1fr; }
}
</style>

@php
    $userName = auth()->user()->name ?? 'Petugas';
@endphp

<div class="drive-dashboard">

    {{-- ALERT FEEDBACK UMUM --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 1. BANNER INFORMASI --}}
    <div class="info-banner-cyan">
        <div class="banner-content">
            <div class="banner-dashboard-tag">
                <i class="bi bi-grid-fill"></i> Dashboard Petugas
            </div>
            <h2 class="banner-title">
                Selamat Datang Kembali, {{ $userName }}! 👋
            </h2>
            <p class="banner-subtitle">
                Papan informasi sistem dokumentasi liputan SIPEDOK. Pastikan seluruh foto dan video kegiatan ter-unggah secara rapi.
            </p>
        </div>
        <div class="banner-badge">
            <i class="bi bi-shield-check"></i> Akses Petugas Aktif
        </div>
    </div>

    {{-- 2. PANDUAN FITUR UTAMA PETUGAS --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 18px;">
        <div class="card-header bg-white py-3 border-bottom" style="border-radius: 18px 18px 0 0;">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-info-circle-fill me-2" style="color: var(--navbar-green);"></i>Panduan Fitur Utama Petugas
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3 row-cols-md-5">
                <!-- Fitur 1: Data Kegiatan -->
                <div>
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="feature-icon-box me-2">
                                <i class="bi bi-calendar2-event-fill"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">1. Data Kegiatan</h6>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 11px; line-height: 1.4;">
                            Mencari, memfilter (bulan/tahun), dan menjelajahi folder dokumentasi liputan secara interaktif.
                        </p>
                    </div>
                </div>

                <!-- Fitur 2: Kelola Folder -->
                <div>
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="feature-icon-box me-2">
                                <i class="bi bi-folder-plus"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">2. Kelola Folder</h6>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 11px; line-height: 1.4;">
                            Membuat folder agenda baru dengan mengisi nama kegiatan, lokasi, serta tanggal pelaksanaan.
                        </p>
                    </div>
                </div>

                <!-- Fitur 3: Notifikasi WA Pimpinan -->
                <div>
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="feature-icon-box me-2" style="background-color: #25d366;">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">3. Info WA Pimpinan</h6>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 11px; line-height: 1.4;">
                            Setelah membuat folder, gunakan tombol *📲 Kirim Notifikasi WA* di dalam folder untuk memberi tahu pimpinan via Fonnte.
                        </p>
                    </div>
                </div>

                <!-- Fitur 4: Unggah Media -->
                <div>
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="feature-icon-box me-2">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">4. Unggah Media</h6>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 11px; line-height: 1.4;">
                            Mengunggah berkas foto dan video dokumentasi secara kilat melalui area *Quick Upload Hub*.
                        </p>
                    </div>
                </div>

                <!-- Fitur 5: Pantau Storage -->
                <div>
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <div class="d-flex align-items-center mb-2">
                            <div class="feature-icon-box me-2">
                                <i class="bi bi-hdd-network"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 13px;">5. Pantau Storage</h6>
                        </div>
                        <p class="small text-muted mb-0" style="font-size: 11px; line-height: 1.4;">
                            Memantau kapasitas penyimpanan media dan riwayat aktivitas unggahan secara *real-time*.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. CARDS STATISTIK --}}
    <div class="stat-grid-4">
        <div class="stat-card-box">
            <div class="stat-card-top">
                <div>
                    <div class="stat-card-title">Total Folder Liputan</div>
                    <div class="stat-card-value">{{ $totalFolder ?? 0 }}</div>
                </div>
                <div class="stat-card-icon icon-yellow">
                    <i class="bi bi-folder-fill"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span><i class="bi bi-graph-up-arrow me-1"></i> Terbanyak bulan ini</span>
                <span class="badge-status-pill aktif">Aktif</span>
            </div>
        </div>

        <div class="stat-card-box">
            <div class="stat-card-top">
                <div>
                    <div class="stat-card-title">Total File Unggahan</div>
                    <div class="stat-card-value">{{ ($totalFoto ?? 0) + ($totalVideo ?? 0) }}</div>
                </div>
                <div class="stat-card-icon icon-cyan">
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span><i class="bi bi-image me-1"></i> {{ $totalFoto ?? 0 }} Foto</span>
                <span><i class="bi bi-camera-reels me-1"></i> {{ $totalVideo ?? 0 }} Video</span>
            </div>
        </div>

        <div class="stat-card-box">
            <div class="stat-card-top">
                <div>
                    <div class="stat-card-title">Aktivitas Hari Ini</div>
                    <div class="stat-card-value">{{ $todayUploadsCount ?? 0 }}</div>
                </div>
                <div class="stat-card-icon icon-green">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span><i class="bi bi-clock-history me-1"></i> Update real-time</span>
                <span class="badge-status-pill ready">Siap</span>
            </div>
        </div>

        <div class="stat-card-box">
            <div class="stat-card-top">
                <div>
                    <div class="stat-card-title">Penggunaan Storage</div>
                    <div class="stat-card-value">{{ $storageUsedFormatted ?? '0.0 MB' }}</div>
                </div>
                <div class="stat-card-icon icon-red">
                    <i class="bi bi-hdd-stack-fill"></i>
                </div>
            </div>
            <div class="storage-progress-container">
                <div class="storage-bar-bg">
                    <div class="storage-bar-fill" style="width: {{ $storagePercentage ?? 5 }}%;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. LAYOUT UTAMA --}}
    <div class="dashboard-main-grid">

        {{-- KOLOM KIRI --}}
        <div>
            {{-- QUICK UPLOAD HUB --}}
            <div class="upload-hub-card">
                <div class="hub-header">
                    <div>
                        <h3 class="hub-title">⚡ Quick Upload Hub</h3>
                        <div class="hub-subtitle">Unggah dokumentasi baru secara kilat ke folder aktif</div>
                    </div>
                    @if(Route::has('petugas.kegiatan.create'))
                        <a href="{{ route('petugas.kegiatan.create') }}" class="btn-buat-folder">
                            <i class="bi bi-plus-lg"></i> Buat Folder Baru
                        </a>
                    @endif
                </div>

                <a href="{{ Route::has('petugas.kegiatan.create') ? route('petugas.kegiatan.create') : url('petugas/kegiatan/create') }}" class="upload-dropzone-link">
                    <div class="upload-dropzone">
                        <div class="upload-icon-circle">
                            <i class="bi bi-arrow-up"></i>
                        </div>
                        <div class="dropzone-text-main">
                            Klik di sini untuk upload cepat foto/video liputan
                        </div>
                        <div class="dropzone-text-sub">
                            Mendukung format JPG, PNG, MP4, MOV. File akan langsung terorganisir di sistem.
                        </div>
                    </div>
                </a>
            </div>

            {{-- STREAM DOKUMENTASI TERBARU --}}
            <div>
                <div class="stream-section-title">
                    <i class="bi bi-play-btn-fill text-danger"></i> Stream Dokumentasi Terbaru
                </div>

                @if(isset($folders) && $folders->count() > 0)
                    <div class="folder-grid">
                        @foreach($folders as $folder)
                            @php $folderName = $folder->nama_folder ?? $folder->nama ?? 'Folder Liputan'; @endphp
                            <a href="{{ Route::has('petugas.folder.show') ? route('petugas.folder.show', $folder->id) : '#' }}" class="folder-card">
                                <div class="folder-icon">
                                    <i class="bi bi-folder-fill"></i>
                                </div>
                                <div class="folder-name" title="{{ $folderName }}">{{ $folderName }}</div>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- VISUAL KHUSUS JIKA EMPTY / KOSONG --}}
                    <div class="card border-0 shadow-sm text-center py-5 px-4" style="border-radius: 18px; background: #ffffff;">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light text-warning rounded-circle" style="width: 70px; height: 70px;">
                                <i class="bi bi-folder-plus" style="font-size: 32px;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Belum Ada Folder Dokumentasi</h6>
                        <p class="text-muted small mb-3" style="max-width: 420px; margin: 0 auto; font-size: 12px;">
                            Mulai dengan membuat folder kegiatan pertama Anda untuk mengorganisir foto dan video liputan secara rapi.
                        </p>
                        @if(Route::has('petugas.kegiatan.create'))
                            <div>
                                <a href="{{ route('petugas.kegiatan.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold" style="background-color: var(--navbar-green); border: none;">
                                    <i class="bi bi-plus-circle me-1"></i> Buat Folder Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN (SIDEBAR) --}}
        <div>
            {{-- WIDGET PANDUAN CEPAT NOTIFIKASI --}}
            <div class="sidebar-widget-card" style="background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%); border-color: #bbf7d0;">
                <div class="widget-title text-success">
                    <i class="bi bi-whatsapp"></i> Alur Notifikasi Pimpinan
                </div>
                <div class="text-muted mb-3" style="font-size: 11px; line-height: 1.5;">
                    Ingin mengirim notifikasi ke pimpinan?
                </div>
                <ol class="ps-3 mb-0 text-muted" style="font-size: 11px; line-height: 1.6;">
                    <li class="mb-1">Buat / Buka *Folder Kegiatan*.</li>
                    <li class="mb-1">Klik tombol <strong class="text-success">📲 Kirim Notifikasi WA</strong> di halaman detail folder.</li>
                    <li>Pilih nama pimpinan dan klik *Kirim Sekarang*.</li>
                </ol>
            </div>

            {{-- WIDGET PINTASAN CEPAT --}}
            <div class="sidebar-widget-card">
                <div class="widget-title">
                    <i class="bi bi-lightning-charge-fill text-warning"></i> Pintasan Cepat
                </div>

                @if(Route::has('petugas.kegiatan.index'))
                    <a href="{{ route('petugas.kegiatan.index') }}" class="quick-action-btn">
                        <i class="bi bi-folder2-open text-primary fs-5"></i>
                        <span>Lihat Semua Kegiatan</span>
                    </a>
                @endif
            </div>

            {{-- WIDGET AKTIVITAS KEGIATAN TERAKHIR --}}
            <div class="sidebar-widget-card">
                <div class="widget-title">
                    <i class="bi bi-activity text-info"></i> Aktivitas Terakhir
                </div>

                @if(isset($recentActivities) && count($recentActivities) > 0)
                    <ul class="activity-list">
                        @foreach($recentActivities as $act)
                            <li class="activity-item">
                                <div class="activity-icon"><i class="bi bi-check-circle-fill"></i></div>
                                <div>
                                    <strong style="color: #0f172a; display: block;">{{ $act->title ?? 'Mengunggah File' }}</strong>
                                    <span style="color: #64748b;">{{ isset($act->created_at) ? \Carbon\Carbon::parse($act->created_at)->diffForHumans() : 'Baru saja' }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4 text-muted" style="font-size: 11px;">
                        <i class="bi bi-clock-history d-block mb-1 fs-4 text-secondary"></i>
                        Belum ada riwayat aktivitas.
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection