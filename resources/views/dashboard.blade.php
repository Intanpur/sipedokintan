@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="mb-4">
    <div style="background:#eef2ff;border-radius:12px;padding:18px 22px;border:1px solid #c7d2fe">
        <div style="font-weight:600;color:#3730a3;font-size:15px">
            Selamat Datang, {{ Auth::user()->name }}!
        </div>
        <div style="color:#6366f1;font-size:13px;margin-top:4px">
            Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>.
            Kelola sistem dokumentasi kegiatan dengan mudah.
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eef2ff;color:#4f46e5">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalKegiatan }}</div>
                <div class="stat-label">Total Kegiatan Liputan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;color:#16a34a">
                <i class="bi bi-cloud-upload"></i>
            </div>
            <div>
                <div class="stat-value">{{ $dokumentasiUnggah }}</div>
                <div class="stat-label">Dokumentasi Unggah</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed;color:#ea580c">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div>
                <div class="stat-value">{{ $progres }}%</div>
                <div class="stat-label">Progress Dokumentasi</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Dokumentasi Terbaru --}}
    <div class="col-md-7">
        <div class="card-box">
            <div class="card-box-header">
                <span>Dokumentasi Terbaru</span>
                <a href="#" style="font-size:13px;color:#4f46e5;text-decoration:none">Lihat Semua</a>
            </div>
            @forelse($dokumentasiTerbaru as $dok)
            <div class="notif-item">
                <div style="width:38px;height:38px;border-radius:10px;
                            background:{{ $dok->tipe_file === 'video' ? '#eef2ff' : '#f0fdf4' }};
                            display:flex;align-items:center;justify-content:center;
                            color:{{ $dok->tipe_file === 'video' ? '#4f46e5' : '#16a34a' }};
                            font-size:18px;flex-shrink:0">
                    <i class="bi bi-{{ $dok->tipe_file === 'video' ? 'camera-video' : 'image' }}"></i>
                </div>
                <div style="flex:1">
                    <div style="font-size:14px;font-weight:500;color:#1e293b">{{ $dok->nama_file }}</div>
                    <div style="font-size:12px;color:#94a3b8">
                        {{ $dok->folder->kegiatan->nama_kegiatan ?? '-' }} •
                        {{ $dok->uploaded_at ? \Carbon\Carbon::parse($dok->uploaded_at)->diffForHumans() : '-' }}
                    </div>
                </div>
                <span style="font-size:11px;padding:3px 10px;border-radius:20px;
                             background:{{ $dok->status_progres === 'selesai' ? '#f0fdf4' : '#fef9c3' }};
                             color:{{ $dok->status_progres === 'selesai' ? '#16a34a' : '#ca8a04' }}">
                    {{ ucfirst($dok->status_progres) }}
                </span>
            </div>
            @empty
            <div style="padding:30px;text-align:center;color:#94a3b8;font-size:14px">
                <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px"></i>
                Belum ada dokumentasi
            </div>
            @endforelse
        </div>
    </div>

    {{-- Notifikasi --}}
    <div class="col-md-5">
        <div class="card-box">
            <div class="card-box-header">
                <span>Notifikasi & Pengingat</span>
            </div>
            <div class="notif-item">
                <div class="notif-dot"></div>
                <div>
                    <div style="font-size:14px;color:#1e293b">Sistem siap digunakan</div>
                    <div style="font-size:12px;color:#94a3b8">Selamat datang di SipeDok</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection