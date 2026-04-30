<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NUPost Admin – @yield('title', 'Dashboard')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=DM+Serif+Display&display=swap" rel="stylesheet">
<style>
:root {
    --cream:       #f0ede8;
    --cream-dark:  #e8e3da;
    --card:        #faf9f7;
    --card-border: rgba(0,0,0,0.07);
    --navy:        #002366;
    --navy-mid:    #003a8c;
    --navy-light:  #1e4fd8;
    --navy-pale:   #e8eef8;
    --ink:         #1a1a1a;
    --ink-mid:     #3d3d3d;
    --ink-soft:    #7a7672;
    --ink-faint:   #b5b0a8;
    --amber:       #f59e0b;
    --green:       #10b981;
    --red:         #ef4444;
    --purple:      #8b5cf6;

    --sb-w:        80px;
    --sb-inner:    56px;
    --radius:      20px;
    --radius-sm:   14px;
    --font:        'DM Sans', sans-serif;
    --font-disp:   'DM Serif Display', serif;
    --shadow-sm:   0 2px 8px rgba(0,0,0,0.05);
    --shadow:      0 6px 24px rgba(0,0,0,0.08);
    --shadow-lg:   0 12px 40px rgba(0,0,0,0.12);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    height: 100%; width: 100%;
    font-family: var(--font);
    background: #111111;
    color: var(--ink);
    font-size: 14px;
    -webkit-font-smoothing: antialiased;
    overflow: hidden;
}

/* ── SHELL (same floating pattern as requestor) */
.shell { display: flex; height: 100vh; background: #111111; }

/* ══════════════════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════════════════ */
.sidebar {
    width: var(--sb-w);
    min-width: var(--sb-w);
    flex-shrink: 0;
    background: #111827;
    display: flex; flex-direction: column; align-items: center;
    padding: 18px 12px 18px; gap: 0; z-index: 200;
}

.sb-brand {
    width: var(--sb-inner); height: var(--sb-inner);
    border-radius: 16px; background: var(--navy);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; box-shadow: 0 4px 16px rgba(0,35,102,0.5);
    margin-bottom: 20px; cursor: default; transition: transform .2s;
}
.sb-brand:hover { transform: scale(1.06); }
.sb-brand svg { color: white; }

.sb-group {
    background: #1e2a3a; border-radius: 20px;
    padding: 6px; display: flex; flex-direction: column;
    gap: 2px; width: var(--sb-inner); flex-shrink: 0;
}
.sb-spacer { flex: 1; }

.sb-item {
    position: relative; width: 44px; height: 44px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.38); text-decoration: none;
    transition: all .2s cubic-bezier(.34,1.4,.64,1); cursor: pointer; flex-shrink: 0;
}
.sb-item svg { transition: transform .2s cubic-bezier(.34,1.4,.64,1); }
.sb-item:hover { background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.85); }
.sb-item:hover svg { transform: scale(1.15); }

/* Per-icon color on hover */
.sb-item--dashboard:hover { color: #7da8ff !important; }
.sb-item--requests:hover  { color: #6ee7b7 !important; }
.sb-item--calendar:hover  { color: #c084fc !important; }
.sb-item--analytics:hover { color: #fbbf24 !important; }
.sb-item--settings:hover  { color: #fb923c !important; }

/* Active state */
.sb-item.active { color: white; box-shadow: 0 3px 12px rgba(0,0,0,0.3); }
.sb-item.active svg { transform: scale(1.05); }
.sb-item--dashboard.active { background: rgba(59,110,245,0.28); }
.sb-item--requests.active  { background: rgba(16,185,129,0.25); }
.sb-item--calendar.active  { background: rgba(168,85,247,0.25); }
.sb-item--analytics.active { background: rgba(245,158,11,0.25); }
.sb-item--settings.active  { background: rgba(249,115,22,0.22); }

/* Amber left bar on active */
.sb-item.active::before {
    content: ''; position: absolute;
    left: -6px; top: 28%; height: 44%;
    width: 3px; border-radius: 0 3px 3px 0;
    background: var(--amber);
}

/* Tooltip */
.sb-label {
    position: absolute; left: calc(100% + 16px); top: 50%;
    transform: translateY(-50%) scale(0.9) translateX(-6px);
    background: #0d1b3e; color: white;
    font-size: 11.5px; font-weight: 600; font-family: var(--font);
    padding: 6px 12px; border-radius: 10px; white-space: nowrap;
    opacity: 0; pointer-events: none;
    transition: all .18s cubic-bezier(.34,1.3,.64,1);
    box-shadow: 0 4px 16px rgba(0,0,0,0.3); z-index: 9999;
}
.sb-label::before {
    content: ''; position: absolute; left: -5px; top: 50%; transform: translateY(-50%);
    border: 5px solid transparent; border-right-color: #0d1b3e; border-left: 0;
}
.sb-item:hover .sb-label,
.sb-foot-item:hover .sb-label { opacity: 1; transform: translateY(-50%) scale(1) translateX(0); }

.sb-foot {
    display: flex; flex-direction: column; align-items: center;
    gap: 6px; width: var(--sb-inner); flex-shrink: 0;
}
.sb-foot-item {
    position: relative; width: 44px; height: 44px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.35); cursor: pointer;
    background: none; border: none;
    transition: all .2s cubic-bezier(.34,1.4,.64,1); font-family: var(--font);
}
.sb-foot-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.8); }
.sb-foot-item:hover svg { transform: scale(1.12); }
.sb-foot-item svg { transition: transform .2s; }
.sb-foot-item--logout:hover { background: rgba(239,68,68,0.15); color: #fca5a5; }
.sb-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--navy); display: flex; align-items: center;
    justify-content: center; font-size: 14px; font-weight: 700; color: white;
    border: 2px solid rgba(255,255,255,0.12); flex-shrink: 0;
}

/* ══════════════════════════════════════════════════════
   FLOATING MAIN WRAPPER  (same as requestor)
══════════════════════════════════════════════════════ */
.main-wrapper {
    flex: 1;
    background: var(--cream);
    border-radius: 22px;
    margin: 10px 10px 10px 0;
    display: flex; flex-direction: column;
    overflow: hidden; min-width: 0;
}

/* ══════════════════════════════════════════════════════
   TOPBAR (inside the floating wrapper)
══════════════════════════════════════════════════════ */
.topbar {
    height: 64px; background: var(--card);
    border-bottom: 1px solid rgba(0,0,0,0.06);
    display: flex; align-items: center;
    padding: 0 28px; gap: 14px; flex-shrink: 0;
    border-radius: 22px 22px 0 0;
    justify-content: flex-end;
}
.topbar__right { display: flex; align-items: center; gap: 10px; margin-left: auto; }
.topbar__date {
    padding: 7px 14px; border-radius: 20px;
    background: var(--card); border: 1px solid rgba(0,0,0,0.08);
    font-size: 12px; color: var(--ink-mid); font-weight: 600; white-space: nowrap;
}
.admin-chip-wrap { position: relative; }
.topbar__admin-chip {
    display: flex; align-items: center; gap: 8px;
    padding: 5px 14px 5px 5px; border-radius: 24px;
    background: #111827; border: 1px solid rgba(255,255,255,0.08);
    cursor: pointer; transition: background .15s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.topbar__admin-chip:hover { background: #1e2a3a; }
.topbar__admin-av {
    width: 30px; height: 30px; border-radius: 50%;
    background: var(--navy); display: flex; align-items: center;
    justify-content: center; font-size: 13px; font-weight: 700; color: white;
}
.topbar__admin-name { font-size: 12.5px; font-weight: 600; color: white; }

.admin-dropdown {
    position: absolute; top: calc(100% + 10px); right: 0;
    background: var(--card); border: 1px solid rgba(0,0,0,0.08);
    border-radius: var(--radius); box-shadow: var(--shadow-lg);
    min-width: 210px; z-index: 200; overflow: hidden; display: none;
}
.admin-dropdown.open { display: block; }
.admin-dropdown__header { padding: 14px 16px; border-bottom: 1px solid rgba(0,0,0,0.06); background: var(--cream-dark); }
.admin-dropdown__name  { font-size: 13.5px; font-weight: 700; color: var(--ink); }
.admin-dropdown__email { font-size: 11.5px; color: var(--ink-soft); margin-top: 2px; }
.admin-dropdown__item {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 16px; font-size: 13px; color: var(--ink-mid);
    text-decoration: none; transition: background .12s; cursor: pointer;
    background: none; border: none; width: 100%; font-family: var(--font); text-align: left;
}
.admin-dropdown__item:hover { background: var(--cream-dark); }
.admin-dropdown__item--danger { color: #dc2626; }
.admin-dropdown__item--danger:hover { background: #fef2f2; }

/* ══════════════════════════════════════════════════════
   PAGE CONTENT AREA
══════════════════════════════════════════════════════ */
.page-content { flex: 1; overflow-y: auto; background: var(--cream); padding: 28px 30px; }

/* ══════════════════════════════════════════════════════
   GLOBAL COMPONENTS
══════════════════════════════════════════════════════ */
.badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 10.5px; font-weight: 600; white-space: nowrap; }
.badge--pending      { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
.badge--under-review { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
.badge--approved     { background: #dcfce7; color: #16a34a; }
.badge--posted       { background: #ede9fe; color: #7c3aed; }
.badge--rejected     { background: #fee2e2; color: #dc2626; }
.badge--high         { background: #fee2e2; color: #dc2626; }
.badge--urgent       { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
.badge--medium       { background: #fef3c7; color: #d97706; }
.badge--low          { background: #f1f5f9; color: #64748b; }
.alert { padding: 12px 16px; border-radius: var(--radius-sm); font-size: 13px; margin-bottom: 16px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.alert--success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.alert--error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

.panel {
    background: var(--card); border: 1px solid rgba(0,0,0,0.06);
    border-radius: var(--radius); box-shadow: var(--shadow-sm); overflow: hidden;
}
.panel__head {
    padding: 18px 22px 14px; display: flex; align-items: flex-start; justify-content: space-between;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}
.panel__title { font-family: var(--font-disp); font-size: 17px; color: var(--ink); }
.panel__sub   { font-size: 11.5px; color: var(--ink-soft); margin-top: 3px; }
.panel__link  { font-size: 12.5px; color: var(--navy-light); font-weight: 600; text-decoration: none; white-space: nowrap; }
.panel__link:hover { text-decoration: underline; }
.panel__body  { padding: 20px 22px; }

@yield('head-styles')
</style>
</head>
<body>
<div class="shell">

<!-- ═══ SIDEBAR ═══════════════════════════════════════════ -->
<aside class="sidebar">
    <div class="sb-brand">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
            <path d="M2 17l10 5 10-5"/>
            <path d="M2 12l10 5 10-5"/>
        </svg>
    </div>

    <div class="sb-group">
        <a href="{{ route('admin.dashboard') }}"
           class="sb-item sb-item--dashboard {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/></svg>
            <span class="sb-label">Dashboard</span>
        </a>
        <a href="{{ route('admin.requests') }}"
           class="sb-item sb-item--requests {{ request()->routeIs('admin.requests*') ? 'active' : '' }}">
            <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="sb-label">Requests</span>
        </a>
        <a href="{{ route('admin.calendar') }}"
           class="sb-item sb-item--calendar {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
            <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2.5"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span class="sb-label">Calendar</span>
        </a>
        <a href="{{ route('admin.analytics') }}"
           class="sb-item sb-item--analytics {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span class="sb-label">Visualization</span>
        </a>
    </div>

    <div class="sb-spacer"></div>

    <div class="sb-group" style="margin-bottom:10px;">
        <a href="{{ route('admin.settings') }}"
           class="sb-item sb-item--settings {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            <span class="sb-label">Settings</span>
        </a>
    </div>

    <div class="sb-foot">
        <div class="sb-foot-item" style="position:relative;">
            <div class="sb-avatar">A</div>
            <span class="sb-label">Administrator</span>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:contents;">
            @csrf
            <button type="submit" class="sb-foot-item sb-foot-item--logout" style="position:relative;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="sb-label">Sign Out</span>
            </button>
        </form>
    </div>
</aside>

<!-- ═══ FLOATING MAIN WRAPPER ═══════════════════════════ -->
<div class="main-wrapper">

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar__right">
            <div class="topbar__date" id="topbar-date"></div>
            <div class="admin-chip-wrap">
                <div class="topbar__admin-chip" id="admin-chip">
                    <div class="topbar__admin-av">A</div>
                    <span class="topbar__admin-name">Admin</span>
                </div>
                <div class="admin-dropdown" id="admin-dropdown">
                    <div class="admin-dropdown__header">
                        <div class="admin-dropdown__name">Administrator</div>
                        <div class="admin-dropdown__email">admin@nupost.com</div>
                    </div>
                    <a href="{{ route('admin.settings') }}" class="admin-dropdown__item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="admin-dropdown__item admin-dropdown__item--danger">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert--success">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert--error">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>

</div><!-- /.main-wrapper -->
</div><!-- /.shell -->

<script>
(function(){
    const el = document.getElementById('topbar-date');
    if(el) el.textContent = new Date().toLocaleDateString('en-US',{
        weekday:'short', month:'short', day:'numeric', year:'numeric'
    });
})();
const chip = document.getElementById('admin-chip');
const dd   = document.getElementById('admin-dropdown');
if(chip && dd){
    chip.addEventListener('click', e => { e.stopPropagation(); dd.classList.toggle('open'); });
    document.addEventListener('click', () => dd.classList.remove('open'));
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('scripts')
</body>
</html>