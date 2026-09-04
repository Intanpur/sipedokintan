@extends('layouts.app')

@section('title', 'Monitoring Unggahan & Aktivitas - SIPEDOK')

@section('content')

<!-- Font & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
:root {
    --primary-color: #0d9488;
    --primary-dark: #0f766e;
    --primary-light: #14b8a6;
    --bg-main: #f8fafc;
    --card-border: rgba(226, 232, 240, 0.8);
}

body {
    background-color: var(--bg-main);
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #334155;
}

.card-modern {
    background: #ffffff;
    border: 1px solid var(--card-border);
    border-radius: 20px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.03);
}

.banner-hero {
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
    border-radius: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 30px -5px rgba(13, 148, 136, 0.3);
}

.stat-card {
    background: #ffffff;
    border: 1px solid var(--card-border);
    border-radius: 18px;
    padding: 1.25rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.06);
}

.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}

.table-custom thead th {
    background-color: #f8fafc;
    color: #64748b;
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 700;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
}

.table-custom tbody td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.875rem;
}

.btn-action-detail {
    background-color: #f0fdf4;
    color: var(--primary-dark);
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 6px 14px;
    font-weight: 600;
    font-size: 0.813rem;
}

.btn-action-detail:hover {
    background-color: var(--primary-color);
    color: #ffffff;
}
</style>

<div class="container-fluid px-4 py-3">

    {{-- Banner Header --}}
    <div class="banner-hero text-white p-4 p-lg-5 mb-4">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-8">
                <h2 class="fw-extrabold fs-1 mb-2">Monitoring Unggahan & Aktivitas Petugas</h2>
                <p class="mb-0 text-white-50 fs-6">
                    Audit Trail & Jejak Aktivitas: Pantau riwayat pengunggahan dan pengunduhan berkas secara akurat tanpa saling menyalahkan.
                </p>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-shield-check display-1 text-white opacity-25"></i>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        {{-- Total Kegiatan --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-bold fs-7 text-uppercase">Total Kegiatan</span>
                        <h2 class="fw-extrabold fs-2 mt-1 mb-0 text-dark">{{ $totalKegiatan }}</h2>
                    </div>
                    <div class="icon-box" style="background: #ccfbf1; color: #0f766e;">
                        <i class="bi bi-collection-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Upload --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-bold fs-7 text-uppercase">Total Upload</span>
                        <h2 class="fw-extrabold fs-2 mt-1 mb-0 text-dark">{{ $totalUpload }}</h2>
                    </div>
                    <div class="icon-box" style="background: #dcfce7; color: #15803d;">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Download --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-bold fs-7 text-uppercase">Total Download</span>
                        <h2 class="fw-extrabold fs-2 mt-1 mb-0 text-dark">{{ $totalDownload }}</h2>
                    </div>
                    <div class="icon-box" style="background: #e0f2fe; color: #0369a1;">
                        <i class="bi bi-cloud-arrow-down-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Table --}}
    <div class="card card-modern">
        <div class="p-4 border-bottom">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-text me-2 text-success"></i>Tabel Monitoring Aktivitas</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari kegiatan, folder, atau pengunggah..." onkeyup="filterTable()" style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>Nama Kegiatan</th>
                            <th>Folder</th>
                            <th>Pengunggah</th>
                            <th>Role</th>
                            <th class="text-center">Jumlah File</th>
                            <th>Upload Terakhir</th>
                            <th class="text-center" width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatan as $item)
                      @php
                        $folder = $item->folder; // Mengambil objek folder (hasOne)
                        $files = $folder ? $folder->dokumentasi : collect(); // Ambil relasi dokumentasi jika folder ada
                        
                        $filesCount = $files->count();
                        $lastFile = $files->sortByDesc('created_at')->first();
                    @endphp
                            <tr class="table-row" data-search="{{ strtolower($item->nama_kegiatan . ' ' . ($folder->nama_folder ?? '') . ' ' . ($item->createdBy->name ?? '')) }}">
                                <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td><div class="fw-bold text-dark fs-6">{{ $item->nama_kegiatan }}</div></td>
                                <td>
                                    <span class="badge bg-light text-primary border fw-semibold">
                                        <i class="bi bi-folder-fill me-1"></i>{{ $folder->nama_folder ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->createdBy->name ?? '-' }}</div>
                                    <small class="text-muted font-monospace">{{ $item->createdBy->id_user ?? $item->createdBy->username ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark fw-bold text-capitalize">
                                        {{ $item->createdBy->role ?? 'Petugas' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill px-3">{{ $filesCount }} File</span>
                                </td>
                                <td class="text-secondary font-monospace fs-7">
                                    {{ $lastFile ? \Carbon\Carbon::parse($lastFile->created_at)->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.kegiatan.show', $item->id) }}" class="btn btn-action-detail text-nowrap">
                                        <i class="bi bi-eye-fill me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                    Belum ada data kegiatan & aktivitas log.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function filterTable() {
    let keyword = document.getElementById('searchInput').value.toLowerCase();
    let rows = document.querySelectorAll('.table-row');

    rows.forEach(function(row) {
        let text = row.dataset.search;
        if (text.includes(keyword)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>

@endsection