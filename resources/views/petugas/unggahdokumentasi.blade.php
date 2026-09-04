@extends('layouts.app')

@section('title', 'Upload Dokumentasi')
@section('page-title', 'Upload Dokumentasi')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Upload Dokumentasi</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('petugas.dokumentasi.store', $folder->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Pilih Foto / Video
                </label>

                <input type="file"
                       name="file[]"
                       class="form-control"
                       multiple
                       required>

                <small class="text-muted">
                    Dapat memilih beberapa foto dan video sekaligus.
                </small>

            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('petugas.folder.show', $folder->id) }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit"
                        class="btn btn-primary">
                    Upload Dokumentasi
                </button>

            </div>

        </form>

    </div>

</div>

@endsection