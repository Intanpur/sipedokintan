@extends('layouts.app')

@section('title', 'Data Petugas - SIPEDOK')

@section('content')
<div class="container-fluid p-0 space-y-4">

    <!-- Judul Halaman Bergaya Modern & Berwarna -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="fw-extrabold mb-1 tracking-tight" style="color: #0f766e; font-size: 1.65rem; font-weight: 800;">
                <i class="bi bi-people-fill me-2 text-teal-600"></i>Data Petugas & Pengguna
            </h3>
            <p class="text-muted small mb-0">Kelola akun, status pengaktifan, dan hak akses petugas SIPEDOK</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-md rounded-4 mb-4 p-3 d-flex align-items-center justify-content-between" role="alert" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); color: #065f46; border-left: 5px solid #10b981 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; background-color: #10b981;">
                    <i class="bi bi-check-lg fs-5"></i>
                </div>
                <div>
                    <strong class="d-block fw-bold" style="color: #064e3b;">Berhasil!</strong>
                    <span class="small" style="color: #047857;">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-md rounded-4 mb-4 p-3 d-flex align-items-center justify-content-between" role="alert" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); color: #991b1b; border-left: 5px solid #ef4444 !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; background-color: #ef4444;">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                </div>
                <div>
                    <strong class="d-block fw-bold" style="color: #7f1d1d;">Perhatian!</strong>
                    <span class="small" style="color: #991b1b;">{{ session('error') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Banner -->
    <div class="card border-0 shadow-md rounded-4 overflow-hidden mb-4" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 40%, #059669 100%);">
        <div class="card-body p-4 p-md-5 text-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                <div>
                    <h2 class="fw-black mb-2 tracking-tight text-white display-6" style="font-weight: 800;">Kelola Data Petugas SIPEDOK</h2>
                    <p class="opacity-90 small mb-0" style="font-size: 0.95rem; line-height: 1.5; color: #ecfdf5; max-width: 650px;">
                        Kelola data pengguna, kredensial autentikasi, status aktif akun, serta penugasan peran (*role*) untuk seluruh staf peliputan dokumen secara terpusat.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.datapetugas.create') }}" class="btn btn-light text-teal-900 fw-bold px-4 py-3 rounded-3 shadow-lg hover-scale transition-all d-inline-flex align-items-center gap-2 text-decoration-none" style="background: #ffffff; color: #0f766e; border: none; font-size: 0.95rem;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #ccfbf1; color: #0f766e;">
                            <i class="bi bi-plus-lg fw-bold"></i>
                        </div>
                        <span>Tambah Petugas Baru</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- Card Total -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 d-flex flex-row align-items-center gap-3 hover-card transition-all" style="border-left: 5px solid #0d9488 !important;">
                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%); color: #0f766e;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-xs text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.75rem;">Total Akun</span>
                    <span class="fs-3 fw-extrabold text-dark">{{ count($petugas) }}</span>
                </div>
            </div>
        </div>
        <!-- Card Admin -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 d-flex flex-row align-items-center gap-3 hover-card transition-all" style="border-left: 5px solid #7c3aed !important;">
                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); color: #6b21a8;">
                    <i class="bi bi-shield-lock-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-xs text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.75rem;">Administrator</span>
                    <span class="fs-3 fw-extrabold text-dark">{{ $petugas->filter(fn($p) => strtolower($p->role ?? '') === 'admin')->count() }}</span>
                </div>
            </div>
        </div>
        <!-- Card Pimpinan -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 d-flex flex-row align-items-center gap-3 hover-card transition-all" style="border-left: 5px solid #d97706 !important;">
                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e;">
                    <i class="bi bi-star-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-xs text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.75rem;">Pimpinan</span>
                    <span class="fs-3 fw-extrabold text-dark">{{ $petugas->filter(fn($p) => strtolower($p->role ?? '') === 'pimpinan')->count() }}</span>
                </div>
            </div>
        </div>
        <!-- Card Petugas/Staff -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 d-flex flex-row align-items-center gap-3 hover-card transition-all" style="border-left: 5px solid #0284c7 !important;">
                <div class="rounded-3 p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0369a1;">
                    <i class="bi bi-person-badge-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-xs text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.75rem;">Petugas / Staff</span>
                    <span class="fs-3 fw-extrabold text-dark">{{ $petugas->filter(fn($p) => strtolower($p->role ?? 'petugas') === 'petugas')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="card border-0 shadow-md rounded-4 overflow-hidden bg-white">
        
        <!-- Filter Header -->
        <div class="card-header py-3 px-4 border-bottom" style="background: linear-gradient(135deg, #f0fdf4 0%, #e6fffa 100%); border-color: #ccfbf1 !important;">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-6">
                    <div class="input-group rounded-3 overflow-hidden border shadow-sm bg-white" style="border-color: #99f6e4 !important;">
                        <span class="input-group-text bg-white border-0 ps-3" style="color: #0d9488;">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-0 bg-white py-2 text-dark shadow-none" placeholder="Cari nama atau username..." aria-label="Cari nama atau username" onkeyup="filterTable()">
                        <button class="btn btn-white border-0 text-muted px-3" type="button" onclick="resetSearch()" title="Bersihkan Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <select id="roleFilter" class="form-select rounded-3 shadow-sm py-2 px-3 font-semibold w-auto" style="min-width: 170px;" onchange="filterTable()">
                        <option value="">-- Semua Role --</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="pimpinan">Pimpinan</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0 custom-green-table" id="petugasTable">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fs-7 fw-bold text-white" style="width: 70px;">No</th>
                            <th class="py-3 text-uppercase fs-7 fw-bold text-white">Petugas / Nama</th>
                            <th class="py-3 text-uppercase fs-7 fw-bold text-white">Username Login</th>
                            <th class="py-3 text-uppercase fs-7 fw-bold text-white text-center">Hak Akses / Role</th>
                            <th class="py-3 text-uppercase fs-7 fw-bold text-white text-center" style="width: 130px;">Status Akun</th>
                            <th class="pe-4 py-3 text-uppercase fs-7 fw-bold text-white text-center" style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugas as $index => $p)
                            @php
                                $rawNama = trim($p->nama ?? $p->nama_petugas ?? $p->nama_lengkap ?? $p->name ?? '');
                                $namaFinal = ($rawNama === '' || $rawNama === '-') ? ('Petugas ' . $p->id) : $rawNama;

                                $rawUsername = strtolower(trim($p->username ?? ''));
                                if ($rawUsername === '' || $rawUsername === '-') {
                                    $rawUsername = 'petugas' . $p->id;
                                }
                                $usernameFinal = $rawUsername;

                                $cleanNameForInitial = preg_replace('/[^a-zA-Z]/', '', $namaFinal);
                                $initial = !empty($cleanNameForInitial) ? strtoupper(substr($cleanNameForInitial, 0, 1)) : 'P';
                            @endphp
                            <tr class="petugas-row hover-row-teal" data-name="{{ strtolower($namaFinal) }}" data-username="{{ strtolower($usernameFinal) }}" data-role="{{ strtolower($p->role ?? 'petugas') }}">
                                <td class="ps-4 fw-bold" style="color: #0f766e;">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-box rounded-circle fw-black text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #0d9488 0%, #042f2e 100%); font-size: 16px; flex-shrink: 0;">
                                            {{ $initial }}
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block mb-0.5" style="color: #0f766e; font-size: 0.95rem;">{{ $namaFinal }}</span>
                                            <span class="d-inline-flex align-items-center gap-1" style="color: #0d9488; font-size: 12px;">
                                                <i class="bi bi-envelope-fill"></i> {{ $usernameFinal }}@sipedok.com
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge px-3 py-2 font-monospace fw-bold rounded-3" style="background-color: #f0fdf4; color: #065f46; border: 1px solid #a7f3d0; font-size: 0.85rem;">
                                        <i class="bi bi-at me-0.5"></i>{{ $usernameFinal }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php $role = strtolower($p->role ?? 'petugas'); @endphp
                                    @if($role == 'admin')
                                        <span class="badge rounded-pill px-3 py-2 fw-bold" style="background-color: #f3e8ff; color: #6b21a8; border: 1.5px solid #d8b4fe;">
                                            <i class="bi bi-shield-check me-1"></i> Admin
                                        </span>
                                    @elseif($role == 'petugas')
                                        <span class="badge rounded-pill px-3 py-2 fw-bold" style="background-color: #ccfbf1; color: #0f766e; border: 1.5px solid #5eead4;">
                                            <i class="bi bi-person-badge-fill me-1"></i> Petugas
                                        </span>
                                    @elseif($role == 'pimpinan')
                                        <span class="badge rounded-pill px-3 py-2 fw-bold" style="background-color: #fef3c7; color: #92400e; border: 1.5px solid #fcd34d;">
                                            <i class="bi bi-star-fill me-1"></i> Pimpinan
                                        </span>
                                    @elseif($role == 'editor')
                                        <span class="badge rounded-pill px-3 py-2 fw-bold" style="background-color: #e0f2fe; color: #0369a1; border: 1.5px solid #7dd3fc;">
                                            <i class="bi bi-camera-video-fill me-1"></i> Editor
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2 bg-secondary text-white fw-bold">
                                            {{ ucfirst($role) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Status Akun -->
                                <td class="text-center">
                                    @if($p->is_active ?? true)
                                        <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background-color: #d1fae5; color: #065f46; border: 1.5px solid #6ee7b7;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background-color: #ffe4e6; color: #9f1239; border: 1.5px solid #fca5a5;">
                                            <i class="bi bi-x-circle-fill me-1"></i> Non-Aktif
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="pe-4 text-center">
                                    <div class="d-inline-flex align-items-center gap-1 p-1 rounded-3" style="background-color: #f0fdf4; border: 1px solid #ccfbf1;">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.datapetugas.edit', $p->id) }}" class="btn btn-sm btn-white text-warning border-0 rounded-2 px-2 py-1.5 d-flex align-items-center gap-1 shadow-sm" title="Edit Data Petugas">
                                            <i class="bi bi-pencil-square fs-6"></i>
                                            <span class="small fw-semibold">Edit</span>
                                        </a>

                                        <!-- Toggle Status Button -->
                                        @if($p->is_active ?? true)
                                            <form action="{{ route('admin.users.nonaktifkan', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-white text-warning border-0 rounded-2 px-2 py-1.5 d-flex align-items-center gap-1 shadow-sm" title="Nonaktifkan User" onclick="return confirm('Apakah Anda yakin ingin MENONAKTIFKAN akun {{ $namaFinal }}?');">
                                                    <i class="bi bi-person-x-fill fs-6 text-warning"></i>
                                                    <span class="small fw-semibold text-warning">Matikan</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.aktifkan', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-white text-success border-0 rounded-2 px-2 py-1.5 d-flex align-items-center gap-1 shadow-sm" title="Aktifkan User" onclick="return confirm('Apakah Anda yakin ingin MENGAKTIFKAN akun {{ $namaFinal }}?');">
                                                    <i class="bi bi-person-check-fill fs-6 text-success"></i>
                                                    <span class="small fw-semibold text-success">Aktifkan</span>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.users.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas {{ $namaFinal }}? Akun login terkait juga akan dihapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-white text-danger border-0 rounded-2 px-2 py-1.5 d-flex align-items-center gap-1 shadow-sm" title="Hapus Petugas">
                                                <i class="bi bi-trash3-fill fs-6"></i>
                                                <span class="small fw-semibold">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 64px; height: 64px; background-color: #ccfbf1; color: #0f766e;">
                                            <i class="bi bi-people-fill fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1" style="color: #0f766e;">Belum Ada Data Petugas</h6>
                                        <p class="small mb-0" style="color: #0d9488;">Belum ada data petugas yang terdaftar di dalam sistem.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        <!-- Row Khusus Hasil Pencarian Kosong (JS) -->
                        <tr id="noResultsRow" style="display: none;">
                            <td colspan="6" class="text-center py-5">
                                <div class="py-3">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 54px; height: 54px; background-color: #fef2f2; color: #ef4444;">
                                        <i class="bi bi-search fs-3"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1" style="color: #991b1b;">Data Tidak Ditemukan</h6>
                                    <p class="small text-muted mb-0">Tidak ada data petugas yang cocok dengan kata kunci atau filter yang Anda pilih.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="card-footer py-3 px-4 border-top d-flex justify-content-between align-items-center" style="background-color: rgba(240, 253, 244, 0.5); border-color: #ccfbf1 !important;">
            <span class="text-muted small">
                Menampilkan <strong id="visibleCount" class="fw-bold" style="color: #0f766e;">{{ count($petugas) }}</strong> dari <strong class="fw-bold" style="color: #0f766e;">{{ count($petugas) }}</strong> total data petugas.
            </span>
            <span class="badge bg-white border px-3 py-1.5 rounded-pill shadow-sm" style="color: #0f766e; border-color: #99f6e4 !important;">
                SIPEDOK Admin Module
            </span>
        </div>
    </div>

</div>

<style>
    /* Custom Green Table Styles */
    .custom-green-table {
        border-collapse: collapse !important;
        width: 100%;
        border: 2px solid #0d9488 !important;
    }
    
    .custom-green-table th,
    .custom-green-table td {
        border-right: 2px solid #2dd4bf !important;
        border-bottom: 1px solid #a7f3d0 !important;
        color: #0f766e !important;
        vertical-align: middle;
    }

    .custom-green-table th:last-child,
    .custom-green-table td:last-child {
        border-right: none !important;
    }

    .custom-green-table thead th {
        background-color: #0f766e !important;
        color: #ffffff !important;
        border-bottom: 2px solid #042f2e !important;
        border-right: 2px solid rgba(255, 255, 255, 0.3) !important;
        font-weight: 700;
    }

    .custom-green-table thead th:last-child {
        border-right: none !important;
    }

    .hover-row-teal:hover {
        background-color: #ecfdf5 !important;
    }

    .hover-scale {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-scale:hover {
        transform: translateY(-2px);
    }

    /* Style Dropdown Filter Konsisten */
    #roleFilter {
        background-color: #f0fdf4 !important;
        color: #0f766e !important;
        border: 1px solid #81c784 !important;
        font-weight: 600;
    }

    #roleFilter option {
        background-color: #ffffff !important;
        color: #0f766e !important;
    }
</style>

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
        const roleFilter = document.getElementById('roleFilter').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.petugas-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const username = row.getAttribute('data-username') || '';
            const role = row.getAttribute('data-role') || '';

            const matchesSearch = name.includes(searchInput) || username.includes(searchInput);
            const matchesRole = roleFilter === '' || role === roleFilter;

            if (matchesSearch && matchesRole) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update Counter
        const visibleCountElem = document.getElementById('visibleCount');
        if (visibleCountElem) {
            visibleCountElem.textContent = visibleCount;
        }

        // Tampilkan Pesan "Data Tidak Ditemukan" Jika Filter Kosong
        const noResultsRow = document.getElementById('noResultsRow');
        if (noResultsRow) {
            noResultsRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }
    }

    function resetSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('roleFilter').value = '';
        filterTable();
    }
</script>

@endsection