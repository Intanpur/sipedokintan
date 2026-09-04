<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kegiatan - SipeDok</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Tombol Kembali -->
        <div class="mb-6">
            <a href="{{ route('admin.kegiatan.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1">
                ← Kembali ke Daftar Kegiatan
            </a>
        </div>

        <!-- KARTU INFORMASI KEGIATAN -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8 border-t-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        Dibuat oleh: {{ $kegiatan->createdBy->name ?? 'Tidak Diketahui' }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $kegiatan->nama_kegiatan }}</h1>
                    <p class="text-gray-600 mt-2"><span class="font-semibold">Lokasi:</span> {{ $kegiatan->lokasi }}</p>
                </div>
                <div class="text-right">
                    <span class="px-4 py-2 rounded-full text-sm font-bold block mb-2
                        {{ $kegiatan->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        Status: {{ ucfirst($kegiatan->status) }}
                    </span>
                    <p class="text-xs text-gray-500">PJ: {{ $kegiatan->penanggung_jawab }}</p>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div>
                <h3 class="font-bold text-gray-700">Deskripsi Kegiatan:</h3>
                <p class="text-gray-600 mt-1 bg-gray-50 p-4 rounded border italic">
                    "{{ $kegiatan->deskripsi ?? 'Tidak ada deskripsi.' }}"
                </p>
            </div>
        </div>

        <!-- FOLDER DOKUMENTASI & FILE -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Folder Dokumentasi (Foto & Video)</h2>
        
        @forelse($kegiatan->folder as $folder)
            <div class="bg-white shadow rounded-lg p-6 mb-6 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-2">
                        <!-- Icon Folder -->
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-800">{{ $folder->nama_folder }}</h3>
                    </div>
                    <div class="text-sm text-gray-500">
                        Foto: <span class="font-bold text-gray-800">{{ $folder->total_foto }}</span> | 
                        Video: <span class="font-bold text-gray-800">{{ $folder->total_video }}</span>
                    </div>
                </div>

                <!-- FILE DI DALAM FOLDER -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @forelse($folder->dokumentasi as $file)
                        <div class="bg-gray-50 border rounded-lg overflow-hidden group hover:shadow-md transition">
                            <!-- Preview File Sederhana -->
                            <div class="h-32 bg-slate-200 flex items-center justify-center text-gray-400 relative">
                                @if(in_array($file->tipe_file, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $file->path_file) }}" class="w-full h-full object-cover">
                                @else
                                    <!-- Icon File Video / Lainnya -->
                                    <svg class="w-12 h-12 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path>
                                    </svg>
                                @endif
                                <span class="absolute top-2 left-2 text-[10px] bg-slate-900/80 text-white px-2 py-0.5 rounded font-semibold uppercase">
                                    {{ $file->tipe_file }}
                                </span>
                            </div>
                            <div class="p-2.5">
                                <p class="text-xs font-bold text-gray-700 truncate" title="{{ $file->nama_file }}">
                                    {{ $file->nama_file }}
                                </p>
                                <p class="text-[10px] text-gray-400 mt-0.5">
                                    {{ round($file->ukuran_file / 1024, 2) }} KB
                                </p>
                                <span class="inline-block mt-2 text-[10px] font-bold px-2 py-0.5 rounded-full
                                    {{ $file->status_progres === 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($file->status_progres ?? 'menunggu') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-4 text-center text-sm text-gray-400 italic">
                            Folder ini kosong, belum ada foto/video yang diunggah.
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-yellow-50 text-yellow-800 p-4 rounded border border-yellow-200 text-center">
                Petugas belum membuat folder dokumentasi untuk kegiatan ini.
            </div>
        @endforelse

    </div>

</body>
</html>