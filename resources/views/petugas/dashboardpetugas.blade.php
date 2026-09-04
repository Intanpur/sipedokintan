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
    background: var(--navbar-green);
    border-radius: 20px;
    padding: 26px 30px;
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
    font-size: 22px;
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
   ROW 1: STATISTIK CARDS
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
.icon-green  { background: #bbf7d0; color: #16a34a; }
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
   QUICK UPLOAD HUB
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

/* =========================================================
   STREAM DOKUMENTASI TERBARU
========================================================= */
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
   RIGHT SIDEBAR
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
    margin-bottom: 6px;
}

.widget-subtitle {
    font-size: 11px;
    color: #64748b;
    line-height: 1.4;
    margin-bottom: 16px;
}

.btn-chat-wa {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    background: #10b981;
    color: #ffffff !important;
    border: none;
    border-radius: 14px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    transition: all 0.25s ease;
}

.btn-chat-wa:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
}

.empty-activity {
    text-align: center;
    padding: 24px 10px;
    color: #94a3b8;
    font-size: 12px;
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

/* =========================================================
   RESPONSIVE LAYOUT
========================================================= */
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
    $userName = auth()->user()->name ?? 'Intan';
@endphp

<div class="drive-dashboard">

    {{-- PAPAN INFORMASI BANNER --}}
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
            <i class="bi bi-shield-check"></i> Sistem Aktif & Siap
        </div>
    </div>

    {{-- ROW 1: CARDS STATISTIK --}}
    <div class="stat-grid-4">

        {{-- Card 1: Total Folder --}}
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

        {{-- Card 2: Total File --}}
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

        {{-- Card 3: Status Notifikasi WA --}}
        <div class="stat-card-box">
            <div class="stat-card-top">
                <div>
                    <div class="stat-card-title">Status Notifikasi WA</div>
                    <div class="stat-card-value">{{ $waSentCount ?? 0 }} Terkirim</div>
                </div>
                <div class="stat-card-icon icon-green">
                    <i class="bi bi-whatsapp"></i>
                </div>
            </div>
            <div class="stat-card-footer">
                <span><i class="bi bi-check2-all me-1"></i> Ke Pimpinan</span>
                <span class="badge-status-pill ready">Ready</span>
            </div>
        </div>

        {{-- Card 4: Penggunaan Storage --}}
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

    {{-- LAYOUT UTAMA --}}
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

                {{-- DENGAN MENGGUNAKAN TAG <a> KE ROUTE CREATE KITA MENGHINDARI METHOD POST KETIKA BANNER DIKLIK --}}
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
                    <div style="background: #f1f5f9; padding: 30px; border-radius: 16px; border: 1px solid #cbd5e1; text-align: center; color: #64748b; font-size: 12px;">
                        <i class="bi bi-inbox" style="font-size: 32px; display: block; margin-bottom: 6px; color: #94a3b8;"></i>
                        Belum ada stream dokumentasi kegiatan terbaru.
                    </div>
                @endif
            </div>

        </div>

        {{-- KOLOM KANAN (SIDEBAR) --}}
        <div>

            {{-- WIDGET 1: KONTAK PIMPINAN SIAGA --}}
            <div class="sidebar-widget-card">
                <div class="widget-title">
                    <i class="bi bi-whatsapp text-success"></i> Kontak Pimpinan Siaga
                </div>
                <div class="widget-subtitle">
                    Pilih pimpinan tujuan untuk mengirim notifikasi pesan instan tanpa perlu buka folder satu per satu.
                </div>

                <div class="mb-3">
                    <select id="selectPimpinan" class="form-select form-select-sm" onchange="updateWaLink()" style="border-radius: 10px; font-size: 12px; padding: 8px 12px; border-color: #cbd5e1;">
                        <option value="" disabled selected>-- Pilih Pimpinan Tujuan --</option>
                        @if(isset($listPimpinan) && $listPimpinan->count() > 0)
                            @foreach($listPimpinan as $p)
                                <option value="{{ $p->no_hp }}" data-nama="{{ $p->name }}">
                                    {{ $p->name }} ({{ $p->no_hp ?? 'No. HP Belum Ada' }})
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled>Data pimpinan belum tersedia</option>
                        @endif
                    </select>
                </div>

                <a id="btnChatWa" href="#" target="_blank" class="btn-chat-wa" style="pointer-events: none; opacity: 0.5; background-color: #94a3b8; box-shadow: none;">
                    <i class="bi bi-chat-dots-fill"></i> Chat Pimpinan Sekarang
                </a>
            </div>

            <script>
            function updateWaLink() {
                const select = document.getElementById('selectPimpinan');
                const selectedOption = select.options[select.selectedIndex];
                const noHp = selectedOption.value;
                const namaPimpinan = selectedOption.getAttribute('data-nama');
                const btn = document.getElementById('btnChatWa');

                if (noHp && noHp !== 'null') {
                    let formattedPhone = noHp.replace(/[^0-9]/g, '');
                    if (formattedPhone.startsWith('0')) {
                        formattedPhone = '62' + formattedPhone.slice(1);
                    }

                    const message = encodeURIComponent(`Halo ${namaPimpinan}, laporan dokumentasi kegiatan terbaru sudah diunggah ke SIPEDOK.`);
                    
                    btn.href = `https://wa.me/${formattedPhone}?text=${message}`;
                    btn.style.pointerEvents = 'auto';
                    btn.style.opacity = '1';
                    btn.style.backgroundColor = '#10b981';
                    btn.style.boxShadow = '0 4px 12px rgba(16, 185, 129, 0.25)';
                } else {
                    alert('Nomor HP untuk pimpinan ini belum diatur oleh admin!');
                    btn.style.pointerEvents = 'none';
                    btn.style.opacity = '0.5';
                    btn.style.backgroundColor = '#94a3b8';
                    btn.style.boxShadow = 'none';
                }
            }
            </script>

            {{-- WIDGET 2: AKTIVITAS KEGIATAN TERAKHIR --}}
            <div class="sidebar-widget-card">
                <div class="widget-title">
                    <i class="bi bi-activity"></i> Aktivitas Kegiatan Terakhir
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
                    <div class="empty-activity">
                        Belum ada riwayat aktivitas folder.
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>

@endsection