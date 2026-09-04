@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- =========================================================
        ALERT
    ========================================================== --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif


    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif


    {{-- =========================================================
        VALIDATION ERROR
    ========================================================== --}}

    @if($errors->any())
        <div class="alert alert-danger">

            <strong>
                Terjadi kesalahan:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach

            </ul>

        </div>
    @endif


    {{-- =========================================================
        HEADER FOLDER
    ========================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <div class="mb-2">

                        <a
                            href="{{ route('petugas.folder.show', ['folder' => $folder->id]) }}"
                            class="text-decoration-none"
                        >
                            <i class="bi bi-arrow-left"></i>
                            Kembali ke Kegiatan
                        </a>

                    </div>

                    <h3 class="fw-bold mb-1">

                        <i class="bi bi-folder-fill text-warning me-2"></i>

                        {{ $folder->nama_folder }}

                    </h3>

                    @if($folder->kegiatan)

                        <div class="text-muted">

                            <i class="bi bi-calendar-event me-1"></i>

                            {{ $folder->kegiatan->nama_kegiatan ?? '-' }}

                        </div>

                    @endif

                    @if($folder->deskripsi)

                        <p class="text-muted mt-2 mb-0">

                            {{ $folder->deskripsi }}

                        </p>

                    @endif

                </div>


                {{-- =================================================
                    UPLOAD FORM
                ================================================== --}}

                <div>

                    <form
                        id="uploadForm"
                        action="{{ route('petugas.folder.upload', ['folder' => $folder->id]) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        <input
                            type="file"
                            name="files[]"
                            id="fileInput"
                            multiple
                            accept="image/*,video/*"
                            hidden
                        >

                        <button
                            type="button"
                            id="uploadButton"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-cloud-arrow-up me-1"></i>

                            Upload Dokumentasi

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        TOTAL
    ========================================================== --}}

    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-primary me-3">

                            <i class="bi bi-images"></i>

                        </div>

                        <div>

                            <div class="text-muted">
                                Foto
                            </div>

                            <h4 class="mb-0 fw-bold">
                                {{ $folder->total_foto ?? 0 }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-danger me-3">

                            <i class="bi bi-camera-video"></i>

                        </div>

                        <div>

                            <div class="text-muted">
                                Video
                            </div>

                            <h4 class="mb-0 fw-bold">
                                {{ $folder->total_video ?? 0 }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="fs-2 text-success me-3">

                            <i class="bi bi-file-earmark"></i>

                        </div>

                        <div>

                            <div class="text-muted">
                                Total Berkas
                            </div>

                            <h4 class="mb-0 fw-bold">
                                {{ $folder->dokumentasi->count() }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        DAFTAR DOKUMENTASI
    ========================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-grid-3x3-gap me-2"></i>

                    Dokumentasi

                </h5>

                <span class="badge bg-primary">

                    {{ $folder->dokumentasi->count() }} Berkas

                </span>

            </div>

        </div>


        <div class="card-body">


            {{-- =====================================================
                PENTING:
                Dokumentasi hanya diambil dari folder yang sedang
                dibuka.
            ====================================================== --}}

            @forelse($folder->dokumentasi as $doc)

                @php

                    $tipe = strtolower(
                        $doc->tipe_file ?? ''
                    );

                    $isFoto = in_array(
                        $tipe,
                        [
                            'foto',
                            'image',
                            'jpg',
                            'jpeg',
                            'png',
                            'webp',
                            'gif'
                        ]
                    );

                    $isVideo = $tipe === 'video';

                @endphp


                <div class="card mb-3 border">

                    <div class="card-body">

                        <div class="row align-items-center">


                            {{-- =================================================
                                THUMBNAIL
                            ================================================== --}}

                            <div class="col-md-2">

                                <div
                                    class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="height:120px; overflow:hidden;"
                                >

                                    @if($isFoto)

                                        <img
                                            src="{{ asset('storage/' . $doc->path_file) }}"
                                            alt="{{ $doc->nama_file }}"
                                            class="img-fluid"
                                            style="width:100%; height:100%; object-fit:cover;"
                                            onerror="this.style.display='none';"
                                        >

                                    @elseif($isVideo)

                                        <i class="bi bi-play-circle-fill text-primary fs-1"></i>

                                    @else

                                        <i class="bi bi-file-earmark text-secondary fs-1"></i>

                                    @endif

                                </div>

                            </div>


                            {{-- =================================================
                                INFORMASI FILE
                            ================================================== --}}

                            <div class="col-md-7">

                                <h6 class="fw-bold mb-2">

                                    {{ $doc->nama_file }}

                                </h6>


                                <div class="mb-2">

                                    @if($isFoto)

                                        <span class="badge bg-primary">
                                            <i class="bi bi-image me-1"></i>
                                            FOTO
                                        </span>

                                    @elseif($isVideo)

                                        <span class="badge bg-danger">
                                            <i class="bi bi-camera-video me-1"></i>
                                            VIDEO
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            FILE
                                        </span>

                                    @endif

                                </div>


                                <small class="text-muted d-block">

                                    <i class="bi bi-file-earmark me-1"></i>

                                    {{ $doc->nama_file }}

                                </small>


                                @if(!empty($doc->ukuran_file))

                                    <small class="text-muted d-block">

                                        <i class="bi bi-hdd me-1"></i>

                                        {{ number_format($doc->ukuran_file / 1024, 2) }}
                                        KB

                                    </small>

                                @endif


                                @if(!empty($doc->created_at))

                                    <small class="text-muted d-block">

                                        <i class="bi bi-clock me-1"></i>

                                        {{ $doc->created_at->format('d M Y H:i') }}

                                    </small>

                                @endif

                            </div>


                            {{-- =================================================
                                AKSI
                            ================================================== --}}

                            <div class="col-md-3">

                                <div class="d-flex flex-wrap gap-2 justify-content-md-end">


                                    {{-- PREVIEW --}}

                                    <a
                                        href="{{ route(
                                            'petugas.folder.preview',
                                            $doc->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- DOWNLOAD --}}

                                    <a
                                        href="{{ route(
                                            'petugas.folder.download',
                                            $doc->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-success"
                                    >

                                        <i class="bi bi-download"></i>

                                    </a>


                                    {{-- RENAME --}}

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-warning"
                                        onclick="renameFile(
                                            {{ $doc->id }},
                                            @js($doc->nama_file)
                                        )"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </button>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'petugas.folder.destroyFile',
                                            $doc->id
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus file ini?'
                                        )"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            @empty

                <div class="text-center py-5">

                    <div class="display-1 text-muted">

                        <i class="bi bi-folder2-open"></i>

                    </div>

                    <h5 class="mt-3">

                        Belum ada dokumentasi

                    </h5>

                    <p class="text-muted">

                        Silakan upload foto atau video dokumentasi.

                    </p>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="document.getElementById('fileInput').click()"
                    >

                        <i class="bi bi-cloud-arrow-up me-1"></i>

                        Upload Dokumentasi

                    </button>

                </div>

            @endforelse

        </div>

    </div>

</div>


{{-- =========================================================
    FORM RENAME
========================================================== --}}

<form
    id="renameForm"
    action=""
    method="POST"
    style="display:none;"
>
    @csrf

    @method('PUT')

    <input
        type="text"
        name="nama_file"
        id="renameInput"
    >

</form>


{{-- =========================================================
    JAVASCRIPT
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const fileInput = document.getElementById('fileInput');

    const uploadButton = document.getElementById('uploadButton');

    const uploadForm = document.getElementById('uploadForm');


    /*
    |--------------------------------------------------------------------------
    | TOMBOL UPLOAD
    |--------------------------------------------------------------------------
    */

    if (uploadButton && fileInput) {

        uploadButton.addEventListener(
            'click',
            function () {

                fileInput.click();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILE DIPILIH
    |--------------------------------------------------------------------------
    */

    if (fileInput && uploadForm) {

        fileInput.addEventListener(
            'change',
            function () {

                if (this.files.length === 0) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | KONFIRMASI
                |--------------------------------------------------------------------------
                */

                const jumlah = this.files.length;

                const konfirmasi = confirm(
                    'Upload ' +
                    jumlah +
                    ' file dokumentasi?'
                );


                if (!konfirmasi) {

                    this.value = '';

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | SUBMIT FORM
                |--------------------------------------------------------------------------
                */

                uploadForm.submit();

            }
        );

    }

});


/*
|--------------------------------------------------------------------------
| RENAME FILE
|--------------------------------------------------------------------------
*/

function renameFile(id, oldName)
{
    const newName = prompt(
        'Masukkan nama file baru:',
        oldName
    );


    if (
        newName === null ||
        newName.trim() === ''
    ) {
        return;
    }


    const form = document.getElementById(
        'renameForm'
    );


    const input = document.getElementById(
        'renameInput'
    );


    input.value = newName;


    form.action =
        "{{ url('/petugas/folder/file') }}/"
        + id
        + "/rename";


    form.submit();
}

</script>

@endsection