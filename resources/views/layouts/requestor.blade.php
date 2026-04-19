<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NUPost – @yield('title', 'Dashboard')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
<style>
:root {
    --sidebar-bg:   #111111;
    --sidebar-w:    72px;
    --accent:       #3b6ef5;
    --accent-dim:   rgba(59,110,245,0.15);
    --navy:         #0e2040;
    --navy-light:   #132648;

    --page-bg:      #d8dce8;
    --card-bg:      #ffffff;
    --border:       #e4e8f0;
    --text:         #111827;
    --text-muted:   #6b7280;
    --text-faint:   #9ca3af;

    --font:         'DM Sans', sans-serif;
    --topbar-h:     64px;
    --radius-xl:    22px;
    --radius-lg:    16px;
    --radius:       12px;
    --radius-sm:    8px;

    /* admin sidebar vars */
    --sb-w:         80px;
    --sb-inner:     56px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    font-family: var(--font);
    background: var(--sidebar-bg);
    color: var(--text);
    font-size: 14px;
    -webkit-font-smoothing: antialiased;
    height: 100%;
    overflow: hidden;
}

.shell { display: flex; height: 100vh; background: #111111; }

/* ══════════════════════════════════════════════════════
   SIDEBAR — Admin style merged into requestor
══════════════════════════════════════════════════════ */
.sidebar {
    width: var(--sb-w);
    min-width: var(--sb-w);
    flex-shrink: 0;
    background: #111827;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 18px 12px 18px;
    gap: 0;
    z-index: 200;
}

/* Brand/Logo — same as admin sb-brand */
.sidebar__logo {
    width: var(--sb-inner); height: var(--sb-inner);
    border-radius: 16px;
    background: var(--accent);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(59,110,245,0.45);
    margin-bottom: 20px;
    text-decoration: none; overflow: hidden;
    transition: transform .2s;
}
.sidebar__logo:hover { transform: scale(1.06); }
.sidebar__logo img { width: 28px; height: 28px; object-fit: contain; }
.sidebar__logo-text { font-size: 15px; font-weight: 800; color: white; }

/* ── Grouped pill container — the key admin detail */
.sb-group {
    background: #1e2a3a;
    border-radius: 20px;
    padding: 6px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    width: var(--sb-inner);
    flex-shrink: 0;
}

.sb-spacer { flex: 1; }

/* ── Individual nav item — exact admin style */
.sb-item {
    position: relative;
    width: 44px; height: 44px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.38);
    text-decoration: none;
    transition: all .2s cubic-bezier(.34,1.4,.64,1);
    cursor: pointer; flex-shrink: 0;
}
.sb-item svg { transition: transform .2s cubic-bezier(.34,1.4,.64,1); }
.sb-item:hover {
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.85);
}
.sb-item:hover svg { transform: scale(1.15); }

/* Per-icon hover colors */
.sb-item--dashboard:hover { color: #7da8ff !important; }
.sb-item--requests:hover  { color: #6ee7b7 !important; }
.sb-item--calendar:hover  { color: #c084fc !important; }
.sb-item--notifs:hover    { color: #fbbf24 !important; }
.sb-item--profile:hover   { color: #fca5a5 !important; }
.sb-item--create:hover    { color: #86efac !important; }

/* Active states — per-icon colored backgrounds */
.sb-item.active { color: white; box-shadow: 0 3px 12px rgba(0,0,0,0.3); }
.sb-item.active svg { transform: scale(1.05); }
.sb-item--dashboard.active { background: rgba(59,110,245,0.28); }
.sb-item--requests.active  { background: rgba(16,185,129,0.25); }
.sb-item--calendar.active  { background: rgba(168,85,247,0.25); }
.sb-item--notifs.active    { background: rgba(245,158,11,0.25); }
.sb-item--profile.active   { background: rgba(239,68,68,0.22); }

/* Amber left bar on active — admin signature */
.sb-item.active::before {
    content: ''; position: absolute;
    left: -6px; top: 28%; height: 44%;
    width: 3px; border-radius: 0 3px 3px 0;
    background: #f59e0b;
}

/* Notif dot */
.sb-item__dot {
    position: absolute; top: 8px; right: 8px;
    width: 7px; height: 7px; background: #ef4444;
    border-radius: 50%; border: 2px solid #111827;
}

/* ── Tooltip — admin style with arrow */
.sb-label {
    position: absolute;
    left: calc(100% + 16px); top: 50%;
    transform: translateY(-50%) scale(0.9) translateX(-6px);
    background: #0d1b3e; color: white;
    font-size: 11.5px; font-weight: 600; font-family: var(--font);
    padding: 6px 12px; border-radius: 10px; white-space: nowrap;
    opacity: 0; pointer-events: none;
    transition: all .18s cubic-bezier(.34,1.3,.64,1);
    box-shadow: 0 4px 16px rgba(0,0,0,0.3); z-index: 9999;
}
.sb-label::before {
    content: ''; position: absolute;
    left: -5px; top: 50%; transform: translateY(-50%);
    border: 5px solid transparent;
    border-right-color: #0d1b3e; border-left: 0;
}
.sb-item:hover .sb-label,
.sb-foot-item:hover .sb-label { opacity: 1; transform: translateY(-50%) scale(1) translateX(0); }

/* MINI CALENDAR — stays same as before */
.sidebar__cal {
    margin: 10px 0 14px; padding: 12px 8px;
    background: var(--navy); border-radius: 14px; width: var(--sb-inner);
    display: flex; flex-direction: column; align-items: center; gap: 5px;
}
.cal__month   { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: rgba(255,255,255,0.4); }
.cal__day-num { font-size: 20px; font-weight: 700; color: white; line-height: 1; }
.cal__weekday { font-size: 9px; color: rgba(255,255,255,0.4); font-weight: 600; }
.cal__dots    { display: flex; gap: 3px; }
.cal__dot     { width: 5px; height: 5px; border-radius: 50%; background: var(--accent); opacity: 0.6; }
.cal__dot:first-child { opacity: 1; }

/* ── Footer items — admin sb-foot style */
.sb-foot {
    display: flex; flex-direction: column; align-items: center;
    gap: 6px; width: var(--sb-inner); flex-shrink: 0;
}

/* Create button (+ button in bottom group) */
.sb-create {
    width: 44px; height: 44px; border-radius: 14px;
    background: var(--accent); color: white;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; transition: all .2s cubic-bezier(.34,1.4,.64,1);
    box-shadow: 0 4px 14px rgba(59,110,245,0.5);
    position: relative;
}
.sb-create:hover { transform: scale(1.08); box-shadow: 0 6px 20px rgba(59,110,245,0.6); }
.sb-create svg { transition: transform .2s cubic-bezier(.34,1.4,.64,1); }
.sb-create:hover svg { transform: scale(1.15) rotate(90deg); }

.sb-foot-item {
    position: relative;
    width: 44px; height: 44px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.35); cursor: pointer;
    background: none; border: none;
    transition: all .2s cubic-bezier(.34,1.4,.64,1); font-family: var(--font);
}
.sb-foot-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.8); }
.sb-foot-item:hover svg { transform: scale(1.12); }
.sb-foot-item svg { transition: transform .2s; }

/* ── MAIN WRAPPER ────────────────────── */
.main-wrapper {
    flex: 1; background: #e8ecf4;
    border-radius: var(--radius-xl);
    margin: 10px 10px 10px 0;
    display: flex; flex-direction: column;
    overflow: hidden; min-width: 0;
}

/* ── TOPBAR ──────────────────────────── */
.topbar {
    height: var(--topbar-h); background: var(--card-bg);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    padding: 0 28px; gap: 16px; flex-shrink: 0;
    border-radius: var(--radius-xl) var(--radius-xl) 0 0;
}
.topbar__title { font-size: 20px; font-weight: 700; letter-spacing: -0.4px; }
.topbar__search { flex: 1; max-width: 320px; position: relative; margin: 0 auto; }
.topbar__search input {
    width: 100%; height: 38px; border: 1.5px solid var(--border); border-radius: 20px;
    padding: 0 14px 0 38px; font-size: 13px; font-family: var(--font);
    background: #f4f6fb; outline: none; color: var(--text); transition: border-color .15s;
}
.topbar__search input::placeholder { color: var(--text-faint); }
.topbar__search input:focus { border-color: var(--accent); background: white; }
.topbar__search-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--text-faint); pointer-events: none; }
.topbar__search button[type="submit"] { display: none; }

.topbar__actions { display: flex; align-items: center; gap: 10px; margin-left: auto; }
.topbar__icon-btn {
    position: relative; width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    background: #f4f6fb; border: 1.5px solid var(--border);
    cursor: pointer; color: var(--text-muted); text-decoration: none; transition: all .15s;
}
.topbar__icon-btn:hover { background: var(--border); color: var(--text); }
.topbar__icon-btn--active { background: var(--accent-dim); border-color: rgba(59,110,245,0.25); color: var(--accent); }
.topbar__badge {
    position: absolute; top: 4px; right: 4px;
    width: 14px; height: 14px; background: #ef4444; color: white;
    font-size: 8px; font-weight: 700; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--card-bg);
}
.topbar__user {
    display: flex; align-items: center; gap: 8px;
    padding: 4px 12px 4px 4px; border: 1.5px solid var(--border); border-radius: 24px;
    cursor: pointer; transition: all .15s; text-decoration: none; color: var(--text); background: white;
}
.topbar__user:hover { border-color: #c8d0de; background: #f4f6fb; }
.topbar__avatar {
    width: 30px; height: 30px; border-radius: 50%;
    background: var(--accent-dim);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; color: var(--accent);
    overflow: hidden; flex-shrink: 0;
}
.topbar__avatar img { width: 100%; height: 100%; object-fit: cover; }
.topbar__username { font-size: 13px; font-weight: 600; }

/* ── PAGE CONTENT ────────────────────── */
.page-content { flex: 1; overflow-y: auto; background: #e8ecf4; }

/* ── SHARED ──────────────────────────── */
.badge { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
.badge--approved     { background: #dcfce7; color: #15803d; }
.badge--posted       { background: #ede9fe; color: #6d28d9; }
.badge--under-review { background: #fef3c7; color: #b45309; }
.badge--pending      { background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }
.badge--rejected     { background: #fee2e2; color: #b91c1c; }
.badge--high         { background: #fee2e2; color: #b91c1c; }
.badge--urgent       { background: #fff7ed; color: #c2410c; }
.badge--medium       { background: #fef3c7; color: #b45309; }
.badge--low          { background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }
.tag { display: inline-flex; padding: 2px 8px; border-radius: 5px; font-size: 11px; background: #f3f4f6; color: #374151; }

.alert { padding: 12px 16px; border-radius: var(--radius-sm); font-size: 13px; margin-bottom: 16px; font-weight: 500; }
.alert--success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.alert--error   { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
</style>
@yield('head-styles')
</head>
<body>

<div class="shell">

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">

        {{-- LOGO --}}
        <a href="{{ route('requestor.dashboard') }}" class="sidebar__logo">
            <img src="/assets/nupostlogo.png" alt=""
                 onerror="this.style.display='none';this.parentElement.innerHTML='<span class=\'sidebar__logo-text\'>N</span>'">
        </a>

        {{-- MAIN NAV GROUP (admin-style pill container) --}}
        <div class="sb-group">
            <a href="{{ route('requestor.dashboard') }}"
               class="sb-item sb-item--dashboard {{ request()->routeIs('requestor.dashboard') ? 'active' : '' }}">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
                <span class="sb-label">Dashboard</span>
            </a>
            <a href="{{ route('requestor.requests') }}"
               class="sb-item sb-item--requests {{ request()->routeIs('requestor.requests*') && !request()->routeIs('requestor.requests.create') ? 'active' : '' }}">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="sb-label">My Requests</span>
            </a>
            <a href="{{ route('requestor.calendar') }}"
               class="sb-item sb-item--calendar {{ request()->routeIs('requestor.calendar') ? 'active' : '' }}">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2.5"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span class="sb-label">Calendar</span>
            </a>
            <a href="{{ route('requestor.notifications') }}"
               class="sb-item sb-item--notifs {{ request()->routeIs('requestor.notifications') ? 'active' : '' }}">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                @if(($unread_count ?? 0) > 0)<span class="sb-item__dot"></span>@endif
                <span class="sb-label">Notifications</span>
            </a>
        </div>

        <div class="sb-spacer"></div>

        {{-- MINI CALENDAR --}}
        <div class="sidebar__cal">
            <div class="cal__month">{{ date('M') }}</div>
            <div class="cal__day-num">{{ date('j') }}</div>
            <div class="cal__weekday">{{ date('D') }}</div>
            <div class="cal__dots">
                <div class="cal__dot"></div>
                <div class="cal__dot"></div>
                <div class="cal__dot"></div>
            </div>
        </div>

        {{-- FOOTER GROUP --}}
        <div class="sb-foot">
            {{-- Create button --}}
            <a href="{{ route('requestor.requests.create') }}" class="sb-create" style="margin-bottom:6px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span class="sb-label">New Request</span>
            </a>
            {{-- Profile --}}
            <button class="sb-foot-item sb-foot-item--profile"
               onclick="window.location='{{ route('requestor.profile') }}'"
               style="color: {{ request()->routeIs('requestor.profile*') || request()->routeIs('requestor.settings') ? 'rgba(255,255,255,0.85)' : '' }}">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="sb-label">Profile</span>
            </button>
        </div>

    </aside>

    <!-- ── FLOATING MAIN WRAPPER ── -->
    <div class="main-wrapper">

        <header class="topbar">
            <div class="topbar__title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar__search">
                <form method="GET" action="{{ route('requestor.requests') }}">
                    <span class="topbar__search-icon">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input type="text" name="search" placeholder="Search requests..."
                           value="{{ request()->routeIs('requestor.requests*') ? request('search', '') : '' }}"
                           autocomplete="off">
                    <button type="submit"></button>
                </form>
            </div>
            <div class="topbar__actions">
                <a href="{{ route('requestor.notifications') }}"
                   class="topbar__icon-btn {{ request()->routeIs('requestor.notifications') ? 'topbar__icon-btn--active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    @if(($unread_count ?? 0) > 0)<span class="topbar__badge">{{ $unread_count > 9 ? '9+' : $unread_count }}</span>@endif
                </a>
                <a href="{{ route('requestor.profile') }}" class="topbar__user">
                    <div class="topbar__avatar">
                        @if(isset($auth_user) && $auth_user->profile_photo && file_exists(public_path('uploads/' . $auth_user->profile_photo)))
                            <img src="/uploads/{{ $auth_user->profile_photo }}" alt="">
                        @else
                            {{ strtoupper(substr(session('name', 'U'), 0, 1)) }}
                        @endif
                    </div>
                    <span class="topbar__username">{{ session('name', 'User') }}</span>
                </a>
            </div>
        </header>

        <div class="page-content">
            @yield('content')
        </div>

    </div>

</div>

@yield('scripts')
</body>
</html>