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

.two-col { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:18px; }
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

/* RECENT TABLE */
.rtable { width:100%; border-collapse:collapse; }
.rtable th { padding:9px 16px; text-align:left; font-size:10px; font-weight:700; color:var(--ink-soft); text-transform:uppercase; letter-spacing:0.7px; border-bottom:1.5px solid var(--card-border); background:var(--cream-dark); }
.rtable td { padding:12px 16px; font-size:12.5px; border-bottom:1px solid var(--cream-dark); vertical-align:middle; }
.rtable tbody tr:last-child td { border-bottom:none; }
.rtable tbody tr:hover { background:var(--cream); cursor:pointer; }
</style>
@endsection

@section('content')
@php
    $total    = \App\Models\PostRequest::count();
    $posted   = \App\Models\PostRequest::where('status','Posted')->count();
    $approved = \App\Models\PostRequest::where('status','Approved')->count();
    $pending  = \App\Models\PostRequest::where('status','Pending Review')->count();
    $rejected = \App\Models\PostRequest::where('status','Rejected')->count();
    $review   = \App\Models\PostRequest::where('status','Under Review')->count();
    $users    = \App\Models\User::count();
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
@endphp

<div class="page-hd">
    <div>
        <div class="page-hd__title">Analytics</div>
        <div class="page-hd__sub">Request trends, platform breakdown & performance overview</div>
    </div>
</div>

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

{{-- MAIN CHART --}}
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
                @foreach($platform_counts as $plat=>$cnt)
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
                @foreach($categories as $i=>$cat)
                @php $col=$cat_colors[$i%count($cat_colors)]; @endphp
                <div class="cat-pill">
                    <span class="cat-dot" style="background:{{ $col }};"></span>
                    <span style="font-size:12.5px;font-weight:600;color:var(--ink);flex:1;">{{ Str::limit($cat->category??'Other',12) }}</span>
                    <span style="font-size:13px;font-weight:700;color:var(--ink);">{{ $cat->count }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

{{-- TOP REQUESTORS + STATUS SUMMARY --}}
<div class="two-col">
    <div class="panel-a" style="margin-bottom:0;">
        <div class="pa-head"><div><div class="pa-title">Top Requestors</div><div class="pa-sub">By total submissions</div></div></div>
        <div class="pa-body">
            <div class="trop-list">
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
                $st_items=[
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
            @php
                $sl=strtolower($req->status);
                $sc=str_contains($sl,'posted')?'posted':'approved';
                $plats=$req->platforms_array??[];
            @endphp
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
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
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
</script>
@endsection