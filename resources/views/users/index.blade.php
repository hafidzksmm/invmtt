<x-app-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-hidden">
    <x-app.navbar />

    <div class="users-wrap">

        <div class="users-header">
            <div class="users-header-left">
                <a href="{{ route('dashboard') }}" class="btn-back" title="Kembali ke Home">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5 12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.5Z"/></svg>
                </a>
                <div>
                    <h1 class="users-title">Manajemen User</h1>
                    <p class="users-subtitle">Daftar seluruh akun yang terdaftar di sistem.</p>
                </div>
            </div>
            <a href="{{ route('users.register') }}" class="btn-register">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Register User
            </a>
        </div>

        @if (session('success'))
            <div class="alert-box alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-box alert-error">{{ session('error') }}</div>
        @endif

        <div class="users-card">
            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                            <th class="col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name ?? '-' }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($user->role) {
                                            'superadmin' => 'role-badge-superadmin',
                                            'admin' => 'role-badge-admin',
                                            default => 'role-badge-user',
                                        };
                                    @endphp
                                    <span class="role-badge {{ $badgeClass }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>{{ $user->created_at?->format('d M Y') }}</td>
                                <td class="col-actions">
                                    <div class="action-btns">
                                        <button type="button" class="btn-icon btn-edit" title="Edit User"
                                            data-update-url="{{ route('users.update', $user->id) }}"
                                            data-username="{{ $user->username }}"
                                            onclick="openEditModal(this)">
                                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                        </button>
                                        <button type="button" class="btn-icon btn-delete" title="Hapus User"
                                            data-destroy-url="{{ route('users.destroy', $user->id) }}"
                                            data-username="{{ $user->username }}"
                                            onclick="openDeleteModal(this)">
                                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">Belum ada user terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div id="editModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Edit User</h3>
                <button type="button" class="modal-close" onclick="closeModal('editModal')">&times;</button>
            </div>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_username">Username</label>
                    <input type="text" id="edit_username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_password">Password Baru</label>
                    <input type="password" id="edit_password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="edit_password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="edit_password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" autocomplete="new-password">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete User -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-box modal-box-sm">
            <div class="modal-head">
                <h3>Hapus User</h3>
                <button type="button" class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
            </div>
            <p class="modal-text">Yakin ingin menghapus user <strong id="deleteUsername"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('deleteModal')">Batal</button>
                    <button type="submit" class="btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <x-app.footer />
</main>

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

    .main-content{ background:var(--bg) !important; }

    .users-wrap{
        max-width:1000px;
        margin:0 auto;
        padding:28px 24px 60px;
        font-family:'Inter', sans-serif;
        color:var(--text);
    }

    .users-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        margin-bottom:22px;
        flex-wrap:wrap;
    }
    .users-header-left{
        display:flex;
        align-items:flex-start;
        gap:14px;
    }
    .btn-back{
        display:flex;
        align-items:center;
        justify-content:center;
        width:40px;
        height:40px;
        min-width:40px;
        border-radius:999px;
        background:var(--surface);
        border:1px solid var(--border);
        box-shadow:var(--shadow);
        color:var(--text);
        text-decoration:none;
        transition:.15s ease;
        margin-top:2px;
    }
    .btn-back svg{ width:18px; height:18px; stroke:var(--text); }
    .btn-back:hover{ background:var(--red); border-color:var(--red); }
    .btn-back:hover svg{ stroke:#fff; }
    .users-title{
        font-family:'Space Grotesk', sans-serif;
        font-weight:700;
        font-size:24px;
        margin:0 0 4px;
        letter-spacing:-0.4px;
    }
    .users-subtitle{ font-size:13px; color:var(--muted); margin:0; }

    .btn-register{
        display:flex; align-items:center; gap:8px;
        background:var(--red);
        color:#fff;
        border:none;
        padding:12px 22px;
        border-radius:999px;
        font-size:13.5px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
        text-decoration:none;
        cursor:pointer;
        transition:.15s ease;
        box-shadow:0 6px 16px rgba(225,29,46,0.25);
    }
    .btn-register:hover{ background:var(--red-dark); color:#fff; }
    .btn-register svg{ width:16px; height:16px; stroke:#fff; }

    .alert-box{
        border-radius:12px;
        padding:14px 16px;
        font-size:13px;
        margin-bottom:20px;
    }
    .alert-success{ background:#E3F6E9; color:#1E7B3E; border:1px solid #B9E6C6; }
    .alert-error{ background:var(--red-light); color:var(--red-dark); border:1px solid #F3AEB8; }

    .users-card{
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:18px;
        box-shadow:var(--shadow);
        overflow:hidden;
    }

    .table-responsive{ overflow-x:auto; }
    .users-table{
        width:100%;
        border-collapse:collapse;
        font-size:13.5px;
    }
    .users-table thead th{
        text-align:left;
        padding:16px 20px;
        font-size:11.5px;
        text-transform:uppercase;
        letter-spacing:.03em;
        color:var(--muted);
        border-bottom:1px solid var(--border);
        font-weight:700;
    }
    .users-table tbody td{
        padding:14px 20px;
        border-bottom:1px solid var(--border);
    }
    .users-table tbody tr:last-child td{ border-bottom:none; }
    .empty-state{ text-align:center; color:var(--muted); padding:30px !important; }

    .role-badge{
        display:inline-block;
        padding:4px 12px;
        border-radius:999px;
        font-size:11px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
    }
    .role-badge-superadmin{ background:var(--red); color:#fff; }
    .role-badge-admin{ background:var(--red-light); color:var(--red-dark); }
    .role-badge-user{ background:#EEF2F6; color:#4A5568; }

    .col-actions{ text-align:right; white-space:nowrap; }
    .action-btns{ display:flex; gap:8px; justify-content:flex-end; }
    .btn-icon{
        display:flex;
        align-items:center;
        justify-content:center;
        width:34px;
        height:34px;
        border-radius:10px;
        border:1px solid var(--border);
        background:var(--surface);
        cursor:pointer;
        transition:.15s ease;
    }
    .btn-icon svg{ width:16px; height:16px; stroke:var(--muted); transition:.15s ease; }
    .btn-edit:hover{ background:#EEF2F6; border-color:#D7DEE7; }
    .btn-edit:hover svg{ stroke:#4A5568; }
    .btn-delete:hover{ background:var(--red-light); border-color:#F3AEB8; }
    .btn-delete:hover svg{ stroke:var(--red-dark); }

    /* Modal */
    .modal-overlay{
        display:none;
        position:fixed;
        inset:0;
        background:rgba(17,18,20,0.45);
        align-items:center;
        justify-content:center;
        z-index:1000;
        padding:20px;
    }
    .modal-overlay.active{ display:flex; }
    .modal-box{
        background:var(--surface);
        border-radius:18px;
        width:100%;
        max-width:420px;
        padding:24px;
        box-shadow:0 20px 60px rgba(0,0,0,0.25);
        font-family:'Inter', sans-serif;
    }
    .modal-box-sm{ max-width:380px; }
    .modal-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-bottom:16px;
    }
    .modal-head h3{
        font-family:'Space Grotesk', sans-serif;
        font-size:18px;
        font-weight:700;
        margin:0;
        color:var(--text);
    }
    .modal-close{
        background:none;
        border:none;
        font-size:22px;
        line-height:1;
        color:var(--muted);
        cursor:pointer;
        padding:0;
    }
    .modal-close:hover{ color:var(--text); }
    .modal-text{ font-size:13.5px; color:var(--muted); margin:0 0 20px; }
    .modal-text strong{ color:var(--text); }

    .modal-box .form-group{ margin-bottom:14px; }

    .modal-actions{
        display:flex;
        justify-content:flex-end;
        gap:10px;
        margin-top:20px;
    }
    .btn-cancel{
        background:#F2F3F5;
        color:var(--text);
        border:none;
        padding:10px 18px;
        border-radius:999px;
        font-size:13px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
        cursor:pointer;
        transition:.15s ease;
    }
    .btn-cancel:hover{ background:#E5E7EB; }
    .btn-save{
        background:var(--red);
        color:#fff;
        border:none;
        padding:10px 18px;
        border-radius:999px;
        font-size:13px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
        cursor:pointer;
        transition:.15s ease;
    }
    .btn-save:hover{ background:var(--red-dark); }
    .btn-danger{
        background:var(--red-dark);
        color:#fff;
        border:none;
        padding:10px 18px;
        border-radius:999px;
        font-size:13px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
        cursor:pointer;
        transition:.15s ease;
    }
    .btn-danger:hover{ background:#8C0E19; }
</style>

<script>
    function openEditModal(btn){
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        form.action = btn.dataset.updateUrl;
        document.getElementById('edit_username').value = btn.dataset.username;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_password_confirmation').value = '';
        modal.classList.add('active');
    }

    function openDeleteModal(btn){
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = btn.dataset.destroyUrl;
        document.getElementById('deleteUsername').textContent = btn.dataset.username;
        modal.classList.add('active');
    }

    function closeModal(modalId){
        document.getElementById(modalId).classList.remove('active');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay){
        overlay.addEventListener('click', function(e){
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });

    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape'){
            document.querySelectorAll('.modal-overlay.active').forEach(function(m){
                m.classList.remove('active');
            });
        }
    });
</script>

</x-app-layout>
