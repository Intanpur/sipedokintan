@extends('layouts.app')

@section('title', $file->nama_file)

@section('content')

<style>
    .preview-page {
        position: fixed;
        inset: 0;
        background: #202124;
        z-index: 9999;
        display: flex;
        flex-direction: column;
    }

    /* HEADER */
    .preview-header {
        height: 60px;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 18px;
        background: #202124;
        color: white;
    }

    .preview-file-name {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .preview-file-name i {
        font-size: 20px;
    }

    .preview-file-name span {
        font-size: 15px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 70vw;
    }

    /* CLOSE */
    .preview-close {
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 50%;
        background: transparent;
        color: white;
        font-size: 30px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .2s;
    }

    .preview-close:hover {
        background: rgba(255,255,255,.12);
        color: white;
    }

    /* CONTENT */
    .preview-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 20px;
    }

    .preview-image {
        max-width: 100%;
        max-height: calc(100vh - 100px);
        object-fit: contain;
        border-radius: 3px;
        box-shadow: 0 4px 25px rgba(0,0,0,.35);
    }

    .preview-video {
        max-width: 95%;
        max-height: calc(100vh - 100px);
        width: auto;
        height: auto;
        background: black;
        border-radius: 4px;
        box-shadow: 0 4px 25px rgba(0,0,0,.35);
    }

    .preview-error {
        color: #fff;
        text-align: center;
    }

    .preview-error i {
        font-size: 60px;
        opacity: .6;
    }

    @media (max-width: 768px) {

        .preview-header {
            height: 54px;
            min-height: 54px;
            padding: 0 10px;
        }

        .preview-file-name span {
            max-width: 70vw;
            font-size: 14px;
        }

        .preview-content {
            padding: 10px;
        }

        .preview-image,
        .preview-video {
            max-width: 100%;
            max-height: calc(100vh - 75px);
        }

        .preview-close {
            width: 38px;
            height: 38px;
        }
    }
</style>

<div class="preview-page">

    {{-- HEADER --}}
    <div class="preview-header">

        <div class="preview-file-name">

            @if($file->tipe_file === 'foto')
                <i class="bi bi-image"></i>
            @else
                <i class="bi bi-camera-video"></i>
            @endif

            <span title="{{ $file->nama_file }}">
                {{ $file->nama_file }}
            </span>

        </div>

        {{-- TOMBOL X --}}
        <a
            href="{{ route('petugas.folder.show', $file->folder_id) }}"
            class="preview-close"
            title="Tutup"
        >
            &times;
        </a>

    </div>


    {{-- PREVIEW --}}
    <div class="preview-content">

        @if($file->tipe_file === 'foto')

            <img
                src="{{ asset('storage/' . $file->path_file) }}"
                alt="{{ $file->nama_file }}"
                class="preview-image"
            >

        @elseif($file->tipe_file === 'video')

            <video
                class="preview-video"
                controls
                autoplay
                playsinline
            >
                <source
                    src="{{ asset('storage/' . $file->path_file) }}"
                    type="video/{{ pathinfo($file->nama_file, PATHINFO_EXTENSION) }}"
                >

                Browser Anda tidak mendukung pemutaran video.
            </video>

        @else

            <div class="preview-error">

                <i class="bi bi-file-earmark-x"></i>

                <h5 class="mt-3">
                    File tidak dapat ditampilkan
                </h5>

            </div>

        @endif

    </div>

</div>

@endsection