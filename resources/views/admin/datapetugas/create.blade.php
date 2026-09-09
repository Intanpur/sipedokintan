@extends('layouts.app')

@section('title', 'Tambah Petugas Baru - SIPEDOK')

@section('content')
<div class="container-fluid p-0 space-y-4">

    <!-- Header & Breadcrumb -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="fw-extrabold mb-1 tracking-tight" style="color: #0f766e; font-size: 1.65rem; font-weight: 800;">
                <i class="bi bi-person-plus-fill me-2 text-teal-600"></i>Tambah Petugas Baru
            </h3>
            <p class="text-muted small mb-0">Lengkapi formulir di bawah ini untuk menambahkan akun petugas baru ke sistem</p>
        </div>
        <div>
            <a href="{{ route('admin.datapetugas.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-bold text-decoration-none d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Alert Error Global jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-md rounded-4 mb-4 p-3.5" role="alert" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); color: #991b1b; border-left: 5px solid #ef4444 !important;">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-circle bg-rose-500 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; background-color: #ef4444; flex-shrink: 0;">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                </div>
                <div>
                    <strong class="d-block fw-bold text-rose-900" style="color: #7f1d1d;">Gagal Menyimpan Data!</strong>
                    <span class="small" style="color: #991b1b;">Mohon periksa kembali inputan form di bawah ini.</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card Container -->
    <div class="card border-0 shadow-md rounded-4 overflow-hidden bg-white">
        <!-- Card Header -->
        <div class="card-header py-3.5 px-4 border-bottom border-teal-100" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); color: #ffffff;">
            <h5 class="card-title mb-0 fw-bold fs-6 d-flex align-items-center gap-2">
                <i class="bi bi-card-heading fs-5"></i> Form Data Profil & Akun Petugas
            </h5>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.datapetugas.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <!-- Nama Lengkap -->
                    <div class="col-12 col-md-6">
                        <label for="nama" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Nama Lengkap Petugas <span class="text-danger">*</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </span>
                            <input type="text" 
                                   name="nama" 
                                   id="nama" 
                                   class="form-control border-0 py-2.5 text-dark shadow-none @error('nama') is-invalid @enderror" 
                                   placeholder="Contoh: Ahmad Subagja, S.Kom" 
                                   value="{{ old('nama') }}" 
                                   required>
                        </div>
                        @error('nama')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Username Login -->
                    <div class="col-12 col-md-6">
                        <label for="username" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Username Login <span class="text-danger">*</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-at fs-5"></i>
                            </span>
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   class="form-control border-0 py-2.5 text-dark shadow-none @error('username') is-invalid @enderror" 
                                   placeholder="Contoh: ahmad_subagja" 
                                   value="{{ old('username') }}" 
                                   required>
                        </div>
                        @error('username')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Password Akun <span class="text-danger">*</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-key-fill fs-5"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control border-0 py-2.5 text-dark shadow-none @error('password') is-invalid @enderror" 
                                   placeholder="Minimal 6-8 karakter" 
                                   required>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor Telepon / WhatsApp -->
                    <div class="col-12 col-md-6">
                        <label for="no_hp" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Nomor Telepon / WhatsApp <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-telephone-fill fs-5"></i>
                            </span>
                            <input type="text" 
                                   name="no_hp" 
                                   id="no_hp" 
                                   class="form-control border-0 py-2.5 text-dark shadow-none @error('no_hp') is-invalid @enderror" 
                                   placeholder="Contoh: 081234567890" 
                                   value="{{ old('no_hp') }}">
                        </div>
                        @error('no_hp')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted small">Digunakan sebagai kontak koordinasi atau kontak darurat.</div>
                    </div>

                    <!-- Hak Akses / Role -->
                    <div class="col-12 col-md-6">
                        <label for="role" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Hak Akses / Role <span class="text-danger">*</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-shield-lock-fill fs-5"></i>
                            </span>
                            <select name="role" id="role" class="form-select border-0 py-2.5 text-dark shadow-none @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Peran / Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Akun -->
                    <div class="col-12 col-md-6">
                        <label for="is_active" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Status Pengaktifan Akun <span class="text-danger">*</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-toggle-on fs-5"></i>
                            </span>
                            <select name="is_active" id="is_active" class="form-select border-0 py-2.5 text-dark shadow-none @error('is_active') is-invalid @enderror" required>
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Bisa Login)</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-Aktif (Dibekukan)</option>
                            </select>
                        </div>
                        @error('is_active')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4" style="border-color: #ccfbf1;">

                <!-- Tombol Action -->
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="{{ route('admin.datapetugas.index') }}" class="btn btn-light text-secondary fw-bold px-4 py-2.5 rounded-3">
                        Batal
                    </a>
                    <button type="submit" class="btn text-white fw-bold px-4 py-2.5 rounded-3 shadow-md transition-all d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); border: none;">
                        <i class="bi bi-save2-fill"></i>
                        <span>Simpan Data Petugas</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<style>
    .custom-input-group {
        transition: all 0.2s ease-in-out;
    }
    .custom-input-group:focus-within {
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.15);
    }
</style>
@endsection