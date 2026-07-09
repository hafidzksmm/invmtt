<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />

        <div class="container-fluid py-4 px-5">

            {{-- ================= HEADER ================= --}}
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-4">
                        <div class="full-background"
                            style="background-image: url('../assets/img/header-blue-purple.jpg')"></div>

                        <div class="card-body text-start p-4 w-100">
                            <h3 class="text-white mb-2">
                                MANAJEMEN DO & BAST
                                <span class="badge bg-dark ms-2">{{ $year }}</span>
                            </h3>
                            <p class="mb-0 font-weight-semibold">
                                Data Delivery Order & BAST Project
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">

                        <div class="d-flex justify-content-between align-items-center p-3">

                            {{-- GLOBAL SEARCH --}}
                            <div style="width:300px;">
                                <input type="text" id="globalFilter" class="form-control" placeholder="Cari data...">
                            </div>

                            {{-- ✅ TOMBOL TAMBAH - ONLY ADMIN --}}
                            @if(isAdmin())
                                <button class="btn text-white fw-semibold shadow-sm px-4 py-2"
                                    style="background: linear-gradient(90deg,#2ecc71,#27ae60); border:none;"
                                    data-bs-toggle="modal" data-bs-target="#addDoModal">
                                    <i class="bi bi-plus-lg me-2"></i> Tambah Project
                                </button>
                            @else
                                <span class="badge bg-warning text-dark">Hanya Admin dapat menambah data</span>
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
                                            <th>Tanda <br>Terima</th>
                                            <th>DO</th>
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
                                                                                <td>{{ $i + 1 }}</td>
                                                                                <td
                                                                                    style="max-width:220px; white-space:normal; word-break:break-word; text-align:left; vertical-align:top;">
                                                                                    {{ $item->project }}
                                                                                </td>

                                                                                <td
                                                                                    style="max-width:200px; white-space:normal; word-break:break-word; text-align:left; vertical-align:top;">
                                                                                    {{ $item->vendor }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $item->tanggal_do
                                            ? \Carbon\Carbon::parse($item->tanggal_do)->format('d M Y')
                                            : '-' 
                                                                                }}
                                                                                </td>
                                                                                <td>{{ $item->nomor_do ?? '-' }}</td>

                                                                                {{-- TANDA TERIMA --}}
                                                                                <td>
                                                                                    @php $tt = $item->files->where('type', 'pdf_tanda_terima'); @endphp

                                                                                    @if($tt->count())

                                                                                        <span class="text-success fw-bold"
                                                                                            style="cursor:pointer;font-size:18px;" data-bs-toggle="modal"
                                                                                            data-bs-target="#pdfTandaTerima{{ $item->id }}">
                                                                                            ✅ {{ $tt->count() }}
                                                                                        </span>


                                                                                    @else
                                                                                        ➖
                                                                                    @endif
                                                                                </td>
                                                                                {{-- PDF DO --}}
                                                                                <td>
                                                                                    @if($pdf = $item->files->where('type', 'pdf_do')->first())

                                                                                        <span class="text-success fw-bold d-block"
                                                                                            style="cursor:pointer;font-size:20px;" data-bs-toggle="modal"
                                                                                            data-bs-target="#pdfModal"
                                                                                            onclick="previewPDF('{{ asset('storage/' . $pdf->file_path) }}')">
                                                                                            ✅
                                                                                        </span>


                                                                                    @else
                                                                                        ➖
                                                                                    @endif
                                                                                </td>

                                                                                {{-- FOTO DO --}}
                                                                                <td>
                                                                                    @php $fotoDo = $item->files->where('type', 'foto_do'); @endphp
                                                                                    @if($fotoDo->count())
                                                                                        <span class="text-success fw-bold d-block"
                                                                                            style="cursor:pointer;font-size:20px;" data-bs-toggle="modal"
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
                                                                                    @if($pdf = $item->files->where('type', 'pdf_bast')->first())

                                                                                        <span class="text-success fw-bold d-block"
                                                                                            style="cursor:pointer;font-size:20px;" data-bs-toggle="modal"
                                                                                            data-bs-target="#pdfModal"
                                                                                            onclick="previewPDF('{{ asset('storage/' . $pdf->file_path) }}')">
                                                                                            ✅
                                                                                        </span>


                                                                                    @else
                                                                                        ➖
                                                                                    @endif
                                                                                </td>

                                                                                {{-- FOTO BAST --}}
                                                                                <td>
                                                                                    @php $fotoBast = $item->files->where('type', 'foto_bast'); @endphp
                                                                                    @if($fotoBast->count())
                                                                                        <span class="text-success fw-bold d-block"
                                                                                            style="cursor:pointer;font-size:20px;" data-bs-toggle="modal"
                                                                                            data-bs-target="#fotoBast{{ $item->id }}">
                                                                                            ✅
                                                                                        </span>
                                                                                    @else
                                                                                        ➖
                                                                                    @endif
                                                                                </td>

                                                                                {{-- UPLOAD & DELETE --}}
                                                                                @if(isAdmin())
                                                                                    <td>
                                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                                            data-bs-target="#uploadModal{{ $item->id }}">
                                                                                            Upload
                                                                                        </button>
                                                                                    </td>

                                                                                    {{-- DELETE --}}
                                                                                    <td>
                                                                                        <form method="POST" action="{{ route('do.destroy', $item->id) }}">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button class="btn btn-sm btn-danger"
                                                                                                onclick="return confirm('Hapus data?')">
                                                                                                Delete
                                                                                            </button>
                                                                                        </form>
                                                                                    </td>
                                                                                @else
                                                                                    <td colspan="2"><span class="text-muted text-sm">Tidak ada akses</span></td>
                                                                                @endif
                                                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-muted py-4">
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
            <form method="POST" action="{{ route('do.store', $year) }}" class="modal-content">
                @csrf

                <input type="hidden" name="year" value="{{ $year }}">

                <div class="modal-header bg-success text-white">
                    <h5>Tambah Project ({{ $year }})</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Project</label>
                    <input type="text" name="project" class="form-control mb-3" required>

                    <label>Vendor</label>
                    <input type="text" name="vendor" class="form-control" required>
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
                <form method="POST" action="{{ route('inventory-do.upload', $item->id) }}" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5>Upload File</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Tanggal DO</label>
                            <input type="date" name="tanggal_do" class="form-control"
                                value="{{ $item->tanggal_do ? \Carbon\Carbon::parse($item->tanggal_do)->format('Y-m-d') : '' }}">
                        </div>

                        <div class="mb-3">
                            <label>Nomor DO</label>
                            <input type="text" name="nomor_do" class="form-control" value="{{ $item->nomor_do ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label>Tanggal BAST</label>
                            <input type="date" name="tanggal_bast" class="form-control"
                                value="{{ $item->tanggal_bast ? \Carbon\Carbon::parse($item->tanggal_bast)->format('Y-m-d') : '' }}">
                        </div>

                        <select name="type" class="form-select mb-3 file-type">
                            <option value="">-- Pilih File --</option>
                            <option value="pdf_tanda_terima">Tanda Terima</option>
                            <option value="pdf_do">DO</option>
                            <option value="foto_do">Foto Delivery</option>
                            <option value="pdf_bast">BAST</option>
                            <option value="foto_bast">Foto Instalasi</option>
                        </select>

                        <div class="file-wrapper">
                            <div class="input-group mb-2 file-row">
                                <input type="file" name="file[]" class="form-control">
                                <button type="button" class="btn btn-success btn-add-file" style="display:none">
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
                            $photos = $item->files->where('type', 'foto_do');
                        @endphp

                        @if($photos->count())

                            {{-- MAIN IMAGE --}}
                            <div class="d-flex justify-content-center mb-4 position-relative">
                                <a id="downloadDo{{ $item->id }}" href="{{ asset('storage/' . $photos->first()->file_path) }}"
                                    download class="btn btn-sm btn-light position-absolute top-0 end-0 m-2">
                                    ⬇ Unduh
                                </a>

                                <img id="mainDo{{ $item->id }}" src="{{ asset('storage/' . $photos->first()->file_path) }}"
                                    style="width:900px;height:520px;object-fit:contain;border-radius:12px;">
                            </div>

                            {{-- THUMBNAILS --}}
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                @foreach($photos as $f)
                                    <div class="position-relative">

                                        {{-- DELETE BUTTON --}}
                                        <form action="{{ route('inventory-do.file.delete', $f->id) }}" method="POST"
                                            class="delete-file-form position-absolute" style="top:-8px; right:-8px; z-index:10;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm rounded-circle btn-delete-file"
                                                data-id="{{ $f->id }}" style="width:24px;height:24px;padding:0;">
                                                ×
                                            </button>
                                        </form>


                                        {{-- THUMB IMAGE --}}
                                        <img src="{{ asset('storage/' . $f->file_path) }}"
                                            class="thumb {{ $loop->first ? 'active' : '' }}"
                                            style="width:100px;height:70px;object-fit:cover;cursor:pointer;border-radius:6px;border:2px solid transparent;"
                                            onclick="
                                            document.getElementById('mainDo{{ $item->id }}').src='{{ asset('storage/' . $f->file_path) }}';
                                            document.getElementById('downloadDo{{ $item->id }}').href='{{ asset('storage/' . $f->file_path) }}';

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
                            $photos = $item->files->where('type', 'foto_bast');
                        @endphp

                        @if($photos->count())

                            {{-- MAIN IMAGE --}}
                            <div class="d-flex justify-content-center mb-4 position-relative">
                                <a id="downloadBast{{ $item->id }}" href="{{ asset('storage/' . $photos->first()->file_path) }}"
                                    download class="btn btn-sm btn-light position-absolute top-0 end-0 m-2">
                                    ⬇ Unduh
                                </a>

                                <img id="mainBast{{ $item->id }}" src="{{ asset('storage/' . $photos->first()->file_path) }}"
                                    style="width:900px;height:520px;object-fit:contain;border-radius:12px;">
                            </div>

                            {{-- THUMBNAILS --}}
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                @foreach($photos as $f)
                                    <div class="position-relative">

                                        {{-- DELETE BUTTON --}}
                                        <form action="{{ route('inventory-do.file.delete', $f->id) }}" method="POST"
                                            class="delete-file-form position-absolute" style="top:-8px; right:-8px; z-index:10;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm rounded-circle btn-delete-file"
                                                data-id="{{ $f->id }}" style="width:24px;height:24px;padding:0;">
                                                ×
                                            </button>
                                        </form>

                                        {{-- THUMB IMAGE --}}
                                        <img src="{{ asset('storage/' . $f->file_path) }}"
                                            class="thumb {{ $loop->first ? 'active' : '' }}"
                                            style="width:100px;height:70px;object-fit:cover;cursor:pointer;border-radius:6px;border:2px solid transparent;"
                                            onclick="
                                            document.getElementById('mainBast{{ $item->id }}').src='{{ asset('storage/' . $f->file_path) }}';
                                            document.getElementById('downloadBast{{ $item->id }}').href='{{ asset('storage/' . $f->file_path) }}';

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
                    <iframe id="pdfFrame" src="" width="100%" height="650px" style="border:none;">
                    </iframe>
                </div>

            </div>
        </div>
    </div>

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
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#pdfModal"
                                                    onclick="previewPDF('{{ asset('storage/' . $pdf->file_path) }}')">
                                                    Preview
                                                </button>

                                                <a href="{{ asset('storage/' . $pdf->file_path) }}" download
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
                if (this.value === 'pdf_tanda_terima') {


                    if (addBtn) addBtn.style.display = 'block';

                } else if (this.value.includes('foto')) {


                    if (addBtn) addBtn.style.display = 'block';

                } else {

                    // PDF DO & PDF BAST → single only

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
    </style>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</x-app-layout>