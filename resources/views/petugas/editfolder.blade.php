@extends('layouts.app')

@section('title','Edit Folder')
@section('page-title','Edit Folder')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5>Edit Nama Folder</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('petugas.folder.update', $folder->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Folder</label>

                <input type="text"
                       name="nama_folder"
                       class="form-control"
                       value="{{ $folder->nama_folder }}"
                       required>
            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ url()->previous() }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit"
                        class="btn btn-primary">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection