<x-app-layout>
@php
    $roleDescriptions = [
        'superadmin' => 'Akses penuh — bisa tambah, edit, dan hapus data apa saja.',
        'admin'      => 'Bisa tambah dan edit data, tapi tidak bisa menghapus.',
        'user'       => 'Hanya bisa melihat data, tidak bisa tambah/edit/hapus.',
    ];
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-hidden">
    <x-app.navbar />

    <div class="register-wrap">

        <div class="register-header">
            <div>
                <h1 class="register-title">Register User Baru</h1>
                <p class="register-subtitle">Buat akun baru dan tentukan hak aksesnya.</p>
            </div>
            <a href="{{ route('users.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali
            </a>
        </div>

        <div class="register-card">

            @if ($errors->any())
                <div class="alert-box alert-error">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.register.store') }}">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control"
                            value="{{ old('username') }}" placeholder="Contoh: budi123" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Minimal 7 karakter" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                            placeholder="Ulangi password" required>
                    </div>

                    <div class="form-group form-group-full">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control" required onchange="updateRoleDesc(this.value)">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role...</option>
                            <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        <p id="roleDesc" class="role-desc">Pilih role untuk melihat hak aksesnya.</p>
                    </div>
                </div>

                <div class="role-info-grid">
                    <div class="role-info-card">
                        <span class="role-badge role-badge-superadmin">Superadmin</span>
                        <p>{{ $roleDescriptions['superadmin'] }}</p>
                    </div>
                    <div class="role-info-card">
                        <span class="role-badge role-badge-admin">Admin</span>
                        <p>{{ $roleDescriptions['admin'] }}</p>
                    </div>
                    <div class="role-info-card">
                        <span class="role-badge role-badge-user">User</span>
                        <p>{{ $roleDescriptions['user'] }}</p>
                    </div>
                </div>

                <div class="register-actions">
                    <button type="submit" class="btn-submit">Daftarkan User</button>
                </div>
            </form>
        </div>
    </div>

    <x-app.footer />
</main>

<script>
    const roleDescriptions = {
        superadmin: "Akses penuh — bisa tambah, edit, dan hapus data apa saja.",
        admin: "Bisa tambah dan edit data, tapi tidak bisa menghapus.",
        user: "Hanya bisa melihat data, tidak bisa tambah/edit/hapus."
    };
    function updateRoleDesc(value) {
        const el = document.getElementById('roleDesc');
        el.textContent = roleDescriptions[value] || "Pilih role untuk melihat hak aksesnya.";
    }
    @if(old('role'))
        updateRoleDesc("{{ old('role') }}");
    @endif
</script>

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

    .register-wrap{
        max-width:820px;
        margin:0 auto;
        padding:28px 24px 60px;
        font-family:'Inter', sans-serif;
        color:var(--text);
    }

    .register-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        margin-bottom:22px;
        flex-wrap:wrap;
    }
    .register-title{
        font-family:'Space Grotesk', sans-serif;
        font-weight:700;
        font-size:24px;
        margin:0 0 4px;
        letter-spacing:-0.4px;
    }
    .register-subtitle{ font-size:13px; color:var(--muted); margin:0; }

    .btn-back{
        display:flex; align-items:center; gap:8px;
        background:var(--surface);
        border:1px solid var(--border);
        padding:10px 18px;
        border-radius:999px;
        font-size:13px;
        font-weight:600;
        color:var(--text);
        text-decoration:none;
        box-shadow:var(--shadow);
        transition:.15s ease;
    }
    .btn-back:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }
    .btn-back svg{ width:14px; height:14px; stroke:var(--red); }

    .register-card{
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:18px;
        box-shadow:var(--shadow);
        padding:30px;
    }

    .alert-box{
        border-radius:12px;
        padding:14px 16px;
        font-size:13px;
        margin-bottom:20px;
    }
    .alert-error{
        background:var(--red-light);
        color:var(--red-dark);
        border:1px solid #F3AEB8;
    }

    .form-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:18px;
        margin-bottom:22px;
    }
    .form-group-full{ grid-column:1 / -1; }

    .form-group label{
        display:block;
        font-size:12.5px;
        font-weight:600;
        margin-bottom:6px;
        color:var(--text);
    }
    .form-control{
        width:100%;
        padding:11px 14px;
        border-radius:10px;
        border:1px solid var(--border);
        font-size:13.5px;
        font-family:'Inter', sans-serif;
        color:var(--text);
        background:var(--bg);
        transition:.15s ease;
    }
    .form-control:focus{
        outline:none;
        border-color:var(--red);
        background:#fff;
        box-shadow:0 0 0 3px rgba(225,29,46,0.1);
    }

    .role-desc{
        font-size:12px;
        color:var(--muted);
        margin:8px 0 0;
    }

    .role-info-grid{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:14px;
        margin-bottom:26px;
    }
    .role-info-card{
        background:var(--bg);
        border:1px solid var(--border);
        border-radius:12px;
        padding:14px;
    }
    .role-info-card p{
        font-size:12px;
        color:var(--muted);
        margin:8px 0 0;
        line-height:1.5;
    }
    .role-badge{
        display:inline-block;
        padding:4px 10px;
        border-radius:999px;
        font-size:11px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
    }
    .role-badge-superadmin{ background:var(--red); color:#fff; }
    .role-badge-admin{ background:var(--red-light); color:var(--red-dark); }
    .role-badge-user{ background:#EEF2F6; color:#4A5568; }

    .register-actions{ display:flex; justify-content:flex-end; }
    .btn-submit{
        background:var(--red);
        color:#fff;
        border:none;
        padding:12px 26px;
        border-radius:999px;
        font-size:14px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
        cursor:pointer;
        transition:.15s ease;
        box-shadow:0 6px 16px rgba(225,29,46,0.25);
    }
    .btn-submit:hover{ background:var(--red-dark); }

    @media (max-width: 640px){
        .form-grid{ grid-template-columns:1fr; }
        .role-info-grid{ grid-template-columns:1fr; }
    }
</style>

</x-app-layout>
