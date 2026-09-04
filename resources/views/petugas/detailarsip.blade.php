@extends('layouts.app')

@section('title','Detail Arsip')
@section('page-title','Detail Arsip')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <h4 class="mb-0">
            {{ $kegiatan->nama_kegiatan }}
        </h4>

        <a href="{{ route('petugas.arsip') }}"
           class="btn btn-secondary btn-sm">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>

    <div class="card-body">

        <div class="mb-3">
            <strong>Tanggal :</strong>
            {{ $kegiatan->tanggal_kegiatan }}
        </div>

        <div class="mb-3">
            <strong>Lokasi :</strong>
            {{ $kegiatan->lokasi }}
        </div>

        <hr>

        <h5 class="mb-3">
            Folder Arsip
        </h5>

        <div class="row">

            @foreach($kegiatan->folder as $folder)

            <div class="col-md-4 mb-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <i class="bi bi-folder-fill text-warning"
                           style="font-size:60px"></i>

                        <h6 class="mt-3">
                            {{ $folder->nama_folder }}
                        </h6>

                        <small class="text-muted">

                            📸 {{ $folder->total_foto }}
                            |
                            🎥 {{ $folder->total_video }}

                        </small>

                        <div class="mt-3">

                            <a href="{{ route('petugas.folder.show', $folder->id) }}"
                               class="btn btn-outline-primary btn-sm">

                                <i class="bi bi-eye"></i>
                                Lihat

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>

@endsection