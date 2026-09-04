@extends('layouts.app')

@section('title', 'folder dokumentasi')
@section('page-title', 'folder dokumentasi')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DEFAULT DATA
    |--------------------------------------------------------------------------
    | Pengaman apabila controller tidak mengirim data.
    */

    $folders = $folders ?? collect();
    $recentFiles = $recentFiles ?? collect();
@endphp


<style>

/* =========================================================
   DASHBOARD
========================================================= */

.drive-dashboard {
    padding: 4px 4px 40px;
}


/* =========================================================
   SEARCH
========================================================= */

.drive-search {
    position: relative;
    max-width: 720px;
    margin-bottom: 28px;
}

.drive-search i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 18px;
    z-index: 2;
}

.drive-search input {
    width: 100%;
    height: 48px;
    border: 1px solid #d9e0e7;
    border-radius: 14px;
    padding: 0 20px 0 48px;
    background: white;
    outline: none;
    transition: .2s;
}

.drive-search input:focus {
    border-color: #0d9488;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, .10);
}


/* =========================================================
   SECTION HEADER
========================================================= */

.drive-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    gap: 15px;
}

.drive-section-title {
    font-size: 19px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.drive-section-subtitle {
    font-size: 13px;
    color: #6b7280;
    margin-top: 3px;
}


/* =========================================================
   TAMBAH KEGIATAN
========================================================= */

.btn-tambah-kegiatan {
    border: none;
    background: #0d9488;
    color: white;
    border-radius: 25px;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    transition: .2s;
    box-shadow: 0 4px 12px rgba(13,148,136,.18);
}

.btn-tambah-kegiatan:hover {
    background: #0f766e;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(13,148,136,.25);
}


/* =========================================================
   FOLDER GRID
========================================================= */

.folder-grid {
    display: grid;
    grid-template-columns: repeat(
        auto-fill,
        minmax(220px, 1fr)
    );
    gap: 14px;
    margin-bottom: 35px;
}

.folder-card {
    position: relative;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 15px;
    min-height: 125px;
    transition: .2s ease;
    cursor: pointer;
}

.folder-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 5px 18px rgba(15, 23, 42, .07);
    transform: translateY(-1px);
}

.folder-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}

.folder-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: #fff4cc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f5b400;
    font-size: 23px;
}

.folder-menu .btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: transparent;
    color: #64748b;
}

.folder-menu .btn:hover {
    background: #f1f5f9;
}

.folder-name {
    display: block;
    margin-top: 11px;
    font-weight: 700;
    color: #111827;
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.folder-name:hover {
    color: #0d9488;
}

.folder-event {
    font-size: 12px;
    color: #64748b;
    margin-top: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.folder-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 13px;
    padding-top: 9px;
    border-top: 1px solid #edf2f7;
    font-size: 11px;
    color: #64748b;
}


/* =========================================================
   EMPTY FOLDER
========================================================= */

.empty-folder {
    border: 1px dashed #cbd5e1;
    border-radius: 14px;
    padding: 35px;
    text-align: center;
    color: #64748b;
    background: #fff;
    margin-bottom: 35px;
}

.empty-folder i {
    font-size: 35px;
    color: #94a3b8;
}


/* =========================================================
   DOCUMENTATION HEADER
========================================================= */

.documentation-toolbar {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 15px 15px 0 0;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    flex-wrap: wrap;
}

.documentation-search {
    position: relative;
    width: 300px;
}

.documentation-search i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.documentation-search input {
    width: 100%;
    height: 38px;
    border: 1px solid #d9e0e7;
    border-radius: 10px;
    padding: 0 12px 0 38px;
    outline: none;
    font-size: 13px;
}

.documentation-search input:focus {
    border-color: #0d9488;
}


/* =========================================================
   FILTER
========================================================= */

.documentation-filters {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.filter-btn {
    border: 1px solid #dbe2e8;
    background: white;
    color: #64748b;
    border-radius: 20px;
    padding: 7px 13px;
    font-size: 12px;
    font-weight: 600;
    transition: .2s;
}

.filter-btn:hover {
    background: #f8fafc;
}

.filter-btn.active {
    background: #e0f2fe;
    border-color: #93c5fd;
    color: #2563eb;
}


/* =========================================================
   VIEW SWITCH
========================================================= */

.view-switch {
    display: inline-flex;
    border: 1px solid #dbe2e8;
    border-radius: 10px;
    padding: 3px;
    background: white;
}

.view-switch button {
    width: 36px;
    height: 32px;
    border: none;
    border-radius: 7px;
    background: transparent;
    color: #64748b;
}

.view-switch button.active {
    background: #e0f2fe;
    color: #2563eb;
}


/* =========================================================
   GRID DOKUMENTASI
========================================================= */

.documentation-grid {
    display: grid;
    grid-template-columns: repeat(
        auto-fill,
        minmax(180px, 1fr)
    );
    gap: 14px;
    background: white;
    border: 1px solid #e2e8f0;
    border-top: none;
    border-radius: 0 0 15px 15px;
    padding: 16px;
}

.documentation-card {
    position: relative;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    transition: .2s;
}

.documentation-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 6px 18px rgba(15,23,42,.08);
    transform: translateY(-1px);
}

.documentation-preview {
    height: 145px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.documentation-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.documentation-video-icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #fee2e2;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
}

.documentation-menu {
    position: absolute;
    top: 7px;
    right: 7px;
    z-index: 5;
}

.documentation-menu .btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,.95);
    color: #475569;
    box-shadow: 0 2px 7px rgba(0,0,0,.12);
}

.documentation-menu .btn:hover {
    background: white;
}

.documentation-info {
    padding: 10px 11px 12px;
}

.documentation-name {
    font-size: 12px;
    font-weight: 600;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.documentation-meta {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 4px;
}


/* =========================================================
   LIST
========================================================= */

.documentation-list {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-top: none;
    border-radius: 0 0 15px 15px;
    overflow: hidden;
}

.recent-table {
    width: 100%;
    border-collapse: collapse;
}

.recent-table th {
    padding: 12px 17px;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
    font-weight: 700;
    border-bottom: 1px solid #e2e8f0;
}

.recent-table td {
    padding: 12px 17px;
    border-bottom: 1px solid #edf2f7;
    font-size: 13px;
    color: #334155;
    vertical-align: middle;
}

.recent-table tr:last-child td {
    border-bottom: none;
}

.recent-table tr:hover {
    background: #f8fafc;
}

.file-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.file-icon.photo {
    background: #dcfce7;
    color: #16a34a;
}

.file-icon.video {
    background: #fee2e2;
    color: #ef4444;
}

.file-name {
    font-weight: 600;
    color: #1e293b;
}

.file-folder {
    font-size: 11px;
    color: #64748b;
    margin-top: 2px;
}

.file-type {
    display: inline-flex;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.file-type.photo {
    background: #dcfce7;
    color: #15803d;
}

.file-type.video {
    background: #fee2e2;
    color: #b91c1c;
}

.file-action .btn {
    border: none;
    background: transparent;
    color: #64748b;
    border-radius: 50%;
    width: 34px;
    height: 34px;
}

.file-action .btn:hover {
    background: #f1f5f9;
    color: #0f172a;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-documentation {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-top: none;
    border-radius: 0 0 15px 15px;
    padding: 55px 20px;
    text-align: center;
    color: #64748b;
}

.empty-documentation i {
    font-size: 45px;
    color: #cbd5e1;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .drive-section-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .btn-tambah-kegiatan {
        width: 100%;
        justify-content: center;
    }

    .folder-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .documentation-search {
        width: 100%;
    }

    .documentation-toolbar {
        align-items: stretch;
    }

    .documentation-filters {
        width: 100%;
    }

    .documentation-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .recent-table th:nth-child(2),
    .recent-table td:nth-child(2),
    .recent-table th:nth-child(4),
    .recent-table td:nth-child(4) {
        display: none;
    }
}

@media (max-width: 480px) {

    .folder-grid {
        grid-template-columns: 1fr;
    }

    .documentation-grid {
        grid-template-columns: 1fr;
    }
}

</style>


<div class="drive-dashboard">


    {{-- =====================================================
         SEARCH UTAMA
    ====================================================== --}}

    <div class="drive-search">

        <i class="bi bi-search"></i>

        <input
            type="text"
            id="dashboardSearch"
            placeholder="Cari kegiatan, folder atau file..."
            autocomplete="off"
        >

    </div>


    {{-- =====================================================
         FOLDER KEGIATAN
    ====================================================== --}}

    <div class="drive-section-header">

        <div>

            <h5 class="drive-section-title">
                Folder Kegiatan
            </h5>

            <div class="drive-section-subtitle">
                Dokumentasi dikelompokkan berdasarkan kegiatan
            </div>

        </div>


        <a
            href="{{ route('petugas.kegiatan.create') }}"
            class="btn-tambah-kegiatan"
        >

            <i class="bi bi-folder-plus"></i>

            Tambah Kegiatan

        </a>

    </div>


    {{-- =====================================================
         DAFTAR FOLDER
    ====================================================== --}}

    @if($folders->count())

        <div
            class="folder-grid"
            id="folderContainer"
        >

            @foreach($folders as $folder)

                <div
                    class="folder-card searchable-folder"
                    data-search="{{ strtolower(
                        ($folder->nama_folder ?? '') . ' ' .
                        ($folder->kegiatan->nama_kegiatan ?? '')
                    ) }}"
                >

                    <div class="folder-top">


                        {{-- ICON FOLDER --}}
                        <a
                            href="{{ route(
                                'petugas.folder.show',
                                $folder->id
                            ) }}"
                            class="text-decoration-none"
                        >

                            <div class="folder-icon">

                                <i class="bi bi-folder-fill"></i>

                            </div>

                        </a>


                        {{-- MENU --}}
                        <div class="dropdown folder-menu">

                            <button
                                class="btn"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>


                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">


                                {{-- BUKA --}}
                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route(
                                            'petugas.folder.show',
                                            $folder->id
                                        ) }}"
                                    >

                                        <i class="bi bi-folder2-open me-2"></i>

                                        Buka

                                    </a>

                                </li>


                                {{-- RENAME --}}
                                <li>

                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#renameFolder{{ $folder->id }}"
                                    >

                                        <i class="bi bi-pencil me-2"></i>

                                        Ganti nama

                                    </button>

                                </li>


                                {{-- SHARE --}}
                                <li>

                                    <button
                                        type="button"
                                        class="dropdown-item"
                                    >

                                        <i class="bi bi-people me-2"></i>

                                        Bagikan ke Pimpinan

                                    </button>

                                </li>


                                <li>

                                    <hr class="dropdown-divider">

                                </li>


                                {{-- HAPUS --}}
                                <li>

                                    <form
                                        action="{{ route(
                                            'petugas.folder.destroy',
                                            $folder->id
                                        ) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="dropdown-item text-danger"
                                            onclick="return confirm(
                                                'Hapus folder ini beserta seluruh dokumentasinya?'
                                            )"
                                        >

                                            <i class="bi bi-trash me-2"></i>

                                            Hapus

                                        </button>

                                    </form>

                                </li>


                            </ul>

                        </div>

                    </div>


                    {{-- NAMA FOLDER --}}
                    <a
                        href="{{ route(
                            'petugas.folder.show',
                            $folder->id
                        ) }}"
                        class="folder-name"
                    >

                        {{ $folder->nama_folder }}

                    </a>


                    {{-- NAMA KEGIATAN --}}
                    <div class="folder-event">

                        {{ $folder->kegiatan->nama_kegiatan ?? '-' }}

                    </div>


                    {{-- META --}}
                    <div class="folder-meta">

                        <span>

                            <i class="bi bi-clock me-1"></i>

                            {{ $folder->created_at
                                ? $folder->created_at->diffForHumans()
                                : '-'
                            }}

                        </span>

                        <span>

                            <i class="bi bi-file-earmark-image me-1"></i>

                            {{ $folder->dokumentasi->count() }}

                            File

                        </span>

                    </div>

                </div>


                {{-- =================================================
                     MODAL RENAME FOLDER
                ================================================== --}}

                <div
                    class="modal fade"
                    id="renameFolder{{ $folder->id }}"
                    tabindex="-1"
                    aria-hidden="true"
                >

                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content border-0 shadow">

                            <form
                                action="{{ route(
                                    'petugas.folder.update',
                                    $folder->id
                                ) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PUT')


                                <div class="modal-header">

                                    <h5 class="modal-title">
                                        Ganti Nama Folder
                                    </h5>

                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>

                                </div>


                                <div class="modal-body">

                                    <label class="form-label">
                                        Nama Folder
                                    </label>

                                    <input
                                        type="text"
                                        name="nama_folder"
                                        class="form-control"
                                        value="{{ $folder->nama_folder }}"
                                        required
                                    >

                                </div>


                                <div class="modal-footer">

                                    <button
                                        type="button"
                                        class="btn btn-light"
                                        data-bs-dismiss="modal"
                                    >
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Simpan
                                    </button>

                                </div>


                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-folder">

            <i class="bi bi-folder2-open"></i>

            <h6 class="mt-3">
                Belum ada folder kegiatan
            </h6>

            <p class="small mb-3">
                Buat kegiatan terlebih dahulu untuk
                menyimpan dokumentasi.
            </p>

            <a
                href="{{ route('petugas.kegiatan.create') }}"
                class="btn btn-primary rounded-pill px-4"
            >

                <i class="bi bi-folder-plus me-1"></i>

                Tambah Kegiatan

            </a>

        </div>

    @endif


    {{-- =====================================================
         DOKUMENTASI TERBARU
    ====================================================== --}}

    <div class="drive-section-header mt-4">

        <div>

            <h5 class="drive-section-title">
                Dokumentasi Terbaru
            </h5>

            <div class="drive-section-subtitle">
                Foto dan video terbaru dari seluruh kegiatan
            </div>

        </div>

    </div>


    {{-- =====================================================
         TOOLBAR
    ====================================================== --}}

    <div class="documentation-toolbar">


        {{-- SEARCH --}}
        <div class="documentation-search">

            <i class="bi bi-search"></i>

            <input
                type="text"
                id="documentationSearch"
                placeholder="Cari foto atau video..."
                autocomplete="off"
            >

        </div>


        {{-- FILTER --}}
        <div class="documentation-filters">

            <button
                type="button"
                class="filter-btn active"
                data-filter="all"
            >
                Semua
            </button>

            <button
                type="button"
                class="filter-btn"
                data-filter="foto"
            >

                <i class="bi bi-image me-1"></i>

                Foto

            </button>

            <button
                type="button"
                class="filter-btn"
                data-filter="video"
            >

                <i class="bi bi-camera-video me-1"></i>

                Video

            </button>

        </div>


        {{-- GRID / LIST --}}
        <div class="view-switch">

            <button
                type="button"
                id="gridViewBtn"
                class="active"
                title="Tampilan Grid"
            >

                <i class="bi bi-grid-3x3-gap-fill"></i>

            </button>

            <button
                type="button"
                id="listViewBtn"
                title="Tampilan List"
            >

                <i class="bi bi-list"></i>

            </button>

        </div>

    </div>


    {{-- =====================================================
         GRID VIEW
    ====================================================== --}}

   <div
    class="documentation-grid"
    id="documentationGrid"
>

    @forelse(($recentFiles ?? collect()) as $file)

        <div
            class="documentation-card documentation-item"
            data-type="{{ $file->tipe_file }}"
            data-search="{{ strtolower(
                ($file->nama_file ?? '') . ' ' .
                ($file->folder->nama_folder ?? '') . ' ' .
                ($file->folder->kegiatan->nama_kegiatan ?? '')
            ) }}"
        >

            {{-- isi card kamu --}}

        </div>

    @empty

        <div
            class="empty-documentation"
            style="grid-column: 1 / -1;"
        >
            <i class="bi bi-images"></i>

            <div class="mt-3">
                Belum ada dokumentasi.
            </div>

            <small>
                Dokumentasi yang baru diupload akan muncul di sini.
            </small>
        </div>

    @endforelse

</div>


                {{-- PREVIEW --}}
                <div class="documentation-preview">

                    @if($file->tipe_file === 'foto')

                        <a
                            href="{{ route(
                                'petugas.folder.preview',
                                $file->id
                            ) }}"
                            target="_blank"
                            class="w-100 h-100"
                        >

                            <img
                                src="{{ asset(
                                    'storage/' . $file->path_file
                                ) }}"
                                alt="{{ $file->nama_file }}"
                                loading="lazy"
                            >

                        </a>

                    @else

                        <a
                            href="{{ route(
                                'petugas.folder.preview',
                                $file->id
                            ) }}"
                            target="_blank"
                            class="text-decoration-none"
                        >

                            <div class="documentation-video-icon">

                                <i class="bi bi-play-fill"></i>

                            </div>

                        </a>

                    @endif


                    {{-- MENU --}}
                    <div class="dropdown documentation-menu">

                        <button
                            class="btn"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >

                            <i class="bi bi-three-dots-vertical"></i>

                        </button>


                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">


                            {{-- LIHAT --}}
                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route(
                                        'petugas.folder.preview',
                                        $file->id
                                    ) }}"
                                    target="_blank"
                                >

                                    <i class="bi bi-eye me-2"></i>

                                    Lihat

                                </a>

                            </li>


                            {{-- DOWNLOAD --}}
                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route(
                                        'petugas.folder.download',
                                        $file->id
                                    ) }}"
                                >

                                    <i class="bi bi-download me-2"></i>

                                    Download

                                </a>

                            </li>


                            {{-- RENAME --}}
                            <li>

                                <button
                                    type="button"
                                    class="dropdown-item"
                                    data-bs-toggle="modal"
                                    data-bs-target="#renameFile{{ $file->id }}"
                                >

                                    <i class="bi bi-pencil me-2"></i>

                                    Ganti nama

                                </button>

                            </li>


                            {{-- SHARE --}}
                            <li>

                                <button
                                    type="button"
                                    class="dropdown-item"
                                >

                                    <i class="bi bi-people me-2"></i>

                                    Bagikan ke Pimpinan

                                </button>

                            </li>


                            <li>

                                <hr class="dropdown-divider">

                            </li>


                            {{-- DELETE --}}
                            <li>

                                <form
                                    action="{{ route(
                                        'petugas.folder.destroyFile',
                                        $file->id
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="dropdown-item text-danger"
                                        onclick="return confirm(
                                            'Hapus file ini?'
                                        )"
                                    >

                                        <i class="bi bi-trash me-2"></i>

                                        Hapus

                                    </button>

                                </form>

                            </li>


                        </ul>

                    </div>

                </div>


                {{-- INFO --}}
                <div class="documentation-info">

                    <div
                        class="documentation-name"
                        title="{{ $file->nama_file }}"
                    >

                        {{ $file->nama_file }}

                    </div>

                    <div class="documentation-meta">

                        {{ number_format(
                            ($file->ukuran_file ?? 0) / 1024,
                            2
                        ) }}

                        KB

                        •

                        {{ ucfirst(
                            $file->tipe_file ?? '-'
                        ) }}

                    </div>

                </div>

            </div>


            {{-- =================================================
                 MODAL RENAME FILE
            ================================================== --}}

            <div
                class="modal fade"
                id="renameFile{{ $file->id }}"
                tabindex="-1"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content border-0 shadow">

                        <form
                            action="{{ route(
                                'petugas.folder.renameFile',
                                $file->id
                            ) }}"
                            method="POST"
                        >

                            @csrf
                            @method('PUT')


                            <div class="modal-header">

                                <h5 class="modal-title">
                                    Ganti Nama File
                                </h5>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                ></button>

                            </div>


                            <div class="modal-body">

                                <label class="form-label">
                                    Nama File
                                </label>

                                <input
                                    type="text"
                                    name="nama_file"
                                    class="form-control"
                                    value="{{ $file->nama_file }}"
                                    required
                                >

                            </div>


                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-light"
                                    data-bs-dismiss="modal"
                                >
                                    Batal
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Simpan
                                </button>

                            </div>


                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div
                class="empty-documentation"
                style="grid-column: 1 / -1;"
            >

                <i class="bi bi-images"></i>

                <div class="mt-3">
                    Belum ada dokumentasi.
                </div>

                <small>
                    Dokumentasi yang baru diupload akan muncul di sini.
                </small>

            </div>

        @endforelse

    </div>


    {{-- =====================================================
         LIST VIEW
    ====================================================== --}}

    <div
        class="documentation-list d-none"
        id="documentationList"
    >

        <div class="table-responsive">

            <table class="recent-table">

                <thead>

                    <tr>

                        <th>
                            Nama File
                        </th>

                        <th>
                            Kegiatan
                        </th>

                        <th>
                            Tipe
                        </th>

                        <th>
                            Ukuran
                        </th>

                        <th>
                            Diunggah
                        </th>

                        <th width="60"></th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($recentFiles as $file)

                        <tr
                            class="documentation-list-item"
                            data-type="{{ $file->tipe_file }}"
                            data-search="{{ strtolower(
                                ($file->nama_file ?? '') . ' ' .
                                ($file->folder->nama_folder ?? '') . ' ' .
                                ($file->folder->kegiatan->nama_kegiatan ?? '')
                            ) }}"
                        >


                            {{-- FILE --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div
                                        class="file-icon {{
                                            $file->tipe_file === 'foto'
                                                ? 'photo'
                                                : 'video'
                                        }}"
                                    >

                                        @if($file->tipe_file === 'foto')

                                            <i class="bi bi-image"></i>

                                        @else

                                            <i class="bi bi-camera-video"></i>

                                        @endif

                                    </div>


                                    <div>

                                        <div class="file-name">

                                            {{ $file->nama_file }}

                                        </div>


                                        <div class="file-folder">

                                            <i class="bi bi-folder me-1"></i>

                                            {{ $file->folder->nama_folder ?? '-' }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- KEGIATAN --}}
                            <td>

                                {{ $file->folder->kegiatan->nama_kegiatan ?? '-' }}

                            </td>


                            {{-- TIPE --}}
                            <td>

                                <span
                                    class="file-type {{
                                        $file->tipe_file === 'foto'
                                            ? 'photo'
                                            : 'video'
                                    }}"
                                >

                                    {{ ucfirst(
                                        $file->tipe_file ?? '-'
                                    ) }}

                                </span>

                            </td>


                            {{-- UKURAN --}}
                            <td>

                                {{ number_format(
                                    ($file->ukuran_file ?? 0) / 1024,
                                    2
                                ) }}

                                KB

                            </td>


                            {{-- TANGGAL --}}
                            <td>

                                @if($file->uploaded_at)

                                    {{ \Carbon\Carbon::parse(
                                        $file->uploaded_at
                                    )->format('d M Y H:i') }}

                                @elseif($file->created_at)

                                    {{ $file->created_at->format(
                                        'd M Y H:i'
                                    ) }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- MENU --}}
                            <td class="text-end">

                                <div class="dropdown file-action">

                                    <button
                                        class="btn"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >

                                        <i class="bi bi-three-dots-vertical"></i>

                                    </button>


                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">


                                        {{-- LIHAT --}}
                                        <li>

                                            <a
                                                class="dropdown-item"
                                                href="{{ route(
                                                    'petugas.folder.preview',
                                                    $file->id
                                                ) }}"
                                                target="_blank"
                                            >

                                                <i class="bi bi-eye me-2"></i>

                                                Lihat

                                            </a>

                                        </li>


                                        {{-- DOWNLOAD --}}
                                        <li>

                                            <a
                                                class="dropdown-item"
                                                href="{{ route(
                                                    'petugas.folder.download',
                                                    $file->id
                                                ) }}"
                                            >

                                                <i class="bi bi-download me-2"></i>

                                                Download

                                            </a>

                                        </li>


                                        {{-- RENAME --}}
                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item"
                                                data-bs-toggle="modal"
                                                data-bs-target="#renameFile{{ $file->id }}"
                                            >

                                                <i class="bi bi-pencil me-2"></i>

                                                Ganti nama

                                            </button>

                                        </li>


                                        {{-- SHARE --}}
                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item"
                                            >

                                                <i class="bi bi-people me-2"></i>

                                                Bagikan ke Pimpinan

                                            </button>

                                        </li>


                                        <li>

                                            <hr class="dropdown-divider">

                                        </li>


                                        {{-- DELETE --}}
                                        <li>

                                            <form
                                                action="{{ route(
                                                    'petugas.folder.destroyFile',
                                                    $file->id
                                                ) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="dropdown-item text-danger"
                                                    onclick="return confirm(
                                                        'Hapus file ini?'
                                                    )"
                                                >

                                                    <i class="bi bi-trash me-2"></i>

                                                    Hapus

                                                </button>

                                            </form>

                                        </li>


                                    </ul>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-inbox"
                                    style="
                                        font-size:35px;
                                        color:#94a3b8;
                                    "
                                ></i>

                                <div class="mt-2 text-muted">
                                    Belum ada dokumentasi.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const dashboardSearch =
        document.getElementById('dashboardSearch');

    const documentationSearch =
        document.getElementById('documentationSearch');

    const grid =
        document.getElementById('documentationGrid');

    const list =
        document.getElementById('documentationList');

    const gridBtn =
        document.getElementById('gridViewBtn');

    const listBtn =
        document.getElementById('listViewBtn');

    const filterButtons =
        document.querySelectorAll('.filter-btn');

    let currentFilter = 'all';


    /*
    |--------------------------------------------------------------------------
    | SEARCH DASHBOARD
    |--------------------------------------------------------------------------
    */

    if (dashboardSearch) {

        dashboardSearch.addEventListener(
            'input',
            function () {

                const keyword =
                    this.value
                        .toLowerCase()
                        .trim();


                document
                    .querySelectorAll(
                        '.searchable-folder'
                    )
                    .forEach(function (item) {

                        const text =
                            item.dataset.search || '';

                        item.style.display =
                            text.includes(keyword)
                                ? ''
                                : 'none';

                    });


                document
                    .querySelectorAll(
                        '.documentation-item, .documentation-list-item'
                    )
                    .forEach(function (item) {

                        const text =
                            item.dataset.search || '';

                        item.style.display =
                            text.includes(keyword)
                                ? ''
                                : 'none';

                    });

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER DOKUMENTASI
    |--------------------------------------------------------------------------
    */

    function applyDocumentationFilter() {

        const keyword =
            documentationSearch
                ? documentationSearch.value
                    .toLowerCase()
                    .trim()
                : '';


        document
            .querySelectorAll(
                '.documentation-item'
            )
            .forEach(function (item) {

                const type =
                    item.dataset.type || '';

                const searchText =
                    item.dataset.search || '';

                const typeMatch =
                    currentFilter === 'all' ||
                    type === currentFilter;

                const searchMatch =
                    searchText.includes(keyword);

                item.style.display =
                    typeMatch && searchMatch
                        ? ''
                        : 'none';

            });


        document
            .querySelectorAll(
                '.documentation-list-item'
            )
            .forEach(function (item) {

                const type =
                    item.dataset.type || '';

                const searchText =
                    item.dataset.search || '';

                const typeMatch =
                    currentFilter === 'all' ||
                    type === currentFilter;

                const searchMatch =
                    searchText.includes(keyword);

                item.style.display =
                    typeMatch && searchMatch
                        ? ''
                        : 'none';

            });

    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH DOKUMENTASI
    |--------------------------------------------------------------------------
    */

    if (documentationSearch) {

        documentationSearch.addEventListener(
            'input',
            applyDocumentationFilter
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER FOTO / VIDEO
    |--------------------------------------------------------------------------
    */

    filterButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                filterButtons.forEach(
                    function (btn) {

                        btn.classList.remove(
                            'active'
                        );

                    }
                );


                this.classList.add('active');


                currentFilter =
                    this.dataset.filter || 'all';


                applyDocumentationFilter();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | GRID VIEW
    |--------------------------------------------------------------------------
    */

    if (gridBtn) {

        gridBtn.addEventListener(
            'click',
            function () {

                grid.classList.remove(
                    'd-none'
                );

                list.classList.add(
                    'd-none'
                );

                gridBtn.classList.add(
                    'active'
                );

                listBtn.classList.remove(
                    'active'
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | LIST VIEW
    |--------------------------------------------------------------------------
    */

    if (listBtn) {

        listBtn.addEventListener(
            'click',
            function () {

                grid.classList.add(
                    'd-none'
                );

                list.classList.remove(
                    'd-none'
                );

                listBtn.classList.add(
                    'active'
                );

                gridBtn.classList.remove(
                    'active'
                );

            }
        );

    }

});

</script>

@endsection