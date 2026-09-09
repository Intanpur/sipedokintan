@extends('layouts.app')

@section('title', 'Proses Editing & Bahan Mentah')

@section('content')

<style>
    :root {
        --toska-primary: #0d9488;
        --toska-dark: #0f766e;
        --toska-light: #f0fdfa;
        --toska-border: #ccfbf1;
    }

    .badge-toska {
        background-color: var(--toska-light);
        color: var(--toska-dark);
        border: 1px solid var(--toska-border);
    }

    .card-folder {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        overflow: hidden;
    }

    .folder-header {
        background-color: #fafafa;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
        border-bottom: 1px solid #f1f5f9;
    }

    .icon-folder-box {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .btn-soft-warning {
        background-color: #fffbe3;
        color: #b45309;
        border: 1px solid #fde68a;
        transition: all 0.2s ease;
    }

    .btn-soft-warning:hover {
        background-color: #fef3c7;
        color: #92400e;
    }

    .instruction-box {
        background-color: #fff5f5;
        border-left: 4px solid #ef4444;
        border-radius: 0 8px 8px 0;
    }

    .btn-switch-mode {
        border-color: var(--toska-dark);
        color: var(--toska-dark);
        background-color: #ffffff;
        font-weight: 500;
    }

    .btn-switch-mode:hover, .btn-switch-mode.active {
        background-color: var(--toska-dark) !important;
        color: #ffffff !important;
        border-color: var(--toska-dark) !important;
    }

    /* GRID VIEW */
    .view-grid-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        padding: 18px;
    }

    .media-card {
        width: calc(20% - 12px);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    @media (max-width: 1200px) { .media-card { width: calc(25% - 12px); } }
    @media (max-width: 992px) { .media-card { width: calc(33.333% - 12px); } }
    @media (max-width: 768px) { .media-card { width: calc(50% - 12px); } }
    @media (max-width: 576px) { .media-card { width: 100%; } }

    .media-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.10);
    }

    .media-preview-box {
        height: 180px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .media-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 4px;
        display: block;
        background: #f1f5f9;
    }

    .media-preview-box video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        background: #000;
    }

    .media-error {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        background: #f1f5f9;
        text-align: center;
        padding: 15px;
    }

    .media-error i { font-size: 40px; margin-bottom: 8px; }
    .media-error small { font-size: 11px; }

    .media-card-body { padding: 10px; background: #ffffff; }

    .mode-grid .view-list-container { display: none !important; }
    .mode-grid .view-grid-container { display: flex !important; }
    .mode-list .view-grid-container { display: none !important; }
    .mode-list .view-list-container { display: block !important; }

    .view-list-container { padding: 0 18px 18px 18px; }

    #previewMediaModal .modal-content {
        background: #111827;
        border-radius: 14px;
        overflow: hidden;
    }

    #modalMediaContent {
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #modalMediaContent img { max-width: 100%; max-height: 75vh; object-fit: contain; border-radius: 8px; }
    #modalMediaContent video { width: 100%; max-height: 75vh; border-radius: 8px; }
    
    .feature-chip {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
    }
</style>

<div class="container-fluid py-4 px-3 px-md-4">

    {{-- BANNER HEADER --}}
    <div class="card border-0 shadow-sm text-white mb-4" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); border-radius: 16px;">
        <div class="card-body p-4">
            
            {{-- ATAS: BADGE, GREETING, DAN TOMBOL "MULAI PROCESS EDITING" --}}
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-2 rounded-pill fw-medium">
                        <i class="bi bi-scissors me-1"></i> Editor Workspace
                    </span>
                    <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name ?? 'bejo' }}! 👋</h3>
                    <p class="mb-0 text-white-50">Siap untuk memproses bahan mentah dari pimpinan hari ini? Cek tugas terbarumu di bawah.</p>
                </div>

                <div>
                    <a href="#folders-wrapper" class="btn btn-warning fw-bold px-4 py-2.5 rounded-pill shadow-sm text-dark d-inline-flex align-items-center gap-2">
                        <i class="bi bi-scissors fs-6"></i> Mulai Process Editing
                    </a>
                </div>
            </div>

            {{-- BADAW: KOTAK TENTANG FITUR SISTEM (DIBAWAH KALIMAT "SIAP UNTUK MEMPROSES...") --}}
            <div class="feature-chip p-3 rounded-3 mt-3">
                <div class="fw-bold mb-1 text-white d-flex align-items-center gap-2" style="font-size: 13px;">
                    <i class="bi bi-cpu-fill text-warning"></i> Tentang Fitur Sistem Editor Workspace:
                </div>
                <div class="d-flex flex-wrap gap-3 small text-white-50" style="font-size: 12px;">
                   <span><i class="bi bi-check-circle-fill text-info me-1"></i> Hanya menampilkan bahan foto/video yang siap diolah</span>
<span><i class="bi bi-check-circle-fill text-info me-1"></i> Cukup klik 2x untuk memperbesar foto atau memutar video</span>
<span><i class="bi bi-check-circle-fill text-info me-1"></i> Simpan semua foto/video sekaligus tanpa unduh satu per satu dengan fitur ZIP</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ALERT FLASH MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- HEADER CONTROL --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h6 class="fw-bold text-dark mb-0">
            <i class="bi bi-collection-fill text-teal me-1"></i> Daftar Folder Mentah
        </h6>
        <div class="btn-group shadow-sm" role="group" aria-label="Layout Switcher">
            <button type="button" class="btn btn-sm btn-switch-mode" id="btn-grid" onclick="switchView('grid')">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Grid
            </button>
            <button type="button" class="btn btn-sm btn-switch-mode" id="btn-list" onclick="switchView('list')">
                <i class="bi bi-list-task me-1"></i> List
            </button>
        </div>
    </div>

    {{-- FOLDER WRAPPER --}}
    <div id="folders-wrapper" class="mode-grid">
        @forelse($folders as $folder)
            @php
                $filesACC = $folder->dokumentasi->filter(function($file) {
                    return in_array(strtolower($file->status), ['dipilih', 'editing', 'selesai']);
                });
            @endphp

            <div class="card card-folder shadow-sm mb-4">
                {{-- FOLDER HEADER --}}
                <div class="card-header folder-header py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-folder-box">
                            <i class="bi bi-folder-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h5 class="fw-bold text-dark mb-0 fs-6">{{ $folder->nama_folder }}</h5>
                                <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill small">
                                    <i class="bi bi-tag-fill text-teal me-1"></i>{{ $folder->kegiatan->nama_kegiatan ?? 'Kegiatan Umum' }}
                                </span>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-calendar3 me-1"></i>
                                Diterima: {{ \Carbon\Carbon::parse($folder->created_at)->translatedFormat('d F Y - H:i') }} WIB
                            </small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                        <span class="badge badge-toska px-3 py-2 rounded-pill fw-semibold me-1">
                            <i class="bi bi-images me-1 text-teal"></i>{{ $filesACC->count() }} Berkas Mentah
                        </span>
                        <a href="{{ route('editor.downloadZip', $folder->id) }}" class="btn btn-soft-warning fw-bold btn-sm rounded-pill px-3 py-2 shadow-sm">
                            <i class="bi bi-file-earmark-zip-fill me-1"></i> Unduh Semua (ZIP)
                        </a>
                    </div>
                </div>

                {{-- CATATAN PIMPINAN --}}
                @if(!empty($folder->catatan_pimpinan))
                    <div class="instruction-box px-4 py-2 mt-3 mx-4">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-chat-left-quote-fill text-danger mt-1"></i>
                            <div>
                                <small class="fw-bold text-danger text-uppercase d-block" style="font-size: 11px; letter-spacing: 0.5px;">Instruksi Pimpinan untuk Folder ini:</small>
                                <span class="small text-dark fw-medium">{{ $folder->catatan_pimpinan }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 1. MODE GRID --}}
                <div class="view-grid-container">
                    @forelse($filesACC as $file)
                        @php
                            $rawPath = ltrim(str_replace('\\', '/', $file->path_file ?? $file->file_path ?? $file->path ?? ''), '/');
                            if (str_starts_with($rawPath, 'public/')) {
                                $rawPath = substr($rawPath, 7);
                            }
                            $fileUrl = str_starts_with($rawPath, 'http') ? $rawPath : asset('storage/' . str_replace('storage/', '', $rawPath));

                            $tipeFile = strtolower($file->tipe_file ?? '');
                            $extPath = strtolower(pathinfo($rawPath, PATHINFO_EXTENSION));
                            $extName = strtolower(pathinfo($file->nama_file ?? '', PATHINFO_EXTENSION));

                            $imageExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg'];
                            $videoExts = ['mp4', 'mov', 'avi', 'mkv', 'webm'];

                            $isImage = $tipeFile === 'foto' || in_array($extPath, $imageExts) || in_array($extName, $imageExts);
                            $isVideo = $tipeFile === 'video' || in_array($extPath, $videoExts) || in_array($extName, $videoExts);
                        @endphp

                        <div class="media-card" ondblclick="previewMedia(@js($fileUrl), @js($isVideo ? 'video' : 'image'), @js($file->nama_file))">
                            <div class="media-preview-box">
                                @if($isImage)
                                    <img src="{{ $fileUrl }}" alt="{{ $file->nama_file }}" loading="lazy" onerror="showImageError(this)">
                                @elseif($isVideo)
                                    <video src="{{ $fileUrl }}#t=0.5" preload="metadata"></video>
                                    <div class="position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-50 rounded-circle p-2">
                                        <i class="bi bi-play-fill text-white fs-4"></i>
                                    </div>
                                @else
                                    <div class="media-error">
                                        <i class="bi bi-file-earmark text-secondary"></i>
                                        <small>File tidak dapat dipreview</small>
                                    </div>
                                @endif
                            </div>

                            <div class="media-card-body">
                                <span class="fw-bold text-dark d-block text-truncate small" title="{{ $file->nama_file }}">
                                    {{ $file->nama_file }}
                                </span>

                                @if(!empty($file->instruksi_edit))
                                    <small class="text-danger d-block text-truncate mt-1" style="font-size: 10px;" title="{{ $file->instruksi_edit }}">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $file->instruksi_edit }}
                                    </small>
                                @endif

                                <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top">
                                    <span class="badge {{ strtolower($file->status) === 'selesai' ? 'bg-success' : (strtolower($file->status) === 'editing' ? 'bg-warning text-dark' : 'badge-toska') }} rounded-pill" style="font-size: 9px;">
                                        {{ ucfirst($file->status) }}
                                    </span>
                                    <a href="{{ route('editor.editing.download', $file->id) }}" class="btn btn-xs btn-primary rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;" title="Unduh" onclick="event.stopPropagation();">
                                        <i class="bi bi-download" style="font-size: 11px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-100 text-center text-muted py-4 small">
                            Belum ada file mentah dalam folder ini.
                        </div>
                    @endforelse
                </div>

                {{-- 2. MODE LIST --}}
                <div class="view-list-container">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light small text-muted text-uppercase" style="font-size: 11px;">
                                <tr>
                                    <th width="50" class="text-center ps-3">NO</th>
                                    <th>BERKAS</th>
                                    <th>CATATAN REVISI / EDIT</th>
                                    <th width="120" class="text-center">STATUS</th>
                                    <th width="100" class="text-center pe-3">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($filesACC as $file)
                                    @php
                                        $rawPath = ltrim(str_replace('\\', '/', $file->path_file ?? $file->file_path ?? $file->path ?? ''), '/');
                                        if (str_starts_with($rawPath, 'public/')) {
                                            $rawPath = substr($rawPath, 7);
                                        }
                                        $fileUrl = str_starts_with($rawPath, 'http') ? $rawPath : asset('storage/' . str_replace('storage/', '', $rawPath));

                                        $tipeFile = strtolower($file->tipe_file ?? '');
                                        $extPath = strtolower(pathinfo($rawPath, PATHINFO_EXTENSION));
                                        $extName = strtolower(pathinfo($file->nama_file ?? '', PATHINFO_EXTENSION));

                                        $imageExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg'];
                                        $videoExts = ['mp4', 'mov', 'avi', 'mkv', 'webm'];

                                        $isImage = $tipeFile === 'foto' || in_array($extPath, $imageExts) || in_array($extName, $imageExts);
                                        $isVideo = $tipeFile === 'video' || in_array($extPath, $videoExts) || in_array($extName, $videoExts);
                                    @endphp
                                    <tr style="cursor: pointer;" ondblclick="previewMedia(@js($fileUrl), @js($isVideo ? 'video' : 'image'), @js($file->nama_file))">
                                        <td class="text-center ps-3 text-muted small">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($isImage)
                                                    <i class="bi bi-file-earmark-image fs-5 text-primary"></i>
                                                @elseif($isVideo)
                                                    <i class="bi bi-file-earmark-play fs-5 text-danger"></i>
                                                @else
                                                    <i class="bi bi-file-earmark fs-5 text-secondary"></i>
                                                @endif
                                                <span class="fw-medium text-dark small">{{ $file->nama_file }}</span>
                                            </div>
                                        </td>
                                        <td class="small text-muted">
                                            @if(!empty($file->instruksi_edit))
                                                <span class="text-danger small bg-danger bg-opacity-10 px-2 py-1 rounded">
                                                    {{ $file->instruksi_edit }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ strtolower($file->status) === 'selesai' ? 'bg-success' : (strtolower($file->status) === 'editing' ? 'bg-warning text-dark' : 'badge-toska') }} rounded-pill" style="font-size: 10px;">
                                                {{ ucfirst($file->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-3" onclick="event.stopPropagation();">
                                            <a href="{{ route('editor.editing.download', $file->id) }}" class="btn btn-sm btn-outline-primary rounded-circle p-1" title="Unduh">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4 small">
                                            Belum ada file mentah dalam folder ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="card border-0 shadow-sm p-5 text-center rounded-4">
                <i class="bi bi-folder-x fs-1 text-muted mb-2"></i>
                <h5 class="fw-bold text-dark">Belum Ada Bahan Mentah</h5>
                <p class="text-muted small mb-0">Belum ada folder yang disetujui untuk dilakukan proses editing.</p>
            </div>
        @endforelse
    </div>

</div>

{{-- MODAL PREVIEW --}}
<div class="modal fade" id="previewMediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title text-white text-truncate" id="previewModalTitle">Preview Berkas</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center d-flex align-items-center justify-content-center" style="min-height: 300px;">
                <div id="modalMediaContent" class="w-100"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchView(viewType) {
        const wrapper = document.getElementById('folders-wrapper');
        const btnGrid = document.getElementById('btn-grid');
        const btnList = document.getElementById('btn-list');

        if (viewType === 'list') {
            wrapper.classList.remove('mode-grid');
            wrapper.classList.add('mode-list');
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
            localStorage.setItem('editor_folder_view', 'list');
        } else {
            wrapper.classList.remove('mode-list');
            wrapper.classList.add('mode-grid');
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
            localStorage.setItem('editor_folder_view', 'grid');
        }
    }

    function previewMedia(url, type, fileName) {
        const modalContent = document.getElementById('modalMediaContent');
        const modalTitle = document.getElementById('previewModalTitle');
        modalTitle.innerText = fileName;

        if (type === 'image') {
            modalContent.innerHTML = `<img src="${url}" class="img-fluid rounded shadow" style="max-height: 75vh; object-fit: contain;">`;
        } else if (type === 'video') {
            modalContent.innerHTML = `<video src="${url}" controls autoplay class="w-100 rounded shadow" style="max-height: 75vh;"></video>`;
        }

        const previewModal = new bootstrap.Modal(document.getElementById('previewMediaModal'));
        previewModal.show();
    }

    function showImageError(img) {
        img.parentElement.innerHTML = `
            <div class="media-error">
                <i class="bi bi-exclamation-triangle text-warning"></i>
                <small>Gambar Gagal Dimuat</small>
            </div>
        `;
    }

    document.getElementById('previewMediaModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalMediaContent').innerHTML = '';
    });

    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('editor_folder_view') || 'grid';
        switchView(savedView);
    });
</script>

@endsection