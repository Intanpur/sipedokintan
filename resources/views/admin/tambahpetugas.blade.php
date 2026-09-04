@extends('layouts.app')

@section('title', 'Tambah Petugas')
@section('page-title', 'Tambah Petugas')

@section('content')

<div class="card-box">
    <div class="card-box-header">
        Tambah Data Pengguna
    </div>

    <div class="p-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.datapetugas.store') }}"
              method="POST"
              autocomplete="off">

            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>

                <input type="text"
                       name="nama"
                       class="form-control"
                       placeholder="Masukkan nama lengkap"
                       value="{{ old('nama') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>

                <input type="text"
                       name="username"
                       class="form-control"
                       placeholder="Contoh: rina"
                       value="{{ old('username') }}"
                       autocomplete="off"
                       required>

                <small class="text-muted">
                    Email login akan dibuat otomatis menjadi:
                    username@sipedok.com
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Awal</label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan password"
                       autocomplete="new-password"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>

                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>

                    <option value="petugas"
                        {{ old('role') == 'petugas' ? 'selected' : '' }}>
                        Petugas
                    </option>

                    <option value="pimpinan"
                        {{ old('role') == 'pimpinan' ? 'selected' : '' }}>
                        Pimpinan
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>

            <a href="{{ route('admin.datapetugas') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>

@endsection