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
                            Data Delivery Order & BAST Proyek
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="row">
            <div class="col-12">
                <div class="card border shadow-xs mb-4">

                    {{-- TOMBOL TAMBAH DO (POJOK KANAN ATAS TABLE) --}}
                    <div class="d-flex justify-content-end p-3">
                        <button class="btn text-white fw-semibold shadow-sm px-4 py-2"
                            style="background: linear-gradient(90deg,#2ecc71,#27ae60); border:none;"
                            data-bs-toggle="modal"
                            data-bs-target="#addDoModal">
                            <i class="bi bi-plus-lg me-2"></i> Tambah DO
                        </button>
                    </div>

                    <div class="card-body px-0 py-0">
                        <div class="table-responsive p-3">
                            <table class="table table-hover align-items-center text-center mb-0">

                                <thead class="bg-gray-100">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Project</th>
                                        <th rowspan="2">Vendor</th>
                                        <th colspan="2">Delivery</th>
                                        <th colspan="2">Instalasi</th>
                                        <th rowspan="2">Upload File</th>
                                        <th rowspan="2">Delete</th>
                                    </tr>
                                    <tr>
                                        <th>DO</th>
                                        <th>Foto Delivery</th>
                                        <th>BAST</th>
                                        <th>Foto Instalasi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @forelse($inventarydo as $i => $item)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $item->project }}</td>
                                        <td>{{ $item->vendor }}</td>

                                        {{-- PDF DO --}}
                                        <td>
                                            @if($pdf = $item->files->where('type','pdf_do')->first())
                                                <a href="{{ asset('storage/'.$pdf->file_path) }}"
                                                   target="_blank"
                                                   class="text-success fw-bold d-block" style="font-size:20px;">✅</a>
                                                @if($pdf->note)
                                                    <small class="text-muted d-block mt-1">
                                                        {{ $pdf->note }}
                                                    </small>
                                                @endif
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

                                        {{-- PDF BAST --}}
                                        <td>
                                            @if($pdf = $item->files->where('type','pdf_bast')->first())
                                                <a href="{{ asset('storage/'.$pdf->file_path) }}"
                                                   target="_blank"
                                                   class="text-success fw-bold d-block" style="font-size:20px;">✅</a>
                                                @if($pdf->note)
                                                    <small class="text-muted d-block mt-1">
                                                        {{ $pdf->note }}
                                                    </small>
                                                @endif
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

                                        {{-- UPLOAD --}}
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#uploadModal{{ $item->id }}">
                                                Upload
                                            </button>
                                        </td>

                                        {{-- DELETE --}}
                                        <td>
                                            <form method="POST"
                                                  action="{{ route('do.destroy',$item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Hapus data?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
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
    <form method="POST"
        action="{{ route('do.store', $year) }}"
        class="modal-content">
        @csrf

        <input type="hidden" name="year" value="{{ $year }}">

        <div class="modal-header bg-success text-white">
            <h5>Tambah DO ({{ $year }})</h5>
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

                {{-- PILIH TIPE --}}
                <select name="type"
                        class="form-select mb-3 file-type"
                        required>
                    <option value="">-- Pilih File --</option>
                    <option value="pdf_do">PDF DO</option>
                    <option value="foto_do">Foto DO</option>
                    <option value="pdf_bast">PDF BAST</option>
                    <option value="foto_bast">Foto BAST</option>
                </select>

                {{-- CONTAINER FILE --}}
                <div class="file-wrapper">

                    {{-- FILE ROW --}}
                    <div class="input-group mb-2 file-row">
                        <input type="file"
                               name="file[]"
                               class="form-control"
                               required>
                        <button type="button"
                                class="btn btn-success btn-add-file"
                                style="display:none">
                            ➕
                        </button>
                    </div>

                </div>

                {{-- NOTE PDF --}}
                <textarea name="note"
                          class="form-control mt-3 note-field"
                          rows="3"
                          placeholder="Catatan (khusus PDF)"
                          style="display:none"></textarea>

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
                         style="
                            width:900px;
                            height:520px;
                            object-fit:contain;
                            border-radius:12px;
                         ">
                </div>

                {{-- THUMBNAILS --}}
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @php $first = true; @endphp
                    @foreach($photos as $f)
                        <img src="{{ asset('storage/'.$f->file_path) }}"
                             class="thumb {{ $first ? 'active' : '' }}"
                             style="
                                width:100px;
                                height:70px;
                                object-fit:cover;
                                cursor:pointer;
                                border-radius:6px;
                                border:2px solid transparent;
                             "
                             onclick="
                                document.getElementById('mainDo{{ $item->id }}').src='{{ asset('storage/'.$f->file_path) }}';
                                document.getElementById('downloadDo{{ $item->id }}').href='{{ asset('storage/'.$f->file_path) }}';

                                document.querySelectorAll('#fotoDo{{ $item->id }} .thumb')
                                    .forEach(el => el.classList.remove('active'));
                                this.classList.add('active');
                             ">
                        @php $first = false; @endphp
                    @endforeach
                </div>

                @else
                    <p class="text-center text-light">Tidak ada foto</p>
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
                         style="
                            width:900px;
                            height:520px;
                            object-fit:contain;
                            border-radius:12px;
                         ">
                </div>

                {{-- THUMBNAILS --}}
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @php $first = true; @endphp
                    @foreach($photos as $f)
                        <img src="{{ asset('storage/'.$f->file_path) }}"
                             class="thumb {{ $first ? 'active' : '' }}"
                             style="
                                width:100px;
                                height:70px;
                                object-fit:cover;
                                cursor:pointer;
                                border-radius:6px;
                                border:2px solid transparent;
                             "
                             onclick="
                                document.getElementById('mainBast{{ $item->id }}').src='{{ asset('storage/'.$f->file_path) }}';
                                document.getElementById('downloadBast{{ $item->id }}').href='{{ asset('storage/'.$f->file_path) }}';

                                document.querySelectorAll('#fotoBast{{ $item->id }} .thumb')
                                    .forEach(el => el.classList.remove('active'));
                                this.classList.add('active');
                             ">
                        @php $first = false; @endphp
                    @endforeach
                </div>

                @else
                    <p class="text-center text-light">Tidak ada foto</p>
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
        const note = modal.querySelector('.note-field');
        const addBtn = modal.querySelector('.btn-add-file');
        const wrapper = modal.querySelector('.file-wrapper');

        // reset tambahan field
        wrapper.querySelectorAll('.file-row').forEach((row, i) => {
            if (i > 0) row.remove();
        });

        if (this.value.includes('pdf')) {
            note.style.display = 'block';
            addBtn.style.display = 'none';
        } else {
            note.style.display = 'none';
            note.value = '';
            addBtn.style.display = 'block';
        }
    });
});

// tombol tambah file
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
</script>
<style>
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

</x-app-layout>
