@extends('layouts.app')

@section('title', 'Folder Dokumentasi - SIPEDOK')

@section('content')
<!-- GOOGLE FONTS & BOOTSTRAP ICONS -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- TEMA HIJAU TOSKA & STYLES -->
<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #14b8a6;
        --toska-accent: #2dd4bf;
        --toska-subtle: #ccfbf1;
        --bg-body: #f1f5f9;
        --card-bg: #ffffff;
        --text-dark: #0f172a;
        --text-muted: #475569;
        --border-color: #cbd5e1;
    }

    body {
        background-color: var(--bg-body) !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-dark);
    }

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

    .toska-banner {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.3);
    }

    /* Custom Badges */
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

    /* Form Controls */
    .form-control-toska, .form-select-toska {
        border: 1.5px solid var(--border-color);
        border-radius: 10px;
        padding: 10px 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-control-toska:focus, .form-select-toska:focus {
        border-color: var(--toska-primary);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
    }

    /* Tabel Styling */
    .table-toska {
        color: var(--text-dark) !important;
    }

    .table-toska th {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    .table-toska td {
        color: #0f172a !important;
        vertical-align: middle;
    }
</style>

<div class="container-fluid pb-5 pt-3">

    <!-- 1. HERO BANNER HALAMAN INDEX -->
    <div class="toska-banner p-4 p-lg-5 text-white mb-4 position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <span class="badge bg-white text-dark fw-bold px-3 py-2 rounded-pill mb-3 shadow-sm" style="color: var(--toska-dark) !important;">
                    <i class="bi bi-folder-fill me-1 text-warning"></i> Pusat Repositori Berkas
                </span>
                <h2 class="fw-extrabold mb-2 display-6 text-white" style="font-weight: 800;">
                    Folder Dokumentasi
                </h2>
                <p class="fs-6 mb-0" style="color: #e6fffa; font-weight: 500;">
                    Kelola dan jelajahi seluruh direktori foto & video liputan kegiatan Diskominfo secara terpusat.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">
                    <i class="bi bi-calendar-plus text-success me-2"></i> Buat Folder via Kegiatan
                </a>
            </div>
        </div>
    </div>

    <!-- 2. STATISTIK FOLDER & MEDIA -->
    <div class="row g-3 mb-4">
        <!-- Total Folder -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="toska-card toska-card-hover p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold small" style="color: #475569;">TOTAL FOLDER</span>
                    <div class="p-2 rounded-3" style="background: #fef3c7;">
                        <i class="bi bi-folder-fill fs-5 text-warning"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalFolder ?? 0 }}</h3>
                <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Direktori Aktif</span>
            </div>
        </div>

        <!-- Total Foto -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="toska-card toska-card-hover p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold small" style="color: #475569;">TOTAL FOTO</span>
                    <div class="p-2 rounded-3" style="background: #ffe4e6;">
                        <i class="bi bi-image-fill fs-5 text-danger"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalFoto ?? 0 }}</h3>
                <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Berkas Gambar</span>
            </div>
        </div>

        <!-- Total Video -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="toska-card toska-card-hover p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold small" style="color: #475569;">TOTAL VIDEO</span>
                    <div class="p-2 rounded-3" style="background: #e0f2fe;">
                        <i class="bi bi-camera-video-fill fs-5" style="color: #0284c7;"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalVideo ?? 0 }}</h3>
                <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Rekaman Video</span>
            </div>
        </div>

        <!-- Ukuran Storage -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="toska-card toska-card-hover p-3 h-100" style="border-left: 4px solid var(--toska-primary) !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold small" style="color: #475569;">TOTAL UKURAN</span>
                    <div class="p-2 rounded-3" style="background: var(--toska-subtle);">
                        <i class="bi bi-hdd-network-fill fs-5" style="color: var(--toska-dark);"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0" style="color: var(--toska-dark);">{{ $totalUkuranStorage ?? '0 MB' }}</h3>
                <span class="fw-semibold" style="font-size: 12px; color: #64748b;">Kapasitas Terpakai</span>
            </div>
        </div>
    </div>

    <!-- 3. SEARCH, FILTER, & SORT BAR -->
    <div class="toska-card p-4 mb-4">
        <form action="{{ route('admin.folder.index') }}" method="GET">
            <div class="row g-3 align-items-center">
                <!-- Search Input -->
                <div class="col-lg-5 col-md-6">
                    <label class="form-label fw-bold small text-muted mb-1">CARI FOLDER / KEGIATAN</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 border" style="border-radius: 10px 0 0 10px;">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-toska border-start-0" placeholder="Ketik nama folder, kegiatan, atau petugas...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-lg-3 col-md-3 col-6">
                    <label class="form-label fw-bold small text-muted mb-1">STATUS FOLDER</label>
                    <select name="status" class="form-select form-select-toska" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <!-- Sort Options -->
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label fw-bold small text-muted mb-1">URUTKAN</label>
                    <select name="sort" class="form-select form-select-toska" onchange="this.form.submit()">
                        <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="terbanyak" {{ request('sort') == 'terbanyak' ? 'selected' : '' }}>File Terbanyak</option>
                    </select>
                </div>

                <!-- Submit & Reset Buttons -->
                <div class="col-lg-2 col-md-12 d-flex gap-2 align-self-end">
                    <button type="submit" class="btn btn-success fw-bold text-white w-100 rounded-3 py-2" style="background: var(--toska-dark); border: none;">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'sort']))
                        <a href="{{ route('admin.folder.index') }}" class="btn btn-outline-danger fw-bold rounded-3 py-2" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- 4. TABEL DIREKTORI FOLDER -->
    <div class="toska-card mb-4">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white" style="border-radius: 16px 16px 0 0;">
            <h6 class="fw-bold mb-0" style="color: #0f172a; font-size: 16px;">
                <i class="bi bi-folder2-open me-2" style="color: var(--toska-primary);"></i>Daftar Folder Dokumentasi
            </h6>
            <span class="badge-toska">Total: {{ $folders->total() ?? 0 }} Folder</span>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-toska align-middle mb-0" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">NAMA FOLDER & KEGIATAN</th>
                            <th>PETUGAS UPLOADER</th>
                            <th>KONTEN MEDIA</th>
                            <th>UKURAN</th>
                            <th>STATUS</th>
                            <th>TANGGAL BUAT</th>
                            <th class="text-center pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($folders as $folder)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-folder-fill text-warning fs-3 me-3"></i>
                                    <div>
                                        <a href="{{ route('admin.folder.show', $folder->id) }}" class="fw-bold text-decoration-none text-dark d-block mb-1 hover-toska">
                                            {{ $folder->nama_folder }}
                                        </a>
                                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>{{ $folder->kegiatan->nama_kegiatan ?? 'Kegiatan Umum' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-2 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 30px; height: 30px; background: var(--toska-dark); font-size: 12px;">
                                        {{ strtoupper(substr($folder->user->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold" style="color: #334155;">{{ $folder->user->name ?? 'Sistem' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <span class="badge-rose" title="Jumlah Foto">
                                        <i class="bi bi-image me-1"></i> {{ $folder->foto_count ?? 0 }}
                                    </span>
                                    <span class="badge-cyan" title="Jumlah Video">
                                        <i class="bi bi-camera-video me-1"></i> {{ $folder->video_count ?? 0 }}
                                    </span>
                                </div>
                            </td>
                            <td class="fw-semibold" style="color: #475569;">
                                {{ $folder->size_formatted ?? '0 MB' }}
                            </td>
                            <td>
                                @if(($folder->status ?? '') == 'selesai')
                                    <span class="badge-toska"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                                @elseif(($folder->status ?? '') == 'proses')
                                    <span class="badge-amber"><i class="bi bi-hourglass-split me-1"></i> Proses</span>
                                @else
                                    <span class="badge-cyan"><i class="bi bi-clock me-1"></i> Pending</span>
                                @endif
                            </td>
                            <td style="color: #64748b; font-weight: 500;">
                                {{ $folder->created_at ? $folder->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.folder.show', $folder->id) }}" class="btn btn-sm btn-success fw-bold rounded-pill px-3 py-1 shadow-sm" style="background: var(--toska-dark); border: none;">
                                    <i class="bi bi-folder2-open me-1"></i> Buka Folder
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                <h6 class="fw-bold mb-1">Tidak Ada Folder Ditemukan</h6>
                                <p class="small mb-0">Coba ubah kata kunci pencarian atau filter status Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5. PAGINASI DINAMIS -->
        @if(method_exists($folders, 'hasPages') && $folders->hasPages())
        <div class="p-3 border-top d-flex justify-content-between align-items-center bg-white" style="border-radius: 0 0 16px 16px;">
            <div class="small text-muted fw-semibold">
                Menampilkan {{ $folders->firstItem() }} - {{ $folders->lastItem() }} dari {{ $folders->total() }} Folder
            </div>
            <div>
                {{ $folders->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>

    <!-- 6. FOOTER -->
    <footer class="mt-5 pt-3 border-top text-center small" style="color: #64748b;">
        <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row">
            <div>
                <strong style="color: var(--toska-dark);">SIPEDOK</strong> — Sistem Informasi Pengelolaan Dokumentasi
            </div>
            <div class="mt-2 mt-sm-0">
                &copy; {{ date('Y') }} <strong>Dinas Komunikasi dan Informatika Kabupaten Pringsewu</strong>
            </div>
        </div>
    </footer>

</div>
@endsection