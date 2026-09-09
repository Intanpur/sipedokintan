@extends('layouts.app')

@section('title', 'Tambah Kegiatan')
@section('page-title', 'Tambah Kegiatan Liputan')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <h5 class="mb-4">
            Tambah Kegiatan Liputan
        </h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.kegiatan.store') }}" method="POST">
            @csrf

            {{-- Nama Kegiatan --}}
            <div class="mb-3">
                <label class="form-label">
                    Nama Kegiatan
                </label>

                <input
                    type="text"
                    name="nama_kegiatan"
                    class="form-control"
                    value="{{ old('nama_kegiatan') }}"
                    required
                >
            </div>

            {{-- Lokasi --}}
            <div class="mb-3">
                <label class="form-label">
                    Lokasi
                </label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    value="{{ old('lokasi') }}"
                    required
                >
            </div>

            <div class="row">

                {{-- Tanggal --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Tanggal Kegiatan
                    </label>

                    <input
                        type="date"
                        name="tanggal_kegiatan"
                        class="form-control"
                        value="{{ old('tanggal_kegiatan') }}"
                        required
                    >
                </div>

                {{-- Waktu --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Waktu Mulai
                    </label>

                    <input
                        type="time"
                        name="waktu_mulai"
                        class="form-control"
                        value="{{ old('waktu_mulai') }}"
                    >
                </div>

            </div>

            {{-- Pimpinan --}}
            <div class="mb-3">
                <label class="form-label">
                    Pimpinan
                </label>

                <select
                    name="pimpinan_id"
                    class="form-select"
                    required
                >
                    <option value="">
                        -- Pilih Pimpinan --
                    </option>

                    @foreach ($pimpinan as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ old('pimpinan_id') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->name }}
                        </option>
                    @endforeach

                </select>
            </div>

           

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="bi bi-save"></i>
                    Simpan Kegiatan
                </button>

            </div>

        </form>

    </div>
</div>

@endsection