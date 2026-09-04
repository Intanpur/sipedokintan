@extends('layouts.app')

@section('title', 'Dashboard Editor')

@section('content')

<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #e6f4f1;
    }

    .bg-toska {
        background-color: var(--toska-dark) !important;
    }

    .text-toska {
        color: var(--toska-dark) !important;
    }

    .card-metric {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 12px;
    }

    .card-metric:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
</style>

<div class="container-fluid py-4 px-3 px-md-4">

    {{-- Welcome Banner --}}
    <div class="card border-0 shadow-sm text-white mb-4" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); border-radius: 15px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-2 rounded-pill">
                        <i class="bi bi-stars me-1"></i> Editor Workspace
                    </span>
                    <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name ?? 'Editor' }}! 👋</h3>
                    <p class="mb-0 text-white-50">Siap untuk memproses bahan mentah dari pimpinan hari ini? Cek tugas terbarumu di bawah.</p>
                </div>
                <div>
                    <a href="{{ route('editor.prosesEditing') }}" class="btn btn-warning fw-bold px-4 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-scissors me-1"></i> Mulai Process Editing
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Metric / Statistic Cards --}}
    <div class="row g-3 mb-4">
        
        {{-- Card 1: Total Folder Masuk --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-metric shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Folder Masuk</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ $folders->count() }}</h3>
                    </div>
                    <div class="icon-shape bg-warning bg-opacity-10 text-warning fs-4">
                        <i class="bi bi-folder-symlink-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Total File Mentah --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-metric shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">File Mentah (ACC)</span>
                        @php
                            $totalFile = 0;
                            foreach($folders as $f) {
                                $totalFile += $f->dokumentasi->whereIn('status', ['dipilih', 'editing', 'selesai'])->count();
                            }
                        @endphp
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalFile }}</h3>
                    </div>
                    <div class="icon-shape bg-info bg-opacity-10 text-info fs-4">
                        <i class="bi bi-images"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Menunggu Unduh --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-metric shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Siap Diunduh</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ $folders->count() }} <span class="fs-6 text-muted fw-normal">ZIP</span></h3>
                    </div>
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary fs-4">
                        <i class="bi bi-file-earmark-zip-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4: Status System --}}
        <div class="col-xl-3 col-md-6">
            <div class="card card-metric shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Status Tim Editor</span>
                        <h3 class="fw-bold mb-0 text-success fs-5">
                            <i class="bi bi-check-circle-fill me-1"></i> Active
                        </h3>
                    </div>
                    <div class="icon-shape bg-success bg-opacity-10 text-success fs-4">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Main Content Section --}}
    <div class="row g-4">
        
        {{-- Folder Masuk Terbaru --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-toska me-2"></i>Folder Pilihan Pimpinan Terbaru
                    </h6>
                    <a href="{{ route('editor.prosesEditing') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-muted">
                                <tr>
                                    <th>NAMA FOLDER</th>
                                    <th>KEGIATAN</th>
                                    <th class="text-center">FILE MENTAH</th>
                                    <th class="text-center">TANGGAL</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($folders->take(5) as $folder)
                                    <tr>
                                        <td class="fw-bold text-dark">
                                            <i class="bi bi-folder-fill text-warning me-2 fs-5"></i>
                                            {{ $folder->nama_folder }}
                                        </td>
                                        <td class="text-muted small">
                                            {{ $folder->kegiatan->nama_kegiatan ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border px-2,5 py-1 rounded-pill">
                                                {{ $folder->dokumentasi->whereIn('status', ['dipilih', 'editing', 'selesai'])->count() }} File
                                            </span>
                                        </td>
                                        <td class="text-center small text-muted">
                                            {{ \Carbon\Carbon::parse($folder->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('editor.downloadZip', $folder->id) }}" class="btn btn-sm btn-warning fw-bold text-dark rounded-pill px-3">
                                                <i class="bi bi-download me-1"></i> ZIP
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada folder bahan mentah.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar: Instruksi Pimpinan & Panduan --}}
        <div class="col-lg-4">
            
            {{-- Box Catatan Pimpinan Terakhir --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-chat-left-quote-fill text-danger me-2"></i>Instruksi Pimpinan Terakhir
                    </h6>
                    @if($instruksiTerakhir)
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($instruksiTerakhir->updated_at)->diffForHumans() }}
                        </small>
                    @endif
                </div>
                <div class="card-body">
                    @if($instruksiTerakhir)
                        <div class="d-flex align-items-start">
                            <div class="badge bg-danger bg-opacity-10 text-danger p-2 rounded-circle me-3">
                                <i class="bi bi-exclamation-lg fs-5"></i>
                            </div>
                            <div>
                                <span class="badge bg-secondary mb-1">
                                    Folder: {{ $instruksiTerakhir->folder->nama_folder ?? '-' }}
                                </span>
                                <p class="text-dark fw-semibold mb-0 fs-6">
                                    "{{ $instruksiTerakhir->instruksi_edit }}"
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0 small">
                            Tidak ada instruksi khusus dari pimpinan saat ini.
                        </p>
                    @endif
                </div>
            </div> 
            
            {{-- Quick Guide --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-info-circle-fill text-toska me-2"></i>Panduan Alur Editor
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <span class="badge bg-toska text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:28px; height:28px;">1</span>
                        <small class="text-muted">Masuk ke menu <strong>Proses Editing</strong> atau tekan tombol ZIP di folder yang dituju.</small>
                    </div>
                    <div class="d-flex mb-3">
                        <span class="badge bg-toska text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:28px; height:28px;">2</span>
                        <small class="text-muted">Unduh seluruh berkas mentah sekaligus dalam bentuk berkas terkompresi ZIP.</small>
                    </div>
                    <div class="d-flex">
                        <span class="badge bg-toska text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:28px; height:28px;">3</span>
                        <small class="text-muted">Periksa instruksi edit pimpinan yang terlampir pada masing-masing folder.</small>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection