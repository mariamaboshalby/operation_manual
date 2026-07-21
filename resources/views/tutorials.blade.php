<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barista Academy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --espresso:    #1a0a00;
            --dark-roast:  #2c1503;
            --medium-roast:#6b3a1f;
            --latte:       #c8956c;
            --cream:       #f5e6d3;
            --gold:        #f0c040;
            --gold-light:  #ffe082;
            --azure:       #1565c0;
            --azure-light: #42a5f5;
            --azure-glow:  rgba(66,165,245,0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--espresso);
            color: var(--cream);
            overflow-x: hidden;
        }

        /* ── Particle canvas ── */
        #particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; }

        /* ── Navbar ── */
        .navbar-custom {
            background: rgba(26,10,0,.85);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(240,192,64,.2);
            padding: 1rem 2rem;
            position: sticky; top: 0; z-index: 100;
        }
        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            background: linear-gradient(135deg, var(--gold), var(--azure-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }
        .user-badge {
            background: linear-gradient(135deg, var(--medium-roast), var(--dark-roast));
            border: 1px solid rgba(240,192,64,.3);
            border-radius: 50px;
            padding: .4rem 1.2rem;
            font-size: .85rem;
            color: var(--gold-light);
        }

        /* ── Hero ── */
        .hero {
            position: relative; z-index: 1;
            text-align: center;
            padding: 6rem 1rem 4rem;
        }
        .hero-eyebrow {
            display: inline-block;
            background: linear-gradient(135deg, var(--azure), var(--azure-light));
            color: #fff;
            font-size: .75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            padding: .4rem 1.4rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
            animation: fadeDown .8s ease both;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 7vw, 5.5rem);
            font-weight: 900;
            line-height: 1.1;
            background: linear-gradient(135deg, var(--cream) 30%, var(--gold) 60%, var(--azure-light) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            animation: fadeDown .9s .1s ease both;
        }
        .hero-sub {
            font-size: 1.1rem;
            color: rgba(245,230,211,.65);
            margin-top: 1rem;
            animation: fadeDown 1s .2s ease both;
        }
        .hero-divider {
            width: 80px; height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--azure-light));
            margin: 2rem auto;
            border-radius: 2px;
            animation: scaleIn 1s .3s ease both;
        }

        /* ── Filter tabs ── */
        .filter-bar {
            position: relative; z-index: 1;
            display: flex; flex-wrap: wrap; justify-content: center; gap: .6rem;
            margin-bottom: 3rem;
            animation: fadeUp .8s .4s ease both;
        }
        .filter-btn {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(240,192,64,.2);
            color: var(--cream);
            border-radius: 50px;
            padding: .45rem 1.4rem;
            font-size: .85rem;
            cursor: pointer;
            transition: all .3s;
            font-family: 'Cairo', sans-serif;
        }
        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(135deg, var(--gold), var(--azure));
            border-color: transparent;
            color: var(--espresso);
            font-weight: 700;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(240,192,64,.35);
        }

        /* ── Cards grid ── */
        .cards-section { position: relative; z-index: 1; padding: 0 1rem 6rem; }

        .tutorial-card {
            background: linear-gradient(145deg, rgba(44,21,3,.9), rgba(26,10,0,.95));
            border: 1px solid rgba(240,192,64,.12);
            border-radius: 24px;
            overflow: hidden;
            transition: transform .4s cubic-bezier(.175,.885,.32,1.275),
                        box-shadow .4s ease,
                        border-color .4s ease;
            cursor: pointer;
            animation: cardReveal .6s ease both;
            height: 100%;
        }
        .tutorial-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0,0,0,.6),
                        0 0 40px rgba(240,192,64,.15),
                        0 0 80px var(--azure-glow);
            border-color: rgba(240,192,64,.4);
        }

        .card-thumb {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        .card-thumb img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }
        .tutorial-card:hover .card-thumb img { transform: scale(1.1); }
        .card-thumb-bg {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 5rem;
            transition: transform .5s ease;
        }
        .tutorial-card:hover .card-thumb-bg { transform: scale(1.15); }

        .card-badge {
            position: absolute; top: 12px; right: 12px;
            font-size: .7rem; font-weight: 700; letter-spacing: 1px;
            padding: .3rem .9rem; border-radius: 50px;
            text-transform: uppercase;
        }
        .badge-beginner  { background: linear-gradient(135deg,#2e7d32,#66bb6a); color:#fff; }
        .badge-intermediate { background: linear-gradient(135deg,var(--azure),var(--azure-light)); color:#fff; }
        .badge-advanced  { background: linear-gradient(135deg,#b71c1c,#ef5350); color:#fff; }

        .card-duration {
            position: absolute; bottom: 12px; left: 12px;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            padding: .25rem .8rem;
            font-size: .75rem;
            color: var(--gold-light);
            display: flex; align-items: center; gap: .4rem;
        }

        .card-body-custom { padding: 1.5rem; }
        .card-category {
            font-size: .72rem; letter-spacing: 3px; text-transform: uppercase;
            color: var(--azure-light); margin-bottom: .5rem;
        }
        .card-title-custom {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem; font-weight: 700;
            color: var(--cream); margin-bottom: .6rem;
            line-height: 1.3;
        }
        .card-desc {
            font-size: .85rem;
            color: rgba(245,230,211,.6);
            line-height: 1.6;
            margin-bottom: 1.2rem;
        }
        .card-footer-custom {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid rgba(240,192,64,.1);
        }
        .card-steps { font-size: .8rem; color: rgba(245,230,211,.5); }
        .card-steps i { color: var(--gold); margin-left: .3rem; }

        .btn-start {
            background: linear-gradient(135deg, var(--gold), #e6a817);
            color: var(--espresso);
            border: none; border-radius: 50px;
            padding: .45rem 1.3rem;
            font-size: .82rem; font-weight: 700;
            font-family: 'Cairo', sans-serif;
            transition: all .3s;
            display: flex; align-items: center; gap: .4rem;
        }
        .btn-start:hover {
            background: linear-gradient(135deg, var(--azure-light), var(--azure));
            color: #fff;
            transform: scale(1.05);
            box-shadow: 0 8px 20px var(--azure-glow);
        }

        /* ── Floating orbs ── */
        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(80px); pointer-events: none; z-index: 0;
            animation: orbFloat 8s ease-in-out infinite;
        }
        .orb-1 { width:400px;height:400px; background:rgba(240,192,64,.06); top:-100px; right:-100px; }
        .orb-2 { width:350px;height:350px; background:rgba(66,165,245,.07); bottom:10%; left:-80px; animation-delay:-4s; }
        .orb-3 { width:250px;height:250px; background:rgba(200,149,108,.05); top:50%; right:10%; animation-delay:-2s; }

        /* ── Animations ── */
        @keyframes fadeDown  { from{opacity:0;transform:translateY(-30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeUp    { from{opacity:0;transform:translateY(30px)}  to{opacity:1;transform:translateY(0)} }
        @keyframes scaleIn   { from{opacity:0;transform:scaleX(0)}         to{opacity:1;transform:scaleX(1)} }
        @keyframes cardReveal{ from{opacity:0;transform:translateY(40px)}  to{opacity:1;transform:translateY(0)} }
        @keyframes orbFloat  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)} }

        /* stagger cards */
        .col:nth-child(1) .tutorial-card { animation-delay:.1s }
        .col:nth-child(2) .tutorial-card { animation-delay:.2s }
        .col:nth-child(3) .tutorial-card { animation-delay:.3s }
        .col:nth-child(4) .tutorial-card { animation-delay:.4s }
        .col:nth-child(5) .tutorial-card { animation-delay:.5s }
        .col:nth-child(6) .tutorial-card { animation-delay:.6s }

        /* ── Thumb gradients per category ── */
        .thumb-coffee   { background: linear-gradient(135deg,#3e1c00,#8b4513); }
        .thumb-espresso { background: linear-gradient(135deg,#1a0a00,#4a2000); }
        .thumb-latte    { background: linear-gradient(135deg,#5d3a1a,#c8956c); }
        .thumb-dessert  { background: linear-gradient(135deg,#1a237e,#283593); }
        .thumb-cold     { background: linear-gradient(135deg,#01579b,#0288d1); }
        .thumb-special  { background: linear-gradient(135deg,#4a148c,#7b1fa2); }

        /* ── Progress bar on card hover ── */
        .card-progress {
            height: 3px;
            background: rgba(255,255,255,.08);
            border-radius: 2px;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        .card-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold), var(--azure-light));
            border-radius: 2px;
            width: 0;
            transition: width 1s ease;
        }
        .tutorial-card:hover .card-progress-fill { width: var(--prog); }

        /* ── Stats bar ── */
        .stats-bar {
            position: relative; z-index: 1;
            display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem;
            margin-bottom: 4rem;
            animation: fadeUp .8s .35s ease both;
        }
        .stat-item { text-align: center; }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; font-weight: 900;
            background: linear-gradient(135deg, var(--gold), var(--azure-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .stat-label { font-size: .78rem; color: rgba(245,230,211,.5); letter-spacing: 2px; text-transform: uppercase; }
    </style>
</head>
<body>

<!-- Floating orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<!-- Particle canvas -->
<canvas id="particles"></canvas>

<!-- Navbar -->
<nav class="navbar-custom d-flex align-items-center justify-content-between">
    <span class="brand-logo">☕ Barista Academy</span>
    <div class="d-flex align-items-center gap-3">
        <span class="user-badge">
            <i class="fas fa-user-circle me-1"></i>
            {{ Auth::user()->name }}
        </span>
        @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.index') }}" style="color:rgba(245,230,211,.6);font-size:.82rem;text-decoration:none">
            <i class="fas fa-cog me-1"></i>الأدمن
        </a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" style="background:none;border:none;color:rgba(245,230,211,.5);font-size:.82rem;cursor:pointer;font-family:'Cairo',sans-serif;">
                <i class="fas fa-sign-out-alt me-1"></i>خروج
            </button>
        </form>
    </div>
</nav>

<!-- Company header -->
@if(isset($company))
<div style="position:relative;z-index:1;text-align:center;padding:3rem 1rem 1rem;">
    <a href="{{ route('dashboard') }}" style="display:inline-flex;align-items:center;gap:.5rem;color:rgba(245,230,211,.5);font-size:.82rem;text-decoration:none;margin-bottom:1.5rem;transition:color .2s;" onmouseover="this.style.color='var(--gold-light)'" onmouseout="this.style.color='rgba(245,230,211,.5)'">
        <i class="fas fa-arrow-right"></i> رجوع للشركات
    </a>
    <div style="display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap;">
        @if($company->logo_url)
            <img src="{{ $company->logo_url }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;border:2px solid rgba(240,192,64,.3);">
        @else
            <div style="width:64px;height:64px;border-radius:12px;background:rgba(255,255,255,.06);border:2px solid rgba(240,192,64,.2);display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:rgba(240,192,64,.6);">
                <i class="fa-solid fa-{{ $company->type === 'restaurant' ? 'utensils' : 'building' }}"></i>
            </div>
        @endif
        <div>
            <div style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;background:linear-gradient(135deg,var(--cream) 30%,var(--gold) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">{{ $company->name }}</div>
            <div style="font-size:.8rem;color:rgba(245,230,211,.45);margin-top:.2rem;"><i class="fas fa-book-open me-1" style="color:var(--gold);"></i>{{ $company->tutorials->count() }} تيوتوريال</div>
        </div>
    </div>
</div>
@endif

        <!-- Hero -->
        <div class="hero">
            <div class="hero-eyebrow">
                @if(isset($company))
                    <i class="fas fa-{{ $company->type === 'restaurant' ? 'utensils' : 'building' }} me-1"></i>
                    {{ $company->type === 'restaurant' ? 'مطعم' : 'شركة' }}
                @else
                    كل التيوتوريالز
                @endif
            </div>
            <h1 class="hero-title">
                @if(isset($company)) {{ $company->name }}
                @else Barista Academy
                @endif
            </h1>
            <p class="hero-sub">
                @if(isset($company)) استعرض جميع التيوتوريالز الخاصة بـ {{ $company->name }}
                @else استعرض جميع التيوتوريالز المتاحة
                @endif
            </p>
            <div class="hero-divider"></div>
        </div>

<!-- Filter -->
<div class="filter-bar">
    <button class="filter-btn active" data-filter="all">الكل</button>
    @foreach($categories as $cat)
    <button class="filter-btn" data-filter="{{ $cat->slug }}">{{ $cat->emoji }} {{ $cat->name }}</button>
    @endforeach
</div>

<!-- Cards -->
<section class="cards-section">
    <div class="container-xl">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

            @forelse($tutorials as $t)
            <div class="col" data-cat="{{ $t->category->slug ?? '' }}">
                <div class="tutorial-card" style="--prog:0%">
                    <div class="card-thumb">
                        @if($t->cover_url)
                            <img src="{{ $t->cover_url }}" alt="{{ $t->title }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform .5s ease;">
                        @else
                            <div class="card-thumb-bg {{ $t->thumb_class }}"></div>
                        @endif
                        <span class="card-badge badge-{{ $t->level }}">{{ $t->level }}</span>
                        <div class="card-duration"><i class="fas fa-clock"></i>{{ $t->duration }}</div>
                    </div>
                    <div class="card-body-custom">
                        <div class="card-category">{{ $t->category->name ?? '' }}</div>
                        <h3 class="card-title-custom">{{ $t->title }}</h3>
                        <p class="card-desc">{{ $t->description }}</p>
                        <div class="card-progress">
                            <div class="card-progress-fill"></div>
                        </div>
                        <div class="card-footer-custom">
                            <span class="card-steps"><i class="fas fa-list-check"></i>{{ $t->steps }} خطوات</span>
                        <a href="{{ route('tutorials.show', $t) }}" class="btn-start">ابدأ الآن <i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center" style="color:rgba(245,230,211,.5);padding:3rem">
                لا يوجد تيوتوريالز حتى الآن — أضفها من <a href="{{ route('admin.index') }}" style="color:var(--gold)">لوحة الأدمن</a>
            </div>
            @endforelse

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── Particle system ──
const canvas = document.getElementById('particles');
const ctx = canvas.getContext('2d');
let W, H, particles = [];

function resize() { W = canvas.width = innerWidth; H = canvas.height = innerHeight; }
resize(); window.addEventListener('resize', resize);

class Particle {
    constructor() { this.reset(); }
    reset() {
        this.x = Math.random() * W;
        this.y = Math.random() * H;
        this.r = Math.random() * 2 + .5;
        this.vx = (Math.random() - .5) * .4;
        this.vy = -Math.random() * .6 - .2;
        this.alpha = Math.random() * .4 + .1;
        this.color = Math.random() > .5 ? '240,192,64' : '66,165,245';
    }
    update() {
        this.x += this.vx; this.y += this.vy;
        if (this.y < -10) this.reset();
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${this.color},${this.alpha})`;
        ctx.fill();
    }
}

for (let i = 0; i < 120; i++) particles.push(new Particle());

function animate() {
    ctx.clearRect(0, 0, W, H);
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(animate);
}
animate();

// ── Filter ──
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        document.querySelectorAll('[data-cat]').forEach(col => {
            const show = filter === 'all' || col.dataset.cat === filter;
            col.style.transition = 'opacity .4s, transform .4s';
            col.style.opacity = show ? '1' : '0';
            col.style.transform = show ? 'scale(1)' : 'scale(.9)';
            col.style.pointerEvents = show ? '' : 'none';
        });
    });
});
</script>
</body>
</html>
