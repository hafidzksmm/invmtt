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
                            <h3 class="text-white mb-2">INVENTORY PROJECT </h3>
                            <p class="mb-4 font-weight-semibold">
                                PT. Media Touch Technology
                            </p>
                            <a href="{{ route('dashboard') }}" 
                            class="btn text-white fw-semibold shadow-sm px-4 py-2"
                            style="background: linear-gradient(90deg, #ff512f, #f09819); border: none;">
                            <i class="fas fa-arrow-left me-2"></i> Back
                            </a>
                            <img src="../assets/img/ikon2.png" alt="3d-cube"
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
                                            placeholder="Cari data Inventory Inventory Project..." 
                                            style="max-width: 300px;">
                                    </div>
                                </div>
                                <!-- Tombol Tambah Data & Import Excel rata kanan -->
                                 
                                <!-- Tombol Export -->
                                 <div class="col-xl-8">
                                    
                                    <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
                                        <!-- Tombol Filter -->
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

            <form action="{{ route('projek.filter') }}" method="GET" id="filterForm">
                @csrf
                <div class="modal-body">

                    <!-- Nama Barang -->
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <select id="nama_barang" name="nama_barang" class="form-select bg-dark text-white border-secondary">
                            <option value="">-- Pilih Nama Barang --</option>
                            @foreach ($inventaryprojek->unique('nama_barang') as $item)
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

                    <!-- Tipe -->
                    <div class="mb-3 d-none" id="tipeGroup">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select id="tipe" name="tipe" class="form-select bg-dark text-white border-secondary">
                            <option value="">-- Pilih Tipe --</option>
                        </select>
                    </div>

                    <!-- Merk -->
                    <div class="mb-3 d-none" id="merkGroup">
                        <label for="merk" class="form-label">Merk</label>
                        <select id="merk" name="merk" class="form-select bg-dark text-white border-secondary">
                            <option value="">-- Pilih Merk --</option>
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

<a href="{{ route('projeks.export', request()->query()) }}" class="btn btn-success">
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
                <form action="{{ route('projeks.import') }}" method="POST" enctype="multipart/form-data">
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
<form action="{{ route('projek-store') }}" method="POST">
    @csrf
    <div class="modal-body px-4" style="background-color: #f8f9fb; color: #212529;">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="pn" class="form-label fw-semibold">Produk No(PN)</label>
                <input type="text" class="form-control border-secondary" id="pn" name="pn" required>
            </div>
            <div class="col-md-6">
                <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                <input type="text" class="form-control border-secondary" id="nama_barang" name="nama_barang" required>
            </div>

            <div class="col-md-6">
                <label for="jenis" class="form-label fw-semibold">Jenis</label>
                <input type="text" class="form-control border-secondary" id="jenis" name="jenis" required>
            </div>
            <div class="col-md-6">
                <label for="tipe" class="form-label fw-semibold">tipe</label>
                <input type="text" class="form-control border-secondary" id="tipe" name="tipe" required>
            </div>
            <div class="col-md-6">
                <label for="merk" class="form-label fw-semibold">merk</label>
                <input type="text" class="form-control border-secondary" id="merk" name="merk" required>
            </div>
            <div class="col-md-6">
                <label for="ukuran" class="form-label fw-semibold">Ukuran</label>
                <input type="text" class="form-control border-secondary" id="ukuran" name="ukuran" required>
            </div>
            <div class="col-md-4">
                <label for="jumlah" class="form-label fw-semibold">Jumlah </label>
                <input type="number" class="form-control border-secondary" id="jumlah" name="jumlah" min="1" required>
            </div>
            <div class="col-md-4">
                <label for="sn" class="form-label fw-semibold">Serial No(SN)</label>
                <input type="text" class="form-control border-secondary" id="sn" name="sn" required>
            </div>
            <div class="col-md-4">
                <label for="lokasi" class="form-label fw-semibold">Lokasi</label>
                <input type="text" class="form-control border-secondary" id="lokasi" name="lokasi" required>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
                                                <th>Tipe</th>
                                                <th>Merk</th>
                                                <th>Ukuran</th>
                                                <th>Jumlah</th>
                                                <th>Serial No</th>
                                                <th>Lokasi</th>
                                                <th>Dibuat Pada</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($inventaryprojek as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->pn }}</td>
                                                <td>{{ $item->nama_barang }}</td>
                                                <td>{{ $item->jenis }}</td>
                                                <td class="text-wrap">{{ $item->tipe }}</td>
                                                <td>{{ $item->merk }}</td>
                                                <td>{{ $item->ukuran }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>{{ $item->sn }}</td>
                                                <td>{{ $item->lokasi }}</td>
                                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <!-- Tombol Edit (buka modal) -->
                                                    <button type="button" class="btn btn-sm btn-warning me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </button>

                                                    <!-- Form Hapus -->
                                                    <form action="{{ route('projek.hapus', $item->id) }}" method="POST"
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
                                                        aria-labelledby="editModalLabel{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <form action="{{ route('projek.update', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="editModalLabel{{ $item->id }}">Edit
                                                                            Inventaris</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="pn{{ $item->id }}"
                                                                                class="form-label">Produk No(PN)</label>
                                                                            <input type="text" name="pn"
                                                                                class="form-control"
                                                                                id="pn{{ $item->id }}"
                                                                                value="{{ $item->pn }}"
                                                                                required>
                                                                        </div>

                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="nama_barang{{ $item->id }}"
                                                                                class="form-label">Nama Barang</label>
                                                                            <input type="text" name="nama_barang"
                                                                                class="form-control"
                                                                                id="nama_barang{{ $item->id }}"
                                                                                value="{{ $item->nama_barang }}"
                                                                                required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="jenis{{ $item->id }}"
                                                                                class="form-label">Jenis</label>
                                                                            <input type="text" name="jenis"
                                                                                class="form-control"
                                                                                id="jenis{{ $item->id }}"
                                                                                value="{{ $item->jenis }}" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="tipe{{ $item->id }}"
                                                                                class="form-label">tipe</label>
                                                                            <input type="text" name="tipe"
                                                                                class="form-control"
                                                                                id="tipe{{ $item->id }}"
                                                                                value="{{ $item->tipe }}" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="merk{{ $item->id }}"
                                                                                class="form-label">merk</label>
                                                                            <input type="text" name="merk"
                                                                                class="form-control"
                                                                                id="merk{{ $item->id }}"
                                                                                value="{{ $item->merk }}" required>
                                                                        </div>
                                                                        
                                                                        <div class="mb-3">
                                                                            <label for="ukuran{{ $item->id }}"
                                                                                class="form-label">ukuran</label>
                                                                            <input type="text" name="ukuran"
                                                                                class="form-control"
                                                                                id="ukuran{{ $item->id }}"
                                                                                value="{{ $item->ukuran }}" required>
                                                                        </div>

                                                                      

                                                                        <div class="mb-3">
                                                                            <label for="jumlah{{ $item->id }}"
                                                                                class="form-label">Jumlah</label>
                                                                            <input type="text" name="jumlah"
                                                                                class="form-control"
                                                                                id="jumlah{{ $item->id }}"
                                                                                value="{{ $item->jumlah }}">
                                                                        </div>
                                                                        
                                                                        <div class="mb-3">
                                                                            <label for="sn{{ $item->id }}"
                                                                                class="form-label">Serial No(SN)</label>
                                                                            <input type="text" name="sn"
                                                                                class="form-control"
                                                                                id="sn{{ $item->id }}"
                                                                                value="{{ $item->sn }}" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="lokasi{{ $item->id }}"
                                                                                class="form-label">Lokasi</label>
                                                                            <input type="text" name="lokasi"
                                                                                class="form-control"
                                                                                id="lokasi{{ $item->id }}"
                                                                                value="{{ $item->lokasi }}" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan
                                                                            Perubahan</button>
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
    let projekData = @json($inventaryprojek);

    // Saat pilih Nama Barang
    $('#nama_barang').on('change', function() {
        let selectedBarang = $(this).val();
        if (selectedBarang) {
            let filtered = projekData.filter(item => item.nama_barang === selectedBarang);

            // Jenis unik
            let uniqueJenis = [...new Set(filtered.map(item => item.jenis).filter(Boolean))];
            $('#jenis').empty().append('<option value="">-- Pilih Jenis --</option>');
            uniqueJenis.forEach(j => $('#jenis').append(`<option value="${j}">${j}</option>`));

            $('#jenisGroup').removeClass('d-none');
            $('#tipeGroup, #merkGroup, #ukuranGroup').removeClass('d-none');
        } else {
            $('#jenisGroup, #tipeGroup, #merkGroup, #ukuranGroup').removeClass('d-none');
        }
    });

    // Saat pilih Jenis
    $('#jenis').on('change', function() {
        let barang = $('#nama_barang').val();
        let jenis = $(this).val();
        if (jenis) {
            let filtered = projekData.filter(item =>
                item.nama_barang === barang && item.jenis === jenis
            );

            // Tipe unik
            let uniqueTipe = [...new Set(filtered.map(item => item.tipe).filter(Boolean))];
            $('#tipe').empty().append('<option value="">-- Pilih Tipe --</option>');
            uniqueTipe.forEach(t => $('#tipe').append(`<option value="${t}">${t}</option>`));

            $('#tipeGroup').removeClass('d-none');
            $('#merkGroup, #ukuranGroup').removeClass('d-none');
        } else {
            $('#tipeGroup, #merkGroup, #ukuranGroup').removeClass('d-none');
        }
    });

    // Saat pilih Tipe
    $('#tipe').on('change', function() {
        let barang = $('#nama_barang').val();
        let jenis = $('#jenis').val();
        let tipe = $(this).val();
        if (tipe) {
            let filtered = projekData.filter(item =>
                item.nama_barang === barang &&
                item.jenis === jenis &&
                item.tipe === tipe
            );

            // Merk unik
            let uniqueMerk = [...new Set(filtered.map(item => item.merk).filter(Boolean))];
            $('#merk').empty().append('<option value="">-- Pilih Merk --</option>');
            uniqueMerk.forEach(m => $('#merk').append(`<option value="${m}">${m}</option>`));

            $('#merkGroup').removeClass('d-none');
            $('#ukuranGroup').removeClass('d-none');
        } else {
            $('#merkGroup, #ukuranGroup').removeClass('d-none');
        }
    });

    // Saat pilih Merk
    $('#merk').on('change', function() {
        let barang = $('#nama_barang').val();
        let jenis = $('#jenis').val();
        let tipe = $('#tipe').val();
        let merk = $(this).val();
        if (merk) {
            let filtered = projekData.filter(item =>
                item.nama_barang === barang &&
                item.jenis === jenis &&
                item.tipe === tipe &&
                item.merk === merk
            );

            // Ukuran unik
            let uniqueUkuran = [...new Set(filtered.map(item => item.ukuran).filter(Boolean))];
            $('#ukuran').empty().append('<option value="">-- Pilih Ukuran --</option>');
            uniqueUkuran.forEach(u => $('#ukuran').append(`<option value="${u}">${u}</option>`));

            $('#ukuranGroup').removeClass('d-none');
        } else {
            $('#ukuranGroup').removeClass('d-none');
        }
    });
    // Fitur Search
    function searchTable() {
        let value = $('#searchInput').val().toLowerCase();
        $('#dataTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    }

    // Jalankan pencarian saat mengetik
    $('#searchInput').on('keyup', function(e) {
        if (e.key !== 'Enter') {
            searchTable();
        }
    });

    // Jalankan pencarian saat tekan Enter
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            searchTable();
        }
    });
});
</script>


