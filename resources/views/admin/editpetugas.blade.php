@extends('layouts.app')

@section('title', 'Edit Petugas')
@section('page-title', 'Edit Petugas')

@section('content')

<div class="card-box">
    <div class="card-box-header">
        Edit Data Petugas
    </div>

    <div class="p-4">

        <form action="{{ route('admin.datapetugas.update', $petugas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Petugas</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       value="{{ $petugas->nama }}">
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text"
                       name="username"
                       class="form-control"
                       value="{{ $petugas->username }}">
            </div>

            <div class="mb-3">
    <label>Role</label>

    <select name="role" class="form-select">

        <option value="petugas"
            {{ ($petugas->role ?? '') == 'petugas' ? 'selected' : '' }}>
            Petugas
        </option>

        <option value="pimpinan"
            {{ ($petugas->role ?? '') == 'pimpinan' ? 'selected' : '' }}>
            Pimpinan
        </option>

    </select>
</div>
            <button type="submit" class="btn btn-primary">
                Update
            </button>

        </form>

    </div>
</div>

@endsection