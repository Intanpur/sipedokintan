@extends('layouts.app')

@section('title', 'Proses Editing')

@section('content')

<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #f0fdfa;
        --toska-border: #ccfbf1;
    }

    .badge-toska {
        background-color: var(--toska-light);
        color: var(--toska-dark);
        border: 1px solid var(--toska-border);
    }

    .card-folder {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.25s ease-in-out;
        background: #ffffff;
    }

    .card-folder:hover {
        box-shadow: 0 10px 25px rgba(15, 118, 110, 0.08) !important;
        border-color: #cbd5e1;
    }

    .folder-header {
        background-color: #fafafa;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
        border-bottom: 1px solid #f1f5f9;
    }

    .icon-folder-box {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        box-shadow: inset 0 0 0 1px rgba(217, 119, 6, 0.2);
    }

    .btn-gradient-toska {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-gradient-toska:hover {
        background: linear-gradient(135deg, #0d9488 0%, #115e59 100%);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
    }

    .btn-soft-warning {
        background-color: #fffbe3;
        color: #b45309;
        border: 1px solid #fde68a;
        transition: all 0.2s ease;
    }

    .btn-soft-warning:hover {
        background-color: #fef3c7;
        color: #92400e;
        transform: translateY(-1px);
    }

    .table-modern tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-modern tbody tr:hover {
        background-color: #f8fafc;
    }

    .instruction-box {
        background-color: #fff5f5;
        border-left: 4px solid #ef4444;
        border-radius: 0 8px 8px 0;
    }
</style>

<div class="container-fluid py-4 px-3 px-md-4">

    {{-- Banner Header Estetis Hijau/Teal --}}
    <div class="card border-0 shadow-sm text-white mb-4" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); border-radius: 16px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1,5 rounded-pill fw-medium">
                        <i class="bi bi-scissors me-1"></i> Ruang Kerja Editor
                    </span>
                    <h3 class="fw-bold mb-1">Proses Editing – Berkas Bahan Mentah</h3>
                    <p class="mb-0 text-white-50">Semua folder dan file mentah yang telah didisposisi oleh pimpinan dan siap untuk diunduh.</p>
                </div>
                <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-2 rounded-3 border border-white border-opacity-20">
                    <i class="bi bi-folder-check fs-3 text-warning"></i>
                    <div class="text-start">
                        <span class="d-block small text-white-50 leading-none">Total Folder Ready</span>
                        <strong class="fs-5 text-white">{{ $folders->count() }} Folder</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i> 
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i> 
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- Daftar Folder Bahan Mentah --}}
    @forelse($folders as $folder)
        @php
            $filesACC = $folder->dokumentasi->whereIn('status', ['dipilih', 'editing', 'selesai']);
        @endphp

        <div class="card card-folder shadow-sm mb-4">
            
            {{-- Header Card Folder --}}
            <div class="card-header folder-header py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-folder-box">
                        <i class="bi bi-folder-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="fw-bold text-dark mb-0 fs-6">{{ $folder->nama_folder }}</h5>
                            <span class="badge bg-light text-secondary border px-2,5 py-1 rounded-pill small">
                                <i class="bi bi-tag-fill text-teal me-1"></i>{{ $folder->kegiatan->nama_kegiatan ?? 'Kegiatan Umun' }}
                            </span>
                        </div>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-calendar3 me-1"></i>
                            Diterima: {{ \Carbon\Carbon::parse($folder->created_at)->translatedFormat('d F Y - H:i') }} WIB
                        </small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    {{-- Badge Jumlah File --}}
                    <span class="badge badge-toska px-3 py-2 rounded-pill fw-semibold me-1">
                        <i class="bi bi-images me-1 text-teal"></i>{{ $filesACC->count() }} Berkas Mentah
                    </span>

                    {{-- Tombol Download ZIP Folder --}}
                    <a href="{{ route('editor.downloadZip', $folder->id) }}" class="btn btn-soft-warning fw-bold btn-sm rounded-pill px-3 py-2 shadow-sm">
                        <i class="bi bi-file-earmark-zip-fill me-1"></i> Unduh Semua (ZIP)
                    </a>
                </div>
            </div>

            {{-- Catatan Pimpinan khusus Folder Ini (Jika Ada) --}}
            @if(!empty($folder->catatan_pimpinan))
                <div class="instruction-box px-4 py-2,5 mx-4 mt-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-chat-left-quote-fill text-danger mt-1"></i>
                        <div>
                            <small class="fw-bold text-danger text-uppercase d-block" style="font-size: 11px; letter-spacing: 0.5px;">Instruksi Pimpinan untuk Folder ini:</small>
                            <span class="small text-dark fw-medium">{{ $folder->catatan_pimpinan }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tabel Berkas dalam Folder --}}
            <div class="card-body p-0 mt-2">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead class="table-light small text-muted text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                            <tr>
                                <th width="60" class="text-center ps-4">NO</th>
                                <th>NAMA FILE MENTAH</th>
                                <th>CATATAN REVISI / INSTRUKSI EDIT</th>
                                <th width="140" class="text-center">STATUS</th>
                                <th width="140" class="text-center pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filesACC as $file)
                                <tr>
                                    <td class="text-center fw-bold text-muted ps-4" style="font-size: 12px;">
                                        {{ sprintf('%02d', $loop->iteration) }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="p-2 rounded bg-light text-teal me-2,5 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                @if(strtolower($file->tipe_file ?? 'foto') === 'foto')
                                                    <i class="bi bi-image text-primary fs-5"></i>
                                                @else
                                                    <i class="bi bi-camera-reels text-danger fs-5"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark d-block" style="font-size: 13.5px;">{{ $file->nama_file }}</span>
                                                <small class="text-muted" style="font-size: 11px;">
                                                    <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($file->updated_at)->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if(!empty($file->instruksi_edit))
                                            <span class="text-danger fw-semibold small bg-danger bg-opacity-10 px-2,5 py-1 rounded d-inline-block">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $file->instruksi_edit }}
                                            </span>
                                        @else
                                            <span class="text-muted small italic">Tidak ada catatan khusus</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($file->status === 'editing')
                                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-medium">
                                                <i class="bi bi-hourglass-split me-1"></i>Proses Edit
                                            </span>
                                        @elseif($file->status === 'selesai')
                                            <span class="badge bg-success px-3 py-1.5 rounded-pill fw-medium">
                                                <i class="bi bi-check-circle-fill me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span class="badge badge-toska px-3 py-1.5 rounded-pill fw-medium">
                                                <i class="bi bi-check2-circle me-1"></i>Siap Edit
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('editor.editing.download', $file->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm hover-teal">
                                            <i class="bi bi-download me-1"></i> Unduh
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-4 d-block mb-1 text-secondary"></i>
                                        Belum ada file mentah yang disetujui dalam folder ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    @empty
        <div class="card border-0 shadow-sm p-5 text-center rounded-4">
            <div class="bg-light d-inline-flex align-items-center justify-content-center p-3 rounded-circle mx-auto mb-3" style="width: 70px; height: 70px;">
                <i class="bi bi-folder-x fs-1 text-muted"></i>
            </div>
            <h5 class="fw-bold text-dark">Belum Ada Bahan Mentah</h5>
            <p class="text-muted small mb-0">Belum ada folder yang disetujui oleh Pimpinan untuk dilakukan proses editing.</p>
        </div>
    @endforelse

</div>

@endsection