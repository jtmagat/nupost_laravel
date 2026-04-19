@extends('layouts.admin')
@section('title', 'Request Management')

@section('head-styles')
<style>
.page-hd { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
.page-hd__title { font-family:var(--font-disp); font-size:22px; color:var(--ink); }
.page-hd__sub   { font-size:13px; color:var(--ink-soft); margin-top:3px; }

/* STAT CARDS */
.stats-row { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:22px; }
.scard {
    background:var(--card); border:1px solid rgba(0,0,0,0.06);
    border-radius:var(--radius); padding:18px 16px;
    display:flex; align-items:center; gap:14px;
    box-shadow:var(--shadow-sm); transition:transform .2s,box-shadow .2s;
}
.scard:hover { transform:translateY(-2px); box-shadow:var(--shadow); }
.scard__icon { width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.scard__num  { font-size:24px; font-weight:700; letter-spacing:-0.8px; line-height:1; }
.scard__lbl  { font-size:11.5px; color:var(--ink-soft); font-weight:500; margin-top:3px; }
.scard--yellow .scard__icon { background:#fffbeb; color:#d97706; } .scard--yellow .scard__num { color:#b45309; }
.scard--blue   .scard__icon { background:#eff6ff; color:#2563eb; } .scard--blue   .scard__num { color:#1e40af; }
.scard--green  .scard__icon { background:#f0fdf4; color:#10b981; } .scard--green  .scard__num { color:#047857; }
.scard--purple .scard__icon { background:#faf5ff; color:#7c3aed; } .scard--purple .scard__num { color:#6d28d9; }
.scard--red    .scard__icon { background:#fef2f2; color:#ef4444; } .scard--red    .scard__num { color:#b91c1c; }

/* TOOLBAR */
.toolbar { display:flex; align-items:center; gap:10px; margin-bottom:16px; flex-wrap:wrap; }
.search-wrap { flex:1; min-width:220px; position:relative; }
.search-wrap input {
    width:100%; height:42px;
    background:var(--card); border:1px solid rgba(0,0,0,0.08);
    border-radius:var(--radius-sm); padding:0 14px 0 42px;
    font-size:13px; font-family:var(--font); color:var(--ink); outline:none;
    transition:border-color .15s,box-shadow .15s;
}
.search-wrap input:focus { border-color:var(--navy-light); box-shadow:0 0 0 3px rgba(30,79,216,0.08); }
.search-wrap input::placeholder { color:var(--ink-faint); }
.search-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--ink-faint); pointer-events:none; }
.toolbar select {
    height:42px; background:var(--card); border:1px solid rgba(0,0,0,0.08);
    border-radius:var(--radius-sm); padding:0 14px; font-size:13px;
    font-family:var(--font); color:var(--ink); outline:none; cursor:pointer; transition:border-color .15s;
}
.toolbar select:focus { border-color:var(--navy-light); }
.btn-search {
    height:42px; padding:0 20px; background:var(--navy); color:white;
    border:none; border-radius:var(--radius-sm); font-size:13px; font-weight:600;
    cursor:pointer; font-family:var(--font); transition:background .15s;
    display:flex; align-items:center; gap:7px;
}
.btn-search:hover { background:var(--navy-mid); }
.btn-reset {
    height:42px; padding:0 16px; background:var(--card);
    color:var(--ink-soft); border:1px solid rgba(0,0,0,0.08);
    border-radius:var(--radius-sm); font-size:13px; cursor:pointer;
    font-family:var(--font); text-decoration:none;
    display:flex; align-items:center; gap:6px; transition:all .15s;
}
.btn-reset:hover { background:var(--cream-dark); }

.search-banner {
    display:flex; align-items:center; justify-content:space-between;
    background:var(--navy-pale); border:1px solid rgba(0,35,102,0.12);
    border-radius:var(--radius-sm); padding:10px 16px; margin-bottom:14px;
    font-size:13px; color:var(--navy);
}
.search-banner a { color:var(--navy); font-weight:600; text-decoration:none; font-size:12px; }

/* TABLE PANEL */
.table-panel {
    background:var(--card); border-radius:var(--radius);
    border:1px solid rgba(0,0,0,0.06); box-shadow:var(--shadow-sm); overflow:hidden;
}
.table-panel__head {
    padding:16px 22px; border-bottom:1px solid rgba(0,0,0,0.05);
    display:flex; align-items:center; justify-content:space-between;
}
.table-panel__title { font-family:var(--font-disp); font-size:17px; color:var(--ink); }
.table-panel__count { font-size:12.5px; color:var(--ink-soft); }
.table-panel__count strong { color:var(--ink); }

table { width:100%; border-collapse:collapse; }
thead tr { border-bottom:1px solid rgba(0,0,0,0.05); background:rgba(0,0,0,0.02); }
th { padding:10px 16px; text-align:left; font-size:10px; font-weight:700; color:var(--ink-soft); text-transform:uppercase; letter-spacing:0.7px; white-space:nowrap; }
tbody tr { border-bottom:1px solid rgba(0,0,0,0.04); transition:background .1s; }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover { background:rgba(0,0,0,0.02); }
td { padding:13px 16px; font-size:12.5px; vertical-align:middle; }

.req-info { display:flex; align-items:center; gap:11px; }
.req-thumb { width:40px; height:40px; border-radius:12px; object-fit:cover; flex-shrink:0; border:1px solid rgba(0,0,0,0.06); }
.req-thumb-ph { width:40px; height:40px; border-radius:12px; background:var(--cream-dark); display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
.req-title-text { font-weight:600; font-size:13px; color:var(--ink); }
.req-desc-text  { font-size:11px; color:var(--ink-soft); margin-top:2px; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

.action-wrap { display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
.status-select { padding:6px 10px; border-radius:10px; border:1px solid rgba(0,0,0,0.08); font-size:11.5px; font-family:var(--font); background:var(--card); color:var(--ink); cursor:pointer; outline:none; }
.btn-save { padding:6px 12px; background:var(--navy); color:white; border:none; border-radius:10px; font-size:11.5px; font-weight:600; cursor:pointer; font-family:var(--font); }
.btn-save:hover { background:var(--navy-mid); }
.btn-chat { padding:6px 12px; background:var(--card); color:var(--ink-soft); border:1px solid rgba(0,0,0,0.08); border-radius:10px; font-size:11.5px; font-weight:500; cursor:pointer; font-family:var(--font); display:inline-flex; align-items:center; gap:5px; transition:all .15s; }
.btn-chat:hover { background:var(--navy-pale); border-color:var(--navy-light); color:var(--navy); }
.chat-count { display:inline-flex; align-items:center; justify-content:center; width:17px; height:17px; background:var(--navy); color:white; border-radius:50%; font-size:9px; font-weight:700; }
.date-text { font-size:11.5px; color:var(--ink-soft); white-space:nowrap; }
.empty-state { padding:56px; text-align:center; color:var(--ink-faint); font-size:13px; }

/* CHAT PANEL */
.panel-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.2); z-index:199; backdrop-filter:blur(2px); }
.panel-overlay.open { display:block; }
.chat-panel {
    display:none; position:fixed; top:0; right:0; bottom:0; width:420px;
    background:var(--card); z-index:200;
    flex-direction:column;
    border-left:1px solid rgba(0,0,0,0.08);
    border-radius:24px 0 0 24px;
    box-shadow:-8px 0 40px rgba(0,0,0,0.1);
}
.chat-panel.open { display:flex; }
.chat-panel__head { padding:20px 22px 16px; background:#0d1b3e; border-radius:24px 0 0 0; display:flex; align-items:flex-start; justify-content:space-between; flex-shrink:0; }
.chat-panel__head-left { display:flex; align-items:center; gap:10px; }
.chat-panel__icon { width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; }
.chat-panel__title { font-size:14px; font-weight:700; color:white; }
.chat-panel__sub   { font-size:11.5px; color:rgba(255,255,255,0.45); margin-top:2px; }
.chat-panel__close { background:rgba(255,255,255,0.1); border:none; cursor:pointer; color:white; padding:7px; border-radius:9px; display:flex; align-items:center; transition:background .15s; }
.chat-panel__close:hover { background:rgba(255,255,255,0.18); }
.chat-panel__info { padding:12px 22px; background:rgba(0,0,0,0.03); border-bottom:1px solid rgba(0,0,0,0.05); flex-shrink:0; }
.chat-panel__req-title { font-size:13px; font-weight:600; color:var(--ink); }
.chat-panel__req-meta  { font-size:11.5px; color:var(--ink-soft); margin-top:3px; }
.chat-panel__messages { flex:1; overflow-y:auto; padding:18px 20px; display:flex; flex-direction:column; gap:12px; background:var(--cream); }
.chat-panel__messages::-webkit-scrollbar { width:4px; }
.chat-panel__messages::-webkit-scrollbar-thumb { background:rgba(0,0,0,0.1); border-radius:4px; }
.bubble-row { display:flex; align-items:flex-end; gap:8px; }
.bubble-row--admin { flex-direction:row-reverse; }
.bubble-av { width:30px; height:30px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:white; }
.bubble-av--admin     { background:#0d1b3e; }
.bubble-av--requestor { background:var(--purple); }
.bubble { max-width:76%; padding:10px 14px; border-radius:16px; font-size:13px; line-height:1.55; word-break:break-word; }
.bubble--admin     { background:#0d1b3e; color:white; border-bottom-right-radius:4px; }
.bubble--requestor { background:var(--card); color:var(--ink); border:1px solid rgba(0,0,0,0.06); border-bottom-left-radius:4px; }
.bubble-meta { font-size:10px; margin-top:4px; opacity:.65; }
.bubble--admin .bubble-meta { text-align:right; color:rgba(255,255,255,.8); }
.bubble--requestor .bubble-meta { color:var(--ink-faint); }
.chat-empty-state { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px; color:var(--ink-faint); padding:32px; }
.chat-panel__form { padding:14px 20px; border-top:1px solid rgba(0,0,0,0.05); flex-shrink:0; background:var(--card); border-radius:0 0 0 24px; }
.chat-panel__textarea { width:100%; border:1px solid rgba(0,0,0,0.08); border-radius:12px; padding:10px 14px; font-size:13px; font-family:var(--font); resize:none; outline:none; height:78px; background:var(--cream); color:var(--ink); transition:border-color .15s; }
.chat-panel__textarea:focus { border-color:var(--navy-light); }
.chat-panel__send { width:100%; margin-top:8px; padding:11px; background:#0d1b3e; color:white; border:none; border-radius:12px; font-size:13px; font-weight:600; cursor:pointer; font-family:var(--font); display:flex; align-items:center; justify-content:center; gap:7px; transition:background .15s; }
.chat-panel__send:hover { background:var(--navy); }

.toast { position:fixed; bottom:24px; right:24px; z-index:999; background:#0d1b3e; color:white; padding:12px 20px; border-radius:14px; font-size:13px; font-weight:500; box-shadow:0 4px 20px rgba(0,0,0,0.2); display:flex; align-items:center; gap:10px; animation:slideUp .3s ease,fadeOut .4s ease 2.6s forwards; }
.toast--success { background:#059669; }
.toast--reject  { background:#dc2626; }
@keyframes slideUp { from { transform:translateY(16px); opacity:0; } to { transform:translateY(0); opacity:1; } }
@keyframes fadeOut { from { opacity:1; } to { opacity:0; pointer-events:none; } }
</style>
@endsection

@section('content')
<div class="page-hd">
    <div>
        <div class="page-hd__title">Request Management</div>
        <div class="page-hd__sub">Review, update and communicate with requestors</div>
    </div>
</div>

<div class="stats-row">
    <div class="scard scard--yellow"><div class="scard__icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><div><div class="scard__num">{{ $pending }}</div><div class="scard__lbl">Pending Review</div></div></div>
    <div class="scard scard--blue"><div class="scard__icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div><div><div class="scard__num">{{ $review }}</div><div class="scard__lbl">Under Review</div></div></div>
    <div class="scard scard--green"><div class="scard__icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><div><div class="scard__num">{{ $approved }}</div><div class="scard__lbl">Approved</div></div></div>
    <div class="scard scard--purple"><div class="scard__icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></div><div><div class="scard__num">{{ $posted }}</div><div class="scard__lbl">Posted</div></div></div>
    <div class="scard scard--red"><div class="scard__icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div><div><div class="scard__num">{{ $rejected }}</div><div class="scard__lbl">Rejected</div></div></div>
</div>

<form method="GET" action="{{ route('admin.requests') }}" class="toolbar" id="filter-form">
    <div class="search-wrap">
        <span class="search-icon"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
        <input type="text" name="search" id="search-input" placeholder="Search by title, requester, category..." value="{{ $search }}" autocomplete="off">
    </div>
    <select name="filter">
        <option value="all" {{ $filter==='all'?'selected':'' }}>All Requests</option>
        <option value="pending" {{ $filter==='pending'?'selected':'' }}>Pending Review</option>
        <option value="review" {{ $filter==='review'?'selected':'' }}>Under Review</option>
        <option value="approved" {{ $filter==='approved'?'selected':'' }}>Approved</option>
        <option value="posted" {{ $filter==='posted'?'selected':'' }}>Posted</option>
        <option value="rejected" {{ $filter==='rejected'?'selected':'' }}>Rejected</option>
    </select>
    <select name="sort">
        <option value="newest" {{ $sort==='newest'?'selected':'' }}>Newest First</option>
        <option value="oldest" {{ $sort==='oldest'?'selected':'' }}>Oldest First</option>
        <option value="priority" {{ $sort==='priority'?'selected':'' }}>By Priority</option>
    </select>
    <button type="submit" class="btn-search">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Search
    </button>
    @if($search!==''||$filter!=='all')
        <a href="{{ route('admin.requests') }}" class="btn-reset">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Reset
        </a>
    @endif
</form>

@if($search!=='')
<div class="search-banner">
    <span>Results for <strong>"{{ $search }}"</strong> — <strong>{{ $total }}</strong> found</span>
    <a href="{{ route('admin.requests',['filter'=>$filter,'sort'=>$sort]) }}">✕ Clear</a>
</div>
@endif

<div class="table-panel">
    <div class="table-panel__head">
        <div class="table-panel__title">All Requests</div>
        <div class="table-panel__count">Showing <strong>{{ $total }}</strong> request{{ $total!==1?'s':'' }}</div>
    </div>
    <div style="overflow-x:auto;">
        <table>
            <thead><tr><th>Request</th><th>Requester</th><th>Category</th><th>Priority</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($requests as $req)
                @php
                    $sl=strtolower($req->status);
                    $sc=match(true){str_contains($sl,'approved')=>'approved',str_contains($sl,'posted')=>'posted',str_contains($sl,'under review')=>'under-review',str_contains($sl,'rejected')=>'rejected',default=>'pending'};
                    $pc=match(strtolower($req->priority??'')){'urgent'=>'urgent','high'=>'high','medium'=>'medium',default=>'low'};
                    $thumb=$req->first_media; $cc=$req->comments()->count();
                @endphp
                <tr>
                    <td><div class="req-info" style="cursor:pointer;" onclick="window.location='{{ route('admin.requests.show', $req->id) }}'">@if($thumb)<img class="req-thumb" src="/uploads/{{ $thumb }}" alt="" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"><div class="req-thumb-ph" style="display:none;">📄</div>@else<div class="req-thumb-ph">📄</div>@endif<div><div class="req-title-text">{{ Str::limit($req->title,32) }}</div><div class="req-desc-text">{{ Str::limit($req->description,55) }}</div></div></div></td>
                    <td style="font-weight:500;">{{ $req->requester }}</td>
                    <td style="color:var(--ink-soft);">{{ $req->category }}</td>
                    <td><span class="badge badge--{{ $pc }}">{{ strtoupper($req->priority) }}</span></td>
                    <td><span class="badge badge--{{ $sc }}">{{ $req->status }}</span></td>
                    <td class="date-text">{{ $req->created_at->format('M j, Y') }}</td>
                    <td>
                        <div class="action-wrap">
                            <form method="POST" action="{{ route('admin.requests.status') }}" style="display:flex;align-items:center;gap:5px;" onsubmit="return confirmStatus(this)">
                                @csrf<input type="hidden" name="request_id" value="{{ $req->id }}">
                                <select class="status-select" name="status">@foreach(['Pending Review','Under Review','Approved','Posted','Rejected'] as $s)<option value="{{ $s }}" {{ $req->status===$s?'selected':'' }}>{{ $s }}</option>@endforeach</select>
                                <button type="submit" class="btn-save">Save</button>
                            </form>
                            <button class="btn-chat" onclick="openChat({{ $req->id }},{{ json_encode($req->title) }},{{ json_encode($req->status) }},{{ json_encode($req->requester) }})">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Chat @if($cc>0)<span class="chat-count">{{ $cc }}</span>@endif
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><div class="empty-state">No requests found.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="panel-overlay" id="panel-overlay" onclick="closeChat()"></div>
<div class="chat-panel" id="chat-panel">
    <div class="chat-panel__head">
        <div class="chat-panel__head-left">
            <div class="chat-panel__icon"><svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
            <div><div class="chat-panel__title">Chat with Requestor</div><div class="chat-panel__sub" id="panel-requester-name">—</div></div>
        </div>
        <button class="chat-panel__close" onclick="closeChat()"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <div class="chat-panel__info">
        <div class="chat-panel__req-title" id="panel-req-title">—</div>
        <div class="chat-panel__req-meta" id="panel-req-status"></div>
    </div>
    <div class="chat-panel__messages" id="chat-messages"><div class="chat-empty-state"><svg width="36" height="36" fill="none" stroke="rgba(0,0,0,0.15)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><p>No messages yet.</p></div></div>
    <div class="chat-panel__form">
        <textarea class="chat-panel__textarea" id="chat-input" placeholder="Type a message… (Enter to send)" onkeydown="handleKey(event)"></textarea>
        <button class="chat-panel__send" onclick="sendMessage()"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>Send Message</button>
    </div>
</div>

@if(session('success'))<div class="toast toast--success" id="toast"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>{{ session('success') }}</div>@endif
@if(session('error'))<div class="toast toast--reject" id="toast"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>{{ session('error') }}</div>@endif
@endsection

@section('scripts')
<script>
let cid=null;
let st;
document.getElementById('search-input').addEventListener('input',function(){clearTimeout(st);st=setTimeout(()=>document.getElementById('filter-form').submit(),500);});
function openChat(reqId,title,status,requester){cid=reqId;document.getElementById('panel-req-title').textContent=title;document.getElementById('panel-req-status').textContent=status;document.getElementById('panel-requester-name').textContent=requester;document.getElementById('chat-panel').classList.add('open');document.getElementById('panel-overlay').classList.add('open');document.body.style.overflow='hidden';loadMessages(reqId);}
function closeChat(){document.getElementById('chat-panel').classList.remove('open');document.getElementById('panel-overlay').classList.remove('open');document.body.style.overflow='';cid=null;}
function loadMessages(reqId){const box=document.getElementById('chat-messages');box.innerHTML='<div class="chat-empty-state"><p>Loading…</p></div>';fetch(`/admin/requests/${reqId}/comments`,{headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(r=>r.json()).then(data=>{const msgs=data.comments||[];if(!msgs.length){box.innerHTML='<div class="chat-empty-state"><svg width="36" height="36" fill="none" stroke="rgba(0,0,0,0.15)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><p>No messages yet!</p></div>';return;}box.innerHTML=msgs.map(c=>{const a=c.sender_role==='admin';return`<div class="bubble-row ${a?'bubble-row--admin':''}"><div class="bubble-av ${a?'bubble-av--admin':'bubble-av--requestor'}">${esc(c.sender_name.charAt(0).toUpperCase())}</div><div class="bubble ${a?'bubble--admin':'bubble--requestor'}">${esc(c.message)}<div class="bubble-meta">${a?'Admin':esc(c.sender_name)} · ${esc(c.created_at)}</div></div></div>`;}).join('');box.scrollTop=box.scrollHeight;}).catch(()=>{box.innerHTML='<div class="chat-empty-state"><p>Could not load messages.</p></div>';});}
async function sendMessage(){const input=document.getElementById('chat-input');const msg=input.value.trim();if(!msg||!cid)return;const btn=document.querySelector('.chat-panel__send');btn.disabled=true;try{const res=await fetch('/admin/requests/comment',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:JSON.stringify({request_id:cid,message:msg})});const d=await res.json();if(d.success){input.value='';loadMessages(cid);}else alert('Failed: '+(d.message||'Unknown error'));}catch(e){alert('Connection error.');}btn.disabled=false;}
function handleKey(e){if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();sendMessage();}}
function confirmStatus(f){return confirm(`Update status to "${f.querySelector('select[name="status"]').value}"?`);}
function esc(s){return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');}
setTimeout(()=>document.getElementById('toast')?.remove(),3000);
</script>
@endsection