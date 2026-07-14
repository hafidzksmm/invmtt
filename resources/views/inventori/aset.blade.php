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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-hidden">
    <x-app.navbar />

    <div class="dash-wrap">

        <!-- HEADER (tema sama dengan Dashboard) -->
        <div class="dash-header">
            <div class="dash-brand">
                <div class="dash-greeting">
                    <div class="greeting-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:26px;height:26px;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/><line x1="9" y1="11" x2="15" y2="11"/>
                        </svg>
                    </div>
                    <div class="greeting-text">
                        <span class="greeting-hello">Aset Jual</span>
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
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari data Aset Jual...">
                </div>

                <div class="toolbar-right">
                    <!-- Tombol Filter -->
                    <button type="button" class="btn-pill btn-pill-outline" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>

                    <a href="{{ route('asetjual.export', request()->query()) }}" class="btn-pill btn-pill-green">
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
                            <h5 class="modal-title" id="filterModalLabel">Filter Data Aset Jual</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('aset.filter') }}" method="GET" id="filterForm">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <select id="nama_barang" name="nama_barang" class="form-select">
                                        <option value="">-- Semua Barang --</option>
                                        @foreach ($asset_jual->unique('nama_barang') as $item)
                                            <option value="{{ $item->nama_barang }}">{{ $item->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 d-none" id="jenisGroup">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <select id="jenis" name="jenis" class="form-select">
                                        <option value="">-- Semua Jenis --</option>
                                    </select>
                                </div>

                                <div class="mb-3 d-none" id="merkGroup">
                                    <label for="merk" class="form-label">Merk</label>
                                    <select id="merk" name="merk" class="form-select">
                                        <option value="">-- Semua Merk --</option>
                                    </select>
                                </div>

                                <div class="mb-3 d-none" id="tipeGroup">
                                    <label for="tipe" class="form-label">Tipe</label>
                                    <select id="tipe" name="tipe" class="form-select">
                                        <option value="">-- Semua Tipe --</option>
                                    </select>
                                </div>

                                <div class="mb-3 d-none" id="ukuranGroup">
                                    <label for="ukuran" class="form-label">Ukuran</label>
                                    <select id="ukuran" name="ukuran" class="form-select">
                                        <option value="">-- Semua Ukuran --</option>
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

            {{-- ✅ MODAL IMPORT - ADMIN & SUPERADMIN --}}
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
                            <form action="{{ route('asetjual.import') }}" method="POST" enctype="multipart/form-data">
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

                        <form action="{{ route('aset-store') }}" method="POST">
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
                                        <label for="jenis" class="form-label fw-semibold">Jenis</label>
                                        <input type="text" class="form-control" id="jenis" name="jenis">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="merk" class="form-label fw-semibold">Merk</label>
                                        <input type="text" class="form-control" id="merk" name="merk">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tipe" class="form-label fw-semibold">Tipe</label>
                                        <input type="text" class="form-control" id="tipe" name="tipe">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ukuran" class="form-label fw-semibold">Ukuran</label>
                                        <input type="text" class="form-control" id="ukuran" name="ukuran">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="qty" class="form-label fw-semibold">Quantity (QTY)</label>
                                        <input type="number" class="form-control" id="qty" name="qty" min="1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Serial No (SN)</label>
                                        <textarea name="sn" class="form-control" rows="4"></textarea>
                                        <small class="text-muted">Pisahkan SN dengan enter (1 baris = 1 SN)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn-pill btn-pill-outline" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i> Batal
                                </button>
                                <button type="submit" class="btn-pill btn-pill-red">
                                    <i class="bi bi-save"></i> Simpan
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
                            <th rowspan="0"></th>
                            <th style="cursor: default;">No</th>
                            <th class="sortable-header" data-column="pn">Produk No <span class="sort-indicator"></span></th>
                            <th class="sortable-header" data-column="nama_barang">Nama Barang <span class="sort-indicator"></span></th>
                            <th class="sortable-header" data-column="jenis">Jenis <span class="sort-indicator"></span></th>
                            <th class="sortable-header" data-column="merk">Merk <span class="sort-indicator"></span></th>
                            <th class="sortable-header" data-column="tipe">Tipe <span class="sort-indicator"></span></th>
                            <th class="sortable-header" data-column="ukuran">Ukuran <span class="sort-indicator"></span></th>
                            <th style="cursor: default;">Qty</th>
                            <th style="cursor: default;">Serial No</th>
                            <th style="cursor: default;">Dibuat Pada</th>
                            <th style="cursor: default;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortableTable">
                        @forelse ($asset_jual as $index => $item)
                            <tr data-id="{{ $item->id }}">
                                        <td class="text-center">
                                            <span class="drag-handle" style="cursor:grab; color:#999;">
                                                ⋮⋮
                                            </span>
                                        </td>
                                
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
                                <td class="text-wrap">{{ $item->nama_barang }}</td>
                                <td class="text-wrap">{{ $item->jenis }}</td>
                                <td class="text-wrap">{{ $item->merk }}</td>
                                <td class="text-wrap">{{ $item->tipe }}</td>
                                <td class="text-wrap">{{ $item->ukuran }}</td>
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
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    {{-- ✅ EDIT & HAPUS - ADMIN & SUPERADMIN --}}
                                    @if($canManage)
                                        <button type="button" class="btn-pill btn-pill-outline btn-sm-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <form action="{{ route('aset.hapus', $item->id) }}" method="POST" style="display:inline-block;">
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
                                                <form action="{{ route('aset.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Aset Jual</h5>
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
                                                                <label for="jenis" class="form-label fw-semibold">Jenis</label>
                                                                <input type="text" class="form-control" id="jenis" name="jenis" value="{{ $item->jenis }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="merk" class="form-label fw-semibold">Merk</label>
                                                                <input type="text" class="form-control" id="merk" name="merk" value="{{ $item->merk }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="tipe" class="form-label fw-semibold">Tipe</label>
                                                                <input type="text" class="form-control" id="tipe" name="tipe" value="{{ $item->tipe }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ukuran" class="form-label fw-semibold">Ukuran</label>
                                                                <input type="text" class="form-control" id="ukuran" name="ukuran" value="{{ $item->ukuran }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="qty" class="form-label fw-semibold">Quantity (QTY)</label>
                                                                <input type="number" class="form-control" id="qty" name="qty" min="1" value="{{ $item->qty }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-semibold">Serial No (SN)</label>
                                                                <textarea name="sn" class="form-control" rows="4">{{ $sn_string }}</textarea>
                                                                <small class="text-muted">Pisahkan SN dengan enter (1 baris = 1 SN)</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn-pill btn-pill-outline" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle"></i> Batal
                                                        </button>
                                                        <button type="submit" class="btn-pill btn-pill-red">
                                                            <i class="bi bi-save"></i> Simpan
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
.drag-handle {
    font-size: 18px;
    user-select: none;
}

.drag-handle:active {
    cursor: grabbing;
}

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

    /* Tombol Home / Back (ikon + label) */
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

    .sortable-header{ transition: all 0.2s ease; position: relative; padding: 12px !important; cursor:pointer; user-select:none; }
    .sortable-header:hover{ background-color:var(--red-light) !important; }
    .sort-indicator{ font-size: 0.9em; margin-left: 5px; color:var(--red); }
    .sortable-header[data-column]:has(.sort-indicator:not(:empty)){ background-color:var(--red-light) !important; font-weight:700; }

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

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function () {

    if (typeof $.fn.sortable !== 'function') {
        console.error('jQuery UI belum ter-load. Drag & drop tidak akan berfungsi.');
        return;
    }

    $("#sortableTable").sortable({
        handle: ".drag-handle",
        placeholder: "sortable-placeholder",
        helper: function (e, tr) {
            // biar lebar kolom tidak collapse saat drag
            let $originals = tr.children();
            let $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },
        update: function () {

            let order = [];

            $("#sortableTable tr").each(function (index) {
                let id = $(this).data("id");
                if (id !== undefined) {
                    order.push({
                        id: id,
                        position: index + 1
                    });
                }
            });

            if (order.length === 0) {
                console.error('Tidak ada data-id yang ditemukan pada baris tabel.');
                return;
            }

            $.ajax({
                url: "{{ route('inventory-aset-jual.reorder') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order: order
                },
                success: function () {
                    location.reload();
                },
                error: function (xhr) {
                    console.error('Gagal menyimpan urutan:', xhr.responseText);
                    alert('Gagal menyimpan urutan data. Silakan cek console untuk detail.');
                }
            });
        }
    });

});

$(document).ready(function () {
        let asetData = @json($asset_jual);
        let isUserAdmin = {{ $canManage ? 'true' : 'false' }}; // ✅ true untuk admin & superadmin
        let currentSortColumn = null;
        let currentSortOrder = 'asc';

        function getUniqueValues(field, filters = {}) {
            let filtered = asetData.filter(item => {
                return (!filters.nama_barang || item.nama_barang === filters.nama_barang) &&
                    (!filters.jenis || item.jenis === filters.jenis) &&
                    (!filters.merk || item.merk === filters.merk) &&
                    (!filters.tipe || item.tipe === filters.tipe) &&
                    (!filters.ukuran || item.ukuran === filters.ukuran);
            });
            return [...new Set(filtered.map(item => item[field]).filter(Boolean))];
        }

        function populateDropdown(selector, data, label, selectedVal = '') {
            $(selector).empty().append(`<option value="">-- Semua ${label} --</option>`);
            data.forEach(value => {
                let selected = value === selectedVal ? 'selected' : '';
                $(selector).append(`<option value="${value}" ${selected}>${value}</option>`);
            });
        }

        populateDropdown('#nama_barang', getUniqueValues('nama_barang'), 'Nama Barang');
        populateDropdown('#jenis', getUniqueValues('jenis'), 'Jenis');
        populateDropdown('#merk', getUniqueValues('merk'), 'Merk');
        populateDropdown('#tipe', getUniqueValues('tipe'), 'Tipe');
        populateDropdown('#ukuran', getUniqueValues('ukuran'), 'Ukuran');

        $('#jenisGroup, #merkGroup, #tipeGroup, #ukuranGroup').removeClass('d-none');

        $('#nama_barang, #jenis, #merk, #tipe, #ukuran').on('change', function () {
            let filters = {
                nama_barang: $('#nama_barang').val(),
                jenis: $('#jenis').val(),
                merk: $('#merk').val(),
                tipe: $('#tipe').val(),
                ukuran: $('#ukuran').val()
            };

            populateDropdown('#nama_barang', getUniqueValues('nama_barang', filters), 'Nama Barang', filters.nama_barang);
            populateDropdown('#jenis', getUniqueValues('jenis', filters), 'Jenis', filters.jenis);
            populateDropdown('#merk', getUniqueValues('merk', filters), 'Merk', filters.merk);
            populateDropdown('#tipe', getUniqueValues('tipe', filters), 'Tipe', filters.tipe);
            populateDropdown('#ukuran', getUniqueValues('ukuran', filters), 'Ukuran', filters.ukuran);
        });

        function getValueForSort(item, column) {
            let value = item[column];
            if (column === 'pn' || column === 'sn') {
                try {
                    let decoded = JSON.parse(value || '[]');
                    if (Array.isArray(decoded) && decoded.length > 0) {
                        return decoded[0];
                    }
                } catch (e) {
                    return value || '';
                }
            }
            return value || '';
        }

        function sortTableData(column) {
            if (currentSortColumn === column) {
                currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                currentSortColumn = column;
                currentSortOrder = 'asc';
            }

            $('.sort-indicator').html('');
            $(`.sortable-header[data-column="${column}"] .sort-indicator`).html(
                currentSortOrder === 'asc' ? ' ↑' : ' ↓'
            );

            let sortedData = [...asetData].sort((a, b) => {
                let valueA = getValueForSort(a, column).toString().toLowerCase();
                let valueB = getValueForSort(b, column).toString().toLowerCase();

                if (currentSortOrder === 'asc') {
                    return valueA.localeCompare(valueB, 'id-ID', { numeric: true });
                } else {
                    return valueB.localeCompare(valueA, 'id-ID', { numeric: true });
                }
            });

            renderTable(sortedData);
        }

        function renderTable(dataToRender = asetData) {
            let tbody = $('#dataTable tbody');
            tbody.empty();

            if (dataToRender.length === 0) {
                tbody.html(`
                <tr>
                    <td colspan="11" class="text-center text-muted py-3">
                        Tidak ada data inventaris.
                    </td>
                </tr>
            `);
                return;
            }

            dataToRender.forEach((item, index) => {
                let pns = [];
                let sns = [];
                try {
                    pns = JSON.parse(item.pn || '[]');
                    sns = JSON.parse(item.sn || '[]');
                } catch (e) {
                    pns = item.pn ? [item.pn] : [];
                    sns = item.sn ? [item.sn] : [];
                }

                let pnHtml = Array.isArray(pns) && pns.length > 0
                    ? `<ul class="ps-3 mb-0">${pns.map(pn => `<li>${pn}</li>`).join('')}</ul>`
                    : '';

                let snHtml = Array.isArray(sns) && sns.length > 0
                    ? `<ul class="ps-3 mb-0">${sns.map(sn => `<li>${sn}</li>`).join('')}</ul>`
                    : '';

                let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td class="text-wrap">${pnHtml}</td>
                    <td class="text-wrap">${item.nama_barang || ''}</td>
                    <td class="text-wrap">${item.jenis || ''}</td>
                    <td class="text-wrap">${item.merk || ''}</td>
                    <td class="text-wrap">${item.tipe || ''}</td>
                    <td class="text-wrap">${item.ukuran || ''}</td>
                    <td>${item.qty || ''}</td>
                    <td class="text-wrap">${snHtml}</td>
                    <td>${new Date(item.created_at).toLocaleDateString('id-ID')}</td>
                    <td>
                        ${isUserAdmin ? `
                            <button type="button" class="btn-pill btn-pill-outline btn-sm-pill" data-bs-toggle="modal" data-bs-target="#editModal${item.id}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <form action="{{ route('aset.hapus', ':id') }}".replace(':id', item.id) method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-pill btn-pill-red btn-sm-pill" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        ` : `<span class="text-muted text-sm">Tidak ada akses</span>`}
                    </td>
                </tr>
            `;
                tbody.append(row);
            });
        }

        $('.sortable-header').on('click', function () {
            let column = $(this).data('column');
            sortTableData(column);
        });

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
</script>