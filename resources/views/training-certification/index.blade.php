<x-app-layout>
@php
    $canManage = auth()->check() && (isAdmin() || auth()->user()->role === 'superadmin');
    $canDelete = auth()->check() && auth()->user()->role === 'superadmin';
    // ✅ role 'user' boleh upload sertifikat, tapi tidak boleh tambah/edit/hapus vendor
    $canUploadCert = auth()->check() && (isAdmin() || in_array(auth()->user()->role, ['superadmin', 'user']));
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
                            <path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>
                        </svg>
                    </div>
                    <div class="greeting-text">
                        <span class="greeting-hello">Training Certification</span>
                        <span class="greeting-role">Sertifikasi & Pelatihan per Penyedia (Vendor)</span>
                    </div>
                </div>
            </div>

            <div class="dash-actions">
                @if($canManage)
                <button class="btn-icon-nav" style="background:#2ecc71; color:#fff; border-color:#2ecc71;"
                    data-bs-toggle="modal" data-bs-target="#addProviderModal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span>Tambah Vendor</span>
                </button>
                @endif

                <a href="{{ route('dashboard') }}" class="btn-icon-nav" title="Home">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7"/><path d="M9 22V12h6v10"/><path d="M21 22H3V9"/></svg>
                    <span>Home</span>
                </a>

                <a href="javascript:history.back()" class="btn-icon-nav" title="Back">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    <span>Back</span>
                </a>
            </div>
        </div>

        {{-- ================= GRID VENDOR ================= --}}
        <div class="row">
            <div class="col-12">
                <div class="card border shadow-xs mb-4">
                    <div class="card-body p-4">

                        @if($providers->isEmpty())
                            <p class="text-muted text-center py-5 mb-0">
                                Belum ada penyedia sertifikasi. @if($canManage) Klik "Tambah Vendor" untuk menambahkan. @endif
                            </p>
                        @else
                            <div class="provider-grid" id="providerGrid">
                                @foreach($providers as $provider)
                                <div class="provider-card" data-id="{{ $provider->id }}">

                                    @if($canManage)
                                    <div class="provider-tools">
                                        <button type="button" class="tool-btn tool-edit"
                                            title="Edit Vendor"
                                            data-id="{{ $provider->id }}"
                                            data-name="{{ $provider->name }}"
                                            onclick="openEditProvider(this)">
                                            ✏️
                                        </button>
                                        @if($canDelete)
                                        <form action="{{ route('training-provider.destroy', $provider->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus vendor ini beserta semua sertifikatnya?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="tool-btn tool-delete" title="Hapus Vendor">🗑️</button>
                                        </form>
                                        @endif
                                    </div>
                                    @endif

                                    <div class="provider-logo-wrap"
                                         onclick="openCertModal({{ $provider->id }}, '{{ addslashes($provider->name) }}')">
                                        @if($provider->logo_path)
                                            <img src="{{ asset('storage/'.$provider->logo_path) }}" class="provider-logo" alt="{{ $provider->name }}">
                                        @else
                                            <div class="provider-logo-fallback">{{ strtoupper(substr($provider->name,0,2)) }}</div>
                                        @endif
                                    </div>

                                    <div class="provider-name" onclick="openCertModal({{ $provider->id }}, '{{ addslashes($provider->name) }}')">
                                        {{ $provider->name }}
                                    </div>
                                    <div class="provider-count">
                                        {{ $provider->certificates_count }} sertifikat
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-app.footer />
</main>

{{-- ================= MODAL TAMBAH VENDOR ================= --}}
<div class="modal fade" id="addProviderModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('training-provider.store') }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5>Tambah Penyedia Sertifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label>Nama Vendor</label>
                <input type="text" name="name" class="form-control mb-3" placeholder="Mis. Dell, Lenovo, D-Link, Sophos" required>

                <label>Logo Vendor</label>
                <input type="file" name="logo" accept="image/*" class="form-control">
                <small class="text-muted d-block mt-1">Opsional. Format gambar, maksimal 2MB.</small>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT VENDOR ================= --}}
<div class="modal fade" id="editProviderModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editProviderForm" action="" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5>Edit Penyedia Sertifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label>Nama Vendor</label>
                <input type="text" name="name" id="editProviderName" class="form-control mb-3" required>

                <label>Ganti Logo</label>
                <input type="file" name="logo" accept="image/*" class="form-control">
                <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengganti logo.</small>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL SERTIFIKAT (POP UP UTAMA) ================= --}}
<div class="modal fade" id="certModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="certModalTitle">Sertifikat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                @if($canUploadCert)
                <form id="uploadCertForm" method="POST" enctype="multipart/form-data" class="upload-cert-form mb-4">                    @csrf
                    <input type="hidden" name="provider_id" id="uploadCertProviderId">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="small">Judul Sertifikasi</label>
                            <input type="text" name="title" class="form-control form-control-sm" placeholder="Mis. Dell Certified Engineer">
                        </div>
                        <div class="col-md-3">
                            <label class="small">Nama Pemegang</label>
                            <input type="text" name="holder_name" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2">
                            <label class="small">Tanggal Terbit</label>
                            <input type="date" name="issued_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2">
                            <label class="small">Berlaku Sampai</label>
                            <input type="date" name="expired_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2">
                            <label class="small">File Gambar</label>
                            <input type="file" name="file" accept="image/*" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-success btn-sm">➕ Upload Sertifikat</button>
                    </div>
                    <small class="text-danger d-block mt-1">Maksimal ukuran file 2MB.</small>
                </form>
                <hr>
                @endif

                <div id="certGrid" class="cert-grid">
                    {{-- diisi via AJAX --}}
                </div>

                <p id="certEmptyMsg" class="text-muted text-center py-4" style="display:none;">
                    Belum ada sertifikat untuk vendor ini.
                </p>

            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL LIGHTBOX GAMBAR SERTIFIKAT ================= --}}
<div class="modal fade" id="certLightbox" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center">
                <img id="lightboxImg" src="" style="max-width:100%; max-height:75vh; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.4);">
                <div id="lightboxCaption" class="text-white mt-3"></div>
                <a id="lightboxDownload" href="" download class="btn btn-light btn-sm mt-3">⬇ Unduh</a>
            </div>
        </div>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
const canManage = @json($canManage);
const canDelete = @json($canDelete);
const csrfToken = "{{ csrf_token() }}";

let certModal, certLightbox;
document.addEventListener('DOMContentLoaded', function () {
    certModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('certModal'));
    certLightbox = bootstrap.Modal.getOrCreateInstance(document.getElementById('certLightbox'));
});

// ================= EDIT PROVIDER =================
function openEditProvider(btn) {
    const id = btn.dataset.id;
    const name = btn.dataset.name;

    document.getElementById('editProviderForm').action = `/training-certification/provider/${id}`;
    document.getElementById('editProviderName').value = name;

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editProviderModal'));
    modal.show();
}

// ================= BUKA MODAL SERTIFIKAT =================
function openCertModal(providerId, providerName) {
    document.getElementById('certModalTitle').textContent = 'Sertifikat — ' + providerName;

    // ✅ FIX: elemen ini hanya ada di DOM untuk admin/superadmin (dibungkus kondisi role admin).
    // Untuk role biasa elemen ini null, jadi harus dicek dulu supaya tidak melempar error
    // yang menghentikan seluruh fungsi (termasuk certModal.show() di bawah).
    const providerIdInput = document.getElementById('uploadCertProviderId');
    if (providerIdInput) {
        providerIdInput.value = providerId;
    }

    const uploadForm = document.getElementById('uploadCertForm');
    if (uploadForm) {
        uploadForm.action = `/training-certification/provider/${providerId}/certificates/add`;
    }

    loadCertificates(providerId);

    // ✅ FIX: pakai getOrCreateInstance supaya tidak bergantung urutan load /
    // tidak error kalau certModal belum sempat diinisialisasi di DOMContentLoaded.
    const certModalEl = document.getElementById('certModal');
    certModal = bootstrap.Modal.getOrCreateInstance(certModalEl);
    certModal.show();
}

function loadCertificates(providerId) {
    const grid = document.getElementById('certGrid');
    const emptyMsg = document.getElementById('certEmptyMsg');
    grid.innerHTML = '<p class="text-muted text-center py-4 w-100">Memuat sertifikat...</p>';
    emptyMsg.style.display = 'none';

    fetch(`/training-certification/provider/${providerId}/certificates`)
        .then(res => res.json())
        .then(data => {
            grid.innerHTML = '';

            if (!data.certificates || data.certificates.length === 0) {
                emptyMsg.style.display = 'block';
                return;
            }

            data.certificates.forEach(cert => {
                const card = document.createElement('div');
                card.className = 'cert-card';
                card.dataset.id = cert.id;

                let caption = cert.title ? cert.title : 'Sertifikat';
                if (cert.holder_name) caption += ' — ' + cert.holder_name;

                card.innerHTML = `
                    <div class="cert-thumb" onclick="openLightbox('${cert.image_url}', '${(caption).replace(/'/g, "\\'")}')">
                        <img src="${cert.image_url}" alt="${caption}">
                    </div>
                    <div class="cert-info">
                        <div class="cert-title">${caption}</div>
                        ${cert.issued_date ? `<div class="cert-date">Terbit: ${cert.issued_date}</div>` : ''}
                        ${cert.expired_date ? `<div class="cert-date">Berlaku s/d: ${cert.expired_date}</div>` : ''}
                    </div>
                    ${canDelete ? `<button type="button" class="cert-delete-btn" onclick="deleteCertificate(${cert.id}, this)">🗑️</button>` : ''}
                `;

                grid.appendChild(card);
            });
        })
        .catch(() => {
            grid.innerHTML = '<p class="text-danger text-center py-4 w-100">Gagal memuat sertifikat.</p>';
        });
}

// ================= UPLOAD SERTIFIKAT (AJAX supaya modal tidak reload/tertutup) =================
document.addEventListener('submit', function (e) {
    if (e.target.id === 'uploadCertForm') {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const providerId = document.getElementById('uploadCertProviderId').value;

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(res => {
            form.reset();
            loadCertificates(providerId);
        })
        .catch(() => alert('Gagal upload sertifikat'));
    }
});

// ================= HAPUS SERTIFIKAT =================
function deleteCertificate(certId, btn) {
    if (!confirm('Hapus sertifikat ini?')) return;

    fetch(`/training-certification/certificate/${certId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: new URLSearchParams({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.closest('.cert-card').remove();
        }
    })
    .catch(() => alert('Gagal menghapus sertifikat'));
}

// ================= LIGHTBOX =================
function openLightbox(url, caption) {
    document.getElementById('lightboxImg').src = url;
    document.getElementById('lightboxCaption').textContent = caption;
    document.getElementById('lightboxDownload').href = url;

    const lightboxEl = document.getElementById('certLightbox');
    certLightbox = bootstrap.Modal.getOrCreateInstance(lightboxEl);
    certLightbox.show();
}

// ================= DRAG REORDER VENDOR (opsional, admin only) =================
@if($canManage)
$(function () {
    if ($.fn.sortable) {
        $("#providerGrid").sortable({
            items: ".provider-card",
            placeholder: "provider-placeholder",
            update: function () {
                let order = [];
                $("#providerGrid .provider-card").each(function (index) {
                    order.push({ id: $(this).data("id"), position: index + 1 });
                });

                $.ajax({
                    url: "{{ route('training-provider.reorder') }}",
                    type: "POST",
                    data: { _token: csrfToken, order: order }
                });
            }
        });
    }
});
@endif
</script>

<style>
/* ================= HEADER STYLE (konsisten dengan halaman DO & BAST) ================= */
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
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:16px;
}
.dash-brand{ display:flex; align-items:center; gap:14px; }
.dash-greeting{ display:flex; align-items:center; gap:14px; }
.greeting-avatar{
    width:52px; height:52px; border-radius:16px;
    background:var(--header-red); color:#fff;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; box-shadow:0 4px 10px rgba(225,29,46,0.25);
}
.greeting-text{ display:flex; flex-direction:column; line-height:1.3; }
.greeting-hello{
    font-family:'Space Grotesk', sans-serif; font-weight:700;
    font-size:22px; color:var(--header-text); letter-spacing:-0.4px;
}
.greeting-role{ font-size:13.5px; color:var(--header-muted); }
.dash-actions{ display:flex; align-items:center; gap:12px; }

.btn-icon-nav{
    display:flex; align-items:center; gap:8px;
    background:var(--header-bg); border:1px solid var(--header-border);
    padding:12px 20px; border-radius:999px; font-size:14px; font-weight:600;
    color:var(--header-text); text-decoration:none; cursor:pointer;
    box-shadow:var(--header-shadow); transition:.15s ease;
}
.btn-icon-nav svg{ width:16px; height:16px; stroke:var(--header-red); }
.btn-icon-nav:hover{ background:var(--header-red-light); border-color:var(--header-red); color:var(--header-red-dark); }
.btn-icon-nav:hover svg{ stroke:var(--header-red-dark); }

/* ================= PROVIDER GRID ================= */
/* ================= PROVIDER GRID (diperbesar) ================= */
.provider-grid{
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap:28px;
}
.provider-card{
    position:relative;
    background:#fff;
    border:1px solid var(--header-border);
    border-radius:24px;
    padding:36px 20px 28px;
    text-align:center;
    box-shadow:var(--header-shadow);
    transition:.15s ease;
}
.provider-card:hover{ transform:translateY(-4px); box-shadow:0 14px 30px rgba(0,0,0,0.10); }

.provider-logo-wrap{
    width:150px; height:150px; margin:0 auto 20px;
    border-radius:22px; background:#F4F4F5;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; overflow:hidden;
}
.provider-logo{ width:100%; height:100%; object-fit:contain; padding:16px; }
.provider-logo-fallback{
    font-family:'Space Grotesk', sans-serif; font-weight:700; font-size:38px;
    color:var(--header-red);
}
.provider-name{
    font-weight:700; font-size:19px; color:var(--header-text);
    cursor:pointer; margin-bottom:6px;
}
.provider-count{ font-size:13.5px; color:var(--header-muted); }

.provider-tools{
    position:absolute; top:14px; right:14px;
    display:flex; gap:8px; z-index:5;
}
.tool-btn{
    width:32px; height:32px; border-radius:50%;
    border:none; background:#fff; box-shadow:0 1px 4px rgba(0,0,0,0.15);
    font-size:14px; cursor:pointer; display:flex; align-items:center; justify-content:center;
}
.provider-placeholder{
    border:2px dashed #0d6efd; border-radius:16px; background:#f0f8ff;
}

/* ================= CERTIFICATE GRID (dalam modal) ================= */
.upload-cert-form{
    background:#F8F9FA; border:1px solid var(--header-border);
    border-radius:14px; padding:16px;
}
.cert-grid{
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap:18px;
}
.cert-card{
    position:relative;
    border:1px solid var(--header-border);
    border-radius:14px;
    overflow:hidden;
    background:#fff;
}
.cert-thumb{
    width:100%; height:140px; cursor:pointer; overflow:hidden; background:#F4F4F5;
}
.cert-thumb img{ width:100%; height:100%; object-fit:cover; transition:.2s ease; }
.cert-thumb:hover img{ transform:scale(1.06); }
.cert-info{ padding:10px 12px; }
.cert-title{ font-size:13px; font-weight:600; color:var(--header-text); }
.cert-date{ font-size:11px; color:var(--header-muted); margin-top:2px; }
.cert-delete-btn{
    position:absolute; top:8px; right:8px;
    width:26px; height:26px; border-radius:50%; border:none;
    background:rgba(255,255,255,0.9); box-shadow:0 1px 4px rgba(0,0,0,0.2);
    font-size:12px; cursor:pointer;
}

@media (max-width: 640px){
    .btn-icon-nav span{ display:none; }
    .btn-icon-nav{ padding:12px; }
    .greeting-hello{ font-size:18px; }
}
</style>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</x-app-layout>