@extends('layouts.requestor')

@section('title', 'Calendar')
@section('page-title', 'Calendar')

@section('head-styles')
<style>
.main { padding: 24px 26px 36px; }

/* ── PAGE HEADER ────────────────────── */
.page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 12px;
    margin-bottom: 20px;
}
.page-header-left h1 { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: var(--text); }
.page-header-left p  { font-size: 13px; color: var(--text-muted); margin-top: 3px; }

/* TOGGLE */
.toggle-wrap { display: flex; align-items: center; gap: 10px; flex-shrink: 0; margin-top: 4px; }
.toggle-label { font-size: 12.5px; font-weight: 600; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
.toggle-btn {
    position: relative; width: 42px; height: 23px;
    border-radius: 12px; background: #d1d5db;
    border: none; cursor: pointer; transition: background .25s;
    flex-shrink: 0; padding: 0;
}
.toggle-btn.on { background: #10b981; }
.toggle-btn::after {
    content: ''; position: absolute;
    top: 3px; left: 3px; width: 17px; height: 17px;
    border-radius: 50%; background: white;
    transition: transform .25s; box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
.toggle-btn.on::after { transform: translateX(19px); }

/* PUBLIC BANNER */
.public-banner {
    display: flex; align-items: flex-start; gap: 10px;
    background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(5,150,105,0.06));
    border: 1.5px solid rgba(16,185,129,0.3);
    border-radius: 14px; padding: 13px 16px;
    font-size: 12.5px; color: #065f46;
    margin-bottom: 16px;
    animation: fadeIn .35s ease;
}
.public-banner svg { flex-shrink: 0; margin-top: 1px; color: #059669; }
@keyframes fadeIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }

/* ══════════════════════════════════════
   CALENDAR CARD — PRIVATE MODE (dark navy)
══════════════════════════════════════ */
.cal-card {
    border-radius: 22px;
    overflow: hidden; margin-bottom: 16px;
    transition: all .5s cubic-bezier(.4,0,.2,1);
    position: relative;
}

/* PRIVATE: dark blue gradient (like admin) */
.cal-card--private {
    background: linear-gradient(160deg, #001a4d 0%, #002366 55%, #003080 100%);
    box-shadow: 0 8px 32px rgba(0,26,77,0.35);
    border: none;
}

/* PUBLIC: soft teal/green gradient — very different feel */
.cal-card--public {
    background: linear-gradient(160deg, #064e3b 0%, #065f46 45%, #047857 100%);
    box-shadow: 0 8px 32px rgba(4,120,87,0.35);
    border: none;
}

/* TOOLBAR */
.cal-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px; border-bottom: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.15);
}
.cal-toolbar-left { display: flex; align-items: center; gap: 12px; }
.cal-mode-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-size: 10.5px; font-weight: 700; letter-spacing: 0.3px;
    transition: all .35s;
}
.cal-mode-badge--private { background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.8); border: 1px solid rgba(255,255,255,0.18); }
.cal-mode-badge--public  { background: rgba(52,211,153,0.2); color: #6ee7b7; border: 1px solid rgba(52,211,153,0.35); }
.cal-mode-badge__dot { width: 6px; height: 6px; border-radius: 50%; }
.cal-mode-badge--private .cal-mode-badge__dot { background: rgba(255,255,255,0.6); }
.cal-mode-badge--public  .cal-mode-badge__dot { background: #34d399; box-shadow: 0 0 6px #34d399; }

.cal-nav { display: flex; align-items: center; gap: 10px; }
.cal-nav-btn {
    width: 28px; height: 28px; border-radius: 8px;
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.18);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.7); transition: all .15s; text-decoration: none;
}
.cal-nav-btn:hover { background: rgba(255,255,255,0.2); color: white; }
.cal-month-label { font-size: 14px; font-weight: 700; min-width: 110px; text-align: center; color: white; letter-spacing: -0.3px; }
.cal-today-btn {
    padding: 6px 14px; border-radius: 8px;
    background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
    font-size: 12px; font-weight: 600; cursor: pointer;
    color: rgba(255,255,255,0.8); font-family: var(--font); text-decoration: none;
    transition: all .15s;
}
.cal-today-btn:hover { background: rgba(255,255,255,0.2); color: white; }

/* CALENDAR GRID */
.cal-grid { width: 100%; border-collapse: collapse; table-layout: fixed; }
.cal-grid thead th {
    padding: 10px 8px; text-align: center;
    font-size: 10px; font-weight: 700;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase; letter-spacing: 0.7px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.1);
}
.cal-grid tbody td {
    vertical-align: top; height: 90px; padding: 7px 8px;
    border: 1px solid rgba(255,255,255,0.06); font-size: 12px;
    transition: background .12s;
}
.cal-grid tbody td:hover { background: rgba(255,255,255,0.06); }

.cal-day-num {
    font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.55);
    width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%; margin-bottom: 3px;
}
/* TODAY: amber in private, bright teal in public */
.cal-card--private .cal-day-num--today {
    background: #f59e0b; color: #1a1a1a; font-weight: 800;
    box-shadow: 0 3px 10px rgba(245,158,11,0.45);
}
.cal-card--public .cal-day-num--today {
    background: #34d399; color: #064e3b; font-weight: 800;
    box-shadow: 0 3px 10px rgba(52,211,153,0.45);
}
.cal-day--other .cal-day-num { color: rgba(255,255,255,0.2); }
.cal-day--other { background: rgba(0,0,0,0.12); }

/* Event pills */
.day-load { width: 100%; height: 3px; border-radius: 2px; margin-bottom: 3px; }
.day-load--low    { background: rgba(52,211,153,0.5); }
.day-load--medium { background: rgba(251,191,36,0.6); }
.day-load--high   { background: rgba(239,68,68,0.6); }
.day-count { font-size: 9px; font-weight: 600; color: rgba(255,255,255,0.45); margin-bottom: 2px; }

.cal-event {
    display: block; padding: 2px 6px; border-radius: 5px;
    font-size: 10px; font-weight: 600; color: white;
    margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.5;
}
/* Private mode events */
.cal-card--private .cal-event            { background: rgba(59,110,245,0.75); }
.cal-card--private .cal-event--posted   { background: rgba(124,58,237,0.75); }
.cal-card--private .cal-event--approved { background: rgba(5,150,105,0.75); }
.cal-card--private .cal-event--pending  { background: rgba(148,163,184,0.5); }
.cal-card--private .cal-event--review   { background: rgba(217,119,6,0.75); }
.cal-card--private .cal-event--others   { background: rgba(203,213,225,0.25); color: rgba(255,255,255,0.6); font-style: italic; }
.cal-card--private .cal-event--mine     { border-left: 2.5px solid #f97316; }

/* Public mode events — different accent colors */
.cal-card--public .cal-event            { background: rgba(52,211,153,0.6); }
.cal-card--public .cal-event--posted    { background: rgba(167,139,250,0.7); }
.cal-card--public .cal-event--approved  { background: rgba(74,222,128,0.7); }
.cal-card--public .cal-event--pending   { background: rgba(148,163,184,0.4); }
.cal-card--public .cal-event--review    { background: rgba(251,191,36,0.7); }
.cal-card--public .cal-event--others    { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.55); font-style: italic; }
.cal-card--public .cal-event--mine      { border-left: 2.5px solid #fbbf24; }

/* LEGEND */
.cal-legend {
    display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
    padding: 12px 22px; border-top: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.15);
}
.legend-item { display: flex; align-items: center; gap: 6px; font-size: 11px; color: rgba(255,255,255,0.5); }
.legend-dot  { width: 9px; height: 9px; border-radius: 3px; flex-shrink: 0; }

/* Private legend dots */
.cal-card--private .legend-dot--mine    { background: rgba(59,110,245,0.8); }
.cal-card--private .legend-dot--others  { background: rgba(203,213,225,0.4); }
.cal-card--private .legend-dot--posted  { background: rgba(124,58,237,0.8); }
.cal-card--private .legend-dot--today   { background: #f59e0b; border-radius: 50%; }
.cal-card--private .legend-dot--busy-low  { background: rgba(52,211,153,0.5); }
.cal-card--private .legend-dot--busy-high { background: rgba(239,68,68,0.6); }

/* Public legend dots */
.cal-card--public .legend-dot--mine    { background: rgba(52,211,153,0.8); }
.cal-card--public .legend-dot--others  { background: rgba(255,255,255,0.25); }
.cal-card--public .legend-dot--posted  { background: rgba(167,139,250,0.8); }
.cal-card--public .legend-dot--today   { background: #34d399; border-radius: 50%; }
.cal-card--public .legend-dot--busy-low  { background: rgba(52,211,153,0.5); }
.cal-card--public .legend-dot--busy-high { background: rgba(239,68,68,0.6); }

/* ── UPCOMING CARD ──────────────────── */
.upcoming-card {
    background: white; border-radius: 18px;
    border: 1.5px solid var(--border);
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    padding: 20px 24px;
}
.upcoming-card h3 { font-size: 14px; font-weight: 700; margin-bottom: 14px; color: var(--text); }
.upcoming-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; padding: 24px; color: var(--text-faint); gap: 8px;
}
.upcoming-empty p { font-size: 13px; }
.upcoming-item {
    display: flex; align-items: center; gap: 14px;
    padding: 11px 0; border-bottom: 1px solid #f3f4f6;
}
.upcoming-item:last-child { border-bottom: none; }
.upcoming-dot { width: 9px; height: 9px; border-radius: 50%; background: #001a6e; flex-shrink: 0; }
.upcoming-dot--others { background: #cbd5e1; }
.upcoming-dot--posted { background: #7c3aed; }
.upcoming-title { font-size: 13px; font-weight: 600; color: var(--text); }
.upcoming-meta  { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }
.upcoming-mine-tag {
    display: inline-block; padding: 1px 8px;
    background: #dbeafe; color: #1d4ed8;
    border-radius: 10px; font-size: 10px; font-weight: 700; margin-left: 6px;
}
.upcoming-others-tag {
    display: inline-block; padding: 1px 8px;
    background: #f1f5f9; color: #64748b;
    border-radius: 10px; font-size: 10px; font-weight: 700; margin-left: 6px;
}

@media (max-width: 768px) {
    .cal-grid tbody td { height: 64px; padding: 4px; }
    .page-header { flex-direction: column; }
}
</style>
@endsection

@section('content')
<div class="main">

    <div class="page-header">
        <div class="page-header-left">
            <h1>Post Tracking Calendar</h1>
            <p>{{ $is_public ? "Showing all users' preferred posting dates (titles only)" : 'Showing your personal post schedule' }}</p>
        </div>
        <div class="toggle-wrap">
            <span class="toggle-label">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Public Calendar
            </span>
            <a href="{{ route('requestor.calendar', ['toggle_public' => 1, 'month' => $month, 'year' => $year]) }}" style="text-decoration:none;">
                <div class="toggle-btn {{ $is_public ? 'on' : '' }}"></div>
            </a>
        </div>
    </div>

    @if($is_public)
    <div class="public-banner">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span><strong>Public view is ON</strong> — You can see all users' preferred posting dates (titles only, no personal info). Dates with many requests are highlighted in red so you can pick a less busy date. <strong>Your requests</strong> are shown with a yellow left border.</span>
    </div>
    @endif

    {{-- CALENDAR CARD — class changes based on $is_public --}}
    <div class="cal-card {{ $is_public ? 'cal-card--public' : 'cal-card--private' }}">

        <div class="cal-toolbar">
            <div class="cal-toolbar-left">
                {{-- Mode badge --}}
                <div class="cal-mode-badge {{ $is_public ? 'cal-mode-badge--public' : 'cal-mode-badge--private' }}">
                    <span class="cal-mode-badge__dot"></span>
                    {{ $is_public ? 'Public View' : 'My Schedule' }}
                </div>
                <div class="cal-nav">
                    <a href="{{ route('requestor.calendar', ['month' => $prev_month, 'year' => $prev_year, 'public' => $is_public ? 1 : 0]) }}" class="cal-nav-btn">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                    <span class="cal-month-label">{{ $month_name }}</span>
                    <a href="{{ route('requestor.calendar', ['month' => $next_month, 'year' => $next_year, 'public' => $is_public ? 1 : 0]) }}" class="cal-nav-btn">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </div>
            </div>
            <a href="{{ route('requestor.calendar', ['month' => $today_month, 'year' => $today_year]) }}" class="cal-today-btn">Today</a>
        </div>

        <table class="cal-grid">
            <thead>
                <tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>
            </thead>
            <tbody>
            @php
                $cell = 0;
                $total_cells = ceil(($first_day + $days_in_month) / 7) * 7;
                $user_name = session('name');
                echo "<tr>";
                for ($i = 0; $i < $total_cells; $i++) {
                    $day_num    = $i - $first_day + 1;
                    $is_current = ($day_num >= 1 && $day_num <= $days_in_month);
                    $is_today   = $is_current && $day_num === $today_day && $month === $today_month && $year === $today_year;

                    if ($is_current)         $display_num = $day_num;
                    elseif ($i < $first_day) $display_num = $days_in_prev - ($first_day - $i - 1);
                    else                     $display_num = $day_num - $days_in_month;

                    $cell_class = $is_current ? "" : "cal-day--other";
                    echo "<td class='$cell_class'>";
                    $num_class = $is_today ? "cal-day-num cal-day-num--today" : "cal-day-num";
                    echo "<div class='$num_class'>$display_num</div>";

                    if ($is_current && isset($events[$day_num])) {
                        $day_events = $events[$day_num];
                        $count      = count($day_events);

                        if ($is_public) {
                            $busy_class = $count >= 4 ? "high" : ($count >= 2 ? "medium" : "low");
                            echo "<div class='day-load day-load--$busy_class'></div>";
                            echo "<div class='day-count'>$count req" . ($count > 1 ? "s" : "") . "</div>";
                        }

                        $shown = 0;
                        foreach ($day_events as $ev) {
                            if ($shown >= ($is_public ? 2 : 3)) break;
                            $st      = strtolower($ev->status);
                            $is_mine = $is_public ? ($ev->requester === $user_name) : true;

                            if ($is_public && !$is_mine) {
                                $short = htmlspecialchars(mb_strimwidth($ev->title, 0, 18, "…"));
                                echo "<span class='cal-event cal-event--others' title='Someone else has a request on this date'>$short</span>";
                            } else {
                                $ev_class = match(true) {
                                    str_contains($st, "posted")       => "cal-event cal-event--posted",
                                    str_contains($st, "approved")     => "cal-event cal-event--approved",
                                    str_contains($st, "under review") => "cal-event cal-event--review",
                                    default                           => "cal-event cal-event--pending",
                                };
                                if ($is_public) $ev_class .= " cal-event--mine";
                                $short = htmlspecialchars(mb_strimwidth($ev->title, 0, 18, "…"));
                                echo "<span class='$ev_class' title='" . htmlspecialchars($ev->title) . ($is_public ? " (Your request)" : "") . "'>$short</span>";
                            }
                            $shown++;
                        }
                        $remaining = $count - $shown;
                        if ($remaining > 0) {
                            echo "<span style='font-size:9px;color:rgba(255,255,255,0.7);font-weight:700;'>+$remaining more</span>";
                        }
                    }
                    echo "</td>";
                    $cell++;
                    if ($cell % 7 === 0 && $i < $total_cells - 1) echo "</tr><tr>";
                }
                echo "</tr>";
            @endphp
            </tbody>
        </table>

        <div class="cal-legend">
            @if($is_public)
                <div class="legend-item"><span class="legend-dot legend-dot--mine"></span>Your request</div>
                <div class="legend-item"><span class="legend-dot legend-dot--others"></span>Others' request</div>
                <div class="legend-item"><span class="legend-dot legend-dot--busy-low"></span>Open day</div>
                <div class="legend-item"><span class="legend-dot legend-dot--busy-high"></span>Busy day</div>
                <div class="legend-item"><span class="legend-dot legend-dot--today"></span>Today</div>
            @else
                <div class="legend-item"><span class="legend-dot legend-dot--mine"></span>Scheduled</div>
                <div class="legend-item"><span class="legend-dot legend-dot--posted"></span>Posted</div>
                <div class="legend-item"><span class="legend-dot legend-dot--today"></span>Today</div>
            @endif
        </div>
    </div>

    <div class="upcoming-card">
        <h3>{{ $is_public ? 'Upcoming Posts — Next 7 Days (All Users)' : 'Your Upcoming Posts — Next 7 Days' }}</h3>
        @if($upcoming->isEmpty())
            <div class="upcoming-empty">
                <svg width="36" height="36" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <p>No upcoming scheduled posts in the next 7 days</p>
            </div>
        @else
            @foreach($upcoming as $up)
                @php
                    $st        = strtolower($up->status);
                    $is_mine   = $up->is_mine ?? true;
                    $dot_class = !$is_mine ? "upcoming-dot upcoming-dot--others"
                               : (str_contains($st, "posted") ? "upcoming-dot upcoming-dot--posted" : "upcoming-dot");
                    $date_fmt  = $is_public
                        ? \Carbon\Carbon::parse($up->preferred_date)->format('M j, Y')
                        : \Carbon\Carbon::parse($up->created_at)->format('M j, Y · g:i A');
                @endphp
                <div class="upcoming-item">
                    <span class="{{ $dot_class }}"></span>
                    <div>
                        <div class="upcoming-title">
                            {{ $up->title }}
                            @if($is_public)
                                @if($is_mine)
                                    <span class="upcoming-mine-tag">Yours</span>
                                @else
                                    <span class="upcoming-others-tag">Others</span>
                                @endif
                            @endif
                        </div>
                        <div class="upcoming-meta">{{ $date_fmt }} · {{ $up->status }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>
@endsection