@extends('layouts.app')

@section('title', 'Kurasi & Seleksi Dokumentasi')
@section('page-title', 'Kurasi & Seleksi Dokumentasi')

@section('content')

<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #e6f4f1;
    }

    .btn-toska {
        background-color: var(--toska-dark);
        color: #ffffff;
        border: none;
    }

    .btn-toska:hover {
        background-color: var(--toska-primary);
        color: #ffffff;
    }

    .border-toska {
        border-color: var(--toska-dark) !important;
    }

    .card-media-selected {
        border: 2px solid var(--toska-dark) !important;
        background-color: var(--toska-light);
    }

    .form-check-input:checked {
        background-color: var(--toska-dark);
        border-color: var(--toska-dark);
    }
</style>

<div class="container-fluid py-3">

    {{-- Header Banner --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1"><i class="bi bi-folder-fill me-2"></i>{{ $folder->nama_folder }}</h5>
                    <small class="opacity-75">Pilih foto/video yang disetujui (ACC) untuk diteruskan ke Tim Editor.</small>
                </div>
                <span class="badge bg-white text-dark fw-bold px-3 py-2 rounded-pill">
                    <i class="bi bi-images text-teal me-1"></i> {{ count($files) }} Berkas
                </span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('pimpinan.seleksi.kirimEditor', $folder->id) }}" method="POST">
        @csrf

        {{-- Grid Berkas Media --}}
        <div class="row g-3 mb-4">
            @forelse($files as $file)
                @php
                    $isFoto = strtolower($file->tipe_file ?? 'foto') === 'foto';
                    $fileUrl = asset('storage/' . $file->path_file);
                    $isSelected = $file->status == 'dipilih';
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm media-card {{ $isSelected ? 'card-media-selected' : '' }}">
                        <div class="position-relative style-preview" style="height: 190px; background: #000; overflow: hidden;">
                            @if($isFoto)
                                <img src="{{ $fileUrl }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $file->nama_file }}">
                            @else
                                <video src="{{ $fileUrl }}#t=0.5" class="w-100 h-100" style="object-fit: cover;"></video>
                                <span class="position-absolute top-50 start-50 translate-middle text-white bg-dark bg-opacity-50 rounded-circle p-2">
                                    <i class="bi bi-play-fill fs-3"></i>
                                </span>
                            @endif

                            <span class="position-absolute top-0 end-0 m-2 badge {{ $isFoto ? 'bg-primary' : 'bg-danger' }} rounded-pill">
                                {{ strtoupper($file->tipe_file ?? 'FOTO') }}
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <p class="fw-semibold text-dark text-truncate mb-3" title="{{ $file->nama_file }}">
                                {{ $file->nama_file }}
                            </p>

                            <div class="form-check bg-light p-2 rounded border">
                                <input class="form-check-input ms-1 me-2" type="checkbox" name="selected_files[]" value="{{ $file->id }}" id="file_{{ $file->id }}" {{ $isSelected ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-dark small" for="file_{{ $file->id }}">
                                    Pilih untuk Edit
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted">Tidak ada berkas media untuk diseleksi dalam folder ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Instruksi Catatan Pimpinan --}}
        <div class="card border-0 shadow-sm p-3 mb-4">
            <label for="catatan_pimpinan" class="form-label fw-bold text-dark">
                <i class="bi bi-pencil-square me-1 text-teal"></i> Instruksi Edit untuk Editor:
            </label>
            <textarea name="catatan_pimpinan" id="catatan_pimpinan" class="form-control" rows="3" placeholder="Contoh: Tolong sesuaikan pencahayaan, tingkatkan saturasi, dan beri logo official pada sudut kanan atas..."></textarea>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('pimpinan.kegiatan') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-toska rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-send-fill me-1"></i> Kirim ke Editor
            </button>
        </div>

    </form>
</div>

@endsection