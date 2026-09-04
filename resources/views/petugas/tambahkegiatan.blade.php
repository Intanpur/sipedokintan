@extends('layouts.app')

@section('title', 'Tambah Kegiatan')
@section('page-title', 'Tambah Kegiatan')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        <h5>Form Tambah Kegiatan Liputan</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('petugas.kegiatan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="lokasi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Kegiatan</label>
                <input type="date" name="tanggal_kegiatan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Waktu Mulai</label>
                <input type="time" name="waktu_mulai" class="form-control">
            </div>

            <div class="mb-3">
                <label>Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" class="form-control">
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="form-control"></textarea>
            </div>

          <div class="d-flex justify-content-end gap-2">

            <a href="{{ route('petugas.kegiatan') }}"
            class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

            <button type="submit"
                    class="btn btn-primary">
                <i class="bi bi-check-circle"></i>
                Simpan
            </button>

</div>

        </form>

    </div>
</div>

@endsection