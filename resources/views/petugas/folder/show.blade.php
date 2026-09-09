@extends('layouts.app')

@section('title', 'Detail Folder - SIPEDOK')

@section('content')
<style>
    :root {
        --cyan-primary: #00b4a2;
        --cyan-dark: #007a6e;
        --cyan-light: rgba(0, 180, 162, 0.08);
        --cyan-glow: rgba(0, 180, 162, 0.25);
        --border-color: #e2e8f0;
    }

    .drive-header {
        background: linear-gradient(135deg, rgba(0, 180, 162, 0.06) 0%, rgba(15, 23, 42, 0.03) 100%);
        border: 1px solid rgba(0, 180, 162, 0.18);
        border-radius: 20px;
        padding: 24px 28px;
    }

    .btn-cyan {
        background: linear-gradient(135deg, var(--cyan-primary) 0%, var(--cyan-dark) 100%);
        color: #ffffff;
        border: none;
        font-weight: 700;
        box-shadow: 0 4px 14px var(--cyan-glow);
        transition: all 0.25s ease;
    }
    .btn-cyan:hover {
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 180, 162, 0.35);
    }

    .file-card {
        background: #ffffff;
        border: 2px solid var(--border-color);
        border-radius: 16px;
        transition: all 0.2s ease;
        cursor: pointer;
        user-select: none;
        position: relative;
        overflow: hidden;
    }
    .file-card:hover {
        border-color: var(--cyan-primary);
        box-shadow: 0 8px 20px rgba(0, 180, 162, 0.12);
    }
    .file-card.active {
        border-color: var(--cyan-primary) !important;
        background-color: var(--cyan-light);
    }

    .file-thumbnail {
        height: 140px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    .file-thumbnail img, .file-thumbnail video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-actions-overlay {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 10;
    }
    .btn-dots {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #334155;
        transition: all 0.2s;
    }
    .btn-dots:hover {
        background: #ffffff;
        color: var(--cyan-dark);
        transform: scale(1.05);
    }

    .badge-type {
        position: absolute;
        top: 8px;
        left: 8px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        z-index: 5;
    }

    .inline-name-input {
        transition: all 0.2s ease;
        border-radius: 6px;
        padding: 2px 6px !important;
    }
    .inline-name-input:hover {
        background-color: rgba(0, 180, 162, 0.1) !important;
        cursor: pointer;
    }
    .inline-name-input:focus {
        background-color: #ffffff !important;
        border: 1px solid var(--cyan-primary) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 162, 0.25) !important;
        cursor: text;
    }

    /* Styling Badge Video dengan Warna Hijau Soft yang Terang & Jelas */
    .bg-green-soft { 
        background-color: rgba(25, 135, 84, 0.15) !important; 
        color: #0f5132 !important; 
        border: 1px solid rgba(25, 135, 84, 0.3) !important;
        font-weight: 800;
    }

    /* Mencegah Scrollbar Muncul saat Dropdown Terbuka */
    .table-responsive {
        overflow: visible !important;
    }
</style>

<div class="container-fluid py-4 px-4">

    {{-- Alert Notifikasi Session --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Breadcrumb & Header --}}
    <div class="drive-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('petugas.kegiatan.index') }}" class="text-decoration-none fw-semibold" style="color: var(--cyan-dark);"><i class="bi bi-hdd-network me-1"></i> Drive SIPEDOK</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('petugas.kegiatan.index') }}" class="text-decoration-none text-muted">Kegiatan Liputan</a></li>
                        <li class="breadcrumb-item active text-muted" aria-current="page">Detail Folder</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning">
                        <i class="bi bi-folder-fill fs-2"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0">{{ $folder->nama_folder }}</h3>
                        <div class="d-flex align-items-center gap-3 text-muted small mt-1">
                            <span><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $folder->kegiatan->lokasi ?? 'Lokasi tidak diisi' }}</span>
                            <span><i class="bi bi-calendar-event me-1 text-primary"></i> {{ $folder->kegiatan->tanggal_kegiatan ? \Carbon\Carbon::parse($folder->kegiatan->tanggal_kegiatan)->format('d M Y') : '-' }}</span>
                            <span class="badge bg-light text-dark border"><i class="bi bi-files me-1"></i> {{ $folder->dokumentasi->count() }} File</span>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25"><i class="bi bi-image me-1"></i> {{ $folder->total_foto }} Foto</span>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"><i class="bi bi-film me-1"></i> {{ $folder->total_video }} Video</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('petugas.kegiatan.index') }}" class="btn btn-secondary rounded-pill px-4 py-2 fw-bold text-white text-decoration-none shadow-sm">
                    Kembali
                </a>

                <form action="{{ route('petugas.folder.kirimPimpinan', $folder->id) }}" method="POST" class="d-inline m-0 p-0">
    @csrf
    <!-- Tombol Pemicu Modal -->
<button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#modalKirimWA">
    <span>📲 Kirim Notifikasi WA</span>
</button>

<!-- Modal Pilih Pimpinan -->
<div class="modal fade" id="modalKirimWA" tabindex="-1" aria-labelledby="modalKirimWALabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalKirimWALabel">
                    <i class="bi bi-whatsapp text-success me-2"></i>Pilih Pimpinan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('petugas.folder.kirimPimpinan', $folder->id) }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <p class="text-muted small mb-3">Pilih pimpinan yang akan menerima laporan dokumentasi kegiatan ini via WhatsApp:</p>
                    
                    <div class="mb-3">
                        <label for="pimpinan_id" class="form-label fw-semibold">Nama Pimpinan</label>
                        <select name="pimpinan_id" id="pimpinan_id" class="form-select rounded-3" required>
                            <option value="" selected disabled>-- Pilih Pimpinan --</option>
                            @foreach($pimpinanList as $pimpinan)
                                <option value="{{ $pimpinan->id }}">
                                    {{ $pimpinan->name }} ({{ $pimpinan->no_hp ?? 'No HP belum diisi' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                        <i class="bi bi-send me-1"></i> Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</form>

                <button type="button" class="btn btn-cyan rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-arrow-up-fill fs-5"></i>
                    <span>Upload Dokumentasi</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Toolbar Filter & View Switcher --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-lg-5 col-md-12">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchFile" class="form-control bg-light border-start-0" placeholder="Cari nama file...">
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex gap-2">
                <button class="btn btn-sm btn-outline-cyan active filter-btn" onclick="filterType('all', this)">Semua</button>
                <button class="btn btn-sm btn-outline-cyan filter-btn" onclick="filterType('foto', this)"><i class="bi bi-image me-1"></i> Foto</button>
                <button class="btn btn-sm btn-outline-cyan filter-btn" onclick="filterType('video', this)"><i class="bi bi-film me-1"></i> Video</button>
            </div>

            <div class="col-lg-3 col-md-6 text-end d-flex align-items-center justify-content-end gap-2">
                <span class="small text-muted">Sort:</span>
                <select class="form-select form-select-sm w-auto bg-light border-0" id="sortSelect">
                    <option value="nama">Nama File</option>
                    <option value="terbaru">Terbaru</option>
                    <option value="ukuran">Ukuran File</option>
                </select>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-light border active" id="btnGrid" onclick="setView('grid')"><i class="bi bi-grid-fill"></i></button>
                    <button class="btn btn-light border" id="btnList" onclick="setView('list')"><i class="bi bi-list-task"></i></button>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Layout --}}
    <div class="row g-4">
        {{-- Area Grid/List File --}}
        <div class="col-lg-9" id="fileContainer">
            
            {{-- GRID VIEW --}}
            <div class="row g-3" id="gridView">
                @forelse($folder->dokumentasi as $doc)
                @php
                    $isFoto = $doc->tipe_file === 'foto';
                    $fileUrl = asset('storage/' . $doc->path_file);
                    $fileSizeFormatted = number_format($doc->ukuran_file / (1024 * 1024), 2) . ' MB';
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6 file-item" 
                     data-type="{{ $doc->tipe_file }}" 
                     data-nama="{{ strtolower($doc->nama_file) }}"
                     data-size="{{ $doc->ukuran_file }}">
                    
                    <div class="card file-card h-100" 
                         onclick="selectFile('{{ $doc->id }}', '{{ addslashes($doc->nama_file) }}', '{{ $doc->tipe_file }}', '{{ $fileUrl }}', '{{ $fileSizeFormatted }}', '{{ $doc->uploaded_at }}', '{{ $doc->uploader->name ?? 'Petugas' }}')"
                         ondblclick="previewFile('{{ $fileUrl }}', '{{ $doc->tipe_file }}', '{{ addslashes($doc->nama_file) }}')">
                        
                        <span class="badge badge-type {{ $isFoto ? 'bg-info text-dark' : 'bg-green-soft' }}">
                            {{ strtoupper($doc->tipe_file) }}
                        </span>

                        <div class="card-actions-overlay">
                            <div class="dropdown" onclick="event.stopPropagation();">
                                <button class="btn-dots" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 text-start">
                                    <li>
                                        <button class="dropdown-item py-2 small" onclick="previewFile('{{ $fileUrl }}', '{{ $doc->tipe_file }}', '{{ addslashes($doc->nama_file) }}')">
                                            <i class="bi bi-eye me-2 text-primary"></i> Preview / Lihat
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item py-2 small" onclick="openShareModal('{{ $doc->id }}', '{{ addslashes($doc->nama_file) }}')">
                                            <i class="bi bi-share me-2 text-success"></i> Bagikan ke Pimpinan
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form action="{{ route('petugas.dokumentasi.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 small text-danger">
                                                <i class="bi bi-trash me-2"></i> Hapus File
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="file-thumbnail">
                            @if($isFoto)
                                <img src="{{ $fileUrl }}" alt="{{ $doc->nama_file }}" loading="lazy">
                            @else
                                <video src="{{ $fileUrl }}#t=0.5" preload="metadata"></video>
                                <i class="bi bi-play-circle-fill display-5 text-white position-absolute opacity-75"></i>
                            @endif
                        </div>

                        <div class="p-3">
                            <form action="{{ route('petugas.dokumentasi.update', $doc->id) }}" method="POST" class="mb-1" onclick="event.stopPropagation();">
                                @csrf
                                @method('PUT')
                                <input type="text" 
                                       name="nama_file" 
                                       value="{{ $doc->nama_file }}" 
                                       class="form-control form-control-sm border-0 bg-transparent fw-bold text-dark p-0 shadow-none text-truncate inline-name-input" 
                                       title="Klik untuk mengubah nama"
                                       onblur="if(this.value.trim() !== '' && this.value !== '{{ addslashes($doc->nama_file) }}') this.form.submit();"
                                       onkeydown="if(event.key === 'Enter') { event.preventDefault(); this.blur(); }">
                            </form>
                            
                            <div class="d-flex justify-content-between text-muted small">
                                <span>{{ $fileSizeFormatted }}</span>
                                <span>{{ \Carbon\Carbon::parse($doc->uploaded_at)->format('d M Y') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-folder-x display-3 text-muted opacity-50"></i>
                    <p class="text-muted mt-2 fw-semibold">Belum ada foto atau video di folder ini.</p>
                </div>
                @endforelse
            </div>

            {{-- LIST VIEW --}}
            <div class="table-responsive d-none rounded-4 shadow-sm border" id="listView">
                <table class="table table-hover align-middle bg-white mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Nama File</th>
                            <th>Tipe</th>
                            <th>Ukuran</th>
                            <th>Tanggal Upload</th>
                            <th class="text-end pe-3" style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($folder->dokumentasi as $doc)
                        @php
                            $fileUrl = asset('storage/' . $doc->path_file);
                            $fileSizeFormatted = number_format($doc->ukuran_file / (1024 * 1024), 2) . ' MB';
                        @endphp
                        <tr class="file-item" 
                            data-type="{{ $doc->tipe_file }}" 
                            data-nama="{{ strtolower($doc->nama_file) }}"
                            data-size="{{ $doc->ukuran_file }}"
                            onclick="selectFile('{{ $doc->id }}', '{{ addslashes($doc->nama_file) }}', '{{ $doc->tipe_file }}', '{{ $fileUrl }}', '{{ $fileSizeFormatted }}', '{{ $doc->uploaded_at }}', '{{ $doc->uploader->name ?? 'Petugas' }}')"
                            ondblclick="previewFile('{{ $fileUrl }}', '{{ $doc->tipe_file }}', '{{ addslashes($doc->nama_file) }}')">
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi {{ $doc->tipe_file == 'foto' ? 'bi-image text-info' : 'bi-film text-success' }} fs-5"></i>
                                    <form action="{{ route('petugas.dokumentasi.update', $doc->id) }}" method="POST" class="d-inline mb-0" onclick="event.stopPropagation();">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" 
                                               name="nama_file" 
                                               value="{{ $doc->nama_file }}" 
                                               class="form-control form-control-sm border-0 bg-transparent fw-bold text-dark p-0 shadow-none text-truncate inline-name-input" 
                                               style="max-width: 260px;"
                                               title="Klik untuk mengubah nama"
                                               onblur="if(this.value.trim() !== '' && this.value !== '{{ addslashes($doc->nama_file) }}') this.form.submit();"
                                               onkeydown="if(event.key === 'Enter') { event.preventDefault(); this.blur(); }">
                                    </form>
                                </div>
                            </td>
                            <td><span class="badge {{ $doc->tipe_file == 'foto' ? 'bg-info text-dark' : 'bg-green-soft' }}">{{ strtoupper($doc->tipe_file) }}</span></td>
                            <td class="small text-muted">{{ $fileSizeFormatted }}</td>
                            <td class="small text-muted">{{ \Carbon\Carbon::parse($doc->uploaded_at)->format('d M Y') }}</td>
                            <td class="text-end pe-3">
                                <div class="dropdown" onclick="event.stopPropagation();">
                                    <button class="btn btn-sm btn-light border-0 rounded-circle" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            data-bs-popper-config='{"strategy":"fixed"}'
                                            aria-expanded="false"
                                            style="width: 32px; height: 32px;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 text-start">
                                        <li>
                                            <button class="dropdown-item py-2 small" onclick="previewFile('{{ $fileUrl }}', '{{ $doc->tipe_file }}', '{{ addslashes($doc->nama_file) }}')">
                                                <i class="bi bi-eye me-2 text-primary"></i> Preview / Lihat
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item py-2 small" onclick="openShareModal('{{ $doc->id }}', '{{ addslashes($doc->nama_file) }}')">
                                                <i class="bi bi-share me-2 text-success"></i> Bagikan ke Pimpinan
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form action="{{ route('petugas.dokumentasi.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Yakin hapus file ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 small text-danger">
                                                    <i class="bi bi-trash me-2"></i> Hapus File
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Detail Sidebar Panel (Tersembunyi Secara Default) --}}
        <div class="col-lg-3 d-none" id="detailPanelWrapper">
            <div class="card border-0 shadow-sm rounded-4 p-3 sticky-top" style="top: 20px;" id="detailPanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-info-circle me-1 text-cyan"></i> Detail File</h6>
                    <div class="d-flex gap-1" id="panelActionBtns">
                        <button class="btn btn-sm btn-outline-primary rounded-circle" id="panelBtnPreview" title="Preview"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-outline-success rounded-circle" id="panelBtnShare" title="Bagikan"><i class="bi bi-share"></i></button>
                        <a href="#" class="btn btn-sm btn-outline-dark rounded-circle" id="panelBtnDownload" download title="Download"><i class="bi bi-download"></i></a>
                    </div>
                </div>

                {{-- Area Preview Gambar/Video --}}
                <div class="bg-light rounded-3 p-2 text-center mb-3 border d-flex flex-column align-items-center justify-content-center" style="min-height: 180px;" id="sidebarPreviewBox">
                </div>

                {{-- Metadata File Terpilih --}}
                <div id="sidebarMeta">
                    <h6 class="fw-bold text-dark text-break mb-1" id="sidebarFileName">-</h6>
                    <span class="badge bg-info text-dark mb-3" id="sidebarFileType">FOTO</span>

                    <hr class="my-2">

                    <div class="small">
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Ukuran:</span>
                            <span class="fw-semibold text-dark" id="sidebarFileSize">-</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Pengunggah:</span>
                            <span class="fw-semibold text-dark text-truncate ms-2" style="max-width: 120px;" id="sidebarUploader">-</span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">Tanggal Upload:</span>
                            <span class="fw-semibold text-dark" id="sidebarUploadDate">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- MODAL PREVIEW (Ukuran XL) --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-dark text-white py-2">
                <h6 class="modal-title fw-bold text-truncate" id="previewModalTitle">Preview File</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-black text-center d-flex align-items-center justify-content-center" style="min-height: 500px; max-height: 85vh;">
                <div id="previewModalBody" class="w-100 h-100 d-flex align-items-center justify-content-center"></div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SHARE PIMPINAN --}}
<div class="modal fade" id="sharePimpinanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <!-- Action diisi dinamis via JavaScript atau dipasang ke route kirim file tunggal -->
            <form id="sharePimpinanForm" method="POST" action="">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-share text-success me-2"></i> Bagikan ke Pimpinan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-2">
                    <p class="small text-muted mb-3">Pilih pimpinan yang akan dikirimkan pemberitahuan file <strong id="shareFileNameText"></strong>.</p>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Pilih Pimpinan</label>
                        <select name="pimpinan_id" class="form-select rounded-3" required>
                            <option value="">-- Pilih Pimpinan --</option>
                            @if(isset($pimpinanList))
                                @foreach($pimpinanList as $pimpinan)
                                    <option value="{{ $pimpinan->id }}">{{ $pimpinan->name }}</option>
                                @endforeach
                            @else
                                <option value="{{ $folder->kegiatan->pimpinan_id ?? '' }}">Pimpinan Kegiatan ({{ $folder->kegiatan->pimpinan->name ?? 'Pimpinan Utama' }})</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-cyan rounded-pill px-4"><i class="bi bi-send me-1"></i> Bagikan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL UPLOAD DOKUMENTASI --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <form action="{{ route('petugas.folder.upload', $folder->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-cloud-upload text-cyan me-2"></i> Upload Dokumentasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Pilih Foto / Video</label>
                        <input type="file" name="files[]" class="form-control rounded-3" multiple accept="image/*,video/*" required>
                        <div class="form-text small">Bisa pilih banyak file foto atau video sekaligus.</div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-cyan rounded-pill px-4">Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    function previewFile(url, type, name) {
        const modalTitle = document.getElementById('previewModalTitle');
        const modalBody = document.getElementById('previewModalBody');
        
        modalTitle.innerText = name;
        
        if (type === 'foto') {
            modalBody.innerHTML = `<img src="${url}" class="img-fluid" style="max-height: 80vh; object-fit: contain;">`;
        } else {
            modalBody.innerHTML = `<video src="${url}" controls autoplay class="w-100 h-100" style="max-height: 80vh;"></video>`;
        }
        
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }

    function openShareModal(fileId, fileName) {
        // Set nama file di modal
        document.getElementById('shareFileNameText').innerText = fileName;
        
        // Ubah action form mengarah ke route kirim file tunggal milik petugas
        let form = document.getElementById('sharePimpinanForm');
        form.action = "{{ url('/petugas/dokumentasi') }}/" + fileId + "/share-pimpinan";
        
        // Tampilkan modal
        var shareModal = new bootstrap.Modal(document.getElementById('sharePimpinanModal'));
        shareModal.show();
    }

    function selectFile(id, name, type, url, size, uploadDate, uploader) {
        // 1. Tandai elemen card yang aktif
        document.querySelectorAll('.file-card').forEach(card => card.classList.remove('active'));
        if (event && event.currentTarget) {
            event.currentTarget.classList.add('active');
        }

        // 2. Munculkan Sidebar Panel yang tadinya tersembunyi
        const detailPanelWrapper = document.getElementById('detailPanelWrapper');
        if (detailPanelWrapper) {
            detailPanelWrapper.classList.remove('d-none');
        }

        // 3. Render Preview Gambar/Video
        const sidebarPreviewBox = document.getElementById('sidebarPreviewBox');
        if (type === 'foto') {
            sidebarPreviewBox.innerHTML = `<img src="${url}" class="img-fluid rounded-2 h-100 w-100" style="object-fit: contain; max-height: 180px;">`;
        } else {
            sidebarPreviewBox.innerHTML = `<video src="${url}#t=0.5" class="w-100 rounded-2" style="max-height: 180px; object-fit: cover;" controls></video>`;
        }

        // 4. Update Informasi Metadata File
        document.getElementById('sidebarFileName').innerText = name;
        
        const typeBadge = document.getElementById('sidebarFileType');
        typeBadge.innerText = type.toUpperCase();
        typeBadge.className = type === 'foto' ? 'badge bg-info text-dark mb-3' : 'badge bg-green-soft mb-3';

        document.getElementById('sidebarFileSize').innerText = size;
        document.getElementById('sidebarUploader').innerText = uploader;
        document.getElementById('sidebarUploadDate').innerText = uploadDate;

        // 5. Sambungkan Event Tombol Aksi di Kanan Atas Panel
        document.getElementById('panelBtnPreview').onclick = () => previewFile(url, type, name);
        document.getElementById('panelBtnShare').onclick = () => openShareModal(id, name);
        document.getElementById('panelBtnDownload').href = url;
    }

    function setView(view) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const btnGrid = document.getElementById('btnGrid');
        const btnList = document.getElementById('btnList');

        if (view === 'grid') {
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
        } else {
            gridView.classList.add('d-none');
            listView.classList.remove('d-none');
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
        }
    }

    function filterType(type, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.file-item').forEach(item => {
            if (type === 'all' || item.getAttribute('data-type') === type) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    document.getElementById('searchFile').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.file-item').forEach(item => {
            const name = item.getAttribute('data-nama');
            if (name.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    document.getElementById('sortSelect').addEventListener('change', function() {
        const val = this.value;
        const gridContainer = document.getElementById('gridView');
        const items = Array.from(gridContainer.querySelectorAll('.file-item'));

        items.sort((a, b) => {
            if (val === 'nama') {
                return a.getAttribute('data-nama').localeCompare(b.getAttribute('data-nama'));
            } else if (val === 'ukuran') {
                return parseFloat(b.getAttribute('data-size')) - parseFloat(a.getAttribute('data-size'));
            }
            return 0;
        });

        items.forEach(item => gridContainer.appendChild(item));
    });
</script>
@endsection