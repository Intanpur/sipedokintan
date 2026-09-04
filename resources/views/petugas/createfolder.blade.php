@extends('layouts.app')

@section('title', 'Buat Folder Dokumentasi')
@section('page-title', 'Buat Folder Dokumentasi')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Buat Folder Dokumentasi</h5>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <strong>Kegiatan:</strong>
            {{ $kegiatan->nama_kegiatan }}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.folder.store') }}" method="POST">
            @csrf

            <input type="hidden"
                   name="kegiatan_id"
                   value="{{ $kegiatan->id }}">

            <div class="mb-3">
                <label class="form-label">
                    Nama Folder
                </label>

                <input type="text"
                       name="nama_folder"
                       class="form-control"
                       placeholder="Masukkan nama folder"
                       required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit"
                        class="btn btn-success">
                    <i class="bi bi-save"></i>
                    Simpan
                </button>

                <a href="{{ route('petugas.kegiatan.show', $kegiatan->id) }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

@endsection