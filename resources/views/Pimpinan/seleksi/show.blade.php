@extends('layouts.app')

@section('title', 'Kurasi & Seleksi Dokumentasi')
@section('page-title', 'Kurasi & Seleksi Dokumentasi')

@section('content')

<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #e6f4f1;
    }

    .btn-toska {
        background-color: var(--toska-dark);
        color: #ffffff;
        border: none;
    }

    .btn-toska:hover {
        background-color: var(--toska-primary);
        color: #ffffff;
    }

    .border-toska {
        border-color: var(--toska-dark) !important;
    }

    .card-media-selected {
        border: 2px solid var(--toska-dark) !important;
        background-color: var(--toska-light);
    }

    .form-check-input:checked {
        background-color: var(--toska-dark);
        border-color: var(--toska-dark);
    }
</style>

<div class="container-fluid py-3">

    {{-- Header Banner --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-1"><i class="bi bi-folder-fill me-2"></i>{{ $folder->nama_folder }}</h5>
                    <small class="opacity-75">Pilih foto/video yang disetujui (ACC) untuk diteruskan ke Tim Editor.</small>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-white text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-images text-teal me-1"></i> {{ count($files) }} Berkas
                    </span>

                    <!-- Tombol Switch Grid & List View -->
                    <div class="btn-group" role="group" aria-label="Toggle View">
                        <button type="button" class="btn btn-sm btn-outline-light active" id="btn-grid" onclick="switchView('grid')">
                            <i class="bi bi-grid-3x3-gap-fill me-1"></i> Grid
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-light" id="btn-list" onclick="switchView('list')">
                            <i class="bi bi-list-task me-1"></i> List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('pimpinan.seleksi.kirimEditor', $folder->id) }}" method="POST">
        @csrf

        <!-- ==================== 1. TAMPILAN GRID ==================== -->
        <div id="view-grid" class="row g-3 mb-4">
            @forelse($files as $file)
                @php
                    $isFoto = strtolower($file->tipe_file ?? 'foto') === 'foto';
                    $fileUrl = asset('storage/' . $file->path_file);
                    $isSelected = $file->status == 'dipilih';
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm media-card {{ $isSelected ? 'card-media-selected' : '' }}">
                        <div class="position-relative style-preview" style="height: 190px; background: #000; overflow: hidden;">
                            @if($isFoto)
                                <img src="{{ $fileUrl }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $file->nama_file }}">
                            @else
                                <video src="{{ $fileUrl }}#t=0.5" class="w-100 h-100" style="object-fit: cover;" controls></video>
                            @endif

                            <span class="position-absolute top-0 end-0 m-2 badge {{ $isFoto ? 'bg-primary' : 'bg-danger' }} rounded-pill">
                                {{ strtoupper($file->tipe_file ?? 'FOTO') }}
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <p class="fw-semibold text-dark text-truncate mb-3" title="{{ $file->nama_file }}">
                                {{ $file->nama_file }}
                            </p>

                            <div class="form-check bg-light p-2 rounded border">
                                <input class="form-check-input ms-1 me-2" type="checkbox" name="selected_files[]" value="{{ $file->id }}" id="grid_file_{{ $file->id }}" {{ $isSelected ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-dark small" for="grid_file_{{ $file->id }}">
                                    Pilih untuk Edit
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted">Tidak ada berkas media untuk diseleksi dalam folder ini.</p>
                </div>
            @endforelse
        </div>

        <!-- ==================== 2. TAMPILAN LIST ==================== -->
        <div id="view-list" class="d-none mb-4">
            <div class="table-responsive bg-white rounded-3 border shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="80" class="text-center">Pilih</th>
                            <th width="80">Preview</th>
                            <th>Nama File</th>
                            <th>Tipe File</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                            @php
                                $isFoto = strtolower($file->tipe_file ?? 'foto') === 'foto';
                                $fileUrl = asset('storage/' . $file->path_file);
                                $isSelected = $file->status == 'dipilih';
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="selected_files[]" value="{{ $file->id }}" id="list_file_{{ $file->id }}" {{ $isSelected ? 'checked' : '' }}>
                                </td>
                                <td>
                                    @if($isFoto)
                                        <img src="{{ $fileUrl }}" class="rounded object-fit-cover" width="50" height="50">
                                    @else
                                        <div class="bg-dark rounded d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                                            <i class="bi bi-play-circle fs-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <label for="list_file_{{ $file->id }}" class="fw-bold mb-0 text-dark" style="cursor: pointer;">
                                        {{ $file->nama_file }}
                                    </label>
                                </td>
                                <td>
                                    <span class="badge {{ $isFoto ? 'bg-primary' : 'bg-danger' }} rounded-pill text-uppercase">
                                        {{ $file->tipe_file ?? 'FOTO' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-info rounded-circle" title="Lihat File Asli">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada berkas media untuk diseleksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Instruksi Catatan Pimpinan --}}
        <div class="card border-0 shadow-sm p-3 mb-4">
            <label for="catatan_pimpinan" class="form-label fw-bold text-dark">
                <i class="bi bi-pencil-square me-1 text-teal"></i> Instruksi Edit untuk Editor:
            </label>
            <textarea name="catatan_pimpinan" id="catatan_pimpinan" class="form-control" rows="3" placeholder="Contoh: Tolong sesuaikan pencahayaan, tingkatkan saturasi, dan beri logo official pada sudut kanan atas..."></textarea>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('pimpinan.kegiatan') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-toska rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-send-fill me-1"></i> Kirim ke Editor
            </button>
        </div>

    </form>
</div>

<!-- JavaScript Switch View & Sync Checkbox -->
<script>
    function switchView(viewType) {
        const gridView = document.getElementById('view-grid');
        const listView = document.getElementById('view-list');
        const btnGrid  = document.getElementById('btn-grid');
        const btnList  = document.getElementById('btn-list');

        if (viewType === 'list') {
            gridView.classList.add('d-none');
            listView.classList.remove('d-none');

            btnList.classList.add('active', 'btn-light', 'text-dark');
            btnList.classList.remove('btn-outline-light');

            btnGrid.classList.remove('active', 'btn-light', 'text-dark');
            btnGrid.classList.add('btn-outline-light');

            localStorage.setItem('sipedok_pimpinan_view', 'list');
        } else {
            listView.classList.add('d-none');
            gridView.classList.remove('d-none');

            btnGrid.classList.add('active', 'btn-light', 'text-dark');
            btnGrid.classList.remove('btn-outline-light');

            btnList.classList.remove('active', 'btn-light', 'text-dark');
            btnList.classList.add('btn-outline-light');

            localStorage.setItem('sipedok_pimpinan_view', 'grid');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('sipedok_pimpinan_view') || 'grid';
        switchView(savedView);

        // Sinkronkan CENTANG antara mode Grid dan mode List
        const checkboxes = document.querySelectorAll('input[name="selected_files[]"]');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const val = this.value;
                const isChecked = this.checked;
                document.querySelectorAll(`input[name="selected_files[]"][value="${val}"]`).forEach(otherCb => {
                    otherCb.checked = isChecked;
                });
            });
        });
    });
</script>
@endsection