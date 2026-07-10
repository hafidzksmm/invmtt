<x-app-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg overflow-hidden">
    <x-app.navbar />

    <div class="dash-wrap">

        <!-- HEADER -->
        <div class="dash-header">
            <div class="dash-brand">
                <div class="dash-greeting">
                    <div class="greeting-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:26px;height:26px;">
                            <path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>
                        </svg>
                    </div>
                    <div class="greeting-text">
                        <span class="greeting-hello">Activity Log</span>
                        <span class="greeting-role">Riwayat perubahan data oleh user</span>
                    </div>
                </div>
            </div>

            <div class="dash-actions">
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

        <!-- PANEL FILTER -->
        <div class="panel table-panel">
            <form method="GET" class="panel-toolbar">
                <div class="toolbar-left" style="flex-wrap:wrap;gap:10px;">
                    <select name="user_name" class="search-input" style="min-width:180px;" onchange="this.form.submit()">
                        <option value="">-- Semua User --</option>
                        @foreach($userNames as $name)
                            <option value="{{ $name }}" @selected(request('user_name') === $name)>{{ $name }}</option>
                        @endforeach
                    </select>

                    <select name="action" class="search-input" style="min-width:160px;" onchange="this.form.submit()">
                        <option value="">-- Semua Aksi --</option>
                        <option value="created" @selected(request('action')==='created')>Tambah</option>
                        <option value="updated" @selected(request('action')==='updated')>Edit</option>
                        <option value="deleted" @selected(request('action')==='deleted')>Hapus</option>
                    </select>

                    <select name="model_type" class="search-input" style="min-width:160px;" onchange="this.form.submit()">
                        <option value="">-- Semua Data --</option>
                        @foreach($modelTypes as $type)
                            <option value="{{ $type }}" @selected(request('model_type') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="search-input" style="min-width:150px;">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="search-input" style="min-width:150px;">
                </div>

                <div class="toolbar-right">
                    <button type="submit" class="btn-pill btn-pill-red">
                        <i class="bi bi-search"></i> Terapkan
                    </button>
                    <a href="{{ route('activity-log') }}" class="btn-pill btn-pill-outline">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </form>

            <!-- TIMELINE LOG -->
            <div class="p-3">
                @forelse($logs as $log)
                    <div class="log-item log-{{ $log->action }}">
                        <div class="log-icon">
                            @if($log->action === 'created')
                                <i class="bi bi-plus-lg"></i>
                            @elseif($log->action === 'updated')
                                <i class="bi bi-pencil-fill"></i>
                            @else
                                <i class="bi bi-trash-fill"></i>
                            @endif
                        </div>

                        <div class="log-body">
                            <div class="log-top">
                                <span class="log-user">{{ $log->user_name ?? 'System' }}</span>
                                @if($log->user_role)
                                    <span class="log-role-badge">{{ ucfirst($log->user_role) }}</span>
                                @endif
                                <span class="log-time">{{ $log->created_at->diffForHumans() }} · {{ $log->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            <div class="log-desc">{{ $log->description }}</div>

                            @if($log->action === 'updated' && count($log->changed_fields))
                                <button type="button" class="log-detail-toggle" onclick="this.nextElementSibling.classList.toggle('d-none')">
                                    Lihat perubahan ({{ count($log->changed_fields) }} field) <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="log-detail d-none">
                                    <table class="log-diff-table">
                                        <thead>
                                            <tr><th>Field</th><th>Sebelum</th><th>Sesudah</th></tr>
                                        </thead>
                                        <tbody>
                                            @foreach($log->changed_fields as $field => $vals)
                                                <tr>
                                                    <td class="fw-semibold">{{ $field }}</td>
                                                    <td class="text-muted">{{ is_array($vals['old']) ? json_encode($vals['old']) : ($vals['old'] ?? '—') }}</td>
                                                    <td class="text-success">{{ is_array($vals['new']) ? json_encode($vals['new']) : ($vals['new'] ?? '—') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-4">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>

            <div class="p-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <x-app.footer />
</main>

<style>
    :root{
        --bg: #FAFAFA; --surface: #FFFFFF; --border: #ECECEC;
        --red: #E11D2E; --red-dark: #B0121F; --red-light: #FBD3D9;
        --green: #1FA97A; --green-light: #DFF5EC;
        --blue: #2F6FE4; --blue-light: #E6EEFF;
        --text: #17181A; --muted: #8A8F98;
        --shadow: 0 1px 2px rgba(16,16,16,0.04), 0 8px 24px rgba(16,16,16,0.04);
    }
    html, body, main { width:100%; overflow-x:hidden; }
    .main-content{ background:var(--bg) !important; }
    .dash-wrap{ max-width:1420px; margin:0 auto; padding:34px 32px 70px; font-family:'Inter', sans-serif; color:var(--text); }

    .dash-header{ display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; flex-wrap:wrap; gap:16px; }
    .dash-brand{ display:flex; align-items:center; gap:14px; }
    .dash-greeting{ display:flex; align-items:center; gap:14px; }
    .greeting-avatar{ width:52px; height:52px; border-radius:16px; background:var(--red); color:#fff; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 10px rgba(225,29,46,0.25); }
    .greeting-text{ display:flex; flex-direction:column; line-height:1.3; }
    .greeting-hello{ font-family:'Space Grotesk', sans-serif; font-weight:700; font-size:22px; color:var(--text); letter-spacing:-0.4px; }
    .greeting-role{ font-size:13.5px; color:var(--muted); }
    .dash-actions{ display:flex; align-items:center; gap:12px; }

    .btn-icon-nav{ display:flex; align-items:center; gap:8px; background:var(--surface); border:1px solid var(--border); padding:12px 20px; border-radius:999px; font-size:14px; font-weight:600; color:var(--text); text-decoration:none; cursor:pointer; box-shadow:var(--shadow); transition:.15s ease; }
    .btn-icon-nav svg{ width:16px; height:16px; stroke:var(--red); }
    .btn-icon-nav:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }
    .btn-icon-nav:hover svg{ stroke:var(--red-dark); }

    .panel{ background:var(--surface); border:1px solid var(--border); border-radius:22px; box-shadow:var(--shadow); }
    .table-panel{ padding:26px; }

    .panel-toolbar{ display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; padding-bottom:20px; border-bottom:1px solid var(--border); margin-bottom:10px; }
    .toolbar-left, .toolbar-right{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

    .search-input{ border:1px solid var(--border); border-radius:999px; padding:11px 20px; font-size:13.5px; background:var(--bg); color:var(--text); outline:none; transition:.15s ease; }
    .search-input:focus{ border-color:var(--red); background:var(--surface); }

    .btn-pill{ display:inline-flex; align-items:center; gap:7px; padding:10px 20px; border-radius:999px; font-size:13.5px; font-weight:600; border:none; cursor:pointer; text-decoration:none; transition:.15s ease; white-space:nowrap; }
    .btn-pill-red{ background:var(--red); color:#fff; box-shadow:0 6px 16px rgba(225,29,46,0.25); }
    .btn-pill-red:hover{ background:var(--red-dark); color:#fff; }
    .btn-pill-outline{ background:var(--surface); color:var(--text); border:1px solid var(--border); box-shadow:var(--shadow); }
    .btn-pill-outline:hover{ background:var(--red-light); border-color:var(--red); color:var(--red-dark); }

    /* TIMELINE LOG */
    .log-item{
        display:flex; gap:16px;
        padding:16px 4px;
        border-bottom:1px solid var(--border);
    }
    .log-item:last-child{ border-bottom:none; }

    .log-icon{
        width:38px; height:38px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0; color:#fff; font-size:14px;
        margin-top:2px;
    }
    .log-created .log-icon{ background:var(--green); }
    .log-updated .log-icon{ background:var(--blue); }
    .log-deleted .log-icon{ background:var(--red); }

    .log-body{ flex:1; min-width:0; }
    .log-top{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:4px; }
    .log-user{ font-weight:700; font-family:'Space Grotesk', sans-serif; font-size:14.5px; }
    .log-role-badge{ background:var(--bg); border:1px solid var(--border); padding:2px 10px; border-radius:999px; font-size:11px; color:var(--muted); text-transform:capitalize; }
    .log-time{ font-size:12px; color:var(--muted); margin-left:auto; }
    .log-desc{ font-size:14px; color:var(--text); }

    .log-detail-toggle{
        background:none; border:none; color:var(--red); font-size:12.5px; font-weight:600;
        padding:6px 0; cursor:pointer;
    }
    .log-detail{ margin-top:8px; overflow-x:auto; }
    .log-diff-table{ width:100%; border-collapse:collapse; font-size:12.5px; background:var(--bg); border-radius:10px; overflow:hidden; }
    .log-diff-table th{ text-align:left; padding:8px 12px; background:var(--red-light); color:var(--red-dark); font-weight:700; }
    .log-diff-table td{ padding:8px 12px; border-top:1px solid var(--border); vertical-align:top; }

    @media (max-width: 640px){
        .greeting-hello{ font-size:18px; }
        .btn-icon-nav span{ display:none; }
        .btn-icon-nav{ padding:12px; }
        .log-time{ margin-left:0; }
    }
</style>
</x-app-layout>
