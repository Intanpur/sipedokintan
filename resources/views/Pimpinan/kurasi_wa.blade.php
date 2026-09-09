<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurasi Dokumentasi Pimpinan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Kurasi Dokumentasi: {{ $disposisi->folder->nama_folder }}</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('pimpinan.kurasi.submit', $disposisi->token) }}" method="POST">
                @csrf
                <p class="text-muted">Pilih file foto/video mentah yang ingin diteruskan ke Tim Editor:</p>
                
                <div class="row g-3 mb-4">
                    @foreach($files as $file)
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        📄 <strong>{{ $file->nama_file }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-center gap-2 mb-3">
                                        <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            👁 Preview File
                                        </a>
                                        <!-- Penambahan Fitur Hapus -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $file->id }}">
                                            🗑️ Hapus
                                        </button>
                                    </div>
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input me-2" type="checkbox" name="selected_files[]" value="{{ $file->id }}" id="file_{{ $file->id }}" {{ $file->status == 'dipilih' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="file_{{ $file->id }}">
                                            Pilih untuk Edit
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi Hapus (Ditaruh di dalam loop agar id unik) -->
                        <div class="modal fade" id="modalHapus{{ $file->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Berkas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        Apakah Anda yakin ingin menghapus file <strong>{{ $file->nama_file }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('pimpinan.kurasi.destroy', [$disposisi->token, $file->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label for="catatan_pimpinan" class="form-label fw-bold">Catatan / Catatan Instruksi untuk Editor:</label>
                    <textarea name="catatan_pimpinan" id="catatan_pimpinan" class="form-control" rows="3" placeholder="Contoh: Tolong potong bagian menit ke-2 dan beri watermark logo official."></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">
                    🚀 Kirim Disposisi ke Editor
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Script Bootstrap ditambahkan di bawah agar Modal Hapus dapat berfungsi -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>