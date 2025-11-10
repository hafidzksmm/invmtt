<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-hidden">
        <x-app.navbar />

        <!-- 🎥 FULL RESPONSIVE BACKGROUND VIDEO -->
        <video autoplay muted loop playsinline class="video-bg" aria-hidden="true">
            <source src="{{ asset('assets/img/video.mp4') }}" type="video/mp4">
            Browser kamu tidak mendukung video.
        </video>

        <!-- 📊 DASHBOARD WRAPPER -->
        <div class="dashboard-wrapper">

            <!-- 🏷️ TITLE -->
            <h3 class="text-white fw-bold mb-4 glow-dashboard mt-0 display-2 text-center">
              DASHBOARD
            </h3>

            <!-- 📈 CHART -->
             <div class="col-xl-12">
            <div class="center-chart" role="region" aria-label="Chart statistik">
                <div class="chart-container position-relative">
                    <canvas id="inventoryChart"></canvas>

                    <!-- 🌀 LOGO DI TENGAH CHART -->
                    <div class="logo-center-wrapper" aria-hidden="true">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="floating-logo">
                    </div>
                </div>
            </div>
            </div>
                
                <div class="position-absolute top-0 end-0 mt-3 mt-md-4 me-3 me-md-4 d-flex flex-column align-items-end gap-2 gap-md-3" style="z-index: 3;">
                  <!-- Button Logout --> 
                  <form method="POST" action="{{ route('logout') }}" class="mt-n3 ">
                      @csrf
                      <button type="submit" class="button">
                          <div class="dots_border"></div>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="sparkle">
                              <path class="path" stroke-linejoin="round" stroke-linecap="round" stroke="black" fill="black"
                                  d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097Z" />
                              <path class="path" stroke-linejoin="round" stroke-linecap="round" stroke="black" fill="black"
                                  d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z" />
                              <path class="path" stroke-linejoin="round" stroke-linecap="round" stroke="black" fill="black"
                                  d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z" />
                          </svg>
                          <span class="text_button">Log out</span>
                      </button>
                  </form>
                </div>

<div class="container-fluid py-10">
    <div class="row align-items-start justify-content-between gy-4">

        <!-- ✅ KIRI -->
        <div class="kiri col-12 col-md-3 text-center">
            <h3 class="shine-text text-white fw-bold mb-3">INVENTORY</h3>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <div class="icon-item" onclick="window.location.href='{{ route('view-ws') }}'">
                    <img src="{{ asset('assets/img/build icon.png') }}" class="rounded-circle icon-img shadow"
                        style="width:80px; height:80px; object-fit:cover;">
                    <div class="label-text text-white small mt-0">Workshop</div>
                </div>

                <div class="icon-item" onclick="window.location.href='{{ route('view-projek') }}'">
                    <img src="{{ asset('assets/img/jeks.png') }}" class="rounded-circle icon-img shadow"
                        style="width:80px; height:80px; object-fit:cover;">
                    <div class="label-text text-white small mt-0">Project</div>
                </div>

                <div class="icon-item" onclick="window.location.href='{{ route('view-aset') }}'">
                    <img src="{{ asset('assets/img/juals.png') }}" class="rounded-circle icon-img shadow"
                        style="width:80px; height:80px; object-fit:cover;">
                    <div class="label-text text-white small mt-0">Selling Assets</div>
                </div>
            </div>
        </div>

        <!-- ✅ KANAN -->
        <div class="col-12 col-md-3 text-center">
            <div class="row g-3 justify-content-center">

                <div class="col-6 icon-item" onclick="alert('Documentation Giat');">
                    <img src="{{ asset('assets/img/jual.png') }}" class="rounded-circle shadow"
                        style="width:60px; height:60px; object-fit:cover;">
                    <div class="small fw-bold text-white mt-0">Project<br>Documentation</div>
                </div>

                <div class="col-6 icon-item" onclick="alert('Document MTT');">
                    <img src="{{ asset('assets/img/ikons.png') }}" class="rounded-circle shadow"
                        style="width:60px; height:60px; object-fit:cover;">
                    <div class="small fw-bold text-white mt-0">Project Files</div>
                </div>

                <div class="col-6 icon-item" onclick="window.open('https://mttech.co.id', '_blank')">
                    <img src="{{ asset('assets/img/pany.png') }}" class="rounded-circle shadow"
                        style="width:60px; height:60px; object-fit:cover;">
                    <div class="small fw-bold text-white mt-0">Company Profile</div>
                </div>

                <div class="col-6 icon-item" onclick="alert('Documentation Project');">
                    <img src="{{ asset('assets/img/giats.png') }}" class="rounded-circle shadow"
                        style="width:60px; height:60px; object-fit:cover;">
                    <div class="small fw-bold text-white mt-0">Project Activity</div>
                </div>

            </div>
        </div>

    </div>
</div>

    </div>
</div>

        </div>

        <x-app.footer />
    </main>

    <!-- 📦 CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('inventoryChart').getContext('2d');

        const labels = ['Inventory Project', 'Inventory Workshop', 'Asset Jual'];
        const dataValues = [{{ $countProjek }}, {{ $countInventaris }}, {{ $countAssetjual }}];
        const colors = ['#27243b', '#5f5887', '#a29dde'];

        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: ['#DC143C', '#F75270', '#F7CAC9'],
                    borderColor: '#191919',
                    borderWidth: 6,
                    borderRadius: 18,
                    hoverOffset: 12,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                const label = context.chart.data.labels[context.dataIndex];
                                return `${label}`;
                            }
                        },
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: { size: 16, weight: 'bold' },
                        bodyFont: { size: 14 }
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
                    ctx.font = 'bold 30px Poppins';
                    ctx.fillStyle = '#fff';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    meta.data.forEach((element, index) => {
                        const pos = element.tooltipPosition();
                        const value = data.datasets[0].data[index];
                        ctx.fillText(value, pos.x, pos.y);
                    });
                    ctx.restore();
                }
            }]
        });

        const image = new Image();
        image.src = '/images/logo.png';
        image.onload = function() {
            const plugin = {
                id: 'centerImage',
                beforeDraw(chart) {
                    const { ctx, chartArea: { width, height } } = chart;
                    const x = chart.chartArea.left + width / 2;
                    const y = chart.chartArea.top + height / 2;
                    const imgSize = 70;
                    ctx.drawImage(image, x - imgSize / 2, y - imgSize / 2, imgSize, imgSize);
                }
            };
            chart.config.plugins.push(plugin);
            chart.update();
        };
    });
</script>
    <!-- 🎨 STYLING RESPONSIVE -->
    <style>
        html, body, main {
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }

        .video-bg {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100vw;
            min-height: 100vh;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            z-index: -1;
        }

        .dashboard-wrapper {
            position: relative;
            width: 100%;
            height: 100vh;
            z-index: 2;
        }

        .animated-title {
            position: absolute;
            top: 28px;
            left: 42px;
            font-size: 2.4rem;
            text-shadow: 0 0 25px rgba(255,255,255,0.85);
        }

        /* ✅ Chart turun 20% */
        .center-chart {
            position: absolute;
            top: 53%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 5;
        }

        /* Chart container */
        .chart-container {
            width: 400px;
            height: 400px;
            max-width: 80vw;
            max-height: 65vh;
            position: relative;
        }

        /* ✅ Logo ikut turun 20% + white glow */
        .logo-center-wrapper {
            position: absolute;
            top: 63%;
            left: 50%;
            width: 190px;
            height: 190px;
            transform: translate(-50%, -50%);
            z-index: 6;
        }

        .floating-logo {
            width: 100%;
            height: auto;
            animation: floatY 3s ease-in-out infinite;
            filter: drop-shadow(0 0 14px white) drop-shadow(0 0 26px rgba(255,255,255,0.9));
        }

        @keyframes floatY {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            color: #fff;
        }

        .icon-img {
            width: 95px;
            height: 95px;
            object-fit: cover;
            transition: .25s;
            border: 2px solid transparent;
        }

        .icon-item:hover .icon-img {
            transform: scale(1.12);
            border-color: #ffc107;
        }

        .label-text {
            font-size: .9rem;
            font-weight: 700;
        }

        .icon-left, .icon-right {
            position: absolute;
            bottom: 30px;
            display: flex;
            z-index: 7;
            
        }

        .icon-left {
            left: 30px;
            gap: 18px;
        }

        .icon-right {
            right: 30px;
            flex-direction: column;
            gap: 18px;
        }
        
        /* 📱 Responsive */
        @media (max-width: 1200px) {
            .chart-container { width: 380px; height: 380px; }
            .logo-center-wrapper { width: 145px; height: 145px; }
        }

        @media (max-width: 992px) {
            .animated-title { font-size: 2rem; }
            .chart-container { width: 340px; height: 340px; }
            .logo-center-wrapper { width: 130px; height: 130px; }
            .center-chart { top: 63%; }
            .icon-img { width: 80px; height: 80px; }
        }

        @media (max-width: 768px) {
            .center-chart { top: 65%; left: 50%; }
            .chart-container { width: 300px; height: 300px; }
            .logo-center-wrapper { width: 118px; height: 118px; top: 58%; }
            .icon-img { width: 65px; height: 65px; }
        }

        @media (max-width: 576px) {
            .button{
                top:40px;
                left:30px;
            }
        .animated-title {
                font-size: 1.4rem;
                top: 14px;
                left: 16px;
            }

            .center-chart {
                top: 50%;
                left: 50%;
            }

            .chart-container {
                width: 240px;
                height: 240px;
            }

            .logo-center-wrapper {
                width: 90px;
                height: 90px;
                top: 58%;
            }

            .icon-img {
                width: 53px;
                height: 53px;
            }

            .kiri {
                margin-top: -45px;
                position: relative;
                z-index: 5;
            }

            .kiri h3 {
                font-size: 1.2rem;
                margin-bottom: 14px;
            }

            .kiri .d-flex {
                gap: 10px;
            }

            .icon-item img {
                width: 60px !important;
                height: 60px !important;
            }

            .label-text {
                font-size: 0.75rem;
                margin-top: 3px;
                display: block;
            }

            .col-12.col-md-3.text-center:nth-child(2) {
                padding-top: 260px;
            }        
}

        /* From Uiverse.io by MuhammadHasann */ 
        .button {
        --black-700: hsla(0 0% 12% / 1);
        --border_radius: 9999px;
        --transtion: 0.3s ease-in-out;
        --offset: 2px;

        cursor: pointer;
        position: relative;

        display: flex;
        align-items: center;
        gap: 0.5rem;

        transform-origin: center;

        padding: 1rem 2rem;
        background-color: transparent;

        border: none;
        border-radius: var(--border_radius);
        transform: scale(calc(1 + (var(--active, 0) * 0.1)));

        transition: transform var(--transtion);
        }

        .button::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        width: 80%;
        height: 80%;
        background-color: var(--black-700);

        border-radius: var(--border_radius);
        box-shadow: inset 0 0.5px hsl(0, 0%, 100%), inset 0 -1px 2px 0 hsl(0, 0%, 0%),
            0px 4px 10px -4px hsla(0 0% 0% / calc(1 - var(--active, 0))),
            0 0 0 calc(var(--active, 0) * 0.375rem) hsl(260 97% 50% / 0.75);

        transition: all var(--transtion);
        z-index: 0;
        }

        .button::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        width: 100%;
        height: 100%;
        background-color: hsla(260 97% 61% / 0.75);
        background-image: radial-gradient(
            at 51% 89%,
            hsla(266, 45%, 74%, 1) 0px,
            transparent 50%
            ),
            radial-gradient(at 100% 100%, hsla(266, 36%, 60%, 1) 0px, transparent 50%),
            radial-gradient(at 22% 91%, hsla(266, 36%, 60%, 1) 0px, transparent 50%);
        background-position: top;

        opacity: var(--active, 0);
        border-radius: var(--border_radius);
        transition: opacity var(--transtion);
        z-index: 2;
        }

        .button:is(:hover, :focus-visible) {
        --active: 1;
        }
        .button:active {
        transform: scale(1);
        }

        .button .dots_border {
        --size_border: calc(100% + 2px);

        overflow: hidden;

        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        width: var(--size_border);
        height: var(--size_border);
        background-color: transparent;

        border-radius: var(--border_radius);
        z-index: -10;
        }

        .button .dots_border::before {
        content: "";
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
        transform-origin: left;
        transform: rotate(0deg);

        width: 100%;
        height: 2rem;
        background-color: white;

        mask: linear-gradient(transparent 0%, white 120%);
        animation: rotate 2s linear infinite;
        }

        @keyframes rotate {
        to {
            transform: rotate(360deg);
        }
        }

        .button .sparkle {
        position: relative;
        z-index: 10;

        width: 1.75rem;
        }

        .button .sparkle .path {
        fill: currentColor;
        stroke: currentColor;

        transform-origin: center;

        color: hsl(0, 0%, 100%);
        }

        .button:is(:hover, :focus) .sparkle .path {
        animation: path 1.5s linear 0.5s infinite;
        }

        .button .sparkle .path:nth-child(1) {
        --scale_path_1: 1.2;
        }
        .button .sparkle .path:nth-child(2) {
        --scale_path_2: 1.2;
        }
        .button .sparkle .path:nth-child(3) {
        --scale_path_3: 1.2;
        }

        @keyframes path {
        0%,
        34%,
        71%,
        100% {
            transform: scale(1);
        }
        17% {
            transform: scale(var(--scale_path_1, 1));
        }
        49% {
            transform: scale(var(--scale_path_2, 1));
        }
        83% {
            transform: scale(var(--scale_path_3, 1));
        }
        }

        .button .text_button {
        position: relative;
        z-index: 10;

        background-image: linear-gradient(
            90deg,
            hsla(0 0% 100% / 1) 0%,
            hsla(0 0% 100% / var(--active, 0)) 120%
        );
        background-clip: text;

        font-size: 1rem;
        color: transparent;
        }
        .shine-text {
        position: relative;
        display: inline-block;
        overflow: hidden;
        }

        .shine-text::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        border-radius:20%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.8),
            transparent
        );
        transform: skewX(-25deg);
        animation: shine 2s infinite;
        }

        @keyframes shine {
        0% {
            left: -100%;
        }
        100% {
            left: 120%;
        }
        }
        .glow-dashboard {
        animation: glowPulse 2.5s ease-in-out infinite;
        }

        @keyframes glowPulse {
        0% {
            text-shadow: 0 0 2px rgba(255, 255, 255, 0.3);
        }
        50% {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8),
                        0 0 20px rgba(209, 0, 0, 0.6),
                        0 0 30px rgba(167, 0, 0, 0.4);
        }
        100% {
            text-shadow: 0 0 2px rgba(255, 255, 255, 1);
        }
        }
        .icon-img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            cursor: pointer;
            transition: 0.3s;
        }

        .icon-img:hover {
            transform: scale(1.1);
        }

        
    </style>
</x-app-layout>
