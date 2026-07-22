<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tutorial->title }} — Operation Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --espresso:   #1a0a00;
            --dark-roast: #2c1503;
            --gold:       #f0c040;
            --gold-light: #ffe082;
            --cream:      #f5e6d3;
            --azure:      #1565c0;
            --azure-light:#42a5f5;
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
        .brand-logo {
            font-family:'Playfair Display',serif; font-size:1.4rem;
            background:linear-gradient(135deg,var(--gold),var(--azure-light));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .nav-links { display:flex; align-items:center; gap:1rem; }
        .nav-links a { color:rgba(245,230,211,.6); text-decoration:none; font-size:.85rem; transition:color .2s; }
        .nav-links a:hover { color:var(--gold); }

        /* Hero */
        .course-hero {
            position:relative; overflow:hidden;
            min-height:340px; display:flex; align-items:flex-end;
        }
        .course-hero-img {
            position:absolute; inset:0; width:100%; height:100%; object-fit:cover;
        }
        .course-hero-fallback {
            position:absolute; inset:0;
            background:linear-gradient(135deg,#3e1c00,#8b4513);
        }
        .course-hero-overlay {
            position:absolute; inset:0;
            background:linear-gradient(to top, rgba(26,10,0,1) 0%, rgba(26,10,0,.5) 60%, transparent 100%);
        }
        .course-hero-content {
            position:relative; z-index:1;
            padding:2rem; width:100%;
        }
        .course-meta { display:flex; align-items:center; gap:.8rem; flex-wrap:wrap; margin-bottom:.8rem; }
        .course-badge {
            font-size:.72rem; font-weight:700; letter-spacing:1px;
            padding:.3rem .9rem; border-radius:50px; text-transform:uppercase;
        }
        .badge-beginner     { background:linear-gradient(135deg,#2e7d32,#66bb6a); color:#fff; }
        .badge-intermediate { background:linear-gradient(135deg,var(--azure),var(--azure-light)); color:#fff; }
        .badge-advanced     { background:linear-gradient(135deg,#b71c1c,#ef5350); color:#fff; }
        .course-cat { font-size:.78rem; color:var(--azure-light); letter-spacing:3px; text-transform:uppercase; }
        .course-title {
            font-family:'Playfair Display',serif; font-size:clamp(1.8rem,4vw,2.8rem);
            font-weight:900; color:var(--cream); line-height:1.2; margin-bottom:.6rem;
        }
        .course-stats { display:flex; gap:1.5rem; flex-wrap:wrap; }
        .course-stat { font-size:.82rem; color:rgba(245,230,211,.7); display:flex; align-items:center; gap:.4rem; }
        .course-stat i { color:var(--gold); }

        /* Layout */
        .course-layout {
            max-width:1100px; margin:0 auto; padding:2rem 1rem;
            display:grid; grid-template-columns:1fr 340px; gap:1.5rem; align-items:start;
        }
        @media(max-width:768px) { .course-layout { grid-template-columns:1fr; } }

        /* Description */
        .section-card {
            background:rgba(44,21,3,.6); border:1px solid rgba(240,192,64,.1);
            border-radius:16px; padding:1.5rem; margin-bottom:1.2rem;
        }
        .section-title {
            font-size:1rem; font-weight:700; color:var(--gold-light);
            margin-bottom:1rem; display:flex; align-items:center; gap:.5rem;
        }
        .course-desc { font-size:.9rem; color:rgba(245,230,211,.75); line-height:1.8; }

        /* Lessons */
        .lesson-item {
            display:flex; align-items:center; gap:1rem;
            padding:.9rem 1rem; border-radius:10px;
            border:1px solid rgba(240,192,64,.08);
            background:rgba(255,255,255,.03);
            margin-bottom:.6rem; cursor:pointer;
            transition:background .2s, border-color .2s;
        }
        .lesson-item:hover { background:rgba(240,192,64,.07); border-color:rgba(240,192,64,.2); }
        .lesson-item.active { background:rgba(240,192,64,.1); border-color:rgba(240,192,64,.35); }
        .lesson-num {
            width:32px; height:32px; border-radius:50%; flex-shrink:0;
            background:rgba(240,192,64,.15); border:1px solid rgba(240,192,64,.3);
            display:flex; align-items:center; justify-content:center;
            font-size:.78rem; font-weight:700; color:var(--gold);
        }
        .lesson-item.active .lesson-num { background:var(--gold); color:var(--espresso); }
        .lesson-info { flex:1; min-width:0; }
        .lesson-name { font-size:.88rem; font-weight:600; color:var(--cream); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .lesson-dur  { font-size:.75rem; color:rgba(245,230,211,.5); margin-top:.1rem; }
        .lesson-icon { color:rgba(245,230,211,.3); font-size:.85rem; }
        .lesson-item.active .lesson-icon { color:var(--gold); }

        /* Lesson content panel */
        .lesson-panel {
            background:rgba(44,21,3,.6); border:1px solid rgba(240,192,64,.1);
            border-radius:16px; overflow:hidden;
        }
        .lesson-panel-header {
            padding:1.2rem 1.5rem; border-bottom:1px solid rgba(240,192,64,.1);
            display:flex; align-items:center; gap:.8rem;
        }
        .lesson-panel-num {
            width:36px; height:36px; border-radius:50%; background:var(--gold);
            display:flex; align-items:center; justify-content:center;
            font-weight:700; color:var(--espresso); font-size:.85rem; flex-shrink:0;
        }
        .lesson-panel-title { font-size:1rem; font-weight:700; color:var(--cream); }
        .lesson-panel-body { padding:1.5rem; }

        .video-wrap {
            position:relative; padding-bottom:56.25%; height:0; overflow:hidden;
            border-radius:10px; margin-bottom:1.2rem; background:#000;
        }
        .video-wrap iframe { position:absolute; inset:0; width:100%; height:100%; border:none; }

        .lesson-content-text { font-size:.9rem; color:rgba(245,230,211,.8); line-height:1.9; white-space:pre-wrap; }

        .lesson-nav { display:flex; gap:.6rem; margin-top:1.5rem; }
        .btn-lesson {
            flex:1; padding:.6rem 1rem; border-radius:10px; border:none; cursor:pointer;
            font-family:'Cairo',sans-serif; font-size:.85rem; font-weight:700;
            display:flex; align-items:center; justify-content:center; gap:.5rem;
            transition:all .2s;
        }
        .btn-prev { background:rgba(255,255,255,.07); color:var(--cream); }
        .btn-prev:hover { background:rgba(255,255,255,.12); }
        .btn-next { background:linear-gradient(135deg,var(--gold),#e6a817); color:var(--espresso); }
        .btn-next:hover { opacity:.9; }
        .btn-lesson:disabled { opacity:.35; cursor:not-allowed; }

        /* Sidebar sticky */
        .sidebar-sticky { position:sticky; top:80px; }

        /* Empty */
        .empty-lessons { text-align:center; padding:3rem 1rem; color:rgba(245,230,211,.4); }
        .empty-lessons i { font-size:2.5rem; display:block; margin-bottom:.8rem; }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <span class="brand-logo">☕ Operation Manual</span>
    <div class="nav-links">
        <a href="{{ route('tutorials') }}"><i class="fas fa-arrow-right"></i> الكورسات</a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.lessons.index', $tutorial) }}"><i class="fas fa-cog"></i> إدارة الدروس</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="background:none;border:none;color:rgba(245,230,211,.5);font-size:.85rem;cursor:pointer;font-family:'Cairo',sans-serif;">
                <i class="fas fa-sign-out-alt"></i> خروج
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
        </div>
        <h1 class="course-title">{{ $tutorial->title }}</h1>
        <div class="course-stats">
            <span class="course-stat"><i class="fas fa-list-check"></i> {{ $tutorial->lessons->count() }} درس</span>
            @if($tutorial->duration)
            <span class="course-stat"><i class="fas fa-clock"></i> {{ $tutorial->duration }}</span>
            @endif
        </div>
    </div>
</div>

{{-- Content --}}
<div class="course-layout">

    {{-- Left: description + lesson panel --}}
    <div>
        <div class="section-card">
            <div class="section-title"><i class="fas fa-info-circle"></i> عن الكورس</div>
            <p class="course-desc">{{ $tutorial->description }}</p>
        </div>

        @if($tutorial->lessons->isNotEmpty())
        <div class="lesson-panel" id="lessonPanel">
            <div class="lesson-panel-header">
                <div class="lesson-panel-num" id="panelNum">1</div>
                <div class="lesson-panel-title" id="panelTitle">{{ $tutorial->lessons->first()->title }}</div>
            </div>
            <div class="lesson-panel-body">
                @foreach($tutorial->lessons as $i => $lesson)
                <div class="lesson-slide" id="slide-{{ $lesson->id }}" style="{{ $i > 0 ? 'display:none;' : '' }}">
                    @if($lesson->video_url)
                    <div class="video-wrap">
                        <iframe src="{{ getYoutubeEmbed($lesson->video_url) }}"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    @endif
                    @if($lesson->content)
                    <div class="lesson-content-text">{{ $lesson->content }}</div>
                    @elseif(!$lesson->video_url)
                    <div style="text-align:center;color:rgba(245,230,211,.4);padding:2rem;">
                        <i class="fas fa-book-open" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
                        محتوى الدرس قيد الإعداد
                    </div>
                    @endif
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

    {{-- Right: lessons sidebar --}}
    <div class="sidebar-sticky">
        <div class="section-card" style="padding:1.2rem;">
            <div class="section-title"><i class="fas fa-list-check"></i> قائمة الدروس</div>
            @forelse($tutorial->lessons as $i => $lesson)
            <div class="lesson-item {{ $i === 0 ? 'active' : '' }}"
                 id="item-{{ $lesson->id }}"
                 onclick="goToLesson({{ $lesson->id }}, {{ $i + 1 }}, '{{ addslashes($lesson->title) }}')">
                <div class="lesson-num">{{ $i + 1 }}</div>
                <div class="lesson-info">
                    <div class="lesson-name">{{ $lesson->title }}</div>
                    @if($lesson->duration_minutes)
                    <div class="lesson-dur"><i class="fas fa-clock"></i> {{ $lesson->duration_minutes }} دقيقة</div>
                    @endif
                </div>
                <i class="fas {{ $lesson->video_url ? 'fa-play-circle' : 'fa-book' }} lesson-icon"></i>
            </div>
            @empty
            <div style="text-align:center;color:rgba(245,230,211,.4);padding:1.5rem;font-size:.85rem;">
                لا توجد دروس بعد
            </div>
            @endforelse
        </div>
    </div>

</div>

<script>
const lessons = @json($tutorial->lessons->values()->map(fn($l) => ['id' => $l->id, 'title' => $l->title]));
let current = 0;

function goToLesson(id, num, title) {
    // hide all slides
    document.querySelectorAll('.lesson-slide').forEach(s => s.style.display = 'none');
    document.querySelectorAll('.lesson-item').forEach(i => i.classList.remove('active'));

    // show target
    document.getElementById('slide-' + id).style.display = 'block';
    document.getElementById('item-' + id).classList.add('active');
    document.getElementById('panelNum').textContent = num;
    document.getElementById('panelTitle').textContent = title;

    current = lessons.findIndex(l => l.id === id);
    updateNav();
    window.scrollTo({ top: document.getElementById('lessonPanel').offsetTop - 90, behavior: 'smooth' });
}

function changeLesson(dir) {
    const next = current + dir;
    if (next >= 0 && next < lessons.length) {
        goToLesson(lessons[next].id, next + 1, lessons[next].title);
    }
}

function updateNav() {
    document.getElementById('btnPrev').disabled = current === 0;
    document.getElementById('btnNext').disabled = current === lessons.length - 1;
}

updateNav();
</script>
</body>
</html>
