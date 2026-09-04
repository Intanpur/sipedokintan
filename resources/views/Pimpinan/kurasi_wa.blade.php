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
                                    <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank" class="btn btn-sm btn-outline-info mb-3">
                                        👁 Preview File
                                    </a>
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input me-2" type="checkbox" name="selected_files[]" value="{{ $file->id }}" id="file_{{ $file->id }}" {{ $file->status == 'dipilih' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="file_{{ $file->id }}">
                                            Pilih untuk Edit
                                        </label>
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
</body>
</html>