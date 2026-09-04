@extends('layouts.app')

@section('title','Kurasi Kegiatan')
@section('page-title','Kurasi Kegiatan')

@section('content')

<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
    }

    .badge-toska {
        background-color: var(--toska-dark) !important;
        color: #ffffff !important;
    }
</style>

<div class="card border-0 shadow-sm">

    {{-- Header Card --}}
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-calendar-check me-2"></i>Daftar Kegiatan Liputan
        </h6>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th width="60" class="text-center">NO</th>
                        <th>NAMA KEGIATAN & FOLDER</th>
                        <th width="180">PENGIRIM</th>
                        <th width="130" class="text-center">BERKAS</th>
                        <th width="160">TANGGAL</th>
                        <th width="170" class="text-center">AKSI</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($kegiatan as $item)

                    <tr>

                        <td class="text-center fw-bold text-muted">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Nama Kegiatan & Folder --}}
                        <td>
                            <div class="fw-bold text-dark fs-6">{{ $item->nama_kegiatan }}</div>
                            @if($item->folder)
                                <small class="text-muted">
                                    <i class="bi bi-folder-fill text-warning me-1"></i>{{ $item->folder->nama_folder ?? '-' }}
                                </small>
                            @else
                                <small class="text-muted fst-italic">Belum ada folder</small>
                            @endif
                        </td>

                        {{-- Pengirim / Petugas --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-fill text-secondary"></i>
                                </div>
                                <span class="small fw-semibold text-secondary">
                                    {{ $item->folder->user->name ?? 'Petugas' }}
                                </span>
                            </div>
                        </td>

                        {{-- Jumlah Berkas --}}
                        <td class="text-center">
                            @if($item->folder && $item->folder->dokumentasi)
                                <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                    <i class="bi bi-images text-teal me-1"></i>{{ $item->folder->dokumentasi->count() }} File
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        {{-- Tanggal --}}
                        <td>
                            <small class="text-muted fw-medium">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('d M Y') }}
                            </small>
                        </td>

                        {{-- Status & Aksi --}}
                        <td class="text-center">
                            @if($item->folder && $item->folder->dokumentasi && $item->folder->dokumentasi->where('status', 'dipilih')->count() > 0)
                                <span class="badge badge-toska mb-2 d-inline-flex align-items-center justify-content-center px-3 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1_5"></i>Sudah Diseleksi
                                </span>
                                <div>
                                    <a href="{{ route('pimpinan.seleksi.show', $item->folder->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="bi bi-pencil me-1"></i> Ubah Seleksi
                                    </a>
                                </div>
                            @elseif($item->folder)
                                <a href="{{ route('pimpinan.seleksi.show', $item->folder->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="bi bi-check2-square me-1"></i> Seleksi
                                </a>
                            @else
                                <button class="btn btn-sm btn-light border text-muted rounded-pill px-3" disabled>
                                    Belum Ada Folder
                                </button>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            Belum ada data kegiatan
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection