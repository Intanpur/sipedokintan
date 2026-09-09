@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Pengawasan Aktivitas Pengguna')

@push('styles')
    <!-- Panggil CSS Responsive Admin Global -->
    <link rel="stylesheet" href="{{ asset('css/responsive-admin.css') }}">
@endpush

@section('content')
<style>
    /* Membatasi ukuran ikon SVG pada pagination Laravel */
    .pagination svg {
        width: 1rem !important;
        height: 1rem !important;
    }
    .flex.justify-between.flex-1 {
        display: none; /* Menyembunyikan tampilan tombol bawaan tailwind jika mengganggu */
    }
</style>

<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>Riwayat Aktivitas Sistem</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Nama User</th>
                            <th>Aktivitas</th>
                            <th>File</th>
                            <th>Keterangan</th>
                            <th>IP & Device</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td><strong>{{ $log->user->name }}</strong> ({{ $log->user->role }})</td>
                                <td><span class="badge bg-primary text-uppercase">{{ $log->activity }}</span></td>
                                <td>
                                    @if($log->dokumentasi)
                                        {{ $log->dokumentasi->nama_file }}
                                    @elseif(isset($log->folder) && $log->folder)
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-folder me-1"></i>{{ $log->folder->nama_folder }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $log->description ?? '-' }}</td>
                                <td><small class="text-muted">{{ $log->ip }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada aktivitas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $logs->links() }}</div>
        </div>
    </div>
</div>
@endsection