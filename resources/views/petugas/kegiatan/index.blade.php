@extends('layouts.app')

@section('title', 'Kegiatan Liputan - SIPEDOK')

@section('content')
<style>
    :root {
        --cyan-primary: #00b4a2;
        --cyan-dark: #007a6e;
        --cyan-light: rgba(0, 180, 162, 0.08);
        --cyan-glow: rgba(0, 180, 162, 0.25);
        --border-color: #e2e8f0;
    }

    /* Top Header Banner Hijau (Sesuai Navbar) */
    .drive-header {
        background: linear-gradient(135deg, var(--cyan-primary) 0%, var(--cyan-dark) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 24px 28px;
        color: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 180, 162, 0.25);
    }

    .drive-header .breadcrumb-item,
    .drive-header .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85) !important;
        font-weight: 500;
    }

    .drive-header .breadcrumb-item.active {
        color: #ffffff !important;
        font-weight: 700;
    }

    .drive-header h3 {
        color: #ffffff !important;
    }

    .drive-header p {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Button Tambah Kegiatan di Atas Header Hijau */
    .btn-header-white {
        background: #ffffff;
        color: var(--cyan-dark) !important;
        border: none;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
        transition: all 0.25s ease;
    }
    .btn-header-white:hover {
        background: #f0fdfa;
        color: var(--cyan-primary) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
    }

    /* Cyan Accent Button Standard */
    .btn-cyan {
        background: linear-gradient(135deg, var(--cyan-primary) 0%, var(--cyan-dark) 100%);
        color: #ffffff;
        border: none;
        font-weight: 700;
        box-shadow: 0 4px 14px var(--cyan-glow);
        transition: all 0.25s ease;
    }
    .btn-cyan:hover {
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 180, 162, 0.35);
    }

    /* Toolbar / Filter Card */
    .toolbar-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .search-input-group {
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    .search-input-group:focus-within {
        border-color: var(--cyan-primary);
        box-shadow: 0 0 10px var(--cyan-glow);
        background: #ffffff;
    }

    /* View Switcher Toggle Buttons */
    .view-toggle-btn {
        border-radius: 10px;
        padding: 6px 14px;
        color: #64748b;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .view-toggle-btn.active {
        background: #ffffff;
        color: var(--cyan-dark);
        border-color: var(--border-color);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        font-weight: 700;
    }

    /* Google Drive Style Folder Cards */
    .folder-card {
        background: #ffffff;
        border: 1.5px solid var(--border-color);
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .folder-card:hover {
        border-color: var(--cyan-primary);
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 180, 162, 0.15);
    }

    /* Animated Icon Box */
    .folder-icon-wrapper {
        width: 68px;
        height: 68px;
        background: rgba(255, 193, 7, 0.12);
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffb100;
        transition: all 0.3s ease;
    }
    .folder-card:hover .folder-icon-wrapper {
        transform: scale(1.08) rotate(-3deg);
        background: var(--cyan-light);
        color: var(--cyan-primary);
    }

    /* Dropdown Action Menu (Three Dots) */
    .dropdown-action-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        background: transparent;
        border: none;
        transition: all 0.2s;
    }
    .dropdown-action-btn:hover {
        background: rgba(0, 0, 0, 0.05);
        color: #0f172a;
    }

    /* Primary Action Open Button */
    .btn-open-folder {
        background: var(--cyan-light);
        color: var(--cyan-dark);
        border: 1px solid rgba(0, 180, 162, 0.25);
        font-weight: 700;
        border-radius: 12px;
        padding: 10px;
        transition: all 0.2s ease;
    }
    .btn-open-folder:hover {
        background: var(--cyan-primary);
        color: #ffffff;
        border-color: var(--cyan-primary);
        box-shadow: 0 4px 14px var(--cyan-glow);
    }

    /* List View Styling */
    .list-view-table {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
    }
    .list-view-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid var(--border-color);
        padding: 14px 18px;
    }
    .list-view-table td {
        padding: 14px 18px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .list-view-table tr:hover {
        background-color: var(--cyan-light);
    }
    
    /* Input Rename Inline Folder */
    .inline-folder-name {
        transition: all 0.2s ease;
        border-radius: 6px;
        padding: 3px 8px !important;
    }
    .inline-folder-name:hover {
        background-color: rgba(0, 180, 162, 0.1) !important;
        cursor: pointer;
    }
    .inline-folder-name:focus {
        background-color: #ffffff !important;
        border: 1px solid var(--cyan-primary) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 180, 162, 0.25) !important;
        cursor: text;
    }
</style>

<div class="container-fluid py-4 px-4">

    {{-- Header Section --}}
    <div class="drive-header mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none"><i class="bi bi-hdd-network me-1"></i> Drive SIPEDOK</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kegiatan Liputan</li>
                    </ol>
                </nav>
                <h3 class="fw-extrabold mb-1" style="letter-spacing: -0.02em;">Kegiatan Liputan</h3>
                <p class="mb-0 small">Kelola dan jelajahi folder kegiatan dokumentasi secara interaktif.</p>
            </div>

            <a href="{{ route('petugas.kegiatan.create') }}" class="btn btn-header-white rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2">
                <i class="bi bi-folder-plus fs-5"></i>
                <span>Tambah Kegiatan</span>
            </a>
        </div>
    </div>

    {{-- Toolbar: Search, Filter (Tahun & Bulan) & View Switcher --}}
    <div class="toolbar-card p-3 mb-4">
        <div class="row g-3 align-items-center">
            
            {{-- Search Bar --}}
            <div class="col-lg-4 col-md-12">
                <div class="input-group search-input-group">
                    <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                        <i class="bi bi-search" style="color: var(--cyan-dark);"></i>
                    </span>
                    <input type="text" id="searchKegiatan" class="form-control bg-transparent border-0 py-2 fs-6" placeholder="Cari nama kegiatan / lokasi...">
                </div>
            </div>

            {{-- Filter Bulan --}}
            <div class="col-lg-3 col-md-4 col-6">
                <select class="form-select border-0 bg-light rounded-3 py-2 fw-semibold text-secondary" id="filterBulan">
                    <option value="">Semua Bulan</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>

            {{-- Filter Tahun (Dinamis dari Data Collection) --}}
            @php
                $availableYears = $kegiatan->pluck('tanggal_kegiatan')
                    ->filter()
                    ->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y'))
                    ->unique()
                    ->sortDesc();
            @endphp
            <div class="col-lg-2 col-md-4 col-6">
                <select class="form-select border-0 bg-light rounded-3 py-2 fw-semibold text-secondary" id="filterTahun">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            {{-- View Switcher (Grid vs List) --}}
            <div class="col-lg-3 col-md-4 col-12 text-lg-end text-center">
                <div class="bg-light p-1 rounded-3 d-inline-flex border">
                    <button class="btn view-toggle-btn active" id="btnGridView" onclick="switchView('grid')" title="Tampilan Grid">
                        <i class="bi bi-grid-3x3-gap-fill me-1"></i> Grid
                    </button>
                    <button class="btn view-toggle-btn" id="btnListView" onclick="switchView('list')" title="Tampilan List">
                        <i class="bi bi-list-task me-1"></i> List
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- GRID VIEW SECTION --}}
    <div id="gridView" class="row g-4">
        @forelse($kegiatan as $item)
        @php
            $itemDate = \Carbon\Carbon::parse($item->tanggal_kegiatan);
        @endphp
        <div class="col-xl-4 col-md-6 kegiatan-item" 
             data-nama="{{ strtolower($item->nama_kegiatan) }}" 
             data-lokasi="{{ strtolower($item->lokasi) }}"
             data-tahun="{{ $itemDate->format('Y') }}"
             data-bulan="{{ $itemDate->format('m') }}">
            
            <div class="card folder-card h-100 p-3">
                <div class="card-body d-flex flex-column p-2">
                    
                    {{-- Header Top Card --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge rounded-pill bg-light text-secondary border px-3 py-1 fw-bold" style="font-size: 0.72rem;">
                            <i class="bi bi-file-earmark-image me-1 text-info"></i> {{ $item->folder->files_count ?? 0 }} File
                        </span>

                        {{-- Action Menu --}}
                        <div class="dropdown">
                            <button class="dropdown-action-btn" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 text-start">
                                <li>
                                    <a class="dropdown-item py-2 px-3 small" href="{{ route('petugas.folder.show', $item->folder->id ?? 1) }}">
                                        <i class="bi bi-folder2-open me-2 text-primary"></i> Buka Folder
                                    </a>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item py-2 px-3 small" onclick="focusRename({{ $item->id }}, 'grid')">
                                        <i class="bi bi-pencil me-2 text-warning"></i> Rename
                                    </button>
                                </li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <form action="{{ route('petugas.kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus seluruh kegiatan beserta foldernya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item py-2 px-3 small text-danger">
                                            <i class="bi bi-trash me-2"></i> Hapus
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Folder Icon & Title --}}
                    <div class="text-center my-2">
                        <div class="folder-icon-wrapper mb-3">
                            <i class="bi bi-folder-fill fs-1"></i>
                        </div>

                        {{-- FORM AUTO-SAVE RE-NAME INLINE --}}
                        <form action="{{ route('petugas.kegiatan.update', $item->id) }}" method="POST" class="mb-2" onclick="event.stopPropagation();">
                            @csrf
                            @method('PUT')
                            <input type="text" 
                                   id="input-grid-{{ $item->id }}"
                                   name="nama_kegiatan" 
                                   value="{{ $item->nama_kegiatan }}" 
                                   class="form-control border-0 bg-transparent fw-bold text-dark text-center p-0 shadow-none text-truncate inline-folder-name fs-5" 
                                   title="Klik untuk mengubah nama kegiatan"
                                   onblur="if(this.value.trim() !== '' && this.value !== '{{ addslashes($item->nama_kegiatan) }}') this.form.submit();"
                                   onkeydown="if(event.key === 'Enter') { event.preventDefault(); this.blur(); }">
                        </form>
                    </div>

                    {{-- Metadata Details --}}
                    <div class="bg-light p-2 rounded-3 my-2 text-muted small">
                        <div class="d-flex align-items-center mb-1 text-truncate">
                            <i class="bi bi-geo-alt me-2 text-danger"></i>
                            <span class="text-truncate">{{ $item->lokasi ?? 'Lokasi tidak diisi' }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-event me-2 text-primary"></i>
                            <span>{{ $itemDate->format('d M Y') }}</span>
                        </div>
                    </div>

                    {{-- Bottom Primary Action Button --}}
                    <div class="mt-auto pt-3">
                        <a href="{{ route('petugas.folder.show', $item->folder->id ?? 1) }}" class="btn btn-open-folder w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-folder2-open fs-5"></i>
                            <span>Buka Folder</span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <div class="py-4">
                    <div class="mb-3">
                        <i class="bi bi-folder-x display-1 text-muted opacity-50"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Belum ada kegiatan liputan</h5>
                    <p class="text-muted small">Silakan tambahkan kegiatan baru untuk memulai upload dokumentasi.</p>
                    <a href="{{ route('petugas.kegiatan.create') }}" class="btn btn-cyan rounded-pill px-4 mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Kegiatan
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    {{-- LIST VIEW SECTION --}}
    <div id="listView" class="list-view-table d-none">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Jumlah File</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan as $item)
                    @php
                        $itemDate = \Carbon\Carbon::parse($item->tanggal_kegiatan);
                    @endphp
                    <tr class="kegiatan-item" 
                        data-nama="{{ strtolower($item->nama_kegiatan) }}" 
                        data-lokasi="{{ strtolower($item->lokasi) }}"
                        data-tahun="{{ $itemDate->format('Y') }}"
                        data-bulan="{{ $itemDate->format('m') }}"
                        @if($item->folder)
                            ondblclick="window.location.href='{{ route('petugas.folder.show', $item->folder->id) }}';"
                            style="cursor: pointer;"
                            title="Klik 2x untuk membuka folder"
                        @endif>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-folder-fill fs-3 text-warning"></i>
                                
                                {{-- FORM AUTO-SAVE RE-NAME INLINE --}}
                                <form action="{{ route('petugas.kegiatan.update', $item->id) }}" method="POST" class="mb-0 flex-grow-1" onclick="event.stopPropagation();" ondblclick="event.stopPropagation();">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" 
                                           id="input-list-{{ $item->id }}"
                                           name="nama_kegiatan" 
                                           value="{{ $item->nama_kegiatan }}" 
                                           class="form-control border-0 bg-transparent fw-bold text-dark p-0 shadow-none text-truncate inline-folder-name fs-6" 
                                           title="Klik untuk mengubah nama kegiatan"
                                           onblur="if(this.value.trim() !== '' && this.value !== '{{ addslashes($item->nama_kegiatan) }}') this.form.submit();"
                                           onkeydown="if(event.key === 'Enter') { event.preventDefault(); this.blur(); }">
                                </form>
                            </div>
                        </td>
                        <td class="text-secondary small">
                            <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $item->lokasi }}
                        </td>
                        <td class="text-secondary small">
                            <i class="bi bi-calendar-event me-1 text-primary"></i> {{ $itemDate->format('d M Y') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-semibold">
                                {{ $item->folder->files_count ?? 0 }} File
                            </span>
                        </td>
                        <td class="text-end" onclick="event.stopPropagation();" ondblclick="event.stopPropagation();">
                            {{-- Action Menu Dropdown --}}
                            <div class="dropdown">
                                <button class="dropdown-action-btn" type="button" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 text-start">
                                    @if($item->folder)
                                    <li>
                                        <a class="dropdown-item py-2 px-3 small" href="{{ route('petugas.folder.show', $item->folder->id) }}">
                                            <i class="bi bi-folder2-open me-2 text-primary"></i> Buka Folder
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <button type="button" class="dropdown-item py-2 px-3 small" onclick="focusRename({{ $item->id }}, 'list')">
                                            <i class="bi bi-pencil me-2 text-warning"></i> Rename
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider my-1">
                                    </li>
                                    <li>
                                        <form action="{{ route('petugas.kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus seluruh kegiatan beserta foldernya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 px-3 small text-danger">
                                                <i class="bi bi-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                   @empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">Belum ada kegiatan tersedia.</td>
    </tr>
    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Dynamic Interaction Script --}}
<script>
    // Focus pada input rename saat diklik dari menu titik tiga
    function focusRename(id, view = 'grid') {
        const input = document.getElementById(`input-${view}-${id}`);
        if (input) {
            input.focus();
            input.select();
        }
    }

    // Switch between Grid View and List View
    function switchView(type) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const btnGrid = document.getElementById('btnGridView');
        const btnList = document.getElementById('btnListView');

        if (type === 'grid') {
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
        } else {
            gridView.classList.add('d-none');
            listView.classList.remove('d-none');
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
        }
    }

    // Combined Instant Filter (Search + Bulan + Tahun)
    function applyFilters() {
        const searchValue = document.getElementById('searchKegiatan').value.toLowerCase();
        const selectedBulan = document.getElementById('filterBulan').value;
        const selectedTahun = document.getElementById('filterTahun').value;

        const items = document.querySelectorAll('.kegiatan-item');

        items.forEach(function (item) {
            const nama = item.getAttribute('data-nama') || '';
            const lokasi = item.getAttribute('data-lokasi') || '';
            const bulan = item.getAttribute('data-bulan') || '';
            const tahun = item.getAttribute('data-tahun') || '';

            const matchesSearch = nama.includes(searchValue) || lokasi.includes(searchValue);
            const matchesBulan = selectedBulan === '' || bulan === selectedBulan;
            const matchesTahun = selectedTahun === '' || tahun === selectedTahun;

            if (matchesSearch && matchesBulan && matchesTahun) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Event Listeners untuk Filter Real-time
    document.getElementById('searchKegiatan').addEventListener('keyup', applyFilters);
    document.getElementById('filterBulan').addEventListener('change', applyFilters);
    document.getElementById('filterTahun').addEventListener('change', applyFilters);
</script>
@endsection