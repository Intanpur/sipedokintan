@extends('layouts.app')

@section('title', 'Edit Data Petugas - SIPEDOK')

@section('content')
<div class="container-fluid p-0 space-y-4 max-w-5xl mx-auto">

    <!-- Header Navigation & Title -->
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.datapetugas.index') }}" class="btn btn-sm text-white rounded-pill px-3 py-1.5 fw-bold hover-scale shadow-sm d-inline-flex align-items-center gap-1.5 text-decoration-none" style="background: linear-gradient(135deg, #0d9488 0%, #059669 100%); border: none;">
                    <i class="bi bi-arrow-left-circle-fill fs-6"></i>
                    <span>Kembali</span>
                </a>
                <span class="text-muted small">/ Data Petugas / Edit Petugas</span>
            </div>
            <h3 class="fw-extrabold mb-0 tracking-tight" style="color: #0f766e; font-size: 1.65rem; font-weight: 800;">
                <i class="bi bi-pencil-square me-2 text-teal-600"></i>Edit Data Petugas
            </h3>
        </div>
    </div>

    <!-- Alert Verification Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-md rounded-4 mb-4 p-3.5 d-flex align-items-start gap-3" role="alert" style="background: linear-gradient(135deg, #fef2f2 0%, #ffe4e6 100%); color: #9f1239; border-left: 5px solid #f43f5e !important;">
            <div class="w-10 h-10 rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 38px; height: 38px; background-color: #f43f5e;">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block fw-bold text-rose-950 mb-1" style="color: #881337;">Gagal Memperbarui Data!</strong>
                <ul class="mb-0 ps-3 small" style="color: #9f1239;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Header Banner -->
    <div class="card border-0 shadow-md rounded-4 overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 40%, #059669 100%);">
        <div class="card-body p-4 p-md-5 text-white">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-teal-700 shadow-md bg-white flex-shrink-0" style="width: 56px; height: 56px; color: #0f766e;">
                    <i class="bi bi-person-gear fs-2"></i>
                </div>
                <div>
                    <h4 class="fw-extrabold mb-1 tracking-tight text-white" style="font-weight: 800;">Form Perubahan Akun Petugas</h4>
                    <p class="text-emerald-50 opacity-90 small mb-0" style="font-size: 0.92rem;">
                        Perbarui informasi profil, username login, kontak WhatsApp, atau hak akses role dari petugas <strong class="text-amber-200" style="color: #fef08a;">"{{ $petugas->nama }}"</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="card border-0 shadow-md rounded-4 overflow-hidden bg-white mb-5">
        
        <!-- Form Header Bar -->
        <div class="card-header py-3.5 px-4 border-bottom border-teal-100 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f0fdf4 0%, #e6fffa 100%);">
            <span class="fw-bold text-teal-800 d-flex align-items-center gap-2" style="color: #0f766e;">
                <i class="bi bi-card-checklist text-teal-600"></i> Edit Detail Informasi Petugas (ID: #{{ $petugas->id }})
            </span>
            <span class="badge bg-white text-teal-800 border border-teal-200 px-3 py-1.5 rounded-pill font-mono text-xs shadow-2xs">
                Sistem SIPEDOK
            </span>
        </div>

        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.datapetugas.update', $petugas->id) }}" method="POST" id="formEditPetugas" autocomplete="off">
                @csrf
                @method('PUT')

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
                                   placeholder="Contoh: Ahmad Rizky, S.Kom." 
                                   value="{{ old('nama', $petugas->nama) }}" 
                                   required 
                                   autofocus>
                        </div>
                        @error('nama')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted small">Masukkan nama lengkap beserta gelar jika ada.</div>
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
                                   class="form-control border-0 py-2.5 text-dark shadow-none font-monospace @error('username') is-invalid @enderror" 
                                   placeholder="ahmad_rizky" 
                                   value="{{ old('username', $petugas->username) }}" 
                                   oninput="updateEmailPreview(this.value)" 
                                   required>
                        </div>
                        @error('username')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted small">
                            Email akun otomatis disetting: <strong id="emailPreviewText" class="text-teal-700 font-monospace" style="color: #0d9488;">{{ $petugas->username }}@sipedok.com</strong>
                        </div>
                    </div>

                    <!-- Nomor Telepon / WhatsApp (DITAMBAHKAN) -->
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
                                   value="{{ old('no_hp', $petugas->no_hp) }}">
                        </div>
                        @error('no_hp')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted small">Nomor WhatsApp untuk kontak koordinasi peliputan.</div>
                    </div>

                    <!-- Password (Opsional saat Edit) -->
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Password Login <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-key-fill fs-5"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control border-0 py-2.5 text-dark shadow-none @error('password') is-invalid @enderror" 
                                   placeholder="Kosongkan jika tidak ubah password">
                            <button class="btn btn-white border-0 text-muted px-3" type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()">
                                <i class="bi bi-eye-slash-fill" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted small">Kosongkan jika password tidak ingin diganti (minimal 6 karakter jika diubah).</div>
                    </div>

                    <!-- Hak Akses / Role -->
                    <div class="col-12 col-md-6">
                        <label for="role" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Hak Akses / Role Sistem <span class="text-danger">*</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-amber-300 custom-input-group">
                            <span class="input-group-text border-0 ps-3" style="background-color: #fef3c7; color: #92400e;">
                                <i class="bi bi-shield-check fs-5"></i>
                            </span>
                            @php
                                $selectedRole = old('role', strtolower($petugas->role ?? 'petugas'));
                            @endphp
                            <select name="role" 
                                    id="role" 
                                    class="form-select border-0 py-2.5 font-semibold text-amber-950 shadow-none @error('role') is-invalid @enderror" 
                                    style="background-color: #fef3c7; color: #78350f;" 
                                    onchange="updateRoleBadge(this.value)" 
                                    required>
                                <option value="petugas" {{ $selectedRole == 'petugas' ? 'selected' : '' }}>Petugas / Staff Peliputan</option>
                                <option value="admin" {{ $selectedRole == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                                <option value="pimpinan" {{ $selectedRole == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Executive)</option>
                                <option value="editor" {{ $selectedRole == 'editor' ? 'selected' : '' }}>Editor / Video Graphics</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="mt-2 d-flex align-items-center gap-2" id="roleBadgeContainer">
                            <span class="small text-muted">Preview Badge Role:</span>
                            <span id="roleBadgePreview" class="badge rounded-pill px-3 py-1.5 fw-bold shadow-2xs" style="background-color: #ccfbf1; color: #0f766e; border: 1px solid #5eead4;">
                                <i class="bi bi-person-badge-fill me-1"></i> Petugas
                            </span>
                        </div>
                    </div>

                    <!-- Status Akun (DITAMBAHKAN) -->
                    <div class="col-12 col-md-6">
                        <label for="is_active" class="form-label fw-bold text-teal-900 small mb-1" style="color: #0f766e;">
                            Status Pengaktifan Akun <span class="text-danger">*</span>
                        </label>
                        <div class="input-group rounded-3 overflow-hidden border border-teal-200 custom-input-group focus-within-teal">
                            <span class="input-group-text bg-teal-50 border-0 ps-3 text-teal-700" style="background-color: #f0fdf4; color: #0d9488;">
                                <i class="bi bi-toggle-on fs-5"></i>
                            </span>
                            @php
                                $selectedActive = old('is_active', $petugas->is_active ?? '1');
                            @endphp
                            <select name="is_active" id="is_active" class="form-select border-0 py-2.5 text-dark shadow-none @error('is_active') is-invalid @enderror" required>
                                <option value="1" {{ $selectedActive == '1' ? 'selected' : '' }}>Aktif (Bisa Login)</option>
                                <option value="0" {{ $selectedActive == '0' ? 'selected' : '' }}>Non-Aktif (Dibekukan)</option>
                            </select>
                        </div>
                        @error('is_active')
                            <div class="text-danger small mt-1 font-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted small">Status akses akun ke dalam aplikasi SIPEDOK.</div>
                    </div>

                </div>

                <!-- Divider -->
                <hr class="my-4 border-teal-100" style="border-color: #ccfbf1;">

                <!-- Action Buttons Compact & Vibrant -->
                <div class="d-flex align-items-center justify-content-end gap-2 pt-2">
                    <a href="{{ route('admin.datapetugas.index') }}" class="btn btn-sm btn-light border-slate-300 text-slate-700 font-semibold px-3 py-1.5 rounded-3 text-decoration-none transition-all hover-scale" style="background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-sm text-white font-bold px-3.5 py-1.5 rounded-3 shadow-sm transition-all hover-scale d-inline-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); border: none;">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Update Data</span>
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

    .focus-within-teal:focus-within {
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.2) !important;
    }

    .hover-scale {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-scale:hover {
        transform: translateY(-2px);
    }

    #role option {
        background-color: #ffffff !important;
        color: #1e293b !important;
    }
</style>

<script>
    // Live update email preview
    function updateEmailPreview(val) {
        const previewElem = document.getElementById('emailPreviewText');
        const cleanVal = val.trim().toLowerCase();
        if (cleanVal.length > 0) {
            previewElem.textContent = cleanVal + '@sipedok.com';
        } else {
            previewElem.textContent = '[username]@sipedok.com';
        }
    }

    // Toggle eye password visibility
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye-slash-fill');
            eyeIcon.classList.add('bi-eye-fill');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-fill');
            eyeIcon.classList.add('bi-eye-slash-fill');
        }
    }

    // Live update Role Badge
    function updateRoleBadge(role) {
        const badgeElem = document.getElementById('roleBadgePreview');
        role = (role || '').toLowerCase();

        if (role === 'admin') {
            badgeElem.style.backgroundColor = '#f3e8ff';
            badgeElem.style.color = '#6b21a8';
            badgeElem.style.border = '1px solid #d8b4fe';
            badgeElem.innerHTML = '<i class="bi bi-shield-check me-1"></i> Admin';
        } else if (role === 'pimpinan') {
            badgeElem.style.backgroundColor = '#fef3c7';
            badgeElem.style.color = '#92400e';
            badgeElem.style.border = '1px solid #fcd34d';
            badgeElem.innerHTML = '<i class="bi bi-star-fill me-1"></i> Pimpinan';
        } else if (role === 'editor') {
            badgeElem.style.backgroundColor = '#e0f2fe';
            badgeElem.style.color = '#0369a1';
            badgeElem.style.border = '1px solid #7dd3fc';
            badgeElem.innerHTML = '<i class="bi bi-camera-video-fill me-1"></i> Editor';
        } else {
            badgeElem.style.backgroundColor = '#ccfbf1';
            badgeElem.style.color = '#0f766e';
            badgeElem.style.border = '1px solid #5eead4';
            badgeElem.innerHTML = '<i class="bi bi-person-badge-fill me-1"></i> Petugas';
        }
    }

    // Initialize badge and email preview on page load
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        if (roleSelect && roleSelect.value) {
            updateRoleBadge(roleSelect.value);
        }
        const usernameInput = document.getElementById('username');
        if (usernameInput && usernameInput.value) {
            updateEmailPreview(usernameInput.value);
        }
    });
</script>
@endsection