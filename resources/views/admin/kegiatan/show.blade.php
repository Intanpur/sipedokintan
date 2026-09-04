@extends('layouts.app')

@section('title', 'Detail Monitoring - SIPEDOK')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
:root {
    --primary-color: #0d9488;
    --primary-dark: #0f766e;
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

.timeline-container {
    position: relative;
    padding-left: 20px;
    border-left: 2px dashed #cbd5e1;
}

.timeline-item {
    position: relative;
    padding-bottom: 24px;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -27px;
    top: 2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: var(--primary-color);
    border: 2px solid #ffffff;
}

.timeline-item.download::before {
    background-color: #0284c7;
}
</style>

<div class="container-fluid px-4 py-3">

    {{-- Header Navigation --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-2 px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Monitoring
            </a>
            <h3 class="fw-extrabold mb-0 text-dark">Detail Monitoring Aktivitas</h3>
        </div>
    </div>

    {{-- Ringkasan Informasi Folder --}}
    <div class="card card-modern p-4 mb-4">
        <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="bi bi-folder2-open text-warning me-2"></i>Informasi Folder & Pengunggah</h5>
        
        @php
            $folder = $kegiatan->folder->first();
            $uploader = $kegiatan->createdBy;
        @endphp

        <div class="row g-3">
            <div class="col-md-4">
                <small class="text-muted d-block fw-bold">NAMA FOLDER</small>
                <span class="fs-6 fw-bold text-primary">{{ $folder->nama_folder ?? '-' }}</span>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block fw-bold">NAMA KEGIATAN</small>
                <span class="fs-6 fw-bold text-dark">{{ $kegiatan->nama_kegiatan }}</span>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block fw-bold">UPLOADER</small>
                <span class="fs-6 fw-bold text-dark">{{ $uploader->name ?? '-' }}</span>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block fw-bold">ID USER / USERNAME</small>
                <span class="font-monospace text-secondary fw-semibold">{{ $uploader->id_user ?? $uploader->username ?? '-' }}</span>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block fw-bold">ROLE</small>
                <span class="badge bg-info text-dark font-monospace text-capitalize">{{ $uploader->role ?? 'Petugas' }}</span>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block fw-bold">TANGGAL UPLOAD KEGIATAN</small>
                <span class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d F Y, H:i') }} WIB</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Daftar File --}}
        <div class="col-lg-7">
            <div class="card card-modern p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="bi bi-files text-success me-2"></i>Daftar Berkas Dokumentasi</h5>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama File</th>
                                <th>Jenis</th>
                                <th>Ukuran</th>
                                <th>Waktu Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($kegiatan->folder?->dokumentasi ?? [] as $file)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark fs-7 text-truncate" style="max-width: 200px;" title="{{ $file->nama_file }}">
                                            {{ $file->nama_file }}
                                        </div>
                                    </td>
                                    <td>
                                        @if(strtolower($file->jenis ?? '') == 'foto')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-bold">Foto</span>
                                        @else
                                            <span class="badge bg-info-subtle text-info border border-info-subtle fw-bold">Video</span>
                                        @endif
                                    </td>
                                    <td class="font-monospace fs-7 text-secondary">{{ $file->ukuran_formatted ?? '-' }}</td>
                                    <td class="font-monospace fs-7 text-muted">{{ \Carbon\Carbon::parse($file->created_at)->format('H:i WIB') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada file diunggah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Timeline Aktivitas (Audit Log) --}}
        <div class="col-lg-5">
            <div class="card card-modern p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-dark"><i class="bi bi-clock-history text-info me-2"></i>Timeline Aktivitas</h5>

                <div class="timeline-container mt-3">
                    @forelse($logs as $log)
                        <div class="timeline-item {{ $log->activity == 'download' ? 'download' : '' }}">
                            <small class="text-muted font-monospace fw-bold">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</small>
                            <div class="fw-bold text-dark fs-7 mt-1">
                                {{ $log->user->name ?? 'Pengguna' }} 
                                <span class="badge bg-light text-secondary border font-monospace text-capitalize">{{ $log->user->role ?? '-' }}</span>
                            </div>
                            <div class="text-secondary fs-7 mt-1">
                                @if($log->activity == 'upload')
                                    <i class="bi bi-cloud-arrow-up text-success me-1"></i> Mengunggah <strong>{{ $log->dokumentasi->nama_file ?? 'berkas' }}</strong>
                                @else
                                    <i class="bi bi-cloud-arrow-down text-info me-1"></i> Mengunduh <strong>{{ $log->dokumentasi->nama_file ?? 'berkas' }}</strong>
                                @endif
                                @if($log->description)
                                    <div class="small text-muted fst-italic mt-1">{{ $log->description }}</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-x d-block fs-3 mb-2"></i>
                            Belum ada riwayat aktivitas tercatat.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

@endsection