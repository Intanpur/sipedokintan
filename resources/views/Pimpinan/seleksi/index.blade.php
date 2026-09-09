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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="small text-muted">
                        <th width="60" class="text-center">NO</th>
                        <th>NAMA FOLDER / KEGIATAN</th>
                        <th class="text-center">JUMLAH FILE</th>
                        <th>TANGGAL DIBUAT</th>
                        <th width="200" class="text-center">AKSI</th>
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
                            <div class="d-flex justify-content-center gap-1">
                                <!-- Tombol Seleksi -->
                                <a href="{{ route('pimpinan.seleksi.show', $item->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="bi bi-check2-square me-1"></i> Seleksi
                                </a>

                                <!-- Tombol Hapus Folder -->
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalHapusFolder{{ $item->id }}">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </div>

                            <!-- Modal Konfirmasi Hapus Folder -->
                            <div class="modal fade" id="modalHapusFolder{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-start">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus Folder
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus folder <strong>{{ $item->nama_folder }}</strong> beserta seluruh berkas di dalamnya?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('pimpinan.folder.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">Ya, Hapus Folder</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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