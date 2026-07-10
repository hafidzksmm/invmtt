<x-app-layout>
@php
    // ✅ true untuk admin ATAU superadmin — dipakai di semua tombol CRUD di halaman ini
    // Dibuat toleran terhadap spasi & kapitalisasi (mis. "Super Admin", "super_admin", "SUPERADMIN")
    $rawRole = auth()->check() ? strtolower(trim(auth()->user()->role ?? '')) : '';
    $canManage = auth()->check() && (
        isAdmin() ||
        in_array($rawRole, ['superadmin', 'super_admin', 'super admin'])
    );
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-hidden">
    <x-app.navbar />

    <div class="dash-wrap">

        <!-- HEADER (tema sama dengan Dashboard) -->
        <div class="dash-header">
            <div class="dash-brand">
                <div class="dash-greeting">
                    <div class="greeting-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:26px;height:26px;">
                            <path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/><line x1="9" y1="9" x2="9" y2="9.01"/><line x1="9" y1="13" x2="9" y2="13.01"/>
                        </svg>
                    </div>
                    <div class="greeting-text">
                        <span class="greeting-hello">Inventori Workshop</span>
                        <span class="greeting-role">PT. Media Touch Technology</span>
                    </div>
                </div>
            </div>

            <div class="dash-actions">
                <!-- 🏠 HOME -->
                <a href="{{ route('dashboard') }}" class="btn-icon-nav" title="Home">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7"/><path d="M9 22V12h6v10"/><path d="M21 22H3V9"/></svg>
                    <span>Home</span>
                </a>

                <!-- ⬅️ BACK -->
                <a href="javascript:history.back()" class="btn-icon-nav" title="Back">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    <span>Back</span>
                </a>
            </div>
        </div>

        <!-- PANEL UTAMA -->
        <div class="panel table-panel">
            <div class="panel-toolbar">
                <div class="toolbar-left">
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari data Inventory Workshop...">
                </div>

                <div class="toolbar-right">
                    <!-- Tombol Filter -->
                    <button type="button" class="btn-pill btn-pill-outline" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>

                    <a href="{{ route('inventori.export', request()->query()) }}" class="btn-pill btn-pill-green">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>

                    {{-- ✅ IMPORT & TAMBAH DATA - ADMIN & SUPERADMIN --}}
                    @if($canManage)
                        <button type="button" class="btn-pill btn-pill-green" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="bi bi-file-earmark-arrow-up"></i> Import Excel
                        </button>

                        <button type="button" class="btn-pill btn-pill-red" data-bs-toggle="modal" data-bs-target="#addInventarisModal">
                            <i class="bi bi-plus-lg"></i> Tambah Data
                        </button>
                    @else
                        <span class="badge-noaccess">Hanya Admin dapat menambah data</span>
                    @endif
                </div>
            </div>

            <!-- Modal Filter -->
            <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modal-themed">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel">Filter Data Inventaris</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('ws.filter') }}" method="GET" id="filterForm">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <select id="nama_barang" name="nama_barang" class="form-select">
                                        <option value="">-- Pilih Nama Barang --</option>
                                        @foreach ($inventaris->unique('nama_barang') as $item)
                                            <option value="{{ $item->nama_barang }}">{{ $item->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 d-none" id="merkGroup">
                                    <label for="merk" class="form-label">Merk</label>
                                    <select id="merk" name="merk" class="form-select">
                                        <option value="">-- Pilih Merk --</option>
                                    </select>
                                </div>

                                <div class="mb-3 d-none" id="deskripsiGroup">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <select id="deskripsi" name="deskripsi" class="form-select">
                                        <option value="">-- Pilih Deskripsi --</option>
                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn-pill btn-pill-outline" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i> Tutup
                                </button>
                                <button type="submit" class="btn-pill btn-pill-red">
                                    <i class="bi bi-search"></i> Terapkan Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ✅ MODAL IMPORT & TAMBAH DATA - ADMIN & SUPERADMIN --}}
            @if($canManage)
            <!-- Modal Import Excel -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modal-themed">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Data dari Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('inventori.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="form-label">Pilih File Excel</label>
                                    <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls" required>
                                    <div class="form-text">Format yang didukung: .xlsx, .xls</div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn-pill btn-pill-outline" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn-pill btn-pill-green">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Data -->
            <div class="modal fade" id="addInventarisModal" tabindex="-1" aria-labelledby="addInventarisModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content modal-themed">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="addInventarisModalLabel">
                                <i class="bi bi-box-seam me-2"></i>Tambah Data Inventaris
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{ route('ws-store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Produk No (PN)</label>
                                        <textarea name="pn" class="form-control" rows="4"></textarea>
                                        <small class="text-muted">Pisahkan PN dengan enter (1 baris = 1 PN)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="merk" class="form-label fw-semibold">Merk</label>
                                        <input type="text" class="form-control" id="merk" name="merk">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                                        <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dimensi" class="form-label fw-semibold">Dimensi</label>
                                        <input type="text" class="form-control" id="dimensi" name="dimensi">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="qty" class="form-label fw-semibold">Quantity (QTY)</label>
                                        <input type="number" class="form-control" id="qty" name="qty" min="1" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Serial No (SN)</label>
                                        <textarea name="sn" class="form-control" rows="4"></textarea>
                                        <small class="text-muted">Pisahkan SN dengan enter (1 baris = 1 SN)</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lokasi" class="form-label fw-semibold">Lokasi</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                                            <button type="submit" class="btn-pill btn-pill-red flex-shrink-0" title="Simpan">
                                                <i class="bi bi-save"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn-pill btn-pill-outline" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i> Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- TABEL -->
            <div class="table-responsive p-3">
                <table id="dataTable" class="table table-hover align-items-center text-center mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk No</th>
                            <th class="sortable">Nama Barang <span class="sort-arrow">⬍</span></th>
                            <th class="sortable">Merk <span class="sort-arrow">⬍</span></th>
                            <th class="sortable">Deskripsi <span class="sort-arrow">⬍</span></th>
                            <th>Dimensi</th>
                            <th>Qty</th>
                            <th>Serial No</th>
                            <th class="sortable">Lokasi <span class="sort-arrow">⬍</span></th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventaris as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-wrap">
                                    @php $pns = json_decode($item->pn ?? '[]', true); @endphp
                                    @if (is_array($pns))
                                        <ul class="ps-3 mb-0">
                                            @foreach ($pns as $pn)
                                                <li>{{ $pn }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $item->pn }}
                                    @endif
                                </td>
                                <td class="text-wrap">{{ $item->nama_barang ?? '' }}</td>
                                <td class="text-wrap">{{ $item->merk ?? '' }}</td>
                                <td class="text-wrap">{{ $item->deskripsi ?? '' }}</td>
                                <td class="text-wrap">{{ $item->dimensi ?? '' }}</td>
                                <td>{{ $item->qty }}</td>
                                <td class="text-wrap">
                                    @php $sns = json_decode($item->sn ?? '[]', true); @endphp
                                    @if (is_array($sns))
                                        <ul class="ps-3 mb-0">
                                            @foreach ($sns as $sn)
                                                <li>{{ $sn }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $item->sn }}
                                    @endif
                                </td>
                                <td class="text-wrap">{{ $item->lokasi }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    {{-- ✅ EDIT & HAPUS - ADMIN & SUPERADMIN --}}
                                    @if($canManage)
                                        <button type="button" class="btn-pill btn-pill-outline btn-sm-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <form action="{{ route('ws.hapus', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-pill btn-pill-red btn-sm-pill" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted text-sm">Tidak ada akses</span>
                                    @endif

                                    {{-- ✅ MODAL EDIT - ADMIN & SUPERADMIN --}}
                                    @if($canManage)
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-themed">
                                                <form action="{{ route('ws.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Inventaris</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        @php
                                                            $pns = json_decode($item->pn ?? '[]', true);
                                                            $pn_string = is_array($pns) ? implode("\n", $pns) : $item->pn;
                                                            $sns = json_decode($item->sn ?? '[]', true);
                                                            $sn_string = is_array($sns) ? implode("\n", $sns) : $item->sn;
                                                        @endphp

                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-semibold">Produk No (PN)</label>
                                                                <textarea name="pn" class="form-control" rows="4">{{ $pn_string }}</textarea>
                                                                <small class="text-muted">Pisahkan PN dengan enter (1 baris = 1 PN)</small>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                                                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $item->nama_barang }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="merk" class="form-label fw-semibold">Merk</label>
                                                                <input type="text" class="form-control" id="merk" name="merk" value="{{ $item->merk }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                                                                <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $item->deskripsi }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="dimensi" class="form-label fw-semibold">Dimensi</label>
                                                                <input type="text" class="form-control" id="dimensi" name="dimensi" value="{{ $item->dimensi }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="qty" class="form-label fw-semibold">Quantity (QTY)</label>
                                                                <input type="number" class="form-control" id="qty" name="qty" min="1" value="{{ $item->qty }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-semibold">Serial No (SN)</label>
                                                                <textarea name="sn" class="form-control" rows="4">{{ $sn_string }}</textarea>
                                                                <small class="text-muted">Pisahkan SN dengan enter (1 baris = 1 SN)</small>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="lokasi" class="form-label fw-semibold">Lokasi</label>
                                                                <div class="d-flex gap-2">
                                                                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $item->lokasi }}" required>
                                                                    <button type="submit" class="btn-pill btn-pill-red flex-shrink-0" title="Simpan Perubahan">
                                                                        <i class="bi bi-save"></i> Simpan
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn-pill btn-pill-outline" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle"></i> Batal
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-3">Tidak ada data inventaris.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-app.footer />
</main>

<!-- 🎨 STYLING — TEMA DASHBOARD (MINIMALIS PUTIH-MERAH) -->
<style>
    :root{
        --bg: #FAFAFA;
        --surface: #FFFFFF;
        --border: #ECECEC;
        --red: #E11D2E;
        --red-dark: #B0121F;
        --red-light: #FBD3D9;
        --text: #17181A;
        --muted: #8A8F98;
        --shadow: 0 1px 2px rgba(16,16,16,0.04), 0 8px 24px rgba(16,16,16,0.04);
    }

    html, body, main { width:100%; overflow-x:hidden; }
    .main-content{ background:var(--bg) !important; }

    .dash-wrap{
        max-width:1420px;
        margin:0 auto;
        padding:34px 32px 70px;
        font-family:'Inter', sans-serif;
        color:var(--text);
    }

    /* HEADER */
    .dash-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom:32px;
        flex-wrap:wrap;
        gap:16px;
    }
    .dash-brand{ display:flex; align-items:center; gap:14px; }
    .dash-greeting{ display:flex; align-items:center; gap:14px; }
    .greeting-avatar{
        width:52px; height:52px;
        border-radius:16px;
        background:var(--red);
        color:#fff;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0;
        box-shadow:0 4px 10px rgba(225,29,46,0.25);
    }
    .greeting-text{ display:flex; flex-direction:column; line-height:1.3; }
    .greeting-hello{
        font-family:'Space Grotesk', sans-serif;
        font-weight:700;
        font-size:22px;
        color:var(--text);
        letter-spacing:-0.4px;
    }
    .greeting-role{ font-size:13.5px; color:var(--muted); }

    .dash-actions{ display:flex; align-items:center; gap:12px; }

    .btn-icon-nav{
        display:flex; align-items:center; gap:8px;
        background:var(--surface);
        border:1px solid var(--border);
        padding:12px 20px;
        border-radius:999px;
        font-size:14px;
        font-weight:600;
        color:var(--text);
        text-decoration:none;
        cursor:pointer;
        box-shadow:var(--shadow);
        transition:.15s ease;
    }
    .btn-icon-nav svg{ width:16px; height:16px; stroke:var(--red); }
    .btn-icon-nav:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }
    .btn-icon-nav:hover svg{ stroke:var(--red-dark); }

    /* PANEL */
    .panel{
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:22px;
        box-shadow:var(--shadow);
    }
    .table-panel{ padding:26px 26px 10px; }

    .panel-toolbar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:14px;
        padding-bottom:20px;
        border-bottom:1px solid var(--border);
        margin-bottom:10px;
    }
    .toolbar-left, .toolbar-right{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

    .search-input{
        border:1px solid var(--border);
        border-radius:999px;
        padding:11px 20px;
        font-size:14px;
        min-width:260px;
        background:var(--bg);
        color:var(--text);
        outline:none;
        transition:.15s ease;
    }
    .search-input:focus{ border-color:var(--red); background:var(--surface); }

    /* Tombol pil generik */
    .btn-pill{
        display:inline-flex; align-items:center; gap:7px;
        padding:10px 20px;
        border-radius:999px;
        font-size:13.5px;
        font-weight:600;
        border:none;
        cursor:pointer;
        text-decoration:none;
        transition:.15s ease;
        white-space:nowrap;
    }
    .btn-sm-pill{ padding:7px 14px; font-size:12.5px; margin-right:6px; }

    .btn-pill-red{ background:var(--red); color:#fff; box-shadow:0 6px 16px rgba(225,29,46,0.25); }
    .btn-pill-red:hover{ background:var(--red-dark); color:#fff; }

    .btn-pill-outline{ background:var(--surface); color:var(--text); border:1px solid var(--border); box-shadow:var(--shadow); }
    .btn-pill-outline:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }

    .btn-pill-green{ background:#1FA97A; color:#fff; box-shadow:0 6px 16px rgba(31,169,122,0.22); }
    .btn-pill-green:hover{ background:#178462; color:#fff; }

    .badge-noaccess{
        background:#FFF4D6; color:#8A6D00;
        padding:8px 16px; border-radius:999px;
        font-size:12.5px; font-weight:600;
    }

    /* Tabel */
    #dataTable thead{ background:var(--bg); }
    #dataTable thead th{ color:var(--text); font-weight:700; font-size:13px; border-bottom:1px solid var(--border) !important; }
    #dataTable tbody td{ font-size:13.5px; color:var(--text); vertical-align:middle; }
    #dataTable tbody tr:hover{ background:var(--red-light); }

    th.sortable{ cursor:pointer; user-select:none; transition: all 0.2s ease; padding:12px !important; }
    th.sortable:hover{ background-color:var(--red-light) !important; }
    .sort-arrow{ font-size: 0.9em; margin-left: 5px; color:var(--red); }

    /* Modal tema */
    .modal-themed{
        border-radius:18px;
        border:none;
        overflow:hidden;
        display:flex;
        flex-direction:column;
        max-height:90vh; /* pastikan modal tidak melebihi tinggi layar */
    }
    .modal-themed .modal-header{ background:var(--red); color:#fff; border:none; flex-shrink:0; }
    .modal-themed .modal-header .modal-title{ font-family:'Space Grotesk', sans-serif; font-weight:700; }
    .modal-themed .modal-header .btn-close{ filter:invert(1) brightness(2); }
    .modal-themed .modal-body{
        background:var(--surface);
        color:var(--text);
        overflow-y:auto;   /* hanya body yang scroll */
        flex:1 1 auto;
    }
    .modal-themed .modal-footer{
        background:var(--bg);
        border-top:1px solid var(--border);
        flex-shrink:0;     /* footer selalu terlihat, tidak ikut ter-scroll/kepotong */
    }

    /* Custom scrollbar biar jelas kelihatan di dalam modal-body */
    .modal-themed .modal-body::-webkit-scrollbar{
        width:8px;
    }
    .modal-themed .modal-body::-webkit-scrollbar-track{
        background:var(--bg);
        border-radius:8px;
    }
    .modal-themed .modal-body::-webkit-scrollbar-thumb{
        background:var(--red);
        border-radius:8px;
    }
    .modal-themed .modal-body::-webkit-scrollbar-thumb:hover{
        background:var(--red-dark);
    }
    .modal-themed .modal-body{
        scrollbar-width:thin;              /* Firefox */
        scrollbar-color:var(--red) var(--bg); /* Firefox */
    }

    .modal-themed .form-control, .modal-themed .form-select{
        border:1px solid var(--border); border-radius:10px;
    }
    .modal-themed .form-control:focus, .modal-themed .form-select:focus{
        border-color:var(--red); box-shadow:0 0 0 0.15rem rgba(225,29,46,0.15);
    }

    /* RESPONSIVE */
    @media (max-width: 640px){
        .greeting-hello{ font-size:18px; }
        .btn-icon-nav span{ display:none; }
        .btn-icon-nav{ padding:12px; }
        .search-input{ min-width:100%; }
    }
</style>

</x-app-layout>

@push('scripts')
<script>
    $(document).ready(function () {
        let wsData = @json($inventaris);

        // Filter dinamis untuk Nama Barang → Merk → Deskripsi
        $('#nama_barang').on('change', function () {
            let selectedBarang = $(this).val();
            if (selectedBarang) {
                let filtered = wsData.filter(item => item.nama_barang === selectedBarang);
                let uniqueMerk = [...new Set(filtered.map(item => item.merk).filter(Boolean))];

                $('#merk').empty().append('<option value="">-- Pilih Merk --</option>');
                uniqueMerk.forEach(m => $('#merk').append(`<option value="${m}">${m}</option>`));

                $('#merkGroup').removeClass('d-none');
                $('#deskripsiGroup').removeClass('d-none');
            } else {
                $('#merkGroup, #deskripsiGroup').removeClass('d-none');
            }
        });

        $('#merk').on('change', function () {
            let barang = $('#nama_barang').val();
            let merk = $(this).val();
            if (merk) {
                let filtered = wsData.filter(item => item.nama_barang === barang && item.merk === merk);
                let uniqueDeskripsi = [...new Set(filtered.map(item => item.deskripsi).filter(Boolean))];

                $('#deskripsi').empty().append('<option value="">-- Pilih Deskripsi --</option>');
                uniqueDeskripsi.forEach(d => $('#deskripsi').append(`<option value="${d}">${d}</option>`));

                $('#deskripsiGroup').removeClass('d-none');
            } else {
                $('#deskripsiGroup').removeClass('d-none');
            }
        });

        // Fitur Search
        function searchTable() {
            let value = $('#searchInput').val().toLowerCase();
            $('#dataTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        }

        $('#searchInput').on('keyup', function (e) {
            if (e.key !== 'Enter') {
                searchTable();
            }
        });

        $('#searchInput').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                searchTable();
            }
        });
    });

    function addListItem(containerId, inputName) {
        const container = document.getElementById(containerId);
        const div = document.createElement("div");
        div.classList.add("d-flex", "mb-2");

        div.innerHTML = `
        <input type="text" name="${inputName}[]" class="form-control me-2" required>
        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentNode.remove()">X</button>
    `;
        container.appendChild(div);
    }

    function combineList(inputName, textareaId) {
        const items = document.getElementsByName(inputName + "[]");
        let result = [];
        items.forEach(i => result.push(i.value));
        document.getElementById(textareaId).value = result.join("\n");
    }

    // =========================
    // 🔥 SORTING TABLE A-Z / Z-A
    // =========================
    document.querySelectorAll("#dataTable th.sortable").forEach((header, index) => {
        let asc = true;

        header.addEventListener("click", () => {
            const table = header.closest("table");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            const colIndex = header.cellIndex;

            rows.sort((a, b) => {
                let aText = a.children[colIndex].innerText.trim().toLowerCase();
                let bText = b.children[colIndex].innerText.trim().toLowerCase();

                if (!aText) return 1;
                if (!bText) return -1;

                return asc
                    ? aText.localeCompare(bText)
                    : bText.localeCompare(aText);
            });

            tbody.innerHTML = "";
            rows.forEach(row => tbody.appendChild(row));

            asc = !asc;

            document.querySelectorAll("#dataTable th.sortable .sort-arrow").forEach(el => {
                el.innerHTML = "⬍";
            });

            header.querySelector(".sort-arrow").innerHTML = asc ? "⬆" : "⬇";
        });
    });
</script>
@endpush