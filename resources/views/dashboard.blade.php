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
                <!-- 👋 GREETING USER -->
                <div class="dash-greeting">
                    <div class="greeting-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="greeting-text">
                        <span class="greeting-hello">Hallo, {{ auth()->user()->name ?? 'User' }}</span>
                        {{-- Ganti "role" di bawah ini sesuai nama kolom di tabel users kamu (mis. level, jabatan, dll) --}}
                        <span class="greeting-role">{{ ucfirst(auth()->user()->role ?? 'User') }}</span>
                    </div>
                </div>
            </div>

            <div class="dash-actions">
                @if (auth()->user()->role === 'superadmin')
                    <a href="{{ route('users.register') }}" class="btn-register-user">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        Register User
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Log out
                    </button>
                </form>
<a href="{{ route('activity-log') }}" class="btn-logout" style="text-decoration:none;">
    <svg viewBox="0 0 24 24"
         fill="none"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M3 3v5h5"/>
        <path d="M3.05 13A9 9 0 1 0 6 5.3"/>
        <polyline points="12 7 12 12 16 14"/>
    </svg>
    Activity Log
</a>            </div>
        </div>

        <!-- CENTER: CHART + LOGO -->
        <div class="panel center-panel">
            <div class="chart-wrap" style="display:flex; justify-content:center; align-items:center; min-height:320px;">
                <div class="chart-center">
                    <img src="{{ asset('assets/img/logo.png') }}"
                        alt="Logo"
                        style="width:200px; height:200px; object-fit:contain;">
                </div>
        </div>
            <!-- ICON ROW — HORIZONTAL, TANPA JUDUL SECTION -->
            <div class="icon-row"  style="
        background: url('{{ asset('assets/img/bgdashboard.jpg') }}') center center / cover no-repeat;
        padding: 30px;
        border-radius: 20px;
     ">

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

    /* 👋 GREETING USER — POJOK KIRI ATAS */
    .dash-greeting{
        display:flex;
        align-items:center;
        gap:14px;
    }
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

    .dash-actions{ display:flex; align-items:center; gap:14px; }

    .btn-logout{
        display:flex; align-items:center; gap:8px;
        background:var(--surface);
        border:1px solid var(--border);
        padding:12px 22px;
        border-radius:999px;
        font-size:14px;
        font-weight:600;
        color:var(--text);
        cursor:pointer;
        box-shadow:var(--shadow);
        transition:.15s ease;
    }
    .btn-logout:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }
    .btn-logout svg{ width:16px; height:16px; stroke:var(--red); }

    .btn-register-user{
        display:flex; align-items:center; gap:8px;
        background:var(--red);
        color:#fff;
        border:none;
        padding:12px 22px;
        border-radius:999px;
        font-size:14px;
        font-weight:700;
        font-family:'Space Grotesk', sans-serif;
        text-decoration:none;
        cursor:pointer;
        box-shadow:0 6px 16px rgba(225,29,46,0.25);
        transition:.15s ease;
    }
    .btn-register-user:hover{ background:var(--red-dark); color:#fff; }
    .btn-register-user svg{ width:16px; height:16px; stroke:#fff; }

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
    .chart-wrap{ position:relative; width:220px; height:220px; margin-bottom:28px; }
    .chart-center{
        position:absolute; inset:0;
        display:flex; align-items:center; justify-content:center;
        pointer-events:none;
    }
    .chart-logo{ width:56px; height:56px; object-fit:contain; }
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
        padding-top:26px;
        border-top:1px solid var(--border);
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

    /* YEAR MODAL */
    .year-modal{
        display:none; position:fixed; inset:0;
        background:rgba(23,24,26,0.45);
        z-index:9999; align-items:center; justify-content:center;
    }
    .year-modal-box{
        background:var(--surface);
        padding:26px 30px;
        border-radius:20px;
        text-align:center;
        min-width:300px;
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

    /* RESPONSIVE */
    @media (max-width: 1100px){
        .stats-row{ grid-template-columns:repeat(3,1fr); }
        .icon-tile{ width:92px; height:92px; }
        .chart-wrap{ width:280px; height:280px; }
    }
    @media (max-width: 640px){
        .stats-row{ grid-template-columns:repeat(2,1fr); }
        .icon-row{ gap:22px; }
        .icon-tile{ width:72px; height:72px; }
        .icon-tile svg{ width:30px; height:30px; }
        .dash-title{ font-size:20px; }
        .greeting-hello{ font-size:15px; }
        .chart-wrap{ width:220px; height:220px; }
    }
</style>

</x-app-layout>