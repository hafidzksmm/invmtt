<x-app-layout>
@php
    // ✅ true untuk admin ATAU superadmin — dipakai di semua tombol CRUD di halaman ini
    $canManage = auth()->check() && (isAdmin() || auth()->user()->role === 'superadmin');
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <x-app.navbar />

    <div class="container-fluid py-4 px-5">

        {{-- ================= HEADER ================= --}}
        <div class="dash-header mt-4 mb-4">
            <div class="dash-brand">
                <div class="dash-greeting">
                    <div class="greeting-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:26px;height:26px;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/><line x1="9" y1="11" x2="15" y2="11"/>
                        </svg>
                    </div>
                    <div class="greeting-text">
                        <span class="greeting-hello">
                            Manajemen DO & BAST
                            <span class="badge bg-dark ms-2">{{ $year }}</span>
                        </span>
                        <span class="greeting-role">Data Delivery Order & BAST Project</span>
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

        {{-- ================= TABLE ================= --}}
        <div class="row">
            <div class="col-12">
                <div class="card border shadow-xs mb-4">

<div class="d-flex justify-content-between align-items-center p-3">

    {{-- GLOBAL SEARCH --}}
    <div style="width:300px;">
        <input type="text"
               id="globalFilter"
               class="form-control"
               placeholder="Cari data...">
    </div>

    {{-- ✅ TOMBOL TAMBAH - ADMIN & SUPERADMIN --}}
    @if($canManage)
    <button class="btn text-white fw-semibold shadow-sm px-4 py-2"
        style="background: linear-gradient(90deg,#2ecc71,#27ae60); border:none;"
        data-bs-toggle="modal"
        data-bs-target="#addDoModal">
        <i class="bi bi-plus-lg me-2"></i> Tambah Project
    </button>
    @else
    <span class="badge bg-warning text-dark">Serial No</span>
    @endif

</div>


                    <div class="card-body px-0 py-0">
                        <div class="table-responsive p-3">
                            <table class="table table-hover align-items-center text-center mb-0">

                                <thead class="bg-gray-100">
                                    <tr>
                                        <th rowspan="0"></th>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Project</th>
                                        <th rowspan="2">Vendor</th>
                                        <th rowspan="2">Tanggal <br>DO</th>
                                        <th rowspan="2">Nomor <br>DO</th>


                                    </tr>
                                    <tr>
                                        <th>DO <br>Disti</th>
                                        <th>Tanda <br>Terima</th>
                                        <th>DO <br>Client</th>
                                        <th>Foto <br>Delivery</th>

                                        <th>Tanggal <br>BAST</th>
                                        <th>BAST</th>
                                        <th>Foto <br>Instalasi</th>
                                        <th rowspan="2">Upload <br>File</th>
                                        <th rowspan="2">Delete</th>
                                    </tr>
                                </thead>

                                <tbody id="sortableTable">

                                @forelse($inventarydo as $i => $item)
                                    <tr data-id="{{ $item->id }}">
                                            {{-- DRAG HANDLE --}}
                                        <td class="text-center">
                                            <span class="drag-handle" style="cursor:grab; color:#999;">
                                                ⋮⋮
                                            </span>
                                        </td>
                                        <td>{{ $i+1 }}</td>
                                        <td style="max-width:220px; white-space:normal; word-break:break-word; text-align:left; vertical-align:top;">
                                            {{ $item->project }}
                                        </td>

                                        <td style="max-width:200px; white-space:normal; word-break:break-word; text-align:left; vertical-align:top;">
                                            {{ $item->vendor }}
                                        </td>
                                        <td>
                                            {{ $item->tanggal_do 
                                                ? \Carbon\Carbon::parse($item->tanggal_do)->format('d M Y') 
                                                : '-' 
                                            }}
                                        </td>
                                        <td>{{ $item->nomor_do ?? '-' }}</td>

                                        {{-- DO DISTI (multiple file, sama seperti Tanda Terima) --}}
                                        <td>
                                        @php $doDisti = $item->files->where('type','pdf_do_disti'); @endphp

                                        @if($doDisti->count())

                                            <span class="text-success fw-bold"
                                                style="cursor:pointer;font-size:18px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#pdfDoDisti{{ $item->id }}">
                                                ✅ {{ $doDisti->count() }}
                                            </span>


                                        @else
                                            ➖
                                        @endif
                                        </td>

                                        {{-- TANDA TERIMA --}}
                                        <td>
                                        @php $tt = $item->files->where('type','pdf_tanda_terima'); @endphp

                                        @if($tt->count())

                                            <span class="text-success fw-bold"
                                                style="cursor:pointer;font-size:18px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#pdfTandaTerima{{ $item->id }}">
                                                ✅ {{ $tt->count() }}
                                            </span>


                                        @else
                                            ➖
                                        @endif
                                        </td>
                                        {{-- PDF DO CLIENT --}}
                                        <td>
                                            @if($pdf = $item->files->where('type','pdf_do')->first())

                                                <span class="text-success fw-bold d-block"
                                                    style="cursor:pointer;font-size:20px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#pdfModal"
                                                    onclick="previewPDF('{{ asset('storage/'.$pdf->file_path) }}')">
                                                    ✅
                                                </span>


                                            @else
                                                ➖
                                            @endif
                                        </td>

                                        {{-- FOTO DO --}}
                                        <td>
                                            @php $fotoDo = $item->files->where('type','foto_do'); @endphp
                                            @if($fotoDo->count())
                                                <span class="text-success fw-bold d-block"
                                                    style="cursor:pointer;font-size:20px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#fotoDo{{ $item->id }}">
                                                    ✅
                                                </span>
                                            @else
                                                ➖
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->tanggal_bast 
                                                ? \Carbon\Carbon::parse($item->tanggal_bast)->format('d M Y') 
                                                : '-' 
                                            }}
                                        </td>
                                        {{-- PDF BAST --}}
                                        <td>
                                            @if($pdf = $item->files->where('type','pdf_bast')->first())

                                                <span class="text-success fw-bold d-block"
                                                    style="cursor:pointer;font-size:20px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#pdfModal"
                                                    onclick="previewPDF('{{ asset('storage/'.$pdf->file_path) }}')">
                                                    ✅
                                                </span>


                                            @else
                                                ➖
                                            @endif
                                        </td>

                                        {{-- FOTO BAST --}}
                                        <td>
                                            @php $fotoBast = $item->files->where('type','foto_bast'); @endphp
                                            @if($fotoBast->count())
                                                <span class="text-success fw-bold d-block"
                                                    style="cursor:pointer;font-size:20px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#fotoBast{{ $item->id }}">
                                                    ✅
                                                </span>
                                            @else
                                                ➖
                                            @endif
                                        </td>

                                        {{-- UPLOAD - ADMIN & SUPERADMIN --}}
                                        <td>
                                            @if($canManage)
                                                <button class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $item->id }}">
                                                    Upload
                                                </button>
                                            @else
                                                ➖
                                            @endif
                                        </td>

                                        {{-- DELETE - ADMIN & SUPERADMIN --}}
                                        <td>
                                            @if($canManage)
                                                <form method="POST"
                                                      action="{{ route('do.destroy',$item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Hapus data?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                ➖
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-muted py-4">
                                            Belum ada data
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
</main>

{{-- ================= MODAL TAMBAH DO ================= --}}
<div class="modal fade" id="addDoModal">
    <div class="modal-dialog">
    <form method="POST"
        action="{{ route('do.store', $year) }}"
        class="modal-content">
        @csrf

        <input type="hidden" name="year" value="{{ $year }}">

        <div class="modal-header bg-success text-white">
            <h5>Tambah Project ({{ $year }})</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <label>Project</label>
            <input type="text" name="project"
                class="form-control mb-3" required>

            <label>Vendor</label>
            <input type="text" name="vendor"
                class="form-control" required>
        </div>

        <div class="modal-footer">
            <button class="btn btn-success">Simpan</button>
        </div>
    </form>
    </div>
</div>

{{-- ================= MODAL UPLOAD ================= --}}
@foreach($inventarydo as $item)
<div class="modal fade" id="uploadModal{{ $item->id }}">
    <div class="modal-dialog">
        <form method="POST"
              action="{{ route('inventory-do.upload',$item->id) }}"
              enctype="multipart/form-data"
              class="modal-content">
            @csrf

            <div class="modal-header bg-primary text-white">
                <h5>Upload File</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

<div class="mb-3">
    <label>Tanggal DO</label>
    <input type="date"
           name="tanggal_do"
           class="form-control"
           value="{{ $item->tanggal_do ? \Carbon\Carbon::parse($item->tanggal_do)->format('Y-m-d') : '' }}">
</div>

<div class="mb-3">
    <label>Nomor DO</label>
    <input type="text"
           name="nomor_do"
           class="form-control"
           value="{{ $item->nomor_do ?? '' }}">
</div>

<div class="mb-3">
    <label>Tanggal BAST</label>
    <input type="date"
           name="tanggal_bast"
           class="form-control"
           value="{{ $item->tanggal_bast ? \Carbon\Carbon::parse($item->tanggal_bast)->format('Y-m-d') : '' }}">
</div>

                <select name="type"
                        class="form-select mb-3 file-type"
                        >
                    <option value="">-- Pilih File --</option>
                    <option value="pdf_do_disti">DO Disti</option>
                    <option value="pdf_tanda_terima">Tanda Terima</option>
                    <option value="pdf_do">DO Client</option>
                    <option value="foto_do">Foto Delivery</option>
                    <option value="pdf_bast">BAST</option>
                    <option value="foto_bast">Foto Instalasi</option>
                </select>

                <div class="file-wrapper">
                    <div class="input-group mb-2 file-row">
                        <input type="file"
                               name="file[]"
                               class="form-control"
                               >
                        <button type="button"
                                class="btn btn-success btn-add-file"
                                style="display:none">
                            ➕
                        </button>
                    </div>
                </div>
            <small class="text-danger">
                Maksimal ukuran file 2MB
            </small>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Upload</button>
            </div>

        </form>
    </div>
</div>
@endforeach

{{-- ================= MODAL FOTO DO ================= --}}
@foreach($inventarydo as $item)
<div class="modal fade" id="fotoDo{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body">

                @php
                    $photos = $item->files->where('type','foto_do');
                @endphp

                @if($photos->count())

                {{-- MAIN IMAGE --}}
                <div class="d-flex justify-content-center mb-4 position-relative">
                    <a id="downloadDo{{ $item->id }}"
                       href="{{ asset('storage/'.$photos->first()->file_path) }}"
                       download
                       class="btn btn-sm btn-light position-absolute top-0 end-0 m-2">
                        ⬇ Unduh
                    </a>

                    <img id="mainDo{{ $item->id }}"
                         src="{{ asset('storage/'.$photos->first()->file_path) }}"
                         style="width:900px;height:520px;object-fit:contain;border-radius:12px;">
                </div>

                {{-- THUMBNAILS --}}
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @foreach($photos as $f)
                    <div class="position-relative">

                        {{-- DELETE BUTTON --}}
                        <form action="{{ route('inventory-do.file.delete', $f->id) }}"
                            method="POST"
                            class="delete-file-form position-absolute"
                            style="top:-8px; right:-8px; z-index:10;">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="btn btn-danger btn-sm rounded-circle btn-delete-file"
                                    data-id="{{ $f->id }}"
                                    style="width:24px;height:24px;padding:0;">
                                ×
                            </button>
                        </form>


                        {{-- THUMB IMAGE --}}
                        <img src="{{ asset('storage/'.$f->file_path) }}"
                             class="thumb {{ $loop->first ? 'active' : '' }}"
                             style="width:100px;height:70px;object-fit:cover;cursor:pointer;border-radius:6px;border:2px solid transparent;"
                             onclick="
                                document.getElementById('mainDo{{ $item->id }}').src='{{ asset('storage/'.$f->file_path) }}';
                                document.getElementById('downloadDo{{ $item->id }}').href='{{ asset('storage/'.$f->file_path) }}';

                                document.querySelectorAll('#fotoDo{{ $item->id }} .thumb')
                                    .forEach(el => el.classList.remove('active'));
                                this.classList.add('active');
                             ">
                    </div>
                    @endforeach
                </div>

                @else
                    <p class="text-center text-light">Tidak ada foto </p>
                @endif

            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ================= MODAL FOTO BAST ================= --}}
@foreach($inventarydo as $item)
<div class="modal fade" id="fotoBast{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body">

                @php
                    $photos = $item->files->where('type','foto_bast');
                @endphp

                @if($photos->count())

                {{-- MAIN IMAGE --}}
                <div class="d-flex justify-content-center mb-4 position-relative">
                    <a id="downloadBast{{ $item->id }}"
                       href="{{ asset('storage/'.$photos->first()->file_path) }}"
                       download
                       class="btn btn-sm btn-light position-absolute top-0 end-0 m-2">
                        ⬇ Unduh
                    </a>

                    <img id="mainBast{{ $item->id }}"
                         src="{{ asset('storage/'.$photos->first()->file_path) }}"
                         style="width:900px;height:520px;object-fit:contain;border-radius:12px;">
                </div>

                {{-- THUMBNAILS --}}
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @foreach($photos as $f)
                    <div class="position-relative">

                        {{-- DELETE BUTTON --}}
                        <form action="{{ route('inventory-do.file.delete', $f->id) }}"
                            method="POST"
                            class="delete-file-form position-absolute"
                            style="top:-8px; right:-8px; z-index:10;">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="btn btn-danger btn-sm rounded-circle btn-delete-file"
                                    data-id="{{ $f->id }}"
                                    style="width:24px;height:24px;padding:0;">
                                ×
                            </button>
                        </form>

                        {{-- THUMB IMAGE --}}
                        <img src="{{ asset('storage/'.$f->file_path) }}"
                             class="thumb {{ $loop->first ? 'active' : '' }}"
                             style="width:100px;height:70px;object-fit:cover;cursor:pointer;border-radius:6px;border:2px solid transparent;"
                             onclick="
                                document.getElementById('mainBast{{ $item->id }}').src='{{ asset('storage/'.$f->file_path) }}';
                                document.getElementById('downloadBast{{ $item->id }}').href='{{ asset('storage/'.$f->file_path) }}';

                                document.querySelectorAll('#fotoBast{{ $item->id }} .thumb')
                                    .forEach(el => el.classList.remove('active'));
                                this.classList.add('active');
                             ">
                    </div>
                    @endforeach
                </div>

                @else
                    <p class="text-center text-light">Tidak ada foto </p>
                @endif

            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ================= MODAL PDF ================= --}}
<div class="modal fade" id="pdfModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body p-0">
                <iframe id="pdfFrame"
                        src=""
                        width="100%"
                        height="650px"
                        style="border:none;">
                </iframe>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL PDF DO DISTI (multiple file) ================= --}}
@foreach($inventarydo as $item)
<div class="modal fade" id="pdfDoDisti{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">PDF DO Disti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @php
                    $pdfDoDisti = $item->files->where('type', 'pdf_do_disti');
                @endphp

                @if($pdfDoDisti->count() > 0)

                    <ul class="list-group">
                        @foreach($pdfDoDisti as $index => $pdf)
                            <li class="list-group-item d-flex justify-content-between align-items-center">

                                <div>
                                    <strong>📄 PDF DO Disti {{ $index + 1 }}</strong>


                                <div class="d-flex gap-2">
                                    <button type="button"
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pdfModal"
                                        onclick="previewPDF('{{ asset('storage/'.$pdf->file_path) }}')">
                                        Preview
                                    </button>

                                    <a href="{{ asset('storage/'.$pdf->file_path) }}"
                                       download
                                       class="btn btn-sm btn-success">
                                       Download
                                    </a>
                                </div>

                            </li>
                        @endforeach
                    </ul>

                @else
                    <p class="text-center text-muted mb-0">
                        Tidak ada PDF DO Disti
                    </p>
                @endif

            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ================= MODAL PDF TANDA TERIMA ================= --}}
@foreach($inventarydo as $item)
<div class="modal fade" id="pdfTandaTerima{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">PDF Tanda Terima</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @php
                    $pdfTandaTerima = $item->files->where('type', 'pdf_tanda_terima');
                @endphp

                @if($pdfTandaTerima->count() > 0)

                    <ul class="list-group">
                        @foreach($pdfTandaTerima as $index => $pdf)
                            <li class="list-group-item d-flex justify-content-between align-items-center">

                                <div>
                                    <strong>📄 PDF Tanda Terima {{ $index + 1 }}</strong>


                                <div class="d-flex gap-2">
                                    <button type="button"
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pdfModal"
                                        onclick="previewPDF('{{ asset('storage/'.$pdf->file_path) }}')">
                                        Preview
                                    </button>

                                    <a href="{{ asset('storage/'.$pdf->file_path) }}"
                                       download
                                       class="btn btn-sm btn-success">
                                       Download
                                    </a>
                                </div>

                            </li>
                        @endforeach
                    </ul>

                @else
                    <p class="text-center text-muted mb-0">
                        Tidak ada PDF Tanda Terima
                    </p>
                @endif

            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ================= SCRIPT NOTE PDF ================= --}}
<script>
document.querySelectorAll('.file-type').forEach(select => {

    select.addEventListener('change', function () {

        const modal = this.closest('.modal');
        const wrapper = modal.querySelector('.file-wrapper');
        const addBtn = modal.querySelector('.btn-add-file');

        // ================= RESET TAMBAHAN FIELD =================
        wrapper.querySelectorAll('.file-row').forEach((row, i) => {
            if (i > 0) row.remove();
        });

        // kosongkan input pertama
        const firstInput = wrapper.querySelector('.file-row input');
        if (firstInput) firstInput.value = '';

        // ================= LOGIC TYPE =================
if (this.value === 'pdf_tanda_terima' || this.value === 'pdf_do_disti') {


    if (addBtn) addBtn.style.display = 'block';

} else if (this.value.includes('foto')) {


    if (addBtn) addBtn.style.display = 'block';

} else {

    // PDF DO Client & PDF BAST → single only

    if (addBtn) addBtn.style.display = 'none';
}

    });
});


// ================= TAMBAH FILE =================
document.addEventListener('click', function (e) {

    if (e.target.classList.contains('btn-add-file')) {

        const wrapper = e.target.closest('.file-wrapper');

        const row = document.createElement('div');
        row.className = 'input-group mb-2 file-row';
        row.innerHTML = `
            <input type="file" name="file[]" class="form-control" required>
            <button type="button" class="btn btn-danger btn-remove-file">❌</button>
        `;

        wrapper.appendChild(row);
    }

    if (e.target.classList.contains('btn-remove-file')) {
        e.target.closest('.file-row').remove();
    }
});


// ================= GLOBAL SEARCH =================
document.getElementById('globalFilter').addEventListener('keyup', function () {

    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll('#sortableTable tr');

    rows.forEach(row => {

        const rowText = row.innerText.toLowerCase();

        if (rowText.includes(value)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});


// ================= PREVIEW PDF =================
function previewPDF(url) {
    document.getElementById('pdfFrame').src = url;
}

$(function () {

    $("#sortableTable").sortable({
        handle: ".drag-handle", // 🔥 hanya bisa drag dari sini
        placeholder: "sortable-placeholder",
        update: function () {

            let order = [];

            $("#sortableTable tr").each(function (index) {
                order.push({
                    id: $(this).data("id"),
                    position: index + 1
                });
            });

            $.ajax({
                url: "{{ route('inventory-do.reorder') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order: order
                },
                success: function () {
                    location.reload();
                }
            });
        }
    });

});
document.addEventListener("change", function (e) {

    if (e.target.classList.contains("file-input")) {

        let maxSize = 2 * 1024 * 1024; // 2MB

        for (let file of e.target.files) {

            if (file.size > maxSize) {

                alert("Ukuran file maksimal 2MB!");

                e.target.value = ""; // reset input
                return;
            }
        }
    }
});
document.addEventListener("click", function (e) {

    if (e.target.classList.contains("btn-delete-file")) {

        if (!confirm("Hapus foto ini?")) return;

        let button = e.target;
        let form = button.closest("form");
        let url = form.action;

        let thumbnailWrapper = button.closest(".position-relative");
        let thumbImg = thumbnailWrapper.querySelector("img");
        let deletedSrc = thumbImg ? thumbImg.src : null;

        let modal = button.closest(".modal");
        let mainImage = modal.querySelector("img[id^='mainBast']");
        let downloadBtn = modal.querySelector("a[id^='downloadBast']");

        fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: new URLSearchParams({
                _method: "DELETE"
            })
        })
        .then(response => response.json())
        .then(data => {

            // 🔥 Jika gambar yang dihapus sedang aktif
            if (mainImage && deletedSrc && mainImage.src === deletedSrc) {

                let otherThumb = modal.querySelector(
                    ".thumb:not([src='" + deletedSrc + "'])"
                );

                if (otherThumb) {
                    mainImage.src = otherThumb.src;
                    downloadBtn.href = otherThumb.src;

                    modal.querySelectorAll(".thumb")
                        .forEach(el => el.classList.remove("active"));
                    otherThumb.classList.add("active");

                } else {
                    // Kalau tidak ada foto tersisa
                    mainImage.remove();
                    downloadBtn.remove();

                    modal.querySelector(".modal-body")
                        .innerHTML = '<p class="text-center text-light">Tidak ada foto Silahkan upload</p>';
                }
            }

            thumbnailWrapper.remove();
        })
        .catch(error => {
            alert("Gagal menghapus file");
        });
    }
});
</script>
<style>
.sortable-placeholder {
    height: 60px;
    background: #f0f8ff;
    border: 2px dashed #0d6efd;
}

.drag-handle {
    font-size: 18px;
    user-select: none;
}

.drag-handle:active {
    cursor: grabbing;
}

.thumb {
    opacity: 0.6;
    transition: 0.2s ease;
}

.thumb:hover {
    opacity: 1;
    transform: scale(1.05);
}

.thumb.active {
    opacity: 1;
    transform: scale(1.05);
    border: 2px solid #0d6efd !important;
}

/* ================= HEADER STYLE (tema sama seperti Aset Jual) ================= */
:root{
    --header-bg: #FFFFFF;
    --header-border: #ECECEC;
    --header-red: #E11D2E;
    --header-red-dark: #B0121F;
    --header-red-light: #FBD3D9;
    --header-text: #17181A;
    --header-muted: #8A8F98;
    --header-shadow: 0 1px 2px rgba(16,16,16,0.04), 0 8px 24px rgba(16,16,16,0.04);
}

.dash-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:16px;
}
.dash-brand{ display:flex; align-items:center; gap:14px; }
.dash-greeting{ display:flex; align-items:center; gap:14px; }
.greeting-avatar{
    width:52px; height:52px;
    border-radius:16px;
    background:var(--header-red);
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
    color:var(--header-text);
    letter-spacing:-0.4px;
}
.greeting-role{ font-size:13.5px; color:var(--header-muted); }

.dash-actions{ display:flex; align-items:center; gap:12px; }

.btn-icon-nav{
    display:flex; align-items:center; gap:8px;
    background:var(--header-bg);
    border:1px solid var(--header-border);
    padding:12px 20px;
    border-radius:999px;
    font-size:14px;
    font-weight:600;
    color:var(--header-text);
    text-decoration:none;
    cursor:pointer;
    box-shadow:var(--header-shadow);
    transition:.15s ease;
}
.btn-icon-nav svg{ width:16px; height:16px; stroke:var(--header-red); }
.btn-icon-nav:hover{ background:var(--header-red-light); border-color:var(--header-red); color:var(--header-red-dark); }
.btn-icon-nav:hover svg{ stroke:var(--header-red-dark); }

@media (max-width: 640px){
    .greeting-hello{ font-size:18px; }
    .btn-icon-nav span{ display:none; }
    .btn-icon-nav{ padding:12px; }
}
</style>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</x-app-layout>