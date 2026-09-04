@extends('layouts.app')

@section('title', 'Arsip Dokumentasi')
@section('page-title', 'Arsip Dokumentasi')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <strong>Arsip Dokumentasi Kegiatan</strong>

        <a href="{{ route('petugas.kegiatan') }}"
           class="btn btn-secondary btn-sm">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>

    <div class="card-body">

        <form method="GET" class="row g-2 mb-4">

            <div class="col-md-5">

                <input type="text"
                       name="cari"
                       class="form-control"
                       placeholder="Cari Kegiatan..."
                       value="{{ request('cari') }}">

            </div>

            <div class="col-md-3">

                <select name="bulan" class="form-select">

                    <option value="">Semua Bulan</option>

                    @for($i = 1; $i <= 12; $i++)

                        <option value="{{ $i }}"
                            {{ request('bulan') == $i ? 'selected' : '' }}>

                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}

                        </option>

                    @endfor

                </select>

            </div>

            <div class="col-md-2">

                <select name="tahun" class="form-select">

                    <option value="">Semua Tahun</option>

                    @for($i = date('Y'); $i >= 2024; $i--)

                        <option value="{{ $i }}"
                            {{ request('tahun') == $i ? 'selected' : '' }}>

                            {{ $i }}

                        </option>

                    @endfor

                </select>

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary w-100">
                    Filter
                </button>

            </div>

        </form>

        <div class="row">

            @forelse($kegiatan as $item)

            <div class="col-md-4 mb-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body text-center">

                        <i class="bi bi-archive-fill text-primary"
                           style="font-size:65px;"></i>

                        <h6 class="mt-3 fw-bold">
                            {{ $item->nama_kegiatan }}
                        </h6>

                        <div class="text-muted small">

                            {{ $item->tanggal_kegiatan }}

                        </div>

                        <div class="mt-3">

                            <a href="{{ route('petugas.arsip.show', $item->id) }}"
                              class="btn btn-info btn-sm">

                                <i class="bi bi-eye"></i>
                                Lihat Arsip

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            @empty

            <div class="col-12">

                <div class="alert alert-warning text-center">

                    Belum ada arsip dokumentasi kegiatan.

                </div>

            </div>

            @endforelse

        </div>

    </div>

</div>

@endsection