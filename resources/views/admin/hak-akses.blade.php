@extends('layouts.app')

@section('title', 'Kelola Hak Akses')
@section('page-title', 'Kelola Hak Akses')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-1">Manajemen Hak Akses Pengguna</h4>
                    <small class="text-muted">
                        Kelola peran dan status pengguna SIPEDOK
                    </small>
                </div>

                <span class="badge bg-primary fs-6">
                    Total User : {{ $users->count() }}
                </span>

            </div>
        </div>

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="15%">Role</th>
                        <th width="15%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>

                            @if($user->role == 'pimpinan')

                                <span class="badge bg-warning text-dark">
                                    Pimpinan
                                </span>

                            @elseif($user->role == 'petugas')

                                <span class="badge bg-info text-dark">
                                    Petugas
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ ucfirst($user->role) }}
                                </span>

                            @endif

                        </td>

                        <td>

                            @if($user->is_active ?? true)

                                <span class="badge bg-success">
                                    Aktif
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Non Aktif
                                </span>

                            @endif

                        </td>

                        <td>
                        <button
                            class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#edit{{ $user->id }}">
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </button>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center text-muted">
                            Belum ada data pengguna
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>
            @foreach($users as $user)

<div class="modal fade" id="edit{{ $user->id }}" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Hak Akses
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form method="POST"
                  action="{{ route('admin.hakakses.update', $user->id) }}">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Role</label>

                        <select name="role" class="form-select">

                            <option value="petugas"
                                {{ $user->role == 'petugas' ? 'selected' : '' }}>
                                Petugas
                            </option>

                            <option value="pimpinan"
                                {{ $user->role == 'pimpinan' ? 'selected' : '' }}>
                                Pimpinan
                            </option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status Akun</label>

                        <select name="is_active" class="form-select">

                            <option value="1"
                                {{ $user->is_active ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="0"
                                {{ !$user->is_active ? 'selected' : '' }}>
                                Non Aktif
                            </option>

                        </select>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach

        </div>

    </div>

</div>

@endsection