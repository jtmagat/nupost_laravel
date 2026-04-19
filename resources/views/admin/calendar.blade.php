@extends('layouts.admin')
@section('title', 'Calendar')

@section('head-styles')
<style>
.page-hd { margin-bottom: 24px; }
.page-hd__title { font-family: var(--font-disp); font-size: 22px; color: var(--ink); }
.page-hd__sub   { font-size: 13px; color: var(--ink-soft); margin-top: 3px; }

.cal-layout { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }

/* ── CALENDAR PANEL ──────────────────────────────────── */
.cal-panel { background: var(--card); border-radius: var(--radius); border: 1px solid rgba(0,0,0,0.06); box-shadow: var(--shadow-sm); overflow: hidden; }

.cal-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 24px; border-bottom: 1.5px solid var(--card-border);
}
.cal-nav { display: flex; align-items: center; gap: 12px; }
.cal-nav-btn {
    width: 34px; height: 34px; border-radius: 10px;
    border: 1px solid rgba(0,0,0,0.06); background: var(--card);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--ink-soft); text-decoration: none;
    transition: all .15s;
}
.cal-nav-btn:hover { background: var(--navy); border-color: var(--navy); color: white; }
.cal-month-label { font-family: var(--font-disp); font-size: 18px; color: var(--ink); min-width: 160px; text-align: center; }
.cal-today-btn {
    padding: 7px 16px; border-radius: 10px; border: 1px solid rgba(0,0,0,0.06);
    background: var(--card); font-size: 12.5px; font-weight: 600; cursor: pointer;
    color: var(--ink-soft); font-family: var(--font); text-decoration: none;
    transition: all .15s;
}
.cal-today-btn:hover { background: var(--navy); border-color: var(--navy); color: white; }

.cal-grid-head { display: grid; grid-template-columns: repeat(7,1fr); padding: 8px 12px 4px; }
.cal-grid-head span { text-align: center; font-size: 10.5px; font-weight: 700; color: var(--ink-faint); letter-spacing: 0.5px; text-transform: uppercase; }

.cal-grid { display: grid; grid-template-columns: repeat(7,1fr); gap: 3px; padding: 4px 12px 16px; }
.cal-day { min-height: 90px; padding: 8px; border-radius: 12px; position: relative; transition: background .12s; }
.cal-day:hover { background: var(--cream-dark); }
.cal-day--other { opacity: 0.35; }
.cal-day--today { background: var(--navy-pale) !important; border: 1.5px solid rgba(0,35,102,0.2); }

.cal-day-num {
    font-size: 13px; font-weight: 600; color: var(--ink-mid);
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; margin-bottom: 4px;
}
.cal-day--today .cal-day-num { background: var(--navy); color: white; font-weight: 800; }
.cal-day--other .cal-day-num { color: var(--ink-faint); }

/* load bar */
.day-load { height: 3px; border-radius: 2px; margin-bottom: 5px; width: 100%; }
.day-load--low    { background: #bbf7d0; }
.day-load--medium { background: #fde68a; }
.day-load--high   { background: #fca5a5; }

.cal-event {
    display: block; padding: 2px 7px; border-radius: 6px;
    font-size: 9.5px; font-weight: 600; color: white;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 2px; line-height: 1.6;
}
.cal-event--pending  { background: #f59e0b; }
.cal-event--review   { background: var(--navy-light); }
.cal-event--approved { background: #10b981; }
.cal-event--posted   { background: var(--purple); }
.cal-event--rejected { background: #ef4444; }
.cal-event--more { background: none !important; color: var(--navy-light) !important; font-weight: 700; padding: 0 4px; }

/* Legend */
.cal-legend { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; padding: 12px 24px; border-top: 1.5px solid var(--card-border); background: var(--cream-dark); }
.leg-item { display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: var(--ink-soft); }
.leg-dot  { width: 9px; height: 9px; border-radius: 3px; flex-shrink: 0; }

/* ── SIDEBAR PANELS ──────────────────────────────────── */
.side-panel { display: flex; flex-direction: column; gap: 16px; }
.info-card { background: var(--card); border-radius: var(--radius); border: 1px solid rgba(0,0,0,0.06); box-shadow: var(--shadow-sm); overflow: hidden; }
.info-card__head { padding: 16px 18px; border-bottom: 1.5px solid var(--card-border); background: var(--cream-dark); }
.info-card__title { font-family: var(--font-disp); font-size: 16px; color: var(--ink); }
.info-card__sub   { font-size: 11.5px; color: var(--ink-soft); margin-top: 2px; }
.info-card__body  { padding: 16px 18px; }

/* Stats */
.cal-stats { display: flex; flex-direction: column; gap: 11px; }
.cal-stat-row { display: flex; align-items: center; justify-content: space-between; }
.cal-stat-left { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--ink-mid); }
.cal-stat-dot  { width: 8px; height: 8px; border-radius: 2px; flex-shrink: 0; }
.cal-stat-val  { font-size: 13px; font-weight: 700; color: var(--ink); }
.cal-stat-bar-bg   { height: 4px; background: var(--cream-dark); border-radius: 2px; margin-top: 3px; overflow: hidden; }
.cal-stat-bar-fill { height: 100%; border-radius: 2px; }

/* Upcoming */
.upcoming-list { display: flex; flex-direction: column; }
.upcoming-item { display: flex; align-items: flex-start; gap: 10px; padding: 11px 18px; border-bottom: 1px solid var(--cream-dark); transition: background .1s; }
.upcoming-item:last-child { border-bottom: none; }
.upcoming-item:hover { background: var(--cream); }
.upcoming-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
.upcoming-title { font-size: 12.5px; font-weight: 600; color: var(--ink); line-height: 1.4; }
.upcoming-meta  { font-size: 11px; color: var(--ink-soft); margin-top: 2px; }
.upcoming-badge { display: inline-flex; align-items: center; padding: 2px 7px; border-radius: 10px; font-size: 9.5px; font-weight: 600; margin-top: 4px; }
.upcoming-empty { padding: 20px 18px; text-align: center; color: var(--ink-faint); font-size: 13px; }
</style>
@endsection

@section('content')
@php
    $month = (int)request('month', date('n'));
    $year  = (int)request('year',  date('Y'));
    if($month<1){$month=12;$year--;} if($month>12){$month=1;$year++;}
    $prev_m=$month-1;$prev_y=$year; if($prev_m<1){$prev_m=12;$prev_y--;}
    $next_m=$month+1;$next_y=$year; if($next_m>12){$next_m=1;$next_y++;}
    $first_day     = (int)date('w',mktime(0,0,0,$month,1,$year));
    $days_in_month = (int)date('t',mktime(0,0,0,$month,1,$year));
    $days_in_prev  = (int)date('t',mktime(0,0,0,$prev_m,1,$prev_y));
    $month_name    = date('F Y',mktime(0,0,0,$month,1,$year));
    $today_d=(int)date('j');$today_m=(int)date('n');$today_y=(int)date('Y');

    $all_events=\App\Models\PostRequest::whereNotNull('preferred_date')
        ->whereMonth('preferred_date',$month)->whereYear('preferred_date',$year)
        ->orderBy('preferred_date')->get();
    $events=[]; foreach($all_events as $ev){ $d=(int)date('j',strtotime($ev->preferred_date)); $events[$d][]=$ev; }

    $upcoming=\App\Models\PostRequest::whereNotNull('preferred_date')
        ->whereBetween('preferred_date',[now()->format('Y-m-d'),now()->addDays(7)->format('Y-m-d')])
        ->orderBy('preferred_date')->get();

    $month_total=$all_events->count();
    $month_approved=$all_events->whereIn('status',['Approved','Posted'])->count();
    $month_pending=$all_events->where('status','Pending Review')->count();
    $month_rejected=$all_events->where('status','Rejected')->count();

    $status_color=fn($s)=>match(true){
        str_contains(strtolower($s),'approved')    =>'#10b981',
        str_contains(strtolower($s),'posted')      =>'#8b5cf6',
        str_contains(strtolower($s),'under review')=>'#1e4fd8',
        str_contains(strtolower($s),'rejected')    =>'#ef4444',
        default=>'#f59e0b',
    };
    $event_class=fn($s)=>match(true){
        str_contains(strtolower($s),'approved')    =>'cal-event--approved',
        str_contains(strtolower($s),'posted')      =>'cal-event--posted',
        str_contains(strtolower($s),'under review')=>'cal-event--review',
        str_contains(strtolower($s),'rejected')    =>'cal-event--rejected',
        default=>'cal-event--pending',
    };
@endphp

<div class="page-hd">
    <div class="page-hd__title">Scheduling Calendar</div>
    <div class="page-hd__sub">Track preferred posting dates across all requests</div>
</div>

<div class="cal-layout">
    {{-- CALENDAR --}}
    <div class="cal-panel">
        <div class="cal-toolbar">
            <div class="cal-nav">
                <a href="{{ route('admin.calendar') }}?month={{ $prev_m }}&year={{ $prev_y }}" class="cal-nav-btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                <span class="cal-month-label">{{ $month_name }}</span>
                <a href="{{ route('admin.calendar') }}?month={{ $next_m }}&year={{ $next_y }}" class="cal-nav-btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <a href="{{ route('admin.calendar') }}?month={{ date('n') }}&year={{ date('Y') }}" class="cal-today-btn">Today</a>
        </div>

        <div class="cal-grid-head">
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                <span>{{ $d }}</span>
            @endforeach
        </div>

        <div class="cal-grid">
        @php
            $cell=0;
            $total_cells=ceil(($first_day+$days_in_month)/7)*7;
            for($i=0;$i<$total_cells;$i++){
                $day_num=$i-$first_day+1;
                $is_current=($day_num>=1&&$day_num<=$days_in_month);
                $is_today=$is_current&&$day_num===$today_d&&$month===$today_m&&$year===$today_y;
                if($is_current) $display=$day_num;
                elseif($i<$first_day) $display=$days_in_prev-($first_day-$i-1);
                else $display=$day_num-$days_in_month;
                $cls='cal-day';
                if(!$is_current)$cls.=' cal-day--other';
                if($is_today)$cls.=' cal-day--today';
                echo "<div class='$cls'>";
                echo "<div class='cal-day-num'>$display</div>";
                if($is_current&&isset($events[$day_num])){
                    $day_evs=$events[$day_num]; $cnt=count($day_evs);
                    $bar_cls=$cnt>=4?'day-load--high':($cnt>=2?'day-load--medium':'day-load--low');
                    echo "<div class='day-load $bar_cls'></div>";
                    $shown=0;
                    foreach($day_evs as $ev){
                        if($shown>=2)break;
                        $evc=$event_class($ev->status);
                        $short=htmlspecialchars(mb_strimwidth($ev->title,0,14,'…'));
                        echo "<span class='cal-event $evc' title='".htmlspecialchars($ev->title)."'>$short</span>";
                        $shown++;
                    }
                    if($cnt>2) echo "<span class='cal-event cal-event--more'>+".($cnt-2)." more</span>";
                }
                echo "</div>";
            }
        @endphp
        </div>

        <div class="cal-legend">
            <div class="leg-item"><span class="leg-dot" style="background:var(--navy);"></span>Today</div>
            <div class="leg-item"><span class="leg-dot" style="background:#f59e0b;"></span>Pending</div>
            <div class="leg-item"><span class="leg-dot" style="background:var(--navy-light);"></span>Under Review</div>
            <div class="leg-item"><span class="leg-dot" style="background:#10b981;"></span>Approved</div>
            <div class="leg-item"><span class="leg-dot" style="background:#8b5cf6;"></span>Posted</div>
            <div class="leg-item"><span class="leg-dot" style="background:#ef4444;"></span>Rejected</div>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div class="side-panel">
        {{-- Month Stats --}}
        <div class="info-card">
            <div class="info-card__head">
                <div class="info-card__title">{{ date('F',mktime(0,0,0,$month,1,$year)) }} Overview</div>
                <div class="info-card__sub">{{ $month_total }} scheduled request{{ $month_total!==1?'s':'' }}</div>
            </div>
            <div class="info-card__body">
                @php
                    $safe2=max($month_total,1);
                    $si_items=[
                        ['label'=>'Approved/Posted','val'=>$month_approved,'pct'=>round($month_approved/$safe2*100),'color'=>'#10b981'],
                        ['label'=>'Pending Review', 'val'=>$month_pending,  'pct'=>round($month_pending/$safe2*100), 'color'=>'#f59e0b'],
                        ['label'=>'Rejected',       'val'=>$month_rejected, 'pct'=>round($month_rejected/$safe2*100),'color'=>'#ef4444'],
                    ];
                @endphp
                <div class="cal-stats">
                    @foreach($si_items as $si)
                    <div>
                        <div class="cal-stat-row">
                            <div class="cal-stat-left"><span class="cal-stat-dot" style="background:{{ $si['color'] }};"></span>{{ $si['label'] }}</div>
                            <span class="cal-stat-val">{{ $si['val'] }}</span>
                        </div>
                        <div class="cal-stat-bar-bg"><div class="cal-stat-bar-fill" style="width:{{ $si['pct'] }}%;background:{{ $si['color'] }};"></div></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Upcoming --}}
        <div class="info-card">
            <div class="info-card__head">
                <div class="info-card__title">Upcoming — Next 7 Days</div>
                <div class="info-card__sub">{{ $upcoming->count() }} request{{ $upcoming->count()!==1?'s':'' }} scheduled</div>
            </div>
            @if($upcoming->isEmpty())
                <div class="upcoming-empty">No upcoming requests in the next 7 days.</div>
            @else
                <div class="upcoming-list">
                @foreach($upcoming as $up)
                    @php
                        $dot_col=$status_color($up->status);
                        $sl2=strtolower($up->status);
                        $badge_style=match(true){
                            str_contains($sl2,'approved')    =>'background:#dcfce7;color:#16a34a;',
                            str_contains($sl2,'posted')      =>'background:#ede9fe;color:#7c3aed;',
                            str_contains($sl2,'under review')=>'background:#fef3c7;color:#d97706;',
                            str_contains($sl2,'rejected')    =>'background:#fee2e2;color:#dc2626;',
                            default=>'background:#f1f5f9;color:#64748b;',
                        };
                    @endphp
                    <div class="upcoming-item">
                        <span class="upcoming-dot" style="background:{{ $dot_col }};"></span>
                        <div>
                            <div class="upcoming-title">{{ Str::limit($up->title,30) }}</div>
                            <div class="upcoming-meta">{{ \Carbon\Carbon::parse($up->preferred_date)->format('M j, Y') }} · {{ $up->requester }}</div>
                            <span class="upcoming-badge" style="{{ $badge_style }}">{{ $up->status }}</span>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>

        {{-- Quick link --}}
        <a href="{{ route('admin.requests') }}"
           style="display:flex;align-items:center;gap:8px;padding:14px 18px;background:var(--navy);border-radius:14px;font-size:13px;font-weight:600;color:white;text-decoration:none;transition:background .15s;"
           onmouseover="this.style.background='var(--navy-mid)'"
           onmouseout="this.style.background='var(--navy)'">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            View All Requests
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:auto;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>
</div>
@endsection