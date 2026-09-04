@extends('layouts.app')

@section('title','Dashboard Pimpinan')
@section('page-title','Dashboard Pimpinan')

@section('content')
<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #ccfbf1;
    }

    /* Green Theme Stat Cards */
    .card-stat-green {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 5px solid var(--toska-primary) !important;
        border-radius: 14px;
        transition: all 0.2s ease-in-out;
    }

    .card-stat-green:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(13, 148, 136, 0.1) !important;
    }

    .icon-wrapper-green {
        width: 52px;
        height: 52px;
        background-color: var(--toska-light);
        color: var(--toska-dark);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }

    .table-green-header thead {
        background-color: #f1f5f9;
    }

    .table-green-header th {
        color: #334155 !important;
        font-size: 13px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
</style>

{{-- BANNER WELCOME --}}
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); color: white;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-hand-thumbs-up-fill me-2"></i>Selamat Datang, {{ Auth::user()->name }}
                </h4>
                <p class="mb-0 opacity-75 small">
                    Pantau progres unggahan dokumentasi kegiatan dan berikan catatan disposisi secara langsung.
                </p>
            </div>
            <div class="d-none d-md-block text-end">
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm fw-bold">
                    <i class="bi bi-calendar3 me-1 text-teal"></i> {{ date('d F Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

{{-- STATISTIC CARDS (SERAGAM WARNA HIJAU TOSKA) --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card card-stat-green shadow-sm p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Kegiatan</span>
                    <h2 class="fw-extrabold mb-0 mt-1" style="color: var(--toska-dark);">{{ $totalKegiatan }}</h2>
                </div>
                <div class="icon-wrapper-green">
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat-green shadow-sm p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Total Folder</span>
                    <h2 class="fw-extrabold mb-0 mt-1" style="color: var(--toska-dark);">{{ $totalFolder }}</h2>
                </div>
                <div class="icon-wrapper-green">
                    <i class="bi bi-folder-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat-green shadow-sm p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Dokumentasi Foto</span>
                    <h2 class="fw-extrabold mb-0 mt-1" style="color: var(--toska-dark);">{{ $totalFoto }}</h2>
                </div>
                <div class="icon-wrapper-green">
                    <i class="bi bi-images"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-stat-green shadow-sm p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold">Dokumentasi Video</span>
                    <h2 class="fw-extrabold mb-0 mt-1" style="color: var(--toska-dark);">{{ $totalVideo }}</h2>
                </div>
                <div class="icon-wrapper-green">
                    <i class="bi bi-film"></i>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- TABEL MONITORING KEGIATAN LEBIH LENGKAP --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0 text-dark">
            <i class="bi bi-clock-history text-success me-2"></i>Kegiatan Liputan Terbaru
        </h6>
        <a href="{{ route('pimpinan.kegiatan') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-green-header">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal Liputan</th>
                        <th class="text-center">Folder</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatanTerbaru as $k)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $k->nama_kegiatan }}</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($k->created_at)->translatedFormat('d M Y') }}
                            </small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-folder-fill text-warning me-1"></i> {{ $k->folder_count ?? 0 }} Folder
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pimpinan.kegiatan') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            Belum ada data kegiatan terbaru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection