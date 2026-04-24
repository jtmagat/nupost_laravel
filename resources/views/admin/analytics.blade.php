@extends('layouts.admin')
@section('title', 'Analytics')

@section('head-styles')
<style>
.page-hd { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; }
.page-hd__title { font-family:var(--font-disp); font-size:22px; color:var(--ink); }
.page-hd__sub   { font-size:13px; color:var(--ink-soft); margin-top:3px; }

/* STAT CARDS */
.stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:22px; }
.scard { background:var(--card); border:1.5px solid var(--card-border); border-radius:var(--radius); padding:20px 18px; box-shadow:var(--shadow-sm); transition:transform .2s,box-shadow .2s; }
.scard:hover { transform:translateY(-3px); box-shadow:var(--shadow); }
.scard__top { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.scard__icon { width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; }
.scard__trend { font-size:11px; font-weight:600; padding:3px 9px; border-radius:20px; }
.scard__num { font-size:28px; font-weight:700; letter-spacing:-1px; line-height:1; margin-bottom:5px; }
.scard__lbl { font-size:12px; color:var(--ink-soft); font-weight:500; }

/* PANELS */
.panel-a { background:var(--card); border:1.5px solid var(--card-border); border-radius:var(--radius); box-shadow:var(--shadow-sm); overflow:hidden; margin-bottom:18px; }
.pa-head { padding:18px 22px 14px; display:flex; align-items:flex-start; justify-content:space-between; border-bottom:1.5px solid var(--card-border); }
.pa-title { font-family:var(--font-disp); font-size:17px; color:var(--ink); }
.pa-sub   { font-size:11.5px; color:var(--ink-soft); margin-top:2px; }
.pa-body  { padding:22px; }

<<<<<<< HEAD
.two-col   { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:18px; }
=======
.two-col { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:18px; }
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
.three-col { display:grid; grid-template-columns:1fr 1fr 1fr; gap:18px; margin-bottom:18px; }

/* CHART */
.chart-wrap { position:relative; height:240px; }

/* PLATFORM BARS */
.platform-list { display:flex; flex-direction:column; gap:13px; }
.platform-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:5px; }
.platform-left { display:flex; align-items:center; gap:9px; font-size:13px; font-weight:600; color:var(--ink); }
.platform-icon { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:14px; }
.platform-val { font-size:13px; font-weight:700; color:var(--ink); }
.pbar-bg { height:8px; background:var(--cream-dark); border-radius:4px; overflow:hidden; }
.pbar-fill { height:100%; border-radius:4px; }

/* CATEGORY PILLS */
.cat-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.cat-pill { background:var(--cream-dark); border-radius:12px; padding:12px 14px; display:flex; align-items:center; gap:10px; transition:transform .15s; }
.cat-pill:hover { transform:scale(1.02); }
.cat-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }

/* TOP REQUESTORS */
.trop-list { display:flex; flex-direction:column; gap:12px; }
.trop-item { display:flex; align-items:center; gap:11px; }
.trop-av { width:36px; height:36px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:white; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
.trop-av img { width:100%; height:100%; object-fit:cover; }
.trop-name { font-size:13px; font-weight:600; color:var(--ink); }
.trop-dept { font-size:10.5px; color:var(--ink-soft); margin-top:1px; }
.trop-bar-bg { height:6px; background:var(--cream-dark); border-radius:3px; overflow:hidden; }
.trop-bar-fill { height:100%; border-radius:3px; }
.trop-count { font-size:13px; font-weight:700; color:var(--navy); width:24px; text-align:right; flex-shrink:0; }

/* STATUS SUMMARY */
.status-list { display:flex; flex-direction:column; gap:9px; }

<<<<<<< HEAD
=======
/* META BANNER */
.meta-banner { display:flex; align-items:center; gap:16px; background:var(--navy-pale); border:1.5px solid rgba(0,35,102,0.15); border-radius:var(--radius); padding:20px 24px; margin-bottom:16px; }
.meta-banner__icon { width:48px; height:48px; background:var(--navy); border-radius:13px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.meta-banner__title { font-size:15px; font-weight:700; color:var(--navy); margin-bottom:3px; }
.meta-banner__sub   { font-size:12.5px; color:var(--navy-light); }
.meta-badge { font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; background:var(--navy); color:white; margin-top:6px; display:inline-block; }

.meta-cards { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:18px; }
.meta-card { background:var(--card); border:1.5px solid var(--card-border); border-radius:var(--radius); padding:18px; display:flex; flex-direction:column; gap:10px; box-shadow:var(--shadow-sm); }
.meta-card__icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; }
.meta-card__label { font-size:12px; font-weight:600; color:var(--ink-soft); }
.meta-ph { flex:1; background:var(--cream-dark); border-radius:10px; border:1.5px dashed #93c5fd; min-height:80px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:5px; }
.meta-ph p { font-size:10.5px; color:#93c5fd; font-weight:500; }

>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
/* RECENT TABLE */
.rtable { width:100%; border-collapse:collapse; }
.rtable th { padding:9px 16px; text-align:left; font-size:10px; font-weight:700; color:var(--ink-soft); text-transform:uppercase; letter-spacing:0.7px; border-bottom:1.5px solid var(--card-border); background:var(--cream-dark); }
.rtable td { padding:12px 16px; font-size:12.5px; border-bottom:1px solid var(--cream-dark); vertical-align:middle; }
.rtable tbody tr:last-child td { border-bottom:none; }
.rtable tbody tr:hover { background:var(--cream); cursor:pointer; }
<<<<<<< HEAD

/* ── META / FACEBOOK SECTION ─────────── */
.fb-section-divider { display:flex; align-items:center; gap:14px; margin:28px 0 18px; }
.fb-section-divider__line { flex:1; height:1.5px; background:var(--card-border); }
.fb-section-divider__label { font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--ink-faint); white-space:nowrap; }

/* FB Hero */
.fb-hero {
    background:linear-gradient(135deg,#001a4d 0%,#002e7a 55%,#003a8c 100%);
    border-radius:var(--radius); padding:22px 26px; margin-bottom:16px;
    display:flex; align-items:center; justify-content:space-between; gap:16px;
    box-shadow:0 8px 32px rgba(0,26,77,0.25); position:relative; overflow:hidden;
}
.fb-hero::before { content:''; position:absolute; top:-40px; right:-40px; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle,rgba(59,130,246,0.18) 0%,transparent 65%); pointer-events:none; }
.fb-hero__left { display:flex; align-items:center; gap:14px; position:relative; z-index:1; }
.fb-hero__icon { width:48px; height:48px; border-radius:13px; background:rgba(255,255,255,0.12); border:1.5px solid rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.fb-hero__name { font-family:var(--font-disp); font-size:18px; color:white; }
.fb-hero__sub  { font-size:12px; color:rgba(255,255,255,0.55); margin-top:2px; }
.fb-hero__right { display:flex; align-items:center; gap:10px; position:relative; z-index:1; }
.fb-stat { background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.18); border-radius:12px; padding:10px 16px; text-align:center; }
.fb-stat__val { font-size:20px; font-weight:800; color:white; }
.fb-stat__lbl { font-size:10.5px; color:rgba(255,255,255,0.55); margin-top:1px; }
.fb-refresh-btn {
    display:inline-flex; align-items:center; gap:6px; padding:9px 15px;
    background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.25);
    border-radius:11px; font-size:12px; font-weight:600; color:white;
    text-decoration:none; transition:all .15s;
}
.fb-refresh-btn:hover { background:rgba(255,255,255,0.2); color:white; }

/* FB Metric cards */
.fb-metrics { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:18px; }
.fb-mcard {
    background:var(--card); border:1.5px solid var(--card-border);
    border-radius:var(--radius); padding:18px 16px; box-shadow:var(--shadow-sm);
    position:relative; overflow:hidden;
}
.fb-mcard::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:var(--radius) var(--radius) 0 0; }
.fb-mcard--blue::before   { background:linear-gradient(90deg,#3b6ef5,#60a5fa); }
.fb-mcard--green::before  { background:linear-gradient(90deg,#10b981,#34d399); }
.fb-mcard--amber::before  { background:linear-gradient(90deg,#f59e0b,#fbbf24); }
.fb-mcard--purple::before { background:linear-gradient(90deg,#8b5cf6,#a78bfa); }
.fb-mcard__ico { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; margin-bottom:10px; }
.fb-mcard__val { font-size:26px; font-weight:800; color:var(--ink); letter-spacing:-0.5px; }
.fb-mcard__lbl { font-size:11.5px; color:var(--ink-soft); margin-top:2px; }
.fb-mcard__sub { font-size:10.5px; color:var(--ink-faint); margin-top:5px; }

/* FB Chart tabs */
.fb-chart-tabs { display:flex; gap:4px; }
.fb-chart-tab { padding:5px 12px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; border:none; font-family:var(--font); transition:all .15s; color:var(--ink-soft); background:transparent; }
.fb-chart-tab.active { background:var(--navy); color:white; }
.fb-chart-tab:hover:not(.active) { background:var(--cream-dark); }

/* FB Posts */
.fb-posts-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:14px; }
.fb-post-card { background:var(--card); border:1.5px solid var(--card-border); border-radius:14px; overflow:hidden; box-shadow:var(--shadow-sm); transition:all .15s; }
.fb-post-card:hover { transform:translateY(-2px); box-shadow:var(--shadow); }
.fb-post-card__img { width:100%; height:140px; object-fit:cover; display:block; background:var(--cream-dark); }
.fb-post-card__body { padding:13px 15px; }
.fb-post-card__date { font-size:11px; color:var(--ink-faint); margin-bottom:7px; }
.fb-post-card__msg { font-size:12.5px; color:var(--ink-mid); line-height:1.5; margin-bottom:10px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
.fb-post-card__stats { display:flex; gap:14px; padding-top:8px; border-top:1px solid var(--cream-dark); }
.fb-post-stat { display:flex; align-items:center; gap:5px; font-size:12px; font-weight:600; color:var(--ink-soft); }
.fb-post-card__link { display:inline-flex; align-items:center; gap:5px; margin-top:9px; padding:5px 11px; border-radius:8px; font-size:11.5px; font-weight:600; background:var(--navy-pale); color:var(--navy); text-decoration:none; transition:all .15s; }
.fb-post-card__link:hover { background:var(--navy); color:white; }

/* FB Error */
.fb-error { background:#fee2e2; border:1.5px solid #fca5a5; border-radius:14px; padding:18px 22px; display:flex; align-items:flex-start; gap:12px; font-size:13px; color:#b91c1c; margin-bottom:16px; }

/* FB Placeholder (if env not set) */
.fb-placeholder { background:var(--cream-dark); border:2px dashed #93c5fd; border-radius:14px; padding:36px; text-align:center; color:#64748b; }
.fb-placeholder svg { margin:0 auto 12px; display:block; opacity:.4; }
.fb-placeholder h3 { font-size:15px; font-weight:700; margin-bottom:6px; }
.fb-placeholder p  { font-size:12.5px; line-height:1.6; }
.fb-placeholder code { background:white; padding:2px 8px; border-radius:6px; font-size:11.5px; color:var(--navy); }
=======
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
</style>
@endsection

@section('content')
@php
<<<<<<< HEAD
    // ── Internal NUPost Analytics ────────────────────────────────────────
=======
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
    $total    = \App\Models\PostRequest::count();
    $posted   = \App\Models\PostRequest::where('status','Posted')->count();
    $approved = \App\Models\PostRequest::where('status','Approved')->count();
    $pending  = \App\Models\PostRequest::where('status','Pending Review')->count();
    $rejected = \App\Models\PostRequest::where('status','Rejected')->count();
    $review   = \App\Models\PostRequest::where('status','Under Review')->count();
    $users    = \App\Models\User::count();
<<<<<<< HEAD
    $approval_rate = $total > 0 ? round(($approved + $posted) / $total * 100) : 0;
    $safe = max($total, 1);

    $months_data = [];
    for ($i = 5; $i >= 0; $i--) {
        $m = now()->subMonths($i);
        $months_data[] = [
            'label'    => $m->format('M'),
            'total'    => \App\Models\PostRequest::whereYear('created_at',$m->year)->whereMonth('created_at',$m->month)->count(),
            'posted'   => \App\Models\PostRequest::whereYear('created_at',$m->year)->whereMonth('created_at',$m->month)->where('status','Posted')->count(),
            'approved' => \App\Models\PostRequest::whereYear('created_at',$m->year)->whereMonth('created_at',$m->month)->where('status','Approved')->count(),
        ];
    }

    $platforms_raw    = \App\Models\PostRequest::all();
    $platform_counts  = [];
    foreach ($platforms_raw as $req) {
        foreach ($req->platforms_array ?? [] as $p) {
            $platform_counts[$p] = ($platform_counts[$p] ?? 0) + 1;
        }
    }
    arsort($platform_counts);
    $plat_max    = max($platform_counts ?: [1]);
    $plat_colors = [
        'Facebook'  => ['#1877f2','📘'],
        'Instagram' => ['#e1306c','📸'],
        'Youtube'   => ['#ff0000','📺'],
        'TikTok'    => ['#010101','🎵'],
        'Twitter'   => ['#1da1f2','🐦'],
        'LinkedIn'  => ['#0077b5','💼'],
    ];

    $categories = \App\Models\PostRequest::selectRaw('category,count(*) as count')->groupBy('category')->orderByDesc('count')->get();
    $cat_max    = $categories->max('count') ?: 1;
    $cat_colors = ['#2563eb','#10b981','#f59e0b','#8b5cf6','#ef4444','#0ea5e9','#f97316'];

    $top_requestors = \App\Models\PostRequest::selectRaw('requester,count(*) as total')->groupBy('requester')->orderByDesc('total')->limit(5)->get();
    $top_users      = \App\Models\User::whereIn('name', $top_requestors->pluck('requester'))->get()->keyBy('name');
    $tr_max         = $top_requestors->max('total') ?: 1;
    $av_colors      = ['#2563eb','#10b981','#8b5cf6','#f59e0b','#ef4444'];

    $recent_posted = \App\Models\PostRequest::whereIn('status',['Posted','Approved'])->orderByDesc('created_at')->limit(8)->get();

    // ── Facebook Analytics ───────────────────────────────────────────────
    $fbController = new \App\Http\Controllers\Admin\FacebookAnalyticsController();
    $fb           = $fbController->getData();
    $fbError      = $fb['error'];
    $fbPage       = $fb['pageInfo'];
    $fbMetrics    = $fb['metrics'];
    $fbPosts      = $fb['posts'];
    $fbConfigured = env('FB_PAGE_ID') && env('FB_PAGE_ACCESS_TOKEN');
=======
    $approval_rate = $total>0 ? round(($approved+$posted)/$total*100) : 0;
    $safe = max($total,1);

    $months_data=[];
    for($i=5;$i>=0;$i--){
        $m=now()->subMonths($i);
        $months_data[]=['label'=>$m->format('M'),'total'=>\App\Models\PostRequest::whereYear('created_at',$m->year)->whereMonth('created_at',$m->month)->count(),'posted'=>\App\Models\PostRequest::whereYear('created_at',$m->year)->whereMonth('created_at',$m->month)->where('status','Posted')->count(),'approved'=>\App\Models\PostRequest::whereYear('created_at',$m->year)->whereMonth('created_at',$m->month)->where('status','Approved')->count()];
    }

    $platforms_raw=\App\Models\PostRequest::all();
    $platform_counts=[];
    foreach($platforms_raw as $req){ foreach($req->platforms_array??[] as $p){ $platform_counts[$p]=($platform_counts[$p]??0)+1; } }
    arsort($platform_counts); $plat_max=max($platform_counts?:[1]);
    $plat_colors=['Facebook'=>['#1877f2','📘'],'Instagram'=>['#e1306c','📸'],'Youtube'=>['#ff0000','📺'],'TikTok'=>['#010101','🎵'],'Twitter'=>['#1da1f2','🐦'],'LinkedIn'=>['#0077b5','💼']];

    $categories=\App\Models\PostRequest::selectRaw('category,count(*) as count')->groupBy('category')->orderByDesc('count')->get();
    $cat_max=$categories->max('count')?:1;
    $cat_colors=['#2563eb','#10b981','#f59e0b','#8b5cf6','#ef4444','#0ea5e9','#f97316'];

    $top_requestors=\App\Models\PostRequest::selectRaw('requester,count(*) as total')->groupBy('requester')->orderByDesc('total')->limit(5)->get();
    $top_users=\App\Models\User::whereIn('name',$top_requestors->pluck('requester'))->get()->keyBy('name');
    $tr_max=$top_requestors->max('total')?:1;
    $av_colors=['#2563eb','#10b981','#8b5cf6','#f59e0b','#ef4444'];

    $recent_posted=\App\Models\PostRequest::whereIn('status',['Posted','Approved'])->orderByDesc('created_at')->limit(8)->get();
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
@endphp

<div class="page-hd">
    <div>
        <div class="page-hd__title">Analytics</div>
<<<<<<< HEAD
        <div class="page-hd__sub">Request trends, platform breakdown & Facebook performance</div>
    </div>
</div>

{{-- ── INTERNAL NUPOST ANALYTICS ─────────────────── --}}

=======
        <div class="page-hd__sub">Request trends, platform breakdown & performance overview</div>
    </div>
</div>

>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
{{-- STAT CARDS --}}
<div class="stats-row">
    <div class="scard" style="border-top:3px solid var(--navy);">
        <div class="scard__top">
            <div class="scard__icon" style="background:var(--navy-pale);"><svg width="18" height="18" fill="none" stroke="var(--navy)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
            <span class="scard__trend" style="background:var(--navy-pale);color:var(--navy);">All</span>
        </div>
        <div class="scard__num" style="color:var(--navy);">{{ $total }}</div>
        <div class="scard__lbl">Total Requests</div>
    </div>
    <div class="scard" style="border-top:3px solid #8b5cf6;">
        <div class="scard__top">
            <div class="scard__icon" style="background:#faf5ff;"><svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></div>
            <span class="scard__trend" style="background:#faf5ff;color:#7c3aed;">Live</span>
        </div>
        <div class="scard__num" style="color:#6d28d9;">{{ $posted }}</div>
        <div class="scard__lbl">Published Posts</div>
    </div>
    <div class="scard" style="border-top:3px solid #10b981;">
        <div class="scard__top">
            <div class="scard__icon" style="background:#f0fdf4;"><svg width="18" height="18" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
            <span class="scard__trend" style="background:#f0fdf4;color:#16a34a;">{{ $approval_rate }}%</span>
        </div>
        <div class="scard__num" style="color:#047857;">{{ $approval_rate }}%</div>
        <div class="scard__lbl">Approval Rate</div>
    </div>
    <div class="scard" style="border-top:3px solid #f59e0b;">
        <div class="scard__top">
            <div class="scard__icon" style="background:#fffbeb;"><svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
            <span class="scard__trend" style="background:#fffbeb;color:#d97706;">Active</span>
        </div>
        <div class="scard__num" style="color:#b45309;">{{ $users }}</div>
        <div class="scard__lbl">Requestors</div>
    </div>
</div>

<<<<<<< HEAD
{{-- TREND CHART --}}
=======
{{-- MAIN CHART --}}
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
<div class="panel-a">
    <div class="pa-head">
        <div><div class="pa-title">Request Volume Trend</div><div class="pa-sub">Total submitted vs approved/posted — last 6 months</div></div>
    </div>
    <div class="pa-body"><div class="chart-wrap"><canvas id="trendChart"></canvas></div></div>
</div>

{{-- PLATFORM + CATEGORIES --}}
<div class="two-col">
    <div class="panel-a" style="margin-bottom:0;">
        <div class="pa-head"><div class="pa-title">Platform Breakdown</div></div>
        <div class="pa-body">
            @if(empty($platform_counts))
                <div style="text-align:center;color:var(--ink-faint);padding:20px;font-size:13px;">No platform data yet.</div>
            @else
            <div class="platform-list">
<<<<<<< HEAD
                @foreach($platform_counts as $plat => $cnt)
=======
                @foreach($platform_counts as $plat=>$cnt)
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
                @php $pct=round($cnt/$plat_max*100); $col=$plat_colors[$plat][0]??'#6b7280'; $ico=$plat_colors[$plat][1]??'🌐'; @endphp
                <div>
                    <div class="platform-top">
                        <div class="platform-left"><span class="platform-icon" style="background:{{ $col }}22;">{{ $ico }}</span>{{ $plat }}</div>
                        <span class="platform-val">{{ $cnt }}</span>
                    </div>
                    <div class="pbar-bg"><div class="pbar-fill" style="width:{{ $pct }}%;background:{{ $col }};"></div></div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="panel-a" style="margin-bottom:0;">
        <div class="pa-head"><div class="pa-title">Category Distribution</div></div>
        <div class="pa-body">
            @if($categories->isEmpty())
                <div style="text-align:center;color:var(--ink-faint);padding:20px;font-size:13px;">No data yet.</div>
            @else
            <div class="cat-grid">
<<<<<<< HEAD
                @foreach($categories as $i => $cat)
                @php $col=$cat_colors[$i % count($cat_colors)]; @endphp
                <div class="cat-pill">
                    <span class="cat-dot" style="background:{{ $col }};"></span>
                    <span style="font-size:12.5px;font-weight:600;color:var(--ink);flex:1;">{{ Str::limit($cat->category ?? 'Other', 12) }}</span>
=======
                @foreach($categories as $i=>$cat)
                @php $col=$cat_colors[$i%count($cat_colors)]; @endphp
                <div class="cat-pill">
                    <span class="cat-dot" style="background:{{ $col }};"></span>
                    <span style="font-size:12.5px;font-weight:600;color:var(--ink);flex:1;">{{ Str::limit($cat->category??'Other',12) }}</span>
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
                    <span style="font-size:13px;font-weight:700;color:var(--ink);">{{ $cat->count }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<<<<<<< HEAD
{{-- TOP REQUESTORS + STATUS --}}
=======
{{-- TOP REQUESTORS + STATUS SUMMARY --}}
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
<div class="two-col">
    <div class="panel-a" style="margin-bottom:0;">
        <div class="pa-head"><div><div class="pa-title">Top Requestors</div><div class="pa-sub">By total submissions</div></div></div>
        <div class="pa-body">
            <div class="trop-list">
<<<<<<< HEAD
                @forelse($top_requestors as $i => $tr)
                @php
                    $medals = ['🥇','🥈','🥉'];
                    $uobj   = $top_users[$tr->requester] ?? null;
                    $photo  = $uobj?->profile_photo;
                    $dept   = $uobj?->department ?? ($uobj?->organization ?? 'Requestor');
                    $pct    = round($tr->total / $tr_max * 100);
                    $col    = $av_colors[$i % 5];
                @endphp
                <div class="trop-item">
                    <div style="width:24px;text-align:center;font-size:15px;">{{ $medals[$i] ?? ($i+1).'.' }}</div>
                    <div class="trop-av" style="background:{{ $col }};">
                        @if($photo)<img src="/uploads/{{ $photo }}" alt="">@endif
                        {{ strtoupper(substr($tr->requester, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="trop-name">{{ Str::limit($tr->requester, 18) }}</div>
                        <div class="trop-dept">{{ Str::limit($dept, 20) }}</div>
=======
                @forelse($top_requestors as $i=>$tr)
                @php
                    $medals=['🥇','🥈','🥉'];
                    $uobj=$top_users[$tr->requester]??null;
                    $photo=$uobj?->profile_photo;
                    $dept=$uobj?->department??($uobj?->organization??'Requestor');
                    $pct=round($tr->total/$tr_max*100);
                    $col=$av_colors[$i%5];
                @endphp
                <div class="trop-item">
                    <div style="width:24px;text-align:center;font-size:15px;">{{ $medals[$i]??($i+1).'.' }}</div>
                    <div class="trop-av" style="background:{{ $col }};">
                        @if($photo)<img src="/uploads/{{ $photo }}" alt="">@endif
                        {{ strtoupper(substr($tr->requester,0,1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="trop-name">{{ Str::limit($tr->requester,18) }}</div>
                        <div class="trop-dept">{{ Str::limit($dept,20) }}</div>
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
                    </div>
                    <div style="flex:1;">
                        <div class="trop-bar-bg"><div class="trop-bar-fill" style="width:{{ $pct }}%;background:{{ $col }};"></div></div>
                    </div>
                    <div class="trop-count">{{ $tr->total }}</div>
                </div>
                @empty
                    <div style="text-align:center;color:var(--ink-faint);font-size:13px;padding:20px;">No data yet.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="panel-a" style="margin-bottom:0;">
        <div class="pa-head"><div><div class="pa-title">Status Summary</div></div></div>
        <div class="pa-body">
            @php
<<<<<<< HEAD
                $st_items = [
=======
                $st_items=[
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
                    ['l'=>'Pending Review','v'=>$pending, 'pct'=>round($pending/$safe*100), 'c'=>'#f59e0b'],
                    ['l'=>'Under Review',  'v'=>$review,  'pct'=>round($review/$safe*100),  'c'=>'#1e4fd8'],
                    ['l'=>'Approved',      'v'=>$approved,'pct'=>round($approved/$safe*100),'c'=>'#10b981'],
                    ['l'=>'Posted',        'v'=>$posted,  'pct'=>round($posted/$safe*100),  'c'=>'#8b5cf6'],
                    ['l'=>'Rejected',      'v'=>$rejected,'pct'=>round($rejected/$safe*100),'c'=>'#ef4444'],
                ];
            @endphp
            <div class="status-list">
                @foreach($st_items as $si)
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px;">
                        <div style="display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--ink-mid);">
                            <span style="width:8px;height:8px;border-radius:2px;background:{{ $si['c'] }};display:inline-block;"></span>
                            {{ $si['l'] }}
                        </div>
                        <span style="font-size:12.5px;font-weight:700;color:var(--ink);">{{ $si['v'] }} <span style="font-weight:400;color:var(--ink-faint);">({{ $si['pct'] }}%)</span></span>
                    </div>
                    <div style="height:6px;background:var(--cream-dark);border-radius:3px;overflow:hidden;">
                        <div style="width:{{ $si['pct'] }}%;height:100%;background:{{ $si['c'] }};border-radius:3px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- RECENT POSTED --}}
<div class="panel-a">
    <div class="pa-head">
        <div><div class="pa-title">Recent Published Requests</div><div class="pa-sub">Latest approved & posted</div></div>
    </div>
    <div style="overflow-x:auto;">
        <table class="rtable">
            <thead><tr><th>Request</th><th>Requester</th><th>Category</th><th>Platforms</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($recent_posted as $req)
<<<<<<< HEAD
            @php $sl=strtolower($req->status); $sc=str_contains($sl,'posted')?'posted':'approved'; $plats=$req->platforms_array??[]; @endphp
=======
            @php
                $sl=strtolower($req->status);
                $sc=str_contains($sl,'posted')?'posted':'approved';
                $plats=$req->platforms_array??[];
            @endphp
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
            <tr onclick="window.location='{{ route('admin.requests.show',$req->id) }}'">
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        @if($req->first_media)
                            <img src="/uploads/{{ $req->first_media }}" style="width:36px;height:36px;border-radius:8px;object-fit:cover;" onerror="this.style.display='none'">
                        @else
                            <div style="width:36px;height:36px;border-radius:8px;background:var(--cream-dark);display:flex;align-items:center;justify-content:center;font-size:14px;">📄</div>
                        @endif
                        <div>
                            <div style="font-weight:600;font-size:12.5px;color:var(--ink);">{{ Str::limit($req->title,28) }}</div>
                            <div style="font-size:11px;color:var(--ink-soft);">{{ Str::limit($req->description,38) }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:12.5px;">{{ $req->requester }}</td>
                <td style="font-size:12px;color:var(--ink-soft);">{{ $req->category }}</td>
                <td><div style="display:flex;gap:4px;flex-wrap:wrap;">@foreach(array_slice($plats,0,2) as $p)<span style="font-size:10px;padding:2px 7px;background:var(--navy-pale);color:var(--navy);border-radius:10px;font-weight:600;">{{ $p }}</span>@endforeach</div></td>
                <td><span class="badge badge--{{ $sc }}">{{ $req->status }}</span></td>
                <td style="font-size:11.5px;color:var(--ink-soft);">{{ $req->created_at->format('M j, Y') }}</td>
            </tr>
            @empty
                <tr><td colspan="6" style="padding:32px;text-align:center;color:var(--ink-faint);">No published posts yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<<<<<<< HEAD
{{-- ── FACEBOOK / META ANALYTICS ─────────────────── --}}
<div class="fb-section-divider">
    <div class="fb-section-divider__line"></div>
    <div class="fb-section-divider__label">📘 Facebook Page Analytics</div>
    <div class="fb-section-divider__line"></div>
</div>

@if(session('success'))
<div style="background:#dcfce7;border:1px solid #86efac;border-radius:12px;padding:11px 16px;font-size:13px;color:#15803d;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif

@if(!$fbConfigured)
    {{-- Not configured yet --}}
    <div class="fb-placeholder">
        <svg width="48" height="48" fill="none" stroke="#93c5fd" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        <h3>Facebook Analytics Not Configured</h3>
        <p>Add your credentials in <code>.env</code> to see real-time reach, engagement, and post performance.</p>
        <p style="margin-top:8px;"><code>FB_PAGE_ID=your_page_id</code><br><code>FB_PAGE_ACCESS_TOKEN=your_token</code></p>
    </div>

@elseif($fbError)
    {{-- API Error --}}
    <div class="fb-error">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong>Facebook API Error</strong><br>
            {{ $fbError }}<br>
            <small style="opacity:.75;">Your access token may have expired. Run <code>php artisan config:clear</code> then refresh.</small>
        </div>
    </div>
    <div style="text-align:center;margin-top:8px;">
        <a href="{{ route('admin.analytics.refresh') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:var(--navy);color:white;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
            Retry / Refresh Cache
        </a>
    </div>

@else
    {{-- FB Hero --}}
    <div class="fb-hero">
        <div class="fb-hero__left">
            <div class="fb-hero__icon">
                <svg width="24" height="24" fill="white" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </div>
            <div>
                <div class="fb-hero__name">{{ $fbPage['name'] ?? 'Facebook Page' }}</div>
                <div class="fb-hero__sub">Last updated {{ now()->format('M j, Y · g:i A') }} · Cached 5 mins</div>
            </div>
        </div>
        <div class="fb-hero__right">
            <div class="fb-stat">
                <div class="fb-stat__val">{{ number_format($fbPage['fan_count'] ?? 0) }}</div>
                <div class="fb-stat__lbl">Page Likes</div>
            </div>
            <div class="fb-stat">
                <div class="fb-stat__val">{{ number_format($fbPage['followers_count'] ?? 0) }}</div>
                <div class="fb-stat__lbl">Followers</div>
            </div>
            <a href="{{ route('admin.analytics.refresh') }}" class="fb-refresh-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                Refresh
            </a>
        </div>
    </div>

    {{-- FB Metric Cards --}}
    @if($fbMetrics)
    <div class="fb-metrics">
        <div class="fb-mcard fb-mcard--blue">
            <div class="fb-mcard__ico" style="background:#dbeafe;">
                <svg width="16" height="16" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="fb-mcard__val">{{ number_format($fbMetrics['page_fans']['total'] ?? 0) }}</div>
            <div class="fb-mcard__lbl">Page Likes</div>
            <div class="fb-mcard__sub">Total page fans</div>
        </div>
        <div class="fb-mcard fb-mcard--green">
            <div class="fb-mcard__ico" style="background:#dcfce7;">
                <svg width="16" height="16" fill="#ef4444" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="fb-mcard__val">{{ number_format($fbMetrics['total_likes']['total'] ?? 0) }}</div>
            <div class="fb-mcard__lbl">Total Likes</div>
            <div class="fb-mcard__sub">Across recent posts</div>
        </div>
        <div class="fb-mcard fb-mcard--amber">
            <div class="fb-mcard__ico" style="background:#fef3c7;">
                <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="fb-mcard__val">{{ number_format($fbMetrics['total_comments']['total'] ?? 0) }}</div>
            <div class="fb-mcard__lbl">Total Comments</div>
            <div class="fb-mcard__sub">Across recent posts</div>
        </div>
        <div class="fb-mcard fb-mcard--purple">
            <div class="fb-mcard__ico" style="background:#ede9fe;">
                <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            </div>
            <div class="fb-mcard__val">{{ number_format($fbMetrics['total_shares']['total'] ?? 0) }}</div>
            <div class="fb-mcard__lbl">Total Shares</div>
            <div class="fb-mcard__sub">Across recent posts</div>
        </div>
    </div>
    @endif

    {{-- FB Recent Posts --}}
    @if(count($fbPosts) > 0)
    <div style="font-size:15px;font-weight:700;color:var(--ink);margin-bottom:14px;display:flex;align-items:center;gap:8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        Recent Posts Performance
    </div>
    <div class="fb-posts-grid">
        @foreach($fbPosts as $post)
        <div class="fb-post-card">
            @if(isset($post['full_picture']))
                <img src="{{ $post['full_picture'] }}" class="fb-post-card__img" alt="" onerror="this.style.display='none'">
            @else
                <div class="fb-post-card__img" style="display:flex;align-items:center;justify-content:center;font-size:28px;">📄</div>
            @endif
            <div class="fb-post-card__body">
                <div class="fb-post-card__date">
                    {{ \Carbon\Carbon::parse($post['created_time'])->format('M j, Y · g:i A') }}
                </div>
                <div class="fb-post-card__msg">{{ $post['message'] ?? $post['story'] ?? 'No caption' }}</div>
                <div class="fb-post-card__stats">
                    <div class="fb-post-stat">
                        <svg width="13" height="13" fill="#ef4444" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        {{ number_format($post['likes']['summary']['total_count'] ?? 0) }}
                    </div>
                    <div class="fb-post-stat">
                        <svg width="13" height="13" fill="none" stroke="#3b6ef5" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        {{ number_format($post['comments']['summary']['total_count'] ?? 0) }}
                    </div>
                    <div class="fb-post-stat">
                        <svg width="13" height="13" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                        {{ number_format($post['shares']['count'] ?? 0) }}
                    </div>
                </div>
                @if(isset($post['permalink_url']))
                <a href="{{ $post['permalink_url'] }}" target="_blank" class="fb-post-card__link">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    View on Facebook
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

@endif
{{-- end fb configured --}}

=======
{{-- META PLACEHOLDER --}}
<div style="display:flex;align-items:center;gap:14px;margin:28px 0 18px;">
    <div style="flex:1;height:1.5px;background:var(--card-border);"></div>
    <div style="font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--ink-faint);">Meta / Facebook Analytics</div>
    <div style="flex:1;height:1.5px;background:var(--card-border);"></div>
</div>
<div class="meta-banner">
    <div class="meta-banner__icon">
        <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
    </div>
    <div>
        <div class="meta-banner__title">Facebook & Meta Graph API — Coming Soon</div>
        <div class="meta-banner__sub">Connect your Meta account to view real-time reach, engagement, reactions, and page insights.</div>
        <span class="meta-badge">Configure FACEBOOK_ACCESS_TOKEN & FACEBOOK_PAGE_ID in .env</span>
    </div>
</div>
<div class="meta-cards">
    @php $meta_items=[['label'=>'Total Reach','icon_c'=>'#1877f2','icon_bg'=>'#dbeafe','path'=>'<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'],['label'=>'Engagements','icon_c'=>'#e1306c','icon_bg'=>'#fce7f3','path'=>'<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>'],['label'=>'Reactions','icon_c'=>'#f59e0b','icon_bg'=>'#fef3c7','path'=>'<circle cx="12" cy="12" r="10"/><path d="M8 13s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>'],['label'=>'Shares','icon_c'=>'#10b981','icon_bg'=>'#d1fae5','path'=>'<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>']]; @endphp
    @foreach($meta_items as $mi)
    <div class="meta-card">
        <div class="meta-card__icon" style="background:{{ $mi['icon_bg'] }};"><svg width="20" height="20" fill="none" stroke="{{ $mi['icon_c'] }}" stroke-width="2" viewBox="0 0 24 24">{!! $mi['path'] !!}</svg></div>
        <div class="meta-card__label">{{ $mi['label'] }}</div>
        <div class="meta-ph"><svg width="22" height="22" fill="none" stroke="#93c5fd" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg><p>API Pending</p></div>
    </div>
    @endforeach
</div>
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
<<<<<<< HEAD
// ── Internal NUPost Trend Chart ──────────────────────────────────────────
const months  = @json(array_column($months_data,'label'));
const totals  = @json(array_column($months_data,'total'));
const postedD = @json(array_column($months_data,'posted'));
const approvedD = @json(array_column($months_data,'approved'));
const ctx = document.getElementById('trendChart').getContext('2d');
const gT  = ctx.createLinearGradient(0,0,0,240); gT.addColorStop(0,'rgba(0,35,102,0.12)');  gT.addColorStop(1,'rgba(0,35,102,0)');
const gP  = ctx.createLinearGradient(0,0,0,240); gP.addColorStop(0,'rgba(139,92,246,0.12)'); gP.addColorStop(1,'rgba(139,92,246,0)');
const gA  = ctx.createLinearGradient(0,0,0,240); gA.addColorStop(0,'rgba(16,185,129,0.12)'); gA.addColorStop(1,'rgba(16,185,129,0)');
new Chart(ctx, {
    type: 'line',
    data: { labels: months, datasets: [
        { label:'Total',    data:totals,    borderColor:'#002366', backgroundColor:gT, borderWidth:2.5, pointBackgroundColor:'#002366', pointRadius:4, tension:0.4, fill:true },
        { label:'Approved', data:approvedD, borderColor:'#10b981', backgroundColor:gA, borderWidth:2.5, pointBackgroundColor:'#10b981', pointRadius:4, tension:0.4, fill:true },
        { label:'Posted',   data:postedD,   borderColor:'#8b5cf6', backgroundColor:gP, borderWidth:2.5, pointBackgroundColor:'#8b5cf6', pointRadius:4, tension:0.4, fill:true },
    ]},
    options: {
        responsive:true, maintainAspectRatio:false,
        interaction:{ mode:'index', intersect:false },
        plugins:{
            legend:{ position:'top', align:'end', labels:{ font:{family:'DM Sans',size:12,weight:'600'}, color:'#7a7672', usePointStyle:true, pointStyleWidth:8, boxHeight:8, padding:20 }},
            tooltip:{ backgroundColor:'#1a1a1a', titleFont:{family:'DM Sans',size:12,weight:'700'}, bodyFont:{family:'DM Sans',size:12}, padding:12, cornerRadius:10 }
        },
        scales:{
            x:{ grid:{display:false}, ticks:{font:{family:'DM Sans',size:12},color:'#b5b0a8'} },
            y:{ beginAtZero:true, grid:{color:'#e8e3da'}, ticks:{font:{family:'DM Sans',size:12},color:'#b5b0a8',stepSize:1,callback:v=>Number.isInteger(v)?v:''} }
        }
    }
});
=======
const months=@json(array_column($months_data,'label'));
const totals=@json(array_column($months_data,'total'));
const posted=@json(array_column($months_data,'posted'));
const approved=@json(array_column($months_data,'approved'));
const ctx=document.getElementById('trendChart').getContext('2d');
const gT=ctx.createLinearGradient(0,0,0,240); gT.addColorStop(0,'rgba(0,35,102,0.12)'); gT.addColorStop(1,'rgba(0,35,102,0)');
const gP=ctx.createLinearGradient(0,0,0,240); gP.addColorStop(0,'rgba(139,92,246,0.12)'); gP.addColorStop(1,'rgba(139,92,246,0)');
const gA=ctx.createLinearGradient(0,0,0,240); gA.addColorStop(0,'rgba(16,185,129,0.12)'); gA.addColorStop(1,'rgba(16,185,129,0)');
new Chart(ctx,{type:'line',data:{labels:months,datasets:[
    {label:'Total',data:totals,borderColor:'#002366',backgroundColor:gT,borderWidth:2.5,pointBackgroundColor:'#002366',pointRadius:4,tension:0.4,fill:true},
    {label:'Approved',data:approved,borderColor:'#10b981',backgroundColor:gA,borderWidth:2.5,pointBackgroundColor:'#10b981',pointRadius:4,tension:0.4,fill:true},
    {label:'Posted',data:posted,borderColor:'#8b5cf6',backgroundColor:gP,borderWidth:2.5,pointBackgroundColor:'#8b5cf6',pointRadius:4,tension:0.4,fill:true},
]},options:{responsive:true,maintainAspectRatio:false,interaction:{mode:'index',intersect:false},plugins:{legend:{position:'top',align:'end',labels:{font:{family:'DM Sans',size:12,weight:'600'},color:'#7a7672',usePointStyle:true,pointStyleWidth:8,boxHeight:8,padding:20}},tooltip:{backgroundColor:'#1a1a1a',titleFont:{family:'DM Sans',size:12,weight:'700'},bodyFont:{family:'DM Sans',size:12},padding:12,cornerRadius:10}},scales:{x:{grid:{display:false},ticks:{font:{family:'DM Sans',size:12},color:'#b5b0a8'}},y:{beginAtZero:true,grid:{color:'#e8e3da'},ticks:{font:{family:'DM Sans',size:12},color:'#b5b0a8',stepSize:1,callback:v=>Number.isInteger(v)?v:''}}}}});
>>>>>>> 43bcf98605ecda6f0ebfbec71433733e161c1f26
</script>
@endsection