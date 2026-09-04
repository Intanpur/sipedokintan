@extends('layouts.app')

@section('title', 'Detail Kegiatan')
@section('page-title', 'Detail Kegiatan')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="mb-0">
        {{ $kegiatan->nama_kegiatan }}
    </h4>

    <a href="{{ route('petugas.kegiatan') }}"
       class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

</div>

    <div class="card-body">

        <div class="mb-3">
            <strong>Lokasi :</strong>
            {{ $kegiatan->lokasi }}
        </div>

        <div class="mb-3">
            <strong>Tanggal :</strong>
            {{ $kegiatan->tanggal_kegiatan }}
        </div>

        <div class="mb-3">
            <strong>Penanggung Jawab :</strong>
            {{ $kegiatan->penanggung_jawab }}
        </div>

        <div class="mb-3">
            <strong>Deskripsi :</strong>
            {{ $kegiatan->deskripsi }}
        </div>

        <hr>

<h5 class="mb-3">
    Memo / Catatan
</h5>

<form action="{{ route('petugas.catatan.store') }}"
      method="POST"
      class="mb-3">
    @csrf

    <input type="hidden"
           name="kegiatan_id"
           value="{{ $kegiatan->id }}">

    <div class="input-group">

        <textarea name="isi_catatan"
                  class="form-control"
                  rows="2"
                  placeholder="Tulis catatan kegiatan..."></textarea>

        <button class="btn btn-primary">
            Simpan
        </button>

    </div>

</form>

@forelse($kegiatan->catatan as $catatan)

<div class="card mb-2 border-0 shadow-sm">

    <div class="card-body">

        <small class="text-muted">
            {{ $catatan->user->name }}
            •
            {{ $catatan->created_at->format('d M Y H:i') }}
        </small>

        <div class="mt-1">
            {{ $catatan->isi_catatan }}
        </div>

    </div>

</div>

@empty

<div class="alert alert-light">
    Belum ada catatan.
</div>

@endforelse

        <hr>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Folder Dokumentasi</h5>

            <a href="{{ route('petugas.folder.create', $kegiatan->id) }}"
               class="btn btn-primary btn-sm">
                <i class="bi bi-folder-plus"></i>
                Buat Folder
            </a>
        </div>

        <div class="row">

    @forelse(
        $kegiatan->folder
            ->where('created_at', '>=', now()->subDay())
        as $folder
    )
                <div class="col-md-4 mb-3">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body text-center">

                            <i class="bi bi-folder-fill text-warning"
                               style="font-size:60px"></i>

                            <h6 class="mt-3">

                                {{ $folder->nama_folder }}

                                <a href="{{ route('petugas.folder.edit', $folder->id) }}"
                                class="text-warning ms-1">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                            </h6>
                            
                            <div class="text-muted small mb-3">
                                📸 {{ $folder->total_foto ?? 0 }}
                                |
                                🎥 {{ $folder->total_video ?? 0 }}
                            </div>
                        <div class="d-flex gap-2 justify-content-center">

                            <a href="{{ route('petugas.folder.show', $folder->id) }}"
                                    class="btn btn-info btn-sm">
                                Lihat Dokumentasi
                            </a>

                            <a href="{{ route('petugas.dokumentasi.create', $folder->id) }}"
                            class="btn btn-primary btn-sm">
                                Upload
                            </a>

                        </div>
                        </div>

                    </div>

                </div>

            @empty

                <div class="alert alert-warning">
                    Belum ada folder dokumentasi aktif.
                    Folder yang sudah lewat 24 jam akan otomatis dipindahkan ke Arsip Dokumentasi.
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection