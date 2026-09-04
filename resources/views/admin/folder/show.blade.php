@extends('layouts.app')

@section('title', 'Detail Folder - ' . ($folder->nama_folder ?? 'SIPEDOK'))

@section('content')
<!-- GOOGLE FONTS & BOOTSTRAP ICONS -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- TEMA HIJAU TOSKA & CUSTOM STYLES -->
<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #14b8a6;
        --toska-accent: #2dd4bf;
        --toska-subtle: #ccfbf1;
        --bg-body: #f1f5f9;
        --card-bg: #ffffff;
        --text-dark: #0f172a;
        --text-muted: #475569;
        --border-color: #cbd5e1;
    }

    body {
        background-color: var(--bg-body) !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-dark);
    }

    .toska-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    .toska-banner {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.3);
    }

    /* Badges */
    .badge-toska {
        background-color: var(--toska-subtle);
        color: var(--toska-dark);
        font-weight: 700;
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 8px;
        padding: 5px 10px;
    }

    .badge-amber {
        background-color: #fef3c7;
        color: #92400e;
        font-weight: 700;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 5px 10px;
    }

    .badge-rose {
        background-color: #ffe4e6;
        color: #9f1239;
        font-weight: 700;
        border: 1px solid #fecdd3;
        border-radius: 8px;
        padding: 5px 10px;
    }

    .badge-cyan {
        background-color: #e0f2fe;
        color: #075985;
        font-weight: 700;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 5px 10px;
    }

    /* Drive Grid Card Styling */
    .media-card {
        border: 1px solid var(--border-color);
        border-radius: 14px;
        background: #ffffff;
        transition: all 0.25s ease-in-out;
        overflow: hidden;
        position: relative;
    }

    .media-card:hover {
        transform: translateY(-4px);
        border-color: var(--toska-primary);
        box-shadow: 0 10px 20px rgba(13, 148, 136, 0.15);
    }

    .media-thumb-container {
        height: 160px;
        background-color: #0f172a;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .media-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .media-card:hover .media-thumb-img {
        transform: scale(1.05);
    }

    .play-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 48px;
        height: 48px;
        background: rgba(13, 148, 136, 0.85);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 22px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    /* Timeline Items */
    .timeline-container {
        position: relative;
        padding-left: 20px;
        border-left: 2px solid #e2e8f0;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -26px;
        top: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--toska-primary);
        border: 2px solid #ffffff;
    }
</style>

<div class="container-fluid pb-5 pt-3">

    <!-- 1. HERO BANNER FOLDER & NAVIGASI -->
    <div class="toska-banner p-4 p-lg-5 text-white mb-4 position-relative">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <a href="{{ route('admin.folder.index') }}" class="btn btn-sm btn-light rounded-pill px-3 py-1 fw-bold mb-3 shadow-sm" style="color: var(--toska-dark);">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Folder
                </a>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-folder2-open fs-2 text-warning"></i>
                    <h2 class="fw-extrabold text-white mb-0" style="font-weight: 800;">
                        {{ $folder->nama_folder }}
                    </h2>
                </div>
                <p class="fs-6 mb-0" style="color: #e6fffa; font-weight: 500;">
                    <i class="bi bi-calendar-event me-1"></i> Kegiatan: <strong>{{ $folder->kegiatan->nama_kegiatan ?? 'Kegiatan Umum' }}</strong>
                </p>
            </div>

            <!-- BAGIAN 8: TOMBOL DOWNLOAD ZIP -->
            <div class="d-flex flex-wrap gap-2">
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-file-earmark-zip-fill text-warning me-1"></i> Opsi Download ZIP
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1">
                        <li>
                            <a class="dropdown-menu-item dropdown-item fw-semibold py-2" href="{{ route('admin.folder.downloadZip', ['id' => $folder->id, 'type' => 'all']) }}">
                                <i class="bi bi-archive-fill text-success me-2"></i> Download Semua Berkas ZIP
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item fw-semibold py-2" href="{{ route('admin.folder.downloadZip', ['id' => $folder->id, 'type' => 'foto']) }}">
                                <i class="bi bi-images text-danger me-2"></i> Download Semua Foto
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item fw-semibold py-2" href="{{ route('admin.folder.downloadZip', ['id' => $folder->id, 'type' => 'video']) }}">
                                <i class="bi bi-camera-video-fill text-info me-2"></i> Download Semua Video
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 11: STATISTIK FOLDER RINGKAS -->
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="toska-card p-3 h-100">
                <span class="fw-bold small text-muted d-block mb-1">TOTAL BERKAS</span>
               <h3 class="fw-bold mb-0 text-dark">{{ $folder->files_count ?? $folder->dokumentasi->count() }}</h3>
                <small class="text-muted">Item File</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="toska-card p-3 h-100">
                <span class="fw-bold small text-muted d-block mb-1">TOTAL FOTO</span>
                <h3 class="fw-bold mb-0 text-danger">{{ $totalFoto ?? 0 }}</h3>
                <small class="text-muted">Berkas JPG / PNG</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="toska-card p-3 h-100">
                <span class="fw-bold small text-muted d-block mb-1">TOTAL VIDEO</span>
                <h3 class="fw-bold mb-0" style="color: #0284c7;">{{ $totalVideo ?? 0 }}</h3>
                <small class="text-muted">Berkas MP4 / MOV</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="toska-card p-3 h-100">
                <span class="fw-bold small text-muted d-block mb-1">UKURAN FOLDER</span>
                <h3 class="fw-bold mb-0" style="color: var(--toska-dark);">{{ $totalUkuranFormatted ?? '0 MB' }}</h3>
                <small class="text-muted">Total Storage</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="toska-card p-3 h-100">
                <span class="fw-bold small text-muted d-block mb-1">UPLOAD HARI INI</span>
                <h3 class="fw-bold mb-0 text-success">{{ $uploadHariIniCount ?? 0 }}</h3>
                <small class="text-muted">Berkas Baru</small>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="toska-card p-3 h-100" style="border-left: 4px solid var(--toska-primary);">
                <span class="fw-bold small text-muted d-block mb-1">STATUS FOLDER</span>
                <div class="mt-1">
                    @if(($folder->status ?? '') == 'selesai')
                        <span class="badge-toska"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                    @elseif(($folder->status ?? '') == 'proses')
                        <span class="badge-amber"><i class="bi bi-hourglass-split me-1"></i> Proses</span>
                    @else
                        <span class="badge-cyan"><i class="bi bi-clock me-1"></i> Pending</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- BAR FILTER & SEARCH REAL-TIME (BAGIAN 9 & 10) -->
    <div class="toska-card p-3 mb-4">
        <div class="row g-3 align-items-center">
            <!-- Bagian 10: Search Bar -->
            <div class="col-lg-5 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 border" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari nama file, uploader, atau tipe berkas..." style="border-radius: 0 10px 10px 0;">
                </div>
            </div>

            <!-- Bagian 9: Filter Tab (Client Side / Fast Filtering) -->
            <div class="col-lg-7 col-md-6">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end" id="filterContainer">
                    <button class="btn btn-sm btn-success fw-bold rounded-pill px-3 py-2 filter-btn active" data-filter="all" style="background: var(--toska-dark); border: none;">
                        Semua Media
                    </button>
                    <button class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3 py-2 filter-btn" data-filter="foto">
                        <i class="bi bi-image me-1"></i> Foto
                    </button>
                    <button class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3 py-2 filter-btn" data-filter="video">
                        <i class="bi bi-camera-video me-1"></i> Video
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- UTAMA: GRID GALERI & TIMELINE SIDEBAR -->
    <div class="row g-4">
        
        <!-- BAGIAN 6: GALERI DOKUMENTASI (GRID CARD GOOGLE DRIVE STYLE) -->
        <div class="col-lg-8">
            <div class="toska-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <h6 class="fw-bold mb-0" style="color: #0f172a; font-size: 16px;">
                        <i class="bi border-0 bi-grid-fill me-2" style="color: var(--toska-primary);"></i>Galeri Dokumentasi Media
                    </h6>
                    <small class="text-muted fw-semibold">Klik berkas untuk preview / putar</small>
                </div>

                <div class="row g-3" id="mediaGrid">
                    @forelse($folder->dokumentasi ?? [] as $file)
                    <div class="col-xl-4 col-md-6 media-item" data-type="{{ strtolower($file->jenis) }}" data-name="{{ strtolower($file->nama_file . ' ' . ($file->uploader->name ?? '')) }}">
                        <div class="media-card h-100 d-flex flex-column">
                            
                            <!-- THUMBNAIL AREA -->
                            <div class="media-thumb-container">
                                @if(strtolower($file->jenis) == 'foto')
                                    <img src="{{ Storage::url($file->path) }}" alt="{{ $file->nama_file }}" class="media-thumb-img" loading="lazy">
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 fw-bold" style="font-size: 10px;">
                                        FOTO
                                    </span>
                                @else
                                    <!-- Video Thumbnail Fallback / Player Indicator -->
                                    <video src="{{ Storage::url($file->path) }}#t=0.5" class="media-thumb-img" preload="metadata"></video>
                                    <div class="play-overlay">
                                        <i class="bi bi-play-fill ms-1"></i>
                                    </div>
                                    <span class="badge bg-info position-absolute top-0 start-0 m-2 fw-bold" style="font-size: 10px;">
                                        VIDEO
                                    </span>
                                @endif
                            </div>

                            <!-- CARD INFO -->
                            <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                <div class="mb-2">
                                    <h6 class="fw-bold text-truncate mb-1" style="font-size: 13px; color: #0f172a;" title="{{ $file->nama_file }}">
                                        {{ $file->nama_file }}
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center text-muted small" style="font-size: 11px;">
                                        <span><i class="bi bi-hdd me-1"></i>{{ $file->ukuran_formatted ?? '0 MB' }}</span>
                                        <span><i class="bi bi-person me-1"></i>{{ $file->uploader->name ?? 'Petugas' }}</span>
                                    </div>
                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="d-flex gap-2 mt-2 pt-2 border-top">
                                    <button type="button" class="btn btn-sm btn-light border w-100 fw-bold rounded-pill" 
                                            onclick="openPreviewModal('{{ Storage::url($file->path) }}', '{{ $file->nama_file }}', '{{ strtolower($file->jenis) }}', '{{ $file->ukuran_formatted ?? '-' }}', '{{ $file->uploader->name ?? '-' }}')" style="font-size: 12px;">
                                        <i class="bi bi-eye text-primary me-1"></i> Preview
                                    </button>
                                    <a href="{{ Storage::url($file->path) }}" download="{{ $file->nama_file }}" class="btn btn-sm btn-light border fw-bold rounded-pill px-3" style="font-size: 12px;" title="Download Berkas">
                                        <i class="bi bi-download text-success"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-images fs-1 d-block mb-2 text-secondary"></i>
                        <h6 class="fw-bold mb-1">Folder Ini Masih Kosong</h6>
                        <p class="small mb-0">Belum ada foto atau video yang diunggah ke dalam folder ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- SIDEBAR: INFORMASI FOLDER & TIMELINE AKTIVITAS (BAGIAN 12) -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">

                <!-- INFORMASI DETIL FOLDER -->
                <div class="toska-card p-4">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color: #0f172a; font-size: 15px;">
                        <i class="bi bi-info-circle-fill me-2" style="color: var(--toska-primary);"></i>Detail Direktori
                    </h6>
                    <div class="d-flex flex-column gap-2" style="font-size: 13px;">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Dibuat Oleh:</span>
                            <strong class="text-dark">{{ $folder->user->name ?? 'Sistem' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Tanggal Buat:</span>
                            <strong class="text-dark">{{ $folder->created_at ? $folder->created_at->format('d M Y, H:i') : '-' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Terakhir Diupdate:</span>
                            <strong class="text-dark">{{ $folder->updated_at ? $folder->updated_at->diffForHumans() : '-' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 12: TIMELINE AKTIVITAS -->
                <div class="toska-card p-4">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color: #0f172a; font-size: 15px;">
                        <i class="bi bi-clock-history me-2 text-warning"></i>Timeline Aktivitas Folder
                    </h6>

                    <div class="timeline-container mt-3">
                        @forelse($timelines ?? [] as $act)
                        <div class="timeline-item">
                            <div class="fw-bold text-dark" style="font-size: 13px;">{{ $act->deskripsi }}</div>
                            <div class="d-flex justify-content-between align-items-center mt-1" style="font-size: 11px;">
                                <span class="text-muted"><i class="bi bi-person me-1"></i>{{ $act->user->name ?? 'Petugas' }}</span>
                                <span class="badge bg-light text-dark border">{{ $act->created_at->format('H:i') }} WIB</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-3 text-muted small">
                            <i class="bi bi-calendar-x d-block fs-4 mb-1"></i>
                            Belum ada rekam aktivitas terbaru.
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- 6. FOOTER -->
    <footer class="mt-5 pt-3 border-top text-center small" style="color: #64748b;">
        <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row">
            <div>
                <strong style="color: var(--toska-dark);">SIPEDOK</strong> — Sistem Informasi Pengelolaan Dokumentasi
            </div>
            <div class="mt-2 mt-sm-0">
                &copy; {{ date('Y') }} <strong>Dinas Komunikasi dan Informatika Kabupaten Pringsewu</strong>
            </div>
        </div>
    </footer>

</div>

<!-- BAGIAN 7: MODAL PREVIEW FULLSCREEN (FOTO & VIDEO) -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h6 class="modal-title fw-bold text-dark" id="modalFileName">Preview Berkas</h6>
                    <small class="text-muted" id="modalMetaInfo">-</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <!-- Container Gambar -->
                <div id="photoPreviewContainer" class="d-none">
                    <img id="modalImage" src="" class="img-fluid rounded-3 shadow-sm max-vh-75" style="max-height: 500px; object-fit: contain;">
                </div>

                <!-- Container Video -->
                <div id="videoPreviewContainer" class="d-none">
                    <video id="modalVideo" controls class="w-100 rounded-3 shadow-sm" style="max-height: 500px;">
                        <source src="" id="modalVideoSource" type="video/mp4">
                        Browser Anda tidak mendukung pemutar video.
                    </video>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                <span class="badge-toska" id="modalFileTypeBadge">TIPE MEDIA</span>
                <a href="#" id="modalDownloadBtn" download class="btn btn-success fw-bold rounded-pill px-4" style="background: var(--toska-dark); border: none;">
                    <i class="bi bi-download me-1"></i> Download Berkas Ini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 1. MODAL PREVIEW HANDLER (BAGIAN 7)
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    const photoContainer = document.getElementById('photoPreviewContainer');
    const videoContainer = document.getElementById('videoPreviewContainer');
    const modalImage = document.getElementById('modalImage');
    const modalVideo = document.getElementById('modalVideo');
    const modalVideoSource = document.getElementById('modalVideoSource');
    const modalFileName = document.getElementById('modalFileName');
    const modalMetaInfo = document.getElementById('modalMetaInfo');
    const modalFileTypeBadge = document.getElementById('modalFileTypeBadge');
    const modalDownloadBtn = document.getElementById('modalDownloadBtn');

    function openPreviewModal(url, fileName, type, size, uploader) {
        modalFileName.textContent = fileName;
        modalMetaInfo.textContent = `Ukuran: ${size} | Unggah oleh: ${uploader}`;
        modalDownloadBtn.href = url;
        modalDownloadBtn.setAttribute('download', fileName);

        if (type === 'foto') {
            modalFileTypeBadge.textContent = 'FOTO / GAMBAR';
            photoContainer.classList.remove('d-none');
            videoContainer.classList.add('d-none');
            modalImage.src = url;
            modalVideo.pause();
        } else {
            modalFileTypeBadge.textContent = 'VIDEO DOKUMENTASI';
            videoContainer.classList.remove('d-none');
            photoContainer.classList.add('d-none');
            modalVideoSource.src = url;
            modalVideo.load();
        }

        previewModal.show();
    }

    // Stop Video saat Modal Ditutup
    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function () {
        modalVideo.pause();
    });

    // 2. SEARCH & FILTER CLIENT-SIDE (BAGIAN 9 & 10)
    const searchInput = document.getElementById('searchInput');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const mediaItems = document.querySelectorAll('.media-item');

    let currentFilter = 'all';
    let currentSearch = '';

    function filterMedia() {
        mediaItems.forEach(item => {
            const itemType = item.getAttribute('data-type');
            const itemName = item.getAttribute('data-name');

            const matchesFilter = (currentFilter === 'all') || (itemType === currentFilter);
            const matchesSearch = itemName.includes(currentSearch);

            if (matchesFilter && matchesSearch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Search Input Event
    searchInput.addEventListener('input', function(e) {
        currentSearch = e.target.value.toLowerCase().trim();
        filterMedia();
    });

    // Filter Buttons Event
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.classList.remove('active', 'btn-success');
                b.classList.add('btn-outline-danger', 'btn-outline-primary');
                b.style.background = 'transparent';
            });

            this.classList.add('active', 'btn-success');
            this.style.background = 'var(--toska-dark)';

            currentFilter = this.getAttribute('data-filter');
            filterMedia();
        });
    });
</script>
@endpush