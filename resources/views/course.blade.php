<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tutorial->title }} — Operation Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --espresso:   #1a0a00;
            --dark-roast: #2c1503;
            --gold:       #f0c040;
            --gold-light: #ffe082;
            --cream:      #f5e6d3;
            --azure:      #1565c0;
            --azure-light:#42a5f5;
            --green:      #22c55e;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Cairo',sans-serif; background:var(--espresso); color:var(--cream); min-height:100vh; }

        /* Navbar */
        .navbar-custom {
            background:rgba(26,10,0,.9); backdrop-filter:blur(18px);
            border-bottom:1px solid rgba(240,192,64,.2);
            padding:.9rem 2rem; position:sticky; top:0; z-index:100;
            display:flex; align-items:center; justify-content:space-between;
        }
        .brand-logo { font-family:'Playfair Display',serif; font-size:1.4rem;
            background:linear-gradient(135deg,var(--gold),var(--azure-light));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-links { display:flex; align-items:center; gap:1rem; }
        .nav-links a { color:rgba(245,230,211,.6); text-decoration:none; font-size:.85rem; transition:color .2s; }
        .nav-links a:hover { color:var(--gold); }

        /* Hero */
        .course-hero { position:relative; overflow:hidden; min-height:320px; display:flex; align-items:flex-end; }
        .course-hero-img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
        .course-hero-fallback { position:absolute; inset:0; background:linear-gradient(135deg,#3e1c00,#8b4513); }
        .course-hero-overlay { position:absolute; inset:0; background:linear-gradient(to top,rgba(26,10,0,1) 0%,rgba(26,10,0,.5) 60%,transparent 100%); }
        .course-hero-content { position:relative; z-index:1; padding:2rem; width:100%; }
        .course-meta { display:flex; align-items:center; gap:.8rem; flex-wrap:wrap; margin-bottom:.8rem; }
        .course-badge { font-size:.72rem; font-weight:700; letter-spacing:1px; padding:.3rem .9rem; border-radius:50px; text-transform:uppercase; }
        .badge-beginner     { background:linear-gradient(135deg,#2e7d32,#66bb6a); color:#fff; }
        .badge-intermediate { background:linear-gradient(135deg,var(--azure),var(--azure-light)); color:#fff; }
        .badge-advanced     { background:linear-gradient(135deg,#b71c1c,#ef5350); color:#fff; }
        .course-cat { font-size:.78rem; color:var(--azure-light); letter-spacing:3px; text-transform:uppercase; }
        .course-title { font-family:'Playfair Display',serif; font-size:clamp(1.8rem,4vw,2.8rem); font-weight:900; color:var(--cream); line-height:1.2; margin-bottom:.6rem; }
        .course-stats { display:flex; gap:1.5rem; flex-wrap:wrap; }
        .course-stat { font-size:.82rem; color:rgba(245,230,211,.7); display:flex; align-items:center; gap:.4rem; }
        .course-stat i { color:var(--gold); }

        /* Layout */
        .course-layout { max-width:1100px; margin:0 auto; padding:2rem 1rem; display:grid; grid-template-columns:1fr 340px; gap:1.5rem; align-items:start; }
        @media(max-width:768px) { .course-layout { grid-template-columns:1fr; } }

        /* Cards */
        .section-card { background:rgba(44,21,3,.6); border:1px solid rgba(240,192,64,.1); border-radius:16px; padding:1.5rem; margin-bottom:1.2rem; }
        .section-title { font-size:1rem; font-weight:700; color:var(--gold-light); margin-bottom:1rem; display:flex; align-items:center; gap:.5rem; }
        .course-desc { font-size:.9rem; color:rgba(245,230,211,.75); line-height:1.8; }

        /* Progress bar */
        .progress-bar-wrap { background:rgba(255,255,255,.1); border-radius:50px; height:10px; overflow:hidden; margin:.6rem 0; }
        .progress-bar-fill { height:100%; border-radius:50px; background:linear-gradient(90deg,var(--gold),var(--green)); transition:width .6s ease; }
        .progress-text { font-size:.82rem; color:rgba(245,230,211,.7); display:flex; justify-content:space-between; }

        /* Lesson list items */
        .lesson-item { display:flex; align-items:center; gap:.8rem; padding:.8rem .9rem; border-radius:10px;
            border:1px solid rgba(240,192,64,.08); background:rgba(255,255,255,.03);
            margin-bottom:.5rem; cursor:pointer; transition:background .2s, border-color .2s; }
        .lesson-item:hover { background:rgba(240,192,64,.07); border-color:rgba(240,192,64,.2); }
        .lesson-item.active { background:rgba(240,192,64,.1); border-color:rgba(240,192,64,.35); }
        .lesson-item.completed-item { border-color:rgba(34,197,94,.3); background:rgba(34,197,94,.05); }
        .lesson-num { width:30px; height:30px; border-radius:50%; flex-shrink:0;
            background:rgba(240,192,64,.15); border:1px solid rgba(240,192,64,.3);
            display:flex; align-items:center; justify-content:center; font-size:.75rem; font-weight:700; color:var(--gold); }
        .lesson-item.active .lesson-num { background:var(--gold); color:var(--espresso); }
        .lesson-item.completed-item .lesson-num { background:rgba(34,197,94,.2); border-color:rgba(34,197,94,.5); color:var(--green); }
        .lesson-info { flex:1; min-width:0; }
        .lesson-name { font-size:.85rem; font-weight:600; color:var(--cream); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .lesson-dur  { font-size:.73rem; color:rgba(245,230,211,.5); margin-top:.1rem; }

        /* Lesson panel */
        .lesson-panel { background:rgba(44,21,3,.6); border:1px solid rgba(240,192,64,.1); border-radius:16px; overflow:hidden; }
        .lesson-panel-header { padding:1.2rem 1.5rem; border-bottom:1px solid rgba(240,192,64,.1); display:flex; align-items:center; gap:.8rem; }
        .lesson-panel-num { width:36px; height:36px; border-radius:50%; background:var(--gold); display:flex; align-items:center; justify-content:center; font-weight:700; color:var(--espresso); font-size:.85rem; flex-shrink:0; }
        .lesson-panel-title { font-size:1rem; font-weight:700; color:var(--cream); flex:1; }
        .lesson-panel-done-badge { font-size:.75rem; color:var(--green); display:flex; align-items:center; gap:.3rem; flex-shrink:0; }
        .lesson-panel-body { padding:1.5rem; }

        /* Video */
        .video-wrap { position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:10px; margin-bottom:1.2rem; background:#000; }
        .video-wrap iframe { position:absolute; inset:0; width:100%; height:100%; border:none; }

        .lesson-content-text { font-size:.9rem; color:rgba(245,230,211,.8); line-height:1.9; white-space:pre-wrap; }

        /* Completion area */
        .completion-area { margin-top:1.4rem; padding-top:1.2rem; border-top:1px solid rgba(240,192,64,.1); }
        .btn-complete {
            width:100%; padding:.75rem 1.2rem; border-radius:12px; border:none; cursor:pointer;
            font-family:'Cairo',sans-serif; font-size:.95rem; font-weight:700;
            background:linear-gradient(135deg,var(--gold),#e6a817); color:var(--espresso);
            display:flex; align-items:center; justify-content:center; gap:.5rem;
            transition:all .2s;
        }
        .btn-complete:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 8px 20px rgba(240,192,64,.3); }
        .btn-complete:disabled { opacity:.5; cursor:not-allowed; transform:none; box-shadow:none; }
        .btn-completed-state {
            width:100%; padding:.75rem 1.2rem; border-radius:12px;
            font-family:'Cairo',sans-serif; font-size:.95rem; font-weight:700;
            background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.4);
            color:var(--green); display:flex; align-items:center; justify-content:center; gap:.5rem;
        }

        /* Nav buttons */
        .lesson-nav { display:flex; gap:.6rem; margin-top:1rem; }
        .btn-lesson { flex:1; padding:.6rem 1rem; border-radius:10px; border:none; cursor:pointer; font-family:'Cairo',sans-serif; font-size:.85rem; font-weight:700; display:flex; align-items:center; justify-content:center; gap:.5rem; transition:all .2s; }
        .btn-prev { background:rgba(255,255,255,.07); color:var(--cream); }
        .btn-prev:hover { background:rgba(255,255,255,.12); }
        .btn-next { background:linear-gradient(135deg,var(--gold),#e6a817); color:var(--espresso); }
        .btn-next:hover { opacity:.9; }
        .btn-lesson:disabled { opacity:.35; cursor:not-allowed; }

        /* Certificate card */
        .cert-card { background:linear-gradient(135deg,rgba(240,192,64,.12),rgba(66,165,245,.08));
            border:1px solid rgba(240,192,64,.35); border-radius:16px; padding:1.5rem; text-align:center; }
        .cert-icon { font-size:3rem; color:var(--gold); margin-bottom:.8rem; display:block; }
        .cert-title { font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:var(--gold-light); margin-bottom:.4rem; }
        .cert-num { font-size:.78rem; color:rgba(245,230,211,.55); letter-spacing:2px; margin-bottom:1rem; }
        .btn-cert { display:inline-flex; align-items:center; gap:.5rem; padding:.6rem 1.4rem; border-radius:50px; background:linear-gradient(135deg,var(--gold),#e6a817); color:var(--espresso); font-weight:700; font-size:.88rem; text-decoration:none; font-family:'Cairo',sans-serif; }
        .btn-cert:hover { opacity:.9; color:var(--espresso); }

        /* Sidebar sticky */
        .sidebar-sticky { position:sticky; top:80px; }

        /* Completion all-done */
        .all-done-card { background:linear-gradient(135deg,rgba(34,197,94,.1),rgba(34,197,94,.05)); border:1px solid rgba(34,197,94,.3); border-radius:14px; padding:1.2rem; text-align:center; margin-bottom:1rem; }
        .all-done-icon { font-size:2.2rem; color:var(--green); display:block; margin-bottom:.5rem; }
        .all-done-title { font-size:1rem; font-weight:700; color:var(--green); margin-bottom:.2rem; }

        /* Empty */
        .empty-lessons { text-align:center; padding:3rem 1rem; color:rgba(245,230,211,.4); }
        .empty-lessons i { font-size:2.5rem; display:block; margin-bottom:.8rem; }

        /* Flash */
        .flash-toast { position:fixed; bottom:1.5rem; left:50%; transform:translateX(-50%); z-index:999;
            background:rgba(34,197,94,.9); color:#fff; padding:.75rem 1.5rem; border-radius:50px;
            font-size:.9rem; font-weight:600; display:flex; align-items:center; gap:.5rem;
            box-shadow:0 8px 25px rgba(0,0,0,.3); animation:toastIn .3s ease; }
        @keyframes toastIn { from{opacity:0;transform:translateX(-50%) translateY(20px)} to{opacity:1;transform:translateX(-50%) translateY(0)} }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <span class="brand-logo">☕ Operation Manual</span>
    <div class="nav-links">
        <a href="{{ route('tutorials') }}"><i class="fas fa-arrow-right me-1"></i> الكورسات</a>
        <a href="{{ route('certificates.index') }}"><i class="fas fa-certificate me-1"></i> شهاداتي</a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.lessons.index', $tutorial) }}"><i class="fas fa-cog me-1"></i> إدارة الدروس</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="background:none;border:none;color:rgba(245,230,211,.5);font-size:.85rem;cursor:pointer;font-family:'Cairo',sans-serif;">
                <i class="fas fa-sign-out-alt me-1"></i> خروج
            </button>
        </form>
    </div>
</nav>

{{-- Hero --}}
<div class="course-hero">
    @if($tutorial->cover_url)
        <img class="course-hero-img" src="{{ $tutorial->cover_url }}" alt="{{ $tutorial->title }}">
    @else
        <div class="course-hero-fallback"></div>
    @endif
    <div class="course-hero-overlay"></div>
    <div class="course-hero-content">
        <div class="course-meta">
            <span class="course-badge badge-{{ $tutorial->level }}">
                {{ ['beginner'=>'مبتدئ','intermediate'=>'متوسط','advanced'=>'متقدم'][$tutorial->level] }}
            </span>
            <span class="course-cat">{{ $tutorial->category->name ?? '' }}</span>
            @if($tutorial->certificate_enabled)
            <span style="font-size:.72rem;background:rgba(240,192,64,.2);border:1px solid rgba(240,192,64,.4);color:var(--gold-light);padding:.25rem .8rem;border-radius:50px;">
                <i class="fas fa-certificate me-1"></i> يوجد شهادة
            </span>
            @endif
        </div>
        <h1 class="course-title">{{ $tutorial->title }}</h1>
        <div class="course-stats">
            <span class="course-stat"><i class="fas fa-list-check"></i> {{ $tutorial->lessons->count() }} درس</span>
            @if($tutorial->duration)
            <span class="course-stat"><i class="fas fa-clock"></i> {{ $tutorial->duration }}</span>
            @endif
            <span class="course-stat">
                <i class="fas fa-circle-check"></i>
                {{ $progress['completed'] }} / {{ $progress['total'] }} مكتمل
            </span>
        </div>
    </div>
</div>

{{-- Content --}}
<div class="course-layout">

    {{-- Main column --}}
    <div>
        {{-- About card --}}
        <div class="section-card">
            <div class="section-title"><i class="fas fa-info-circle"></i> عن الكورس</div>
            <p class="course-desc">{{ $tutorial->description }}</p>
        </div>

        {{-- Progress card --}}
        @if($progress['total'] > 0)
        <div class="section-card" id="progressCard">
            <div class="section-title"><i class="fas fa-chart-line"></i> تقدمك في الكورس</div>
            <div class="progress-text">
                <span>{{ $progress['completed'] }} / {{ $progress['total'] }} درس مكتمل</span>
                <span id="progressPercent">{{ $progress['percentage'] }}%</span>
            </div>
            <div class="progress-bar-wrap">
                <div class="progress-bar-fill" id="progressFill" style="width:{{ $progress['percentage'] }}%"></div>
            </div>
            <div class="progress-text" style="margin-top:.4rem;">
                @if($progress['remaining'] > 0)
                    <span style="color:rgba(245,230,211,.5);">{{ $progress['remaining'] }} درس متبقي</span>
                @else
                    <span style="color:var(--green);"><i class="fas fa-check-circle me-1"></i> تم إكمال الكورس!</span>
                @endif
            </div>
        </div>
        @endif

        {{-- Certificate (when earned) --}}
        @if($certificate)
        <div class="cert-card" style="margin-bottom:1.2rem;">
            <i class="fas fa-certificate cert-icon"></i>
            <div class="cert-title">تهانينا! حصلت على شهادة</div>
            <div class="cert-num">{{ $certificate->certificate_number }}</div>
            <a href="{{ route('certificates.show', $certificate) }}" class="btn-cert">
                <i class="fas fa-eye"></i> عرض الشهادة
            </a>
        </div>
        @elseif($progress['is_complete'] && $tutorial->certificate_enabled)
        {{-- Completed but certificate not yet generated (shouldn't happen) --}}
        <div class="all-done-card" style="margin-bottom:1.2rem;">
            <i class="fas fa-check-circle all-done-icon"></i>
            <div class="all-done-title">تم إكمال الكورس!</div>
            <p style="font-size:.82rem;color:rgba(245,230,211,.6);">جاري إعداد الشهادة...</p>
        </div>
        @elseif($progress['is_complete'])
        <div class="all-done-card" style="margin-bottom:1.2rem;">
            <i class="fas fa-check-circle all-done-icon"></i>
            <div class="all-done-title">تم إكمال الكورس!</div>
        </div>
        @endif

        {{-- Lesson panel --}}
        @if($tutorial->lessons->isNotEmpty())
        <div class="lesson-panel" id="lessonPanel">
            <div class="lesson-panel-header">
                <div class="lesson-panel-num" id="panelNum">1</div>
                <div class="lesson-panel-title" id="panelTitle">{{ $tutorial->lessons->first()->title }}</div>
                <div class="lesson-panel-done-badge" id="panelDoneBadge" style="{{ in_array($tutorial->lessons->first()->id, $completedLessonIds) ? '' : 'display:none;' }}">
                    <i class="fas fa-check-circle"></i> مكتمل
                </div>
            </div>
            <div class="lesson-panel-body">

                @foreach($tutorial->lessons as $i => $lesson)
                @php $embedUrl = getYoutubeEmbed($lesson->video_url); @endphp
                <div class="lesson-slide" id="slide-{{ $lesson->id }}" style="{{ $i > 0 ? 'display:none;' : '' }}">

                    {{-- YouTube video (only if a valid embed URL exists) --}}
                    @if($embedUrl)
                    <div class="video-wrap">
                        <iframe src="{{ $embedUrl }}"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                    @endif

                    {{-- Lesson text content --}}
                    @if($lesson->content)
                    <div class="lesson-content-text">{{ $lesson->content }}</div>
                    @elseif(!$embedUrl)
                    <div style="text-align:center;color:rgba(245,230,211,.4);padding:2rem;">
                        <i class="fas fa-book-open" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                        محتوى الدرس قيد الإعداد
                    </div>
                    @endif

                    {{-- Completion area --}}
                    <div class="completion-area">
                        @php $isDone = in_array($lesson->id, $completedLessonIds); @endphp
                        @if($isDone)
                        <div class="btn-completed-state" id="doneState-{{ $lesson->id }}">
                            <i class="fas fa-check-circle"></i>
                            تم إكمال الدرس
                        </div>
                        @else
                        <button class="btn-complete" id="completeBtn-{{ $lesson->id }}"
                                onclick="completeLesson({{ $lesson->id }})">
                            <i class="fas fa-check" id="completeIcon-{{ $lesson->id }}"></i>
                            تم إكمال الدرس
                        </button>
                        @endif
                    </div>

                </div>
                @endforeach

                <div class="lesson-nav">
                    <button class="btn-lesson btn-prev" id="btnPrev" onclick="changeLesson(-1)" disabled>
                        <i class="fas fa-arrow-right"></i> السابق
                    </button>
                    <button class="btn-lesson btn-next" id="btnNext" onclick="changeLesson(1)">
                        التالي <i class="fas fa-arrow-left"></i>
                    </button>
                </div>

            </div>
        </div>
        @else
        <div class="section-card">
            <div class="empty-lessons">
                <i class="fas fa-book-open"></i>
                <p>الدروس قيد الإعداد</p>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.lessons.index', $tutorial) }}" style="color:var(--gold);font-size:.85rem;">
                    <i class="fas fa-plus"></i> أضف أول درس
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="sidebar-sticky">
        <div class="section-card" style="padding:1.2rem;">
            <div class="section-title"><i class="fas fa-list-check"></i> قائمة الدروس</div>

            @forelse($tutorial->lessons as $i => $lesson)
            @php $isCompleted = in_array($lesson->id, $completedLessonIds); @endphp
            <div class="lesson-item {{ $i === 0 ? 'active' : '' }} {{ $isCompleted ? 'completed-item' : '' }}"
                 id="item-{{ $lesson->id }}"
                 onclick="goToLesson({{ $lesson->id }}, {{ $i + 1 }}, '{{ addslashes($lesson->title) }}', {{ $isCompleted ? 'true' : 'false' }})">
                <div class="lesson-num" id="sideNum-{{ $lesson->id }}">
                    @if($isCompleted)
                        <i class="fas fa-check"></i>
                    @else
                        {{ $i + 1 }}
                    @endif
                </div>
                <div class="lesson-info">
                    <div class="lesson-name">{{ $lesson->title }}</div>
                    @if($lesson->duration_minutes)
                    <div class="lesson-dur"><i class="fas fa-clock me-1"></i>{{ $lesson->duration_minutes }} دقيقة</div>
                    @endif
                </div>
                <i class="fas {{ $lesson->video_url ? 'fa-play-circle' : 'fa-book' }}"
                   style="color:rgba(245,230,211,.3);font-size:.85rem;"></i>
            </div>
            @empty
            <div style="text-align:center;color:rgba(245,230,211,.4);padding:1.5rem;font-size:.85rem;">لا توجد دروس بعد</div>
            @endforelse
        </div>
    </div>

</div>

{{-- Toast notification --}}
<div id="toast" class="flash-toast" style="display:none;">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">تم إكمال الدرس</span>
</div>

<script>
// ── Data ─────────────────────────────────────────────────────────
const lessons        = @json($tutorial->lessons->values()->map(fn($l) => ['id' => $l->id, 'title' => $l->title]));
let completedIds     = @json($completedLessonIds);
let progressData     = @json($progress);
const certEnabled    = {{ $tutorial->certificate_enabled ? 'true' : 'false' }};
const certUrl        = @json($certificate ? route('certificates.show', $certificate) : null);
let current          = 0;

// ── Navigation ───────────────────────────────────────────────────
function goToLesson(id, num, title, isDone) {
    document.querySelectorAll('.lesson-slide').forEach(s => s.style.display = 'none');
    document.querySelectorAll('.lesson-item').forEach(i => i.classList.remove('active'));

    document.getElementById('slide-' + id).style.display = 'block';
    document.getElementById('item-' + id).classList.add('active');
    document.getElementById('panelNum').textContent = num;
    document.getElementById('panelTitle').textContent = title;

    const badge = document.getElementById('panelDoneBadge');
    if (badge) badge.style.display = isDone ? 'flex' : 'none';

    current = lessons.findIndex(l => l.id === id);
    updateNav();
    window.scrollTo({ top: document.getElementById('lessonPanel').offsetTop - 90, behavior: 'smooth' });
}

function changeLesson(dir) {
    const next = current + dir;
    if (next >= 0 && next < lessons.length) {
        const l = lessons[next];
        const done = completedIds.includes(l.id);
        goToLesson(l.id, next + 1, l.title, done);
    }
}

function updateNav() {
    document.getElementById('btnPrev').disabled = current === 0;
    document.getElementById('btnNext').disabled = current === lessons.length - 1;
}
updateNav();

// ── Lesson completion (AJAX) ─────────────────────────────────────
function completeLesson(lessonId) {
    const btn = document.getElementById('completeBtn-' + lessonId);
    if (!btn) return;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/lessons/' + lessonId + '/complete', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept':       'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            markLessonDone(lessonId, data.progress);
            showToast('تم إكمال الدرس بنجاح');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-check"></i> تم إكمال الدرس';
    });
}

function markLessonDone(lessonId, prog) {
    completedIds.push(lessonId);
    progressData = prog;

    // Replace button with done state
    const btn = document.getElementById('completeBtn-' + lessonId);
    if (btn) {
        const area = btn.parentElement;
        area.innerHTML = '<div class="btn-completed-state" id="doneState-' + lessonId + '">' +
            '<i class="fas fa-check-circle"></i> تم إكمال الدرس</div>';
    }

    // Update panel badge
    const badge = document.getElementById('panelDoneBadge');
    if (badge) badge.style.display = 'flex';

    // Update sidebar item
    const item = document.getElementById('item-' + lessonId);
    if (item) {
        item.classList.add('completed-item');
        const numEl = document.getElementById('sideNum-' + lessonId);
        if (numEl) numEl.innerHTML = '<i class="fas fa-check"></i>';
    }

    // Update progress UI
    updateProgressUI(prog);

    // Handle course completion
    if (prog.is_complete) {
        handleCourseComplete();
    }
}

function updateProgressUI(prog) {
    const fill    = document.getElementById('progressFill');
    const percent = document.getElementById('progressPercent');
    const card    = document.getElementById('progressCard');
    if (!fill) return;

    fill.style.width = prog.percentage + '%';
    if (percent) percent.textContent = prog.percentage + '%';

    const remaining = card ? card.querySelector('.progress-text:last-child span') : null;
    if (remaining) {
        if (prog.remaining > 0) {
            remaining.textContent = prog.remaining + ' درس متبقي';
            remaining.style.color = '';
        } else {
            remaining.innerHTML = '<i class="fas fa-check-circle me-1"></i> تم إكمال الكورس!';
            remaining.style.color = 'var(--green)';
        }
    }

    const statEl = document.querySelector('.course-stat:nth-child(3)');
    if (statEl) statEl.textContent = prog.completed + ' / ' + prog.total + ' مكتمل';
}

function handleCourseComplete() {
    if (certUrl) {
        // Certificate already exists — show it
        showCertCard(certUrl);
    } else {
        // Reload to trigger certificate generation and show the card
        setTimeout(() => window.location.reload(), 1000);
    }
}

function showCertCard(url) {
    // Insert certificate card before the progress card or lesson panel
    const ref = document.getElementById('progressCard') || document.getElementById('lessonPanel');
    if (!ref) return;
    const div = document.createElement('div');
    div.className = 'cert-card';
    div.style.marginBottom = '1.2rem';
    div.innerHTML =
        '<i class="fas fa-certificate cert-icon"></i>' +
        '<div class="cert-title">تهانينا! حصلت على شهادة</div>' +
        '<div style="margin-bottom:.8rem;"></div>' +
        '<a href="' + url + '" class="btn-cert"><i class="fas fa-eye me-1"></i>عرض الشهادة</a>';
    ref.parentElement.insertBefore(div, ref);
}

// ── Toast ────────────────────────────────────────────────────────
function showToast(msg) {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    t.style.display = 'flex';
    setTimeout(() => { t.style.display = 'none'; }, 3000);
}
</script>

</body>
</html>
