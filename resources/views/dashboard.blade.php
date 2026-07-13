<x-app-layout>
@php
    $currentYear = now()->year;
    $years = [
        $currentYear,
        $currentYear - 1,
        $currentYear - 2,
    ];
    $totalItems = (int)$countProjek + (int)$countInventaris + (int)$countAssetjual + (int)$countDocumentation;
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-hidden">
    <x-app.navbar />

    <!-- 📊 DASHBOARD WRAPPER -->
    <div class="dash-wrap">

        <!-- HEADER -->
        <div class="dash-header">
            <div class="dash-brand">
                <!-- 👋 GREETING USER + DROPDOWN -->
                <div class="dash-greeting" id="greetingDropdownWrap">
                    <button type="button" class="greeting-trigger" id="greetingTrigger" onclick="toggleGreetingDropdown(event)">
                        <div class="greeting-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="greeting-text">
                            <span class="greeting-hello">Hallo, {{ auth()->user()->name ?? 'User' }}</span>
                            {{-- Ganti "role" di bawah ini sesuai nama kolom di tabel users kamu (mis. level, jabatan, dll) --}}
                            <span class="greeting-role">{{ ucfirst(auth()->user()->role ?? 'User') }}</span>
                        </div>
                        <svg class="greeting-chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>

                    <!-- DROPDOWN MENU -->
                    <div class="greeting-dropdown" id="greetingDropdown">
                        <button type="button" class="dropdown-item" onclick="openChangePasswordModal()">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <span>Ubah Password</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="dash-actions">
                @if (auth()->user()->role === 'superadmin')
                    <a href="{{ route('users.register') }}" class="btn-register-user">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        <span>Register User</span>
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span>Log out</span>
                    </button>
                </form>

                <a href="{{ route('activity-log') }}" class="btn-logout" style="text-decoration:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v5h5"/>
                        <path d="M3.05 13A9 9 0 1 0 6 5.3"/>
                        <polyline points="12 7 12 12 16 14"/>
                    </svg>
                    <span>Activity Log</span>
                </a>
            </div>
        </div>

        <!-- CENTER: CHART + LOGO -->
        <div class="panel center-panel">
            <div class="chart-wrap">
                <div class="chart-center">
                    <img src="{{ asset('assets/img/logo.png') }}"
                        alt="Logo"
                        class="dash-logo">
                </div>
            </div>

            <!-- ICON ROW — HORIZONTAL, TANPA JUDUL SECTION -->
            <div class="icon-row">

                <div class="icon-col" onclick="window.location.href='{{ route('view-ws') }}'">
                    <div class="icon-tile tile-workshop" style="background-color: #dc3545;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18"/>
                            <path d="M5 21V7l8-4v18"/>
                            <path d="M19 21V11l-6-4"/>
                            <line x1="9" y1="9" x2="9" y2="9.01"/>
                            <line x1="9" y1="13" x2="9" y2="13.01"/>
                        </svg>
                    </div>
                    <span class="icon-label">Workshop</span>
                </div>
                <div class="icon-col" onclick="window.location.href='{{ route('view-projek') }}'">
                    <div class="icon-tile tile-project" style="background-color: #dc3545;">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    </div>
                    <span class="icon-label">Project</span>
                </div>

                <div class="icon-col" onclick="window.location.href='{{ route('view-aset') }}'">
                    <div class="icon-tile tile-asset" style="background-color: #dc3545;">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/><line x1="9" y1="11" x2="15" y2="11"/></svg>
                    </div>
                    <span class="icon-label">Selling Assets</span>
                </div>

                <div class="icon-col" onclick="openYearModal()">
                    <div class="icon-tile tile-files" style="background-color: #dc3545;">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <span class="icon-label">Project Files</span>
                </div>

                <div class="icon-col" onclick="window.location.href='{{ route('view-training-certification') }}'">
                    <div class="icon-tile tile-activity" style="background-color: #dc3545;">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                    </div>
                    <span class="icon-label">Training <br>Certification</span>
                </div>

                <div class="icon-col" onclick="window.open('http://project.mttech.co.id:8080/', '_blank')">
                    <div class="icon-tile tile-company" style="background-color: #dc3545;">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <span class="icon-label">Monitoring <br>Project</span>
                </div>

            </div>
        </div>
    </div>

    <x-app.footer />
</main>

<!-- YEAR SELECT MODAL -->
<div id="yearModal" class="year-modal">
    <div class="year-modal-box">
        <h5 class="year-modal-title">Pilih Tahun</h5>
        <div class="year-modal-options">
            @foreach ($years as $year)
                <a href="{{ route('view-do', $year) }}" class="year-pill">{{ $year }}</a>
            @endforeach
        </div>
        <button onclick="closeYearModal()" class="year-cancel">Batal</button>
    </div>
</div>

<!-- 🚧 UNDER CONSTRUCTION MODAL -->
<div id="underConstructionModal" class="year-modal">
    <div class="year-modal-box">
        <div style="width:56px;height:56px;border-radius:50%;background:var(--red-light);display:flex;align-items:center;justify-content:center;margin:0 auto;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#B0121F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:28px;height:28px;">
                <path d="M12 9v4"/>
                <path d="M12 17h.01"/>
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            </svg>
        </div>
        <h5 class="year-modal-title">This page is under construction</h5>
        <p style="font-size:13.5px;color:var(--muted);margin:-6px 0 0;">Fitur Training Certification sedang dalam pengembangan.</p>
        <button onclick="closeUnderConstructionModal()" class="year-cancel" style="background:var(--red);color:#fff;padding:10px 22px;border-radius:999px;font-weight:600;">
            Tutup
        </button>
    </div>
</div>

<!-- 🔑 CHANGE PASSWORD MODAL -->
<div id="changePasswordModal" class="year-modal">
    <div class="year-modal-box" style="text-align:left; min-width:320px;">
        <div style="display:flex; align-items:center; justify-content:space-between; width:100%;">
            <h5 class="year-modal-title" style="margin:0;">Ubah Password</h5>
            <button type="button" onclick="closeChangePasswordModal()" style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:20px;line-height:1;padding:0;">&times;</button>
        </div>

        <form method="POST" action="{{ route('password.change') }}" style="width:100%; display:flex; flex-direction:column; gap:14px;">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="cp-label">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" class="cp-input" required autocomplete="current-password">
            </div>

            <div>
                <label for="new_password" class="cp-label">Password Baru</label>
                <input type="password" id="new_password" name="new_password" class="cp-input" required minlength="8" autocomplete="new-password">
            </div>

            <div>
                <label for="new_password_confirmation" class="cp-label">Konfirmasi Password Baru</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="cp-input" required minlength="8" autocomplete="new-password">
            </div>

            @if ($errors->any())
                <div style="background:var(--red-light); color:var(--red-dark); padding:10px 14px; border-radius:10px; font-size:12.5px;">
                    <ul style="margin:0; padding-left:16px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:4px;">
                <button type="button" onclick="closeChangePasswordModal()" class="btn-pill-outline-modal">Batal</button>
                <button type="submit" class="btn-pill-red-modal">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- 📦 CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('inventoryChart');
    if (!ctx) return;

    const chartCtx = ctx.getContext('2d');

    const labels = ['Inventory Project', 'Inventory Workshop', 'Asset Jual', 'Documentation'];
    const dataValues = [{{ $countProjek }}, {{ $countInventaris }}, {{ $countAssetjual }}, {{ $countDocumentation }}];
    const colors = ['#E11D2E', '#F1637A', '#FBD3D9', '#A8D5FF'];
    const labelTextColors = ['#FFFFFF', '#FFFFFF', '#7A1420', '#1A5299'];

    const chart = new Chart(chartCtx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: colors,
                borderColor: '#FFFFFF',
                borderWidth: 5,
                borderRadius: 14,
                hoverOffset: 10,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function (context) {
                            return context.chart.data.labels[context.dataIndex];
                        }
                    },
                    backgroundColor: '#17181A',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 10,
                    cornerRadius: 8
                }
            },

            // ✅ CLICK EVENT ROUTING
            onClick: (event, elements) => {
                if (!elements.length) return;
                const index = elements[0].index;

                if (index === 0) {
                    window.location.href = "{{ route('view-projek') }}";
                } else if (index === 1) {
                    window.location.href = "{{ route('view-ws') }}";
                } else if (index === 2) {
                    window.location.href = "{{ route('view-aset') }}";
                } else if (index === 3) {
                    openYearModal();
                }
            },

            onHover: (event, elements) => {
                const canvas = event.native ? event.native.target : event.target;
                canvas.style.cursor = elements.length ? 'pointer' : 'default';
            }
        },
        plugins: [{
            id: 'valueLabels',
            afterDraw(chart) {
                const { ctx, data } = chart;
                const meta = chart.getDatasetMeta(0);
                ctx.save();
                ctx.font = "700 22px 'Space Grotesk', sans-serif";
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                meta.data.forEach((element, index) => {
                    const pos = element.tooltipPosition();
                    const value = data.datasets[0].data[index];
                    ctx.fillStyle = labelTextColors[index] || '#fff';
                    ctx.fillText(value, pos.x, pos.y);
                });
                ctx.restore();
            }
        }]
    });
});

function openYearModal() {
    document.getElementById('yearModal').style.display = 'flex';
}

function closeYearModal() {
    document.getElementById('yearModal').style.display = 'none';
}

function openUnderConstructionModal() {
    document.getElementById('underConstructionModal').style.display = 'flex';
}

function closeUnderConstructionModal() {
    document.getElementById('underConstructionModal').style.display = 'none';
}

// 🔽 GREETING DROPDOWN
function toggleGreetingDropdown(event) {
    event.stopPropagation();
    const dropdown = document.getElementById('greetingDropdown');
    const wrap = document.getElementById('greetingDropdownWrap');
    dropdown.classList.toggle('show');
    wrap.classList.toggle('open');
}

document.addEventListener('click', function (event) {
    const wrap = document.getElementById('greetingDropdownWrap');
    const dropdown = document.getElementById('greetingDropdown');
    if (wrap && !wrap.contains(event.target)) {
        dropdown.classList.remove('show');
        wrap.classList.remove('open');
    }
});

// 🔑 CHANGE PASSWORD MODAL
function openChangePasswordModal() {
    document.getElementById('greetingDropdown').classList.remove('show');
    document.getElementById('greetingDropdownWrap').classList.remove('open');
    document.getElementById('changePasswordModal').style.display = 'flex';
}

function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').style.display = 'none';
}
</script>

<!-- 🎨 STYLING — MINIMALIS PUTIH-MERAH -->
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

    /* 👋 GREETING USER — POJOK KIRI ATAS + DROPDOWN */
    .dash-greeting{
        position:relative;
        display:inline-block;
    }
    .greeting-trigger{
        display:flex;
        align-items:center;
        gap:14px;
        background:none;
        border:none;
        padding:6px 10px 6px 6px;
        border-radius:16px;
        cursor:pointer;
        transition:.15s ease;
    }
    .greeting-trigger:hover{ background:var(--red-light); }
    .dash-greeting.open .greeting-trigger{ background:var(--red-light); }

    .greeting-avatar{
        width:52px; height:52px;
        border-radius:50%;
        background:var(--red);
        color:#fff;
        display:flex; align-items:center; justify-content:center;
        font-family:'Space Grotesk', sans-serif;
        font-weight:700;
        font-size:19px;
        flex-shrink:0;
        box-shadow:0 4px 10px rgba(225,29,46,0.25);
    }
    .greeting-text{
        display:flex;
        flex-direction:column;
        line-height:1.3;
        text-align:left;
    }
    .greeting-hello{
        font-family:'Space Grotesk', sans-serif;
        font-weight:700;
        font-size:18px;
        color:var(--text);
    }
    .greeting-role{
        font-size:13.5px;
        color:var(--muted);
        text-transform:capitalize;
    }
    .greeting-chevron{
        width:16px; height:16px;
        stroke:var(--muted);
        flex-shrink:0;
        transition:transform .18s ease;
    }
    .dash-greeting.open .greeting-chevron{ transform:rotate(180deg); stroke:var(--red-dark); }

    /* DROPDOWN MENU */
    .greeting-dropdown{
        position:absolute;
        top:calc(100% + 8px);
        left:0;
        min-width:200px;
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:14px;
        box-shadow:0 12px 30px rgba(16,16,16,0.12);
        padding:6px;
        opacity:0;
        visibility:hidden;
        transform:translateY(-6px);
        transition:.15s ease;
        z-index:1000;
    }
    .greeting-dropdown.show{
        opacity:1;
        visibility:visible;
        transform:translateY(0);
    }
    .dropdown-item{
        width:100%;
        display:flex;
        align-items:center;
        gap:10px;
        background:none;
        border:none;
        padding:10px 12px;
        border-radius:10px;
        font-size:13.5px;
        font-weight:600;
        color:var(--text);
        cursor:pointer;
        text-align:left;
        transition:.12s ease;
    }
    .dropdown-item:hover{ background:var(--red-light); color:var(--red-dark); }
    .dropdown-item svg{ width:16px; height:16px; stroke:var(--red); flex-shrink:0; }

    .dash-brand-mark{
        width:46px; height:46px;
        border-radius:12px;
        background:var(--surface);
        border:1px solid var(--border);
        display:flex; align-items:center; justify-content:center;
        overflow:hidden;
    }
    .dash-brand-mark img{ width:70%; height:70%; object-fit:contain; }
    .dash-title{
        font-family:'Space Grotesk', sans-serif;
        font-weight:700;
        font-size:24px;
        letter-spacing:-0.4px;
        margin:0;
    }
    .dash-subtitle{ font-size:12.5px; color:var(--muted); }

    /* dash-actions: default desktop, tapi dibuat scroll-friendly di mobile */
    .dash-actions{
        display:flex;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
    }

    .btn-logout{
        display:flex; align-items:center; gap:8px;
        background:var(--surface);
        border:1px solid var(--border);
        padding:12px 20px;
        border-radius:999px;
        font-size:13.5px;
        font-weight:600;
        color:var(--text);
        cursor:pointer;
        box-shadow:var(--shadow);
        transition:.15s ease;
        white-space:nowrap;
    }
    .btn-logout:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }
    .btn-logout svg{ width:16px; height:16px; stroke:var(--red); flex-shrink:0; }

    .btn-register-user{
        display:flex; align-items:center; gap:8px;
        background:var(--red);
        color:#fff;
        border:none;
        padding:12px 20px;
        border-radius:999px;
        font-size:13.5px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
        text-decoration:none;
        cursor:pointer;
        box-shadow:0 6px 16px rgba(225,29,46,0.25);
        transition:.15s ease;
        white-space:nowrap;
    }
    .btn-register-user:hover{ background:var(--red-dark); color:#fff; }
    .btn-register-user svg{ width:16px; height:16px; stroke:#fff; flex-shrink:0; }

    /* STATS */
    .stats-row{
        display:grid;
        grid-template-columns:repeat(5,1fr);
        gap:16px;
        margin-bottom:24px;
    }
    .stat-card{
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:16px;
        padding:18px 20px;
        box-shadow:var(--shadow);
    }
    .stat-top{ margin-bottom:14px; }
    .stat-icon{
        width:34px; height:34px;
        border-radius:9px;
        background:var(--red-light);
        display:flex; align-items:center; justify-content:center;
    }
    .stat-icon svg{ width:17px; height:17px; stroke:var(--red-dark); }
    .stat-value{ font-family:'Space Grotesk', sans-serif; font-size:26px; font-weight:700; letter-spacing:-0.4px; }
    .stat-label{ font-size:12px; color:var(--muted); margin-top:4px; }

    /* CENTER PANEL — CHART + ICON ROW */
    .panel{
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:22px;
        box-shadow:var(--shadow);
    }
    .center-panel{ display:flex; flex-direction:column; align-items:center; padding:48px 30px 40px; }

    /* Chart / Logo wrap — responsif, tidak lagi pakai inline style fix 320px */
    .chart-wrap{
        position:relative;
        width:100%;
        max-width:220px;
        aspect-ratio:1/1;
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0 auto 24px;
    }
    .chart-center{
        position:absolute; inset:0;
        display:flex; align-items:center; justify-content:center;
        pointer-events:none;
    }

    /* Logo dibuat responsif: mengikuti ukuran container, dibatasi max-width */
    .dash-logo{
        width:100%;
        max-width:180px;
        height:auto;
        object-fit:contain;
    }

    .legend{ display:flex; flex-direction:column; gap:10px; width:100%; max-width:250px; margin-bottom:34px; }
    .legend-item{ display:flex; align-items:center; justify-content:space-between; font-size:12.5px; }
    .legend-left{ display:flex; align-items:center; gap:9px; }
    .dot{ width:9px; height:9px; border-radius:50%; flex-shrink:0; }
    .legend-value{ font-weight:700; font-family:'Space Grotesk', sans-serif; }

    /* ICON ROW — horizontal, background hanya di tile icon (bagian atas halaman tetap polos) */
    .icon-row{
        width:100%;
        display:flex;
        flex-wrap:wrap;
        justify-content:center;
        gap:34px;
        padding:30px;
        border-top:1px solid var(--border);
        background: url('{{ asset('assets/img/bgdashboard.jpg') }}') center center / cover no-repeat;
        border-radius:20px;
        box-sizing:border-box;
    }
    .icon-col{
        display:flex; flex-direction:column; align-items:center; gap:14px;
        cursor:pointer;
    }
    .icon-tile{
        width:84px; height:84px;
        border-radius:20px;
        display:flex; align-items:center; justify-content:center;
        background-size:cover;
        background-position:center;
        background-color:#F4F4F5; /* fallback jika gambar belum diisi */
        position:relative;
        transition:transform .18s ease, box-shadow .18s ease;
        box-shadow:0 1px 2px rgba(0,0,0,0.04);
    }
    /* overlay gelap tipis supaya icon putih tetap kebaca di atas foto apapun */
    .icon-tile::before{
        content:"";
        position:absolute; inset:0;
        border-radius:22px;
        background:linear-gradient(180deg, rgba(17,18,20,0.15), rgba(17,18,20,0.45));
    }
    .icon-tile svg{
        position:relative; z-index:1;
        width:32px; height:32px;
        stroke:#FFFFFF;
    }
    .icon-col:hover .icon-tile{ transform:translateY(-3px) scale(1.04); box-shadow:0 10px 20px rgba(0,0,0,0.12); }
    .icon-label{ font-size:14.5px; font-weight:600; color:var(--text); text-align:center; }

    /* ======================================================
       TEMPLATE GAMBAR BACKGROUND ICON
       Ganti path di bawah ini dengan gambar kamu sendiri.
       Taruh file di: public/assets/img/tiles/
       ====================================================== */
    .tile-workshop{ background-image:url('{{ asset('assets/img/tiles/workshop.jpg') }}'); }
    .tile-project{ background-image:url('{{ asset('assets/img/tiles/project.jpg') }}'); }
    .tile-asset{ background-image:url('{{ asset('assets/img/tiles/asset.jpg') }}'); }
    .tile-files{ background-image:url('{{ asset('assets/img/tiles/files.jpg') }}'); }
    .tile-activity{ background-image:url('{{ asset('assets/img/tiles/activity.jpg') }}'); }
    .tile-company{ background-image:url('{{ asset('assets/img/tiles/company.jpg') }}'); }

    /* YEAR MODAL / GENERIC MODAL */
    .year-modal{
        display:none; position:fixed; inset:0;
        background:rgba(23,24,26,0.45);
        z-index:9999; align-items:center; justify-content:center;
        padding:16px;
    }
    .year-modal-box{
        background:var(--surface);
        padding:26px 30px;
        border-radius:20px;
        text-align:center;
        min-width:300px;
        max-width:100%;
        box-shadow:0 20px 50px rgba(0,0,0,0.15);
        display:flex; flex-direction:column; align-items:center; gap:16px;
        border:1px solid var(--border);
    }
    .year-modal-title{
        font-family:'Space Grotesk', sans-serif;
        font-weight:700; color:var(--text); margin:0;
    }
    .year-modal-options{ display:flex; flex-wrap:wrap; justify-content:center; gap:10px; }
    .year-pill{
        display:inline-block; padding:10px 18px; border-radius:999px;
        background:var(--red); color:#fff; text-decoration:none;
        font-weight:600; font-size:13.5px; transition:.2s;
    }
    .year-pill:hover{ background:var(--red-dark); color:#fff; }
    .year-cancel{
        margin-top:4px; background:none; border:none;
        color:var(--muted); font-size:13px; cursor:pointer;
    }

    /* CHANGE PASSWORD FORM ELEMENTS */
    .cp-label{
        display:block;
        font-size:12.5px;
        font-weight:600;
        color:var(--text);
        margin-bottom:6px;
    }
    .cp-input{
        width:100%;
        border:1px solid var(--border);
        border-radius:10px;
        padding:10px 14px;
        font-size:13.5px;
        background:var(--bg);
        color:var(--text);
        outline:none;
        transition:.15s ease;
        box-sizing:border-box;
    }
    .cp-input:focus{ border-color:var(--red); background:var(--surface); box-shadow:0 0 0 0.15rem rgba(225,29,46,0.15); }

    .btn-pill-outline-modal{
        padding:10px 20px;
        border-radius:999px;
        font-size:13px;
        font-weight:600;
        background:var(--surface);
        color:var(--text);
        border:1px solid var(--border);
        cursor:pointer;
        transition:.15s ease;
    }
    .btn-pill-outline-modal:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }

    .btn-pill-red-modal{
        padding:10px 22px;
        border-radius:999px;
        font-size:13px;
        font-weight:700;
        background:var(--red);
        color:#fff;
        border:none;
        cursor:pointer;
        box-shadow:0 6px 16px rgba(225,29,46,0.25);
        transition:.15s ease;
    }
    .btn-pill-red-modal:hover{ background:var(--red-dark); }

    /* ============================================================
       RESPONSIVE — TABLET
       ============================================================ */
    @media (max-width: 1100px){
        .stats-row{ grid-template-columns:repeat(3,1fr); }
        .icon-tile{ width:92px; height:92px; }
        .chart-wrap{ max-width:260px; }
        .dash-logo{ max-width:200px; }
    }

    /* ============================================================
       RESPONSIVE — MOBILE (≤ 640px)
       ============================================================ */
    @media (max-width: 640px){
        .dash-wrap{ padding:20px 16px 50px; }

        .stats-row{ grid-template-columns:repeat(2,1fr); }

        /* Header jadi lebih rapat & rapi di mobile */
        .dash-header{ gap:12px; margin-bottom:20px; }
        .dash-title{ font-size:20px; }
        .greeting-hello{ font-size:15px; }
        .greeting-avatar{ width:44px; height:44px; font-size:16px; }
        .greeting-trigger{ padding:4px 8px 4px 4px; gap:10px; }
        .greeting-dropdown{ min-width:180px; }

        /* Actions jadi grid rata, tidak wrap acak-acakan */
        .dash-actions{
            width:100%;
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(90px, 1fr));
            gap:8px;
        }
        .btn-logout, .btn-register-user{
            flex-direction:column;
            justify-content:center;
            gap:4px;
            padding:10px 8px;
            font-size:11.5px;
            text-align:center;
            white-space:normal;
        }
        .btn-logout svg, .btn-register-user svg{ width:18px; height:18px; }
        .dash-actions form{ width:100%; }
        .dash-actions form .btn-logout{ width:100%; }

        /* Panel & chart lebih ringkas */
        .center-panel{ padding:28px 16px 28px; }

        /* Logo: ukurannya proporsional & jauh lebih kecil di mobile */
        .chart-wrap{
            max-width:150px;
            margin-bottom:18px;
        }
        .dash-logo{ max-width:130px; }

        /* Icon row lebih rapat & tile lebih kecil supaya muat & tidak "makan tempat" */
        .icon-row{
            gap:16px;
            padding:20px 14px;
            border-radius:16px;
        }
        .icon-tile{ width:64px; height:64px; border-radius:16px; }
        .icon-tile svg{ width:26px; height:26px; }
        .icon-label{ font-size:12px; }
        .icon-col{ gap:8px; width:calc(33.333% - 11px); }
    }

    /* ============================================================
       RESPONSIVE — MOBILE KECIL (≤ 380px)
       ============================================================ */
    @media (max-width: 380px){
        .chart-wrap{ max-width:120px; }
        .dash-logo{ max-width:100px; }
        .icon-tile{ width:56px; height:56px; }
        .icon-tile svg{ width:22px; height:22px; }
        .icon-col{ width:calc(33.333% - 8px); }
        .icon-row{ gap:12px; }
    }
</style>

</x-app-layout>