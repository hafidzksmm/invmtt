<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <div class="full-background"
                            style="background-image: url('../assets/img/header-blue-purple.jpg')"></div>
                        <div class="card-body text-start p-4 w-100">
                            <h3 class="text-white mb-2">ASET JUAL </h3>
                            <p class="mb-4 font-weight-semibold">
                                PT. Media Touch Technology
                            </p>
                            <a href="{{ route('dashboard') }}" 
                            class="btn text-white fw-semibold shadow-sm px-4 py-2"
                            style="background: linear-gradient(90deg, #ff512f, #f09819); border: none;">
                            <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                            <img src="../assets/img/ikon3.png" alt="3d-cube"
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div class="col-xl-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <input type="text" 
                                            id="searchInput" 
                                            class="form-control bg-white text-black border-secondary" 
                                            placeholder="Cari data Inventory Asset Jual..." 
                                            style="max-width: 300px;">
                                    </div>
                                </div>
                                <!-- Tombol Tambah Data & Import Excel rata kanan -->
                                 
                                <!-- Tombol Export -->
                                 <div class="col-xl-8">
                                    
                                    <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
    <!-- Tombol Filter -->
    <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#filterModal">
        <i class="bi bi-funnel-fill"></i> Filter
    </button>

    <!-- Modal Filter -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="filterModalLabel">Filter Data Inventaris</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('aset.filter') }}" method="GET" id="filterForm">
                    @csrf
                    <div class="modal-body">

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <select id="nama_barang" name="nama_barang" class="form-select bg-dark text-white border-secondary">
                                <option value="">-- Pilih Nama Barang --</option>
                                @foreach ($asset_jual->unique('nama_barang') as $item)
                                    <option value="{{ $item->nama_barang }}">{{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis -->
                        <div class="mb-3 d-none" id="jenisGroup">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select id="jenis" name="jenis" class="form-select bg-dark text-white border-secondary">
                                <option value="">-- Pilih Jenis --</option>
                            </select>
                        </div>

                        <!-- Merk -->
                        <div class="mb-3 d-none" id="merkGroup">
                            <label for="merk" class="form-label">Merk</label>
                            <select id="merk" name="merk" class="form-select bg-dark text-white border-secondary">
                                <option value="">-- Pilih Merk --</option>
                            </select>
                        </div>

                        <!-- Tipe -->
                        <div class="mb-3 d-none" id="tipeGroup">
                            <label for="tipe" class="form-label">Tipe</label>
                            <select id="tipe" name="tipe" class="form-select bg-dark text-white border-secondary">
                                <option value="">-- Pilih Tipe --</option>
                            </select>
                        </div>

                        <!-- Ukuran -->
                        <div class="mb-3 d-none" id="ukuranGroup">
                            <label for="ukuran" class="form-label">Ukuran</label>
                            <select id="ukuran" name="ukuran" class="form-select bg-dark text-white border-secondary">
                                <option value="">-- Pilih Ukuran --</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-info text-white">
                            <i class="bi bi-search"></i> Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="{{ route('asetjual.export', request()->query()) }}" class="btn btn-success">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>

                                    
                                        <!-- Tombol untuk membuka modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="bi bi-file-earmark-arrow-up"></i> Import Excel
    </button>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Header Modal -->
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="importModalLabel">Import Data dari Excel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body">
                    <form action="{{ route('asetjual.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls" required>
                            <div class="form-text">Format yang didukung: .xlsx, .xls</div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#addInventarisModal">
                                        <i class="bi bi-plus-lg"></i> Tambah Data
                                    </button>
                                </div>
                                </div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addInventarisModal" tabindex="-1" aria-labelledby="addInventarisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #1e1e2d; color: #f8f9fa; border-radius: 12px; border: none;">
            
            <!-- Header -->
            <div class="modal-header bg-success" >
                <h5 class="modal-title fw-bold" id="addInventarisModalLabel">
                    <i class="bi bi-box-seam me-2 text-info"></i>Tambah Data Inventaris
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

<!-- Body -->
<form action="{{ route('aset-store') }}" method="POST">
    @csrf

    <div class="modal-body px-4" style="background-color: #f8f9fb; color: #212529;">
        <div class="row g-3">

            <!-- PN -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Produk No (PN)</label>
                <textarea name="pn" class="form-control border-secondary" rows="4" required></textarea>
                <small class="text-muted">Pisahkan PN dengan enter (1 baris = 1 PN)</small>
            </div>

            <!-- Nama Barang -->
            <div class="col-md-6">
                <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                <input type="text" class="form-control border-secondary" id="nama_barang" 
                       name="nama_barang" required>
            </div>

            <!-- Jenis -->
            <div class="col-md-6">
                <label for="jenis" class="form-label fw-semibold">Jenis</label>
                <input type="text" class="form-control border-secondary" id="jenis" 
                       name="jenis" required>
            </div>

            <!-- Merk -->
            <div class="col-md-6">
                <label for="merk" class="form-label fw-semibold">Merk</label>
                <input type="text" class="form-control border-secondary" id="merk" 
                       name="merk" required>
            </div>

            <!-- Tipe -->
            <div class="col-md-6">
                <label for="tipe" class="form-label fw-semibold">Tipe</label>
                <input type="text" class="form-control border-secondary" id="tipe" 
                       name="tipe" required>
            </div>

            <!-- Ukuran -->
            <div class="col-md-6">
                <label for="ukuran" class="form-label fw-semibold">Ukuran</label>
                <input type="text" class="form-control border-secondary" id="ukuran" 
                       name="ukuran" required>
            </div>

            <!-- Dimensi -->
            <div class="col-md-6">
                <label for="dimensi" class="form-label fw-semibold">Dimensi</label>
                <input type="text" class="form-control border-secondary" id="dimensi" 
                       name="dimensi" required>
            </div>

            <!-- QTY -->
            <div class="col-md-4">
                <label for="qty" class="form-label fw-semibold">Quantity (QTY)</label>
                <input type="number" class="form-control border-secondary" id="qty" 
                       name="qty" min="1" required>
            </div>

            <!-- SN -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Serial No (SN)</label>
                <textarea name="sn" class="form-control border-secondary" rows="4" required></textarea>
                <small class="text-muted">Pisahkan SN dengan enter (1 baris = 1 SN)</small>
            </div>

            <!-- Lokasi -->
            <div class="col-md-4">
                <label for="lokasi" class="form-label fw-semibold">Lokasi</label>
                <input type="text" class="form-control border-secondary" id="lokasi" 
                       name="lokasi" required>
            </div>

        </div>
    </div>

    <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Batal
        </button>

        <button type="submit" class="btn btn-success text-white">
            <i class="bi bi-save"></i> Simpan
        </button>
    </div>
</form>

        </div>
    </div>
</div>
                            </div>

                            <div class="card-body px-0 py-0">
                                <div class="table-responsive p-3">
                                    <table id="dataTable" class="table table-hover align-items-center text-center mb-0">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th>No</th>
                                                <th>Produk No</th>
                                                <th>Nama Barang</th>
                                                <th>Jenis</th>
                                                <th>Merk</th>
                                                <th>Tipe</th>
                                                <th>Ukuran</th>
                                                <th>Dimensi</th>
                                                <th>Qty</th>
                                                <th>Serial No</th>
                                                <th>Lokasi</th>
                                                <th>Dibuat Pada</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($asset_jual as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="text-wrap">
                                                        @php
                                                            $pns = json_decode($item->pn ?? '[]', true);
                                                        @endphp

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
                                                    <td class="text-wrap">{{ $item->dimensi }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td class="text-wrap">
                                                        @php
                                                            $sns = json_decode($item->sn ?? '[]', true);
                                                        @endphp

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
                                                        <!-- Tombol Edit -->
                                                        <button type="button" class="btn btn-sm btn-warning me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </button>

                                                        <!-- Form Hapus -->
                                                        <form action="{{ route('aset.hapus', $item->id) }}" method="POST"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>

                                                         <!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
    aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('aset.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Inventaris</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4" style="background-color: #f8f9fb; color: #212529;">

                    @php
                        $pns = json_decode($item->pn ?? '[]', true);
                        $pn_string = is_array($pns) ? implode("\n", $pns) : $item->pn;

                        $sns = json_decode($item->sn ?? '[]', true);
                        $sn_string = is_array($sns) ? implode("\n", $sns) : $item->sn;
                    @endphp

                    <div class="row g-3">

                        <!-- PN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Produk No (PN)</label>
                            <textarea name="pn" class="form-control border-secondary" rows="4" required>{{ $pn_string }}</textarea>
                            <small class="text-muted">Pisahkan PN dengan enter (1 baris = 1 PN)</small>
                        </div>

                        <!-- Nama Barang -->
                        <div class="col-md-6">
                            <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                            <input type="text" class="form-control border-secondary" id="nama_barang"
                                name="nama_barang" value="{{ $item->nama_barang }}" required>
                        </div>

                        <!-- Jenis -->
                        <div class="col-md-6">
                            <label for="jenis" class="form-label fw-semibold">Jenis</label>
                            <input type="text" class="form-control border-secondary" id="jenis"
                                name="jenis" value="{{ $item->jenis }}" required>
                        </div>

                        <!-- Merk -->
                        <div class="col-md-6">
                            <label for="merk" class="form-label fw-semibold">Merk</label>
                            <input type="text" class="form-control border-secondary" id="merk"
                                name="merk" value="{{ $item->merk }}" required>
                        </div>

                        <!-- Tipe -->
                        <div class="col-md-6">
                            <label for="tipe" class="form-label fw-semibold">Tipe</label>
                            <input type="text" class="form-control border-secondary" id="tipe"
                                name="tipe" value="{{ $item->tipe }}" required>
                        </div>

                        <!-- Ukuran -->
                        <div class="col-md-6">
                            <label for="ukuran" class="form-label fw-semibold">Ukuran</label>
                            <input type="text" class="form-control border-secondary" id="ukuran"
                                name="ukuran" value="{{ $item->ukuran }}" required>
                        </div>

                        <!-- Dimensi -->
                        <div class="col-md-6">
                            <label for="dimensi" class="form-label fw-semibold">Dimensi</label>
                            <input type="text" class="form-control border-secondary" id="dimensi"
                                name="dimensi" value="{{ $item->dimensi }}" required>
                        </div>

                        <!-- QTY -->
                        <div class="col-md-4">
                            <label for="qty" class="form-label fw-semibold">Quantity (QTY)</label>
                            <input type="number" class="form-control border-secondary" id="qty"
                                name="qty" min="1" value="{{ $item->qty }}" required>
                        </div>

                        <!-- SN -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Serial No (SN)</label>
                            <textarea name="sn" class="form-control border-secondary" rows="4" required>{{ $sn_string }}</textarea>
                            <small class="text-muted">Pisahkan SN dengan enter (1 baris = 1 SN)</small>
                        </div>

                        <!-- Lokasi -->
                        <div class="col-md-4">
                            <label for="lokasi" class="form-label fw-semibold">Lokasi</label>
                            <input type="text" class="form-control border-secondary" id="lokasi"
                                name="lokasi" value="{{ $item->lokasi }}" required>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success text-white">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center text-muted py-3">
                                                        Tidak ada data inventaris.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            
            <x-app.footer />
            
        </div>
    </main>
    

</x-app-layout>
@push('scripts')
<!-- jQuery (pastikan sudah include di layout utama) -->
<script>
$(document).ready(function() {
    let asetData = @json($asset_jual);

    // Fungsi bantu ambil nilai unik dari kolom tertentu dengan filter aktif
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

    // Fungsi isi dropdown
    function populateDropdown(selector, data, label, selectedVal = '') {
        $(selector).empty().append(`<option value="">-- Pilih ${label} --</option>`);
        data.forEach(value => {
            let selected = value === selectedVal ? 'selected' : '';
            $(selector).append(`<option value="${value}" ${selected}>${value}</option>`);
        });
    }

    // Inisialisasi semua dropdown di awal (tampilkan semua data unik)
    populateDropdown('#nama_barang', getUniqueValues('nama_barang'), 'Nama Barang');
    populateDropdown('#jenis', getUniqueValues('jenis'), 'Jenis');
    populateDropdown('#merk', getUniqueValues('merk'), 'Merk');
    populateDropdown('#tipe', getUniqueValues('tipe'), 'Tipe');
    populateDropdown('#ukuran', getUniqueValues('ukuran'), 'Ukuran');

    // Pastikan semua dropdown tampil
    $('#jenisGroup, #merkGroup, #tipeGroup, #ukuranGroup').removeClass('d-none');

    // Saat ada perubahan di salah satu dropdown, update dropdown lainnya agar saling sinkron
    $('#nama_barang, #jenis, #merk, #tipe, #ukuran').on('change', function() {
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


