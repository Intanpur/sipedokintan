@extends('layouts.app')

@section('title', 'Seleksi Dokumentasi')
@section('page-title', 'Seleksi & Kurasi Dokumentasi')

@section('content')
<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
    }
</style>

<div class="card border-0 shadow-sm">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-folder-check me-2"></i>Daftar Folder Kegiatan Siap Seleksi
        </h6>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-muted">
                        <th width="60" class="text-center">NO</th>
                        <th>NAMA FOLDER / KEGIATAN</th>
                        <th class="text-center">JUMLAH FILE</th>
                        <th>TANGGAL DIBUAT</th>
                        <th width="150" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($folders as $item)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">
                                <i class="bi bi-folder-fill text-warning me-2 fs-5"></i>
                                {{ $item->nama_folder ?? 'Folder Tanpa Nama' }}
                            </div>
                            <small class="text-muted">Kegiatan: {{ $item->kegiatan->nama_kegiatan ?? '-' }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-images text-teal me-1"></i> {{ $item->dokumentasi->count() }} Berkas
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                            </small>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pimpinan.seleksi.show', $item->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="bi bi-check2-square me-1"></i> Seleksi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            Belum ada folder yang perlu diseleksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection