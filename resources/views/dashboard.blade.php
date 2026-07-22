<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Operation Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --espresso:    #1a0a00;
            --dark-roast:  #2c1503;
            --gold:        #f0c040;
            --gold-light:  #ffe082;
            --azure:       #1565c0;
            --azure-light: #42a5f5;
            --cream:       #f5e6d3;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Cairo',sans-serif; background:var(--espresso); color:var(--cream); min-height:100vh; overflow-x:hidden; }

        #particles { position:fixed; inset:0; pointer-events:none; z-index:0; }
        .orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; animation:orbFloat 8s ease-in-out infinite; }
        .orb-1 { width:400px;height:400px; background:rgba(240,192,64,.06); top:-100px; right:-100px; }
        .orb-2 { width:350px;height:350px; background:rgba(66,165,245,.07); bottom:10%; left:-80px; animation-delay:-4s; }

        /* Navbar */
        .navbar-custom {
            background:rgba(26,10,0,.85); backdrop-filter:blur(18px);
            border-bottom:1px solid rgba(240,192,64,.2);
            padding:.9rem 2rem; position:sticky; top:0; z-index:100;
            display:flex; align-items:center; justify-content:space-between;
        }
        .brand-logo {
            font-family:'Playfair Display',serif; font-size:1.5rem;
            background:linear-gradient(135deg,var(--gold),var(--azure-light));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .nav-actions { display:flex; align-items:center; gap:1rem; }
        .nav-actions a, .nav-actions button {
            background:none; border:none; color:rgba(245,230,211,.55);
            font-size:.82rem; cursor:pointer; font-family:'Cairo',sans-serif;
            text-decoration:none; transition:color .2s;
        }
        .nav-actions a:hover, .nav-actions button:hover { color:var(--gold-light); }
        .user-badge {
            background:linear-gradient(135deg,#3e1c00,#2c1503);
            border:1px solid rgba(240,192,64,.3); border-radius:50px;
            padding:.35rem 1.1rem; font-size:.82rem; color:var(--gold-light);
        }

        /* Hero */
        .hero { position:relative; z-index:1; text-align:center; padding:10px; }
        .hero-eyebrow {
            display:inline-block;
            background:linear-gradient(135deg,var(--azure),var(--azure-light));
            color:#fff; font-size:.72rem; letter-spacing:4px; text-transform:uppercase;
            padding:.4rem 1.4rem; border-radius:50px; margin-bottom:1.2rem;
            animation:fadeDown .8s ease both;
        }
        .hero-title {
            font-family:'Playfair Display',serif;
            font-size:clamp(2.2rem,6vw,4rem); font-weight:900; line-height:1.1;
            background:linear-gradient(135deg,var(--cream) 30%,var(--gold) 60%,var(--azure-light) 100%);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            animation:fadeDown .9s .1s ease both;
        }
        .hero-sub { font-size:.95rem; color:rgba(245,230,211,.55); margin-top:.8rem; animation:fadeDown 1s .2s ease both; }
        .hero-divider { width:60px;height:3px; background:linear-gradient(90deg,var(--gold),var(--azure-light)); margin: auto; border-radius:2px; animation:scaleIn 1s .3s ease both; }

        /* Search */
        .search-wrap {
            position:relative; z-index:1; max-width:420px; margin:0 auto 3rem;
            animation:fadeDown 1s .35s ease both;
        }
        .search-wrap input {
            width:100%; padding:.75rem 1.2rem .75rem 3rem;
            background:rgba(255,255,255,.07); border:1px solid rgba(240,192,64,.2);
            border-radius:50px; color:var(--cream); font-family:'Cairo',sans-serif;
            font-size:.9rem; outline:none; transition:border-color .3s;
        }
        .search-wrap input::placeholder { color:rgba(245,230,211,.35); }
        .search-wrap input:focus { border-color:rgba(240,192,64,.5); }
        .search-wrap i { position:absolute; left:1.1rem; top:50%; transform:translateY(-50%); color:rgba(245,230,211,.4); }

        /* Filter tabs */
        .filter-bar {
            position:relative; z-index:1;
            display:flex; flex-wrap:wrap; justify-content:center; gap:.6rem;
            margin-bottom:1rem; animation:fadeUp .8s .4s ease both;
        }
        .filter-btn {
            background:rgba(255,255,255,.05); border:1px solid rgba(240,192,64,.2);
            color:var(--cream); border-radius:50px; padding:.4rem 1.3rem;
            font-size:.82rem; cursor:pointer; transition:all .3s; font-family:'Cairo',sans-serif;
        }
        .filter-btn:hover, .filter-btn.active {
            background:linear-gradient(135deg,var(--gold),var(--azure));
            border-color:transparent; color:var(--espresso); font-weight:700;
            transform:translateY(-2px); box-shadow:0 8px 25px rgba(240,192,64,.3);
        }

        /* Company cards */
        .cards-section { position:relative; z-index:1; padding:0 1rem 6rem; }

        .company-card {
            background:linear-gradient(145deg,rgba(44,21,3,.9),rgba(26,10,0,.95));
            border:1px solid rgba(240,192,64,.12); border-radius:20px;
            overflow:hidden; cursor:pointer; text-decoration:none; color:inherit;
            display:block; height:100%;
            transition:transform .4s cubic-bezier(.175,.885,.32,1.275), box-shadow .4s, border-color .4s;
            animation:cardReveal .6s ease both;
        }
        .company-card:hover {
            transform:translateY(-10px) scale(1.02);
            box-shadow:0 25px 55px rgba(0,0,0,.6), 0 0 35px rgba(240,192,64,.15);
            border-color:rgba(240,192,64,.4);
            color:inherit;
        }

        .company-logo-wrap {
            height:160px; display:flex; align-items:center; justify-content:center;
            background:linear-gradient(145deg,rgba(44,21,3,.6),rgba(26,10,0,.8));
            border-bottom:1px solid rgba(240,192,64,.08); position:relative; overflow:hidden;
        }
        .company-logo-wrap img {
            width:90px; height:90px; object-fit:cover; border-radius:16px;
            border:2px solid rgba(240,192,64,.25);
            box-shadow:0 8px 30px rgba(0,0,0,.5);
            transition:transform .4s;
        }
        .company-card:hover .company-logo-wrap img { transform:scale(1.08); }
        .company-logo-icon {
            width:90px; height:90px; border-radius:16px;
            background:rgba(255,255,255,.06); border:2px solid rgba(240,192,64,.2);
            display:flex; align-items:center; justify-content:center;
            font-size:2.5rem; color:rgba(240,192,64,.6);
            transition:transform .4s;
        }
        .company-card:hover .company-logo-icon { transform:scale(1.08); }

        .type-badge {
            position:absolute; top:12px; right:12px;
            font-size:.68rem; font-weight:700; letter-spacing:1px;
            padding:.25rem .8rem; border-radius:50px;
        }
        .type-company    { background:rgba(21,101,192,.35); border:1px solid rgba(66,165,245,.4); color:#90caf9; }
        .type-restaurant { background:rgba(146,64,14,.35); border:1px solid rgba(251,191,36,.4); color:#fde68a; }

        .company-body { padding:1.3rem; }
        .company-name {
            font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700;
            color:var(--cream); margin-bottom:.4rem; text-align:center;
        }
        .company-count {
            text-align:center; font-size:.78rem; color:rgba(245,230,211,.45);
            display:flex; align-items:center; justify-content:center; gap:.4rem;
        }
        .company-count i { color:var(--gold); }

        .btn-explore {
            display:flex; align-items:center; justify-content:center; gap:.5rem;
            margin-top:1rem; padding:.55rem 1rem;
            background:linear-gradient(135deg,rgba(240,192,64,.15),rgba(66,165,245,.1));
            border:1px solid rgba(240,192,64,.2); border-radius:50px;
            font-size:.82rem; color:var(--gold-light); font-family:'Cairo',sans-serif;
            transition:all .3s;
        }
        .company-card:hover .btn-explore {
            background:linear-gradient(135deg,var(--gold),#e6a817);
            border-color:transparent; color:var(--espresso); font-weight:700;
        }

        /* Empty */
        .empty-state { text-align:center; padding:5rem 1rem; color:rgba(245,230,211,.4); }
        .empty-state i { font-size:4rem; margin-bottom:1.5rem; display:block; opacity:.3; }

        @keyframes fadeDown  { from{opacity:0;transform:translateY(-25px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeUp    { from{opacity:0;transform:translateY(25px)}  to{opacity:1;transform:translateY(0)} }
        @keyframes scaleIn   { from{opacity:0;transform:scaleX(0)}         to{opacity:1;transform:scaleX(1)} }
        @keyframes cardReveal{ from{opacity:0;transform:translateY(35px)}  to{opacity:1;transform:translateY(0)} }
        @keyframes orbFloat  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-25px)} }

        .col:nth-child(1) .company-card { animation-delay:.05s }
        .col:nth-child(2) .company-card { animation-delay:.1s }
        .col:nth-child(3) .company-card { animation-delay:.15s }
        .col:nth-child(4) .company-card { animation-delay:.2s }
        .col:nth-child(5) .company-card { animation-delay:.25s }
        .col:nth-child(6) .company-card { animation-delay:.3s }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<canvas id="particles"></canvas>

<!-- Navbar -->
<nav class="navbar-custom">
    <span class="brand-logo"><i class="fa-solid fa-mug-hot me-2"></i>Operation Manual</span>
    <div class="nav-actions">
        <span class="user-badge"><i class="fa-solid fa-circle-user me-1"></i>{{ Auth::user()->name }}</span>
        @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.index') }}"><i class="fa-solid fa-gear me-1"></i>الأدمن</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit"><i class="fa-solid fa-right-from-bracket me-1"></i>خروج</button>
        </form>
    </div>
</nav>

<!-- Hero -->
<div class="hero">
    <div class="hero-eyebrow">اختر وجهتك</div>
    <h1 class="hero-title">Operation Manual</h1>
    <p class="hero-sub">اختر الشركة أو المطعم لتبدأ رحلة التعلم</p>
    <div class="hero-divider"></div>
</div>

<!-- Search -->
<div class="search-wrap px-3">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" id="searchInput" placeholder="ابحث عن شركة أو مطعم...">
</div>

<!-- Filter -->
<div class="filter-bar">
    <button class="filter-btn active" data-filter="all">
        <i class="fa-solid fa-border-all me-1"></i> الكل
    </button>
    <button class="filter-btn" data-filter="company">
        <i class="fa-solid fa-building me-1"></i> شركات
    </button>
    <button class="filter-btn" data-filter="restaurant">
        <i class="fa-solid fa-utensils me-1"></i> مطاعم
    </button>
</div>

<!-- Cards -->
<section class="cards-section">
    <div class="container-xl">
        @if($companies->isEmpty())
        <div class="empty-state">
            <i class="fa-solid fa-building"></i>
            <p>لا توجد شركات أو مطاعم حتى الآن</p>
        </div>
        @else
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4" id="companiesGrid">
            @foreach($companies as $co)
            <div class="col" data-type="{{ $co->type }}" data-name="{{ strtolower($co->name) }}">
                <a href="{{ route('tutorials', ['company' => $co->id]) }}" class="company-card">
                    <div class="company-logo-wrap">
                        @if($co->logo_url)
                            <img src="{{ $co->logo_url }}" alt="{{ $co->name }}">
                        @else
                            <div class="company-logo-icon">
                                <i class="fa-solid fa-{{ $co->type === 'restaurant' ? 'utensils' : 'building' }}"></i>
                            </div>
                        @endif
                        <span class="type-badge type-{{ $co->type }}">
                            <i class="fa-solid fa-{{ $co->type === 'restaurant' ? 'utensils' : 'building' }} me-1"></i>
                            {{ $co->type === 'restaurant' ? 'مطعم' : 'شركة' }}
                        </span>
                    </div>
                    <div class="company-body">
                        <div class="company-name">{{ $co->name }}</div>
                        <div class="company-count">
                            <i class="fa-solid fa-book-open"></i>
                            {{ $co->tutorials->count() }} تيوتوريال
                        </div>
                        <div class="btn-explore">
                            استعرض التيوتوريالز
                            <i class="fa-solid fa-arrow-left"></i>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<script>
// Particles
const canvas = document.getElementById('particles'), ctx = canvas.getContext('2d');
let W, H, pts = [];
function resize(){ W=canvas.width=innerWidth; H=canvas.height=innerHeight; }
resize(); addEventListener('resize', resize);
for(let i=0;i<80;i++) pts.push({
    x:Math.random()*1920, y:Math.random()*1080,
    vx:(Math.random()-.5)*.3, vy:(Math.random()-.5)*.3,
    r:Math.random()*1.5+.5, col:Math.random()>.5?'240,192,64':'66,165,245',
    a:Math.random()*.25+.05
});
(function loop(){
    ctx.clearRect(0,0,W,H);
    pts.forEach(p=>{
        p.x+=p.vx; p.y+=p.vy;
        if(p.x<0||p.x>W) p.vx*=-1;
        if(p.y<0||p.y>H) p.vy*=-1;
        ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
        ctx.fillStyle=`rgba(${p.col},${p.a})`; ctx.fill();
    });
    requestAnimationFrame(loop);
})();

// Filter by type
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
    });
});

// Search
document.getElementById('searchInput').addEventListener('input', applyFilters);

function applyFilters() {
    const type   = document.querySelector('.filter-btn.active').dataset.filter;
    const search = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#companiesGrid .col').forEach(col => {
        const matchType   = type === 'all' || col.dataset.type === type;
        const matchSearch = col.dataset.name.includes(search);
        col.style.display = (matchType && matchSearch) ? '' : 'none';
    });
}
</script>
</body>
</html>
