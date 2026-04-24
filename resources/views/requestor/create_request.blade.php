@extends('layouts.requestor')

@section('title', 'Create Request')
@section('page-title', 'Create Request')

@section('head-styles')
<style>

/* ── PAGE SHELL ─────────────────────── */
.create-page {
    min-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 36px 24px 60px;
}

/* ── HERO HEADING ───────────────────── */
.create-hero {
    text-align: center;
    margin-bottom: 36px;
    max-width: 560px;
}
.create-hero__eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; letter-spacing: 1.2px;
    text-transform: uppercase; color: var(--accent);
    background: rgba(59,110,245,0.08);
    border: 1px solid rgba(59,110,245,0.18);
    padding: 4px 12px; border-radius: 20px;
    margin-bottom: 14px;
}
.create-hero__eyebrow svg { color: var(--accent); }
.create-hero h1 {
    font-size: 30px; font-weight: 800;
    letter-spacing: -0.8px; color: var(--text);
    margin-bottom: 10px; line-height: 1.15;
}
.create-hero h1 span { color: #001a6e; }
.create-hero p { font-size: 14px; color: var(--text-muted); line-height: 1.65; }

/* ── ALERTS ─────────────────────────── */
.alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; font-weight: 500; width: 100%; max-width: 680px; }
.alert--success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.alert--error   { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

/* ── FORM WRAPPER ───────────────────── */
.form-body { width: 100%; max-width: 680px; display: flex; flex-direction: column; gap: 16px; }

/* ── SECTION CARD ───────────────────── */
.form-section {
    background: white; border-radius: 18px;
    border: 1.5px solid var(--border); padding: 26px 28px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04); transition: box-shadow .2s;
}
.form-section:focus-within { box-shadow: 0 4px 20px rgba(59,110,245,0.08); border-color: rgba(59,110,245,0.25); }
.section-title {
    display: flex; align-items: center; gap: 10px;
    font-size: 13.5px; font-weight: 700; color: var(--text);
    margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid var(--border);
}
.section-title__icon { width: 32px; height: 32px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.section-title__icon--blue   { background: #dbeafe; color: #2563eb; }
.section-title__icon--purple { background: #ede9fe; color: #7c3aed; }
.section-title__icon--teal   { background: #d1fae5; color: #059669; }
.section-title__icon--amber  { background: #fef3c7; color: #d97706; }

/* ── FIELDS ─────────────────────────── */
.field { margin-bottom: 16px; }
.field:last-child { margin-bottom: 0; }
.field label { display: block; font-size: 11.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 7px; letter-spacing: 0.3px; text-transform: uppercase; }
.field label .req { color: #ef4444; margin-left: 2px; }
.field label .opt { color: var(--text-faint); font-weight: 400; text-transform: none; font-size: 11px; }
.field input[type="text"],
.field input[type="date"],
.field select,
.field textarea {
    width: 100%; border: 1.5px solid var(--border); border-radius: 12px;
    padding: 11px 14px; font-size: 13.5px; font-family: var(--font);
    color: var(--text); background: #fafbfd;
    outline: none; transition: border-color .15s, background .15s, box-shadow .15s;
}
.field input:focus, .field select:focus, .field textarea:focus {
    border-color: #3b6ef5; background: white; box-shadow: 0 0 0 3px rgba(59,110,245,0.08);
}
.field textarea { resize: vertical; min-height: 110px; line-height: 1.6; }
.field input::placeholder, .field textarea::placeholder { color: #c8cdd8; }
.field select { appearance: none; cursor: pointer; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* ── PLATFORM BUTTONS ───────────────── */
.platform-group { display: flex; gap: 8px; flex-wrap: wrap; }
.platform-btn {
    padding: 8px 16px; border-radius: 10px; border: 1.5px solid var(--border);
    font-size: 12.5px; font-weight: 500; cursor: pointer;
    background: #fafbfd; color: var(--text-muted);
    font-family: var(--font); transition: all .15s;
    display: flex; align-items: center; gap: 7px;
}
.platform-btn:hover:not(.selected) { border-color: #93c5fd; color: var(--text); background: #eff6ff; }
.platform-btn.selected { background: #001a6e; color: white; border-color: #001a6e; box-shadow: 0 2px 8px rgba(0,26,110,0.2); }

/* ── MEDIA UPLOAD ───────────────────── */
.upload-area { display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start; }
.upload-box {
    width: 82px; height: 82px; border: 2px dashed #cbd5e1; border-radius: 12px;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    cursor: pointer; color: var(--text-faint); font-size: 11px; gap: 5px;
    transition: all .15s; background: #fafbfd;
}
.upload-box:hover { border-color: #3b6ef5; background: #eff6ff; color: #3b6ef5; }
.upload-hint { font-size: 11.5px; color: var(--text-faint); margin-top: 6px; }
#media-input { display: none; }
.preview-wrap { position: relative; width: 82px; height: 82px; }
.preview-thumb { width: 82px; height: 82px; border-radius: 12px; object-fit: cover; border: 1.5px solid var(--border); display: block; }
.preview-remove {
    position: absolute; top: -7px; right: -7px;
    width: 22px; height: 22px; background: #ef4444; color: white;
    border: 2px solid white; border-radius: 50%; font-size: 12px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}

/* ── AI SECTION ─────────────────────── */
.ai-section {
    background: linear-gradient(135deg, #f5f3ff 0%, #eff6ff 100%);
    border: 1.5px solid rgba(109,40,217,0.2); border-radius: 18px;
    padding: 22px 28px; box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.ai-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.ai-title { display: flex; align-items: center; gap: 9px; font-size: 13.5px; font-weight: 700; color: #5b21b6; }
.ai-badge { font-size: 9.5px; font-weight: 700; letter-spacing: 0.5px; padding: 2px 8px; border-radius: 20px; background: rgba(109,40,217,0.12); color: #7c3aed; border: 1px solid rgba(109,40,217,0.2); }
.ai-generate-btn {
    display: flex; align-items: center; gap: 7px; padding: 9px 18px;
    background: #5b21b6; color: white; border: none; border-radius: 10px;
    font-size: 12.5px; font-weight: 700; cursor: pointer; font-family: var(--font);
    transition: all .15s; box-shadow: 0 2px 8px rgba(91,33,182,0.3);
}
.ai-generate-btn:hover { background: #4c1d95; transform: translateY(-1px); }
.ai-generate-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }
.ai-hint { font-size: 12px; color: #7c3aed; margin-bottom: 10px; opacity: 0.75; }
.ai-textarea {
    width: 100%; border: 1.5px solid rgba(109,40,217,0.2); border-radius: 12px;
    padding: 12px 14px; font-size: 13.5px; font-family: var(--font);
    background: rgba(255,255,255,0.7); color: var(--text);
    outline: none; resize: vertical; min-height: 140px;
    transition: border-color .15s, box-shadow .15s; line-height: 1.6;
}
.ai-textarea:focus { border-color: #8b5cf6; background: white; box-shadow: 0 0 0 3px rgba(139,92,246,0.1); }
.ai-textarea::placeholder { color: #c4b5fd; }

/* Fixed footer preview */
.ai-footer-preview {
    margin-top: 10px; padding: 12px 14px;
    background: rgba(91,33,182,0.05);
    border: 1px dashed rgba(91,33,182,0.2);
    border-radius: 10px; font-size: 12px; color: #5b21b6; line-height: 1.7;
}
.ai-footer-preview__label {
    display: block; font-size: 9.5px; font-weight: 800; letter-spacing: 0.6px;
    text-transform: uppercase; color: #7c3aed; opacity: 0.65; margin-bottom: 6px;
}

/* ── FORM ACTIONS ───────────────────── */
.form-actions {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px 28px; background: white; border-radius: 18px;
    border: 1.5px solid var(--border); box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.form-actions__left { font-size: 12px; color: var(--text-faint); }
.form-actions__left span { color: #ef4444; }
.actions-right { display: flex; gap: 10px; }
.btn-cancel {
    padding: 10px 24px; border-radius: 10px; border: 1.5px solid var(--border);
    background: white; font-size: 13.5px; font-weight: 600; cursor: pointer;
    color: var(--text-muted); font-family: var(--font); transition: all .15s;
}
.btn-cancel:hover { background: #f3f4f6; border-color: #c8cdd8; color: var(--text); }
.btn-submit {
    padding: 10px 28px; border-radius: 10px; border: none;
    background: #001a6e; color: white; font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: var(--font);
    transition: all .15s; display: flex; align-items: center; gap: 8px;
    box-shadow: 0 3px 12px rgba(0,26,110,0.3);
}
.btn-submit:hover { background: #00237a; transform: translateY(-1px); box-shadow: 0 5px 18px rgba(0,26,110,0.35); }

@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@media (max-width: 600px) { .field-row { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="create-page">

    <div class="create-hero">
        <div class="create-hero__eyebrow">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Request
        </div>
        <h1>What would you like to <span>post?</span></h1>
        <p>Fill in the details below and our admin team will review your request. The more detail you provide, the faster we can approve it.</p>
    </div>

    @if(session('success'))
        <div class="alert alert--success">✅ {{ session('success') }} <a href="{{ route('requestor.requests') }}" style="color:inherit;font-weight:700;margin-left:6px;">View requests →</a></div>
    @endif
    @if(session('error'))
        <div class="alert alert--error">❌ {{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('requestor.requests.store') }}" enctype="multipart/form-data" id="create-form" class="form-body">
        @csrf

        {{-- BASIC INFO --}}
        <div class="form-section">
            <div class="section-title">
                <div class="section-title__icon section-title__icon--blue">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                Basic Information
            </div>
            <div class="field">
                <label>Post Title <span class="req">*</span></label>
                <input type="text" name="title" id="title-field" placeholder="e.g., College Week 2025 Opening Ceremony" value="{{ old('title') }}" required>
            </div>
            <div class="field">
                <label>Description <span class="req">*</span></label>
                <textarea name="description" id="desc-field" placeholder="Describe your event or announcement in detail. Include key info like date, time, and location..." required>{{ old('description') }}</textarea>
            </div>
            <div class="field-row">
                <div class="field">
                    <label>Category <span class="req">*</span></label>
                    <select name="category" id="cat-field" required>
                        <option value="" disabled {{ !old('category') ? 'selected' : '' }}>Select category</option>
                        @foreach(['Events','Announcements','Academic','Sports','Community','Others'] as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Priority <span class="req">*</span></label>
                    <select name="priority" required>
                        <option value="" disabled {{ !old('priority') ? 'selected' : '' }}>Select priority</option>
                        @foreach(['Low','Medium','High','Urgent'] as $pri)
                            <option value="{{ $pri }}" {{ old('priority') === $pri ? 'selected' : '' }}>{{ $pri }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="field">
                <label>Preferred Post Date <span class="opt">(Optional)</span></label>
                <input type="date" name="post_date" value="{{ old('post_date') }}" min="{{ date('Y-m-d') }}">
            </div>
        </div>

        {{-- PLATFORMS --}}
        <div class="form-section">
            <div class="section-title">
                <div class="section-title__icon section-title__icon--teal">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.69 3.36 2 2 0 0 1 3.68 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.7a16 16 0 0 0 7 7l1.06-1.06a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                Target Platforms <span style="color:#ef4444;font-size:12px;font-weight:400;margin-left:4px;">*</span>
            </div>
            @php $selected_platforms = old('platforms', []); @endphp
            <div class="platform-group" id="platform-group">
                @foreach(['Facebook','LinkedIn'] as $p)
                    <button type="button" class="platform-btn {{ in_array($p, $selected_platforms) ? 'selected' : '' }}" data-platform="{{ $p }}">{{ $p }}</button>
                @endforeach
            </div>
            <div id="platform-inputs">
                @foreach($selected_platforms as $p)
                    <input type="hidden" name="platforms[]" value="{{ $p }}">
                @endforeach
            </div>
        </div>

        {{-- MEDIA --}}
        <div class="form-section">
            <div class="section-title">
                <div class="section-title__icon section-title__icon--amber">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                Media Attachments
            </div>
            <div class="upload-area" id="upload-area">
                <label class="upload-box" for="media-input" id="upload-label">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    Upload
                </label>
            </div>
            <input type="file" id="media-input" name="media[]" multiple accept="image/*,video/mp4,video/quicktime">
            <p class="upload-hint">Up to 4 images or videos · Max 10MB each</p>
        </div>

        {{-- AI CAPTION --}}
        <div class="ai-section">
            <div class="ai-header">
                <div class="ai-title">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    AI Caption Generator
                    <span class="ai-badge">✦ Gemini AI</span>
                </div>
                <button type="button" class="ai-generate-btn" id="generate-btn" onclick="generateCaption()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                    Generate Caption
                </button>
            </div>
            <p class="ai-hint">Fill in title & description first, then click Generate.</p>
            <textarea class="ai-textarea" name="caption" id="caption-field"
                      placeholder="Your AI-generated caption will appear here. You can also write your own...">{{ old('caption') }}</textarea>

            {{-- Fixed footer preview --}}
            <div class="ai-footer-preview">
                <span class="ai-footer-preview__label">✦ Auto-added when you submit — not shown in the box above</span>
                Apply now and secure your place for the upcoming academic year: https://onlineapp.nu-lipa.edu.ph/quest/register.php<br>
                Experience 𝘌𝘥𝘶𝘤𝘢𝘵𝘪𝘰𝘯 𝘛𝘩𝘢𝘵 𝘞𝘰𝘳𝘬𝘴.<br>
                #NULipa #EducationThatWorks
            </div>
        </div>

        {{-- SUBMIT BAR --}}
        <div class="form-actions">
            <div class="form-actions__left">Fields marked <span>*</span> are required</div>
            <div class="actions-right">
                <button type="button" class="btn-cancel" onclick="history.back()">Cancel</button>
                <button type="submit" class="btn-submit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Submit Request
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
// ── FIXED FOOTER — auto-appended on submit, NOT shown to user ──────────
const FIXED_FOOTER = "\n\nApply now and secure your place for the upcoming academic year: https://onlineapp.nu-lipa.edu.ph/quest/register.php\nExperience \u{1D60C}\u{1D625}\u{1D636}\u{1D624}\u{1D622}\u{1D635}\u{1D62A}\u{1D630}\u{1D62F} \u{1D61B}\u{1D629}\u{1D622}\u{1D635} \u{1D61E}\u{1D630}\u{1D633}\u{1D62C}\u{1D634}.\n#NULipa\n#EducationThatWorks";

// AUTO-APPEND FOOTER ON SUBMIT — user sees clean caption, DB gets full footer
document.getElementById('create-form').addEventListener('submit', function() {
    const box = document.getElementById('caption-field');
    const current = box.value.trim();
    if (current && !current.includes('onlineapp.nu-lipa.edu.ph')) {
        box.value = current + FIXED_FOOTER;
    }
});

// PLATFORM BUTTONS
const platformInputs = document.getElementById('platform-inputs');
function updatePlatformInputs() {
    platformInputs.innerHTML = '';
    document.querySelectorAll('.platform-btn.selected').forEach(btn => {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'platforms[]'; inp.value = btn.dataset.platform;
        platformInputs.appendChild(inp);
    });
}
document.querySelectorAll('.platform-btn').forEach(btn => {
    btn.addEventListener('click', () => { btn.classList.toggle('selected'); updatePlatformInputs(); });
});

// MEDIA PREVIEW
const mediaInput  = document.getElementById('media-input');
const uploadArea  = document.getElementById('upload-area');
const uploadLabel = document.getElementById('upload-label');
mediaInput.addEventListener('change', () => {
    document.querySelectorAll('.preview-wrap').forEach(el => el.remove());
    const files = Array.from(mediaInput.files).slice(0, 4);
    files.forEach(file => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.createElement('div'); wrap.className = 'preview-wrap';
            const img  = document.createElement('img'); img.src = e.target.result; img.className = 'preview-thumb';
            const rm   = document.createElement('button'); rm.type = 'button'; rm.className = 'preview-remove'; rm.innerHTML = '×';
            rm.onclick = () => wrap.remove();
            wrap.appendChild(img); wrap.appendChild(rm);
            uploadArea.insertBefore(wrap, uploadLabel);
        };
        reader.readAsDataURL(file);
    });
    uploadLabel.style.display = files.length >= 4 ? 'none' : 'flex';
});

// AI CAPTION GENERATOR
async function generateCaption() {
    const title = document.getElementById('title-field').value.trim();
    const desc  = document.getElementById('desc-field').value.trim();
    const cat   = document.getElementById('cat-field').value || 'General';
    const plats = Array.from(document.querySelectorAll('.platform-btn.selected'))
                       .map(b => b.dataset.platform).join(', ');
    const btn   = document.getElementById('generate-btn');
    const box   = document.getElementById('caption-field');

    if (!title || !desc) {
        alert('Please fill in the Title and Description first.');
        return;
    }

    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation:spin 1s linear infinite;display:inline-block;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Generating...`;

    try {
        const res = await fetch('/api/generate-caption', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title, description: desc, category: cat, platforms: plats })
        });

        const data = await res.json();
        if (data.error) throw new Error(data.error);
        if (!data.caption) throw new Error('No caption returned.');

        // Strip ALL hashtags and footers from AI output
        let caption = data.caption
            .replace(/#\w+/g, '')                          // remove all hashtags
            .replace(/Apply now[\s\S]*?register\.php/gi, '')
            .replace(/https?:\/\/onlineapp\.nu-lipa\.edu\.ph[^\s]*/gi, '')
            .replace(/Experience\s+\S*[Ee]ducation\S*\s+\S*[Tt]hat\S*\s+\S*[Ww]orks\S*/gi, '')
            .replace(/\n{3,}/g, '\n\n')   // collapse extra blank lines
            .trim();

        // Show clean caption to user (no footer yet)
        box.value = caption;

    } catch(e) {
        alert('Caption generation failed: ' + e.message);
    } finally {
        btn.disabled = false;
        btn.innerHTML = orig;
    }
}
</script>
@endsection 