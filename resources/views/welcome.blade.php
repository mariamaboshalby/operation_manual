<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Operation Manual — منصة التدريب التشغيلي</title>
    <meta name="description" content="Operation Manual — منصة تدريب تشغيلي متكاملة للشركات والمطاعم: تيوتوريالز، دروس فيديو، ومتابعة تعلم فريقك خطوة بخطوة.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
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
            --azure-glow:  rgba(66,165,245,.25);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body {
            font-family:'Cairo',sans-serif;
            background:var(--espresso);
            color:var(--cream);
            overflow-x:hidden;
        }

        /* ── Background décor ── */
        #particles { position:fixed; inset:0; pointer-events:none; z-index:0; }
        .orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; animation:orbFloat 8s ease-in-out infinite; }
        .orb-1 { width:420px;height:420px; background:rgba(240,192,64,.07); top:-120px; right:-120px; }
        .orb-2 { width:360px;height:360px; background:rgba(66,165,245,.08); bottom:8%; left:-90px; animation-delay:-4s; }
        .orb-3 { width:260px;height:260px; background:rgba(200,149,108,.06); top:45%; right:8%; animation-delay:-2s; }

        /* ── Navbar ── */
        .navbar-custom {
            background:rgba(26,10,0,.85); backdrop-filter:blur(18px);
            border-bottom:1px solid rgba(240,192,64,.2);
            padding:.9rem 2rem; position:sticky; top:0; z-index:100;
            display:flex; align-items:center; justify-content:space-between; gap:1rem;
        }
        .brand-logo {
            font-family:'Playfair Display',serif; font-size:1.5rem;
            background:linear-gradient(135deg,var(--gold),var(--azure-light));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            white-space:nowrap;
        }
        .nav-menu { display:flex; align-items:center; gap:1.4rem; flex-wrap:wrap; }
        .nav-menu a.nav-item-link {
            color:rgba(245,230,211,.6); text-decoration:none; font-size:.85rem;
            transition:color .2s;
        }
        .nav-menu a.nav-item-link:hover { color:var(--gold-light); }
        .btn-nav-ghost {
            border:1px solid rgba(240,192,64,.3); border-radius:50px;
            padding:.4rem 1.3rem; font-size:.83rem; color:var(--gold-light);
            text-decoration:none; transition:all .3s; white-space:nowrap;
        }
        .btn-nav-ghost:hover { background:rgba(240,192,64,.1); color:var(--gold-light); }
        .btn-nav-solid {
            background:linear-gradient(135deg,var(--gold),#e6a817);
            color:var(--espresso); font-weight:700; border-radius:50px;
            padding:.4rem 1.4rem; font-size:.83rem; text-decoration:none;
            transition:all .3s; white-space:nowrap;
        }
        .btn-nav-solid:hover {
            background:linear-gradient(135deg,var(--azure-light),var(--azure));
            color:#fff; box-shadow:0 8px 20px var(--azure-glow);
        }

        /* ── Hero ── */
        .hero {
            position:relative; z-index:1; text-align:center;
            padding:6rem 1rem 4rem; max-width:900px; margin:0 auto;
        }
        .hero-eyebrow {
            display:inline-block;
            background:linear-gradient(135deg,var(--azure),var(--azure-light));
            color:#fff; font-size:.72rem; letter-spacing:4px; text-transform:uppercase;
            padding:.45rem 1.5rem; border-radius:50px; margin-bottom:1.4rem;
            animation:fadeDown .8s ease both;
        }
        .hero-title {
            font-family:'Playfair Display',serif;
            font-size:clamp(2.4rem,7vw,4.5rem); font-weight:900; line-height:1.15;
            background:linear-gradient(135deg,var(--cream) 25%,var(--gold) 60%,var(--azure-light) 100%);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            animation:fadeDown .9s .1s ease both;
        }
        .hero-title-ar {
            font-family:'Cairo',sans-serif;
            font-size:clamp(1.4rem,4vw,2.2rem); font-weight:900;
            color:var(--cream); margin-top:.6rem;
            animation:fadeDown .95s .15s ease both;
        }
        .hero-sub {
            font-size:clamp(.95rem,2vw,1.1rem); color:rgba(245,230,211,.6);
            margin:1.2rem auto 0; max-width:620px; line-height:1.9;
            animation:fadeDown 1s .2s ease both;
        }
        .hero-divider {
            width:70px; height:3px; margin:1.6rem auto;
            background:linear-gradient(90deg,var(--gold),var(--azure-light));
            border-radius:2px; animation:scaleIn 1s .3s ease both;
        }
        .hero-actions {
            display:flex; justify-content:center; gap:.9rem; flex-wrap:wrap;
            animation:fadeUp 1s .35s ease both;
        }
        .btn-hero-main {
            background:linear-gradient(135deg,var(--gold),#e6a817);
            color:var(--espresso); font-weight:700; font-size:1rem;
            border-radius:50px; padding:.8rem 2.4rem; text-decoration:none;
            display:inline-flex; align-items:center; gap:.6rem;
            transition:all .3s; box-shadow:0 10px 30px rgba(240,192,64,.25);
        }
        .btn-hero-main:hover {
            background:linear-gradient(135deg,var(--azure-light),var(--azure));
            color:#fff; transform:translateY(-3px);
            box-shadow:0 15px 40px var(--azure-glow);
        }
        .btn-hero-alt {
            border:1px solid rgba(240,192,64,.35); color:var(--gold-light);
            font-size:1rem; border-radius:50px; padding:.8rem 2.2rem;
            text-decoration:none; display:inline-flex; align-items:center; gap:.6rem;
            transition:all .3s;
        }
        .btn-hero-alt:hover {
            background:rgba(240,192,64,.1); color:var(--gold-light);
            transform:translateY(-3px);
        }

        /* Hero mock card */
        .hero-visual {
            position:relative; z-index:1; max-width:760px; margin:3.5rem auto 0;
            animation:fadeUp 1.1s .5s ease both; padding:0 1rem;
        }
        .mock-window {
            background:linear-gradient(145deg,rgba(44,21,3,.95),rgba(26,10,0,.98));
            border:1px solid rgba(240,192,64,.2); border-radius:20px;
            overflow:hidden; box-shadow:0 40px 90px rgba(0,0,0,.7), 0 0 60px rgba(240,192,64,.07);
        }
        .mock-bar {
            display:flex; align-items:center; gap:.45rem;
            padding:.8rem 1.2rem; border-bottom:1px solid rgba(240,192,64,.12);
            background:rgba(26,10,0,.6);
        }
        .mock-dot { width:11px; height:11px; border-radius:50%; }
        .mock-body { padding:1.5rem; display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
        @media(max-width:576px){ .mock-body { grid-template-columns:1fr; } }
        .mock-card {
            background:rgba(255,255,255,.04); border:1px solid rgba(240,192,64,.12);
            border-radius:14px; padding:1rem; text-align:center;
        }
        .mock-card i { font-size:1.6rem; margin-bottom:.6rem; display:block; }
        .mock-card .mc-title { font-size:.85rem; font-weight:700; color:var(--cream); }
        .mock-card .mc-sub { font-size:.72rem; color:rgba(245,230,211,.45); margin-top:.2rem; }
        .mock-progress { height:5px; background:rgba(255,255,255,.08); border-radius:3px; margin-top:.8rem; overflow:hidden; }
        .mock-progress span { display:block; height:100%; border-radius:3px; background:linear-gradient(90deg,var(--gold),var(--azure-light)); }

        /* ── Stats ── */
        .stats-bar {
            position:relative; z-index:1;
            display:flex; flex-wrap:wrap; justify-content:center; gap:3rem;
            padding:4rem 1rem 2rem;
        }
        .stat-item { text-align:center; min-width:110px; }
        .stat-num {
            font-family:'Playfair Display',serif; font-size:2.4rem; font-weight:900;
            background:linear-gradient(135deg,var(--gold),var(--azure-light));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .stat-label { font-size:.78rem; color:rgba(245,230,211,.5); letter-spacing:2px; }

        /* ── Sections ── */
        .section { position:relative; z-index:1; padding:5rem 1rem; }
        .section-head { text-align:center; max-width:640px; margin:0 auto 3.5rem; }
        .section-eyebrow {
            display:inline-block; font-size:.7rem; letter-spacing:4px; text-transform:uppercase;
            color:var(--azure-light); border:1px solid rgba(66,165,245,.3);
            border-radius:50px; padding:.3rem 1.2rem; margin-bottom:1rem;
        }
        .section-title {
            font-family:'Playfair Display',serif; font-size:clamp(1.6rem,4vw,2.4rem);
            font-weight:900;
            background:linear-gradient(135deg,var(--cream) 40%,var(--gold) 100%);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .section-sub { font-size:.92rem; color:rgba(245,230,211,.55); margin-top:.8rem; line-height:1.9; }

        /* ── Feature cards ── */
        .feature-card {
            background:linear-gradient(145deg,rgba(44,21,3,.9),rgba(26,10,0,.95));
            border:1px solid rgba(240,192,64,.12); border-radius:20px;
            padding:1.8rem; height:100%;
            transition:transform .4s cubic-bezier(.175,.885,.32,1.275), box-shadow .4s, border-color .4s;
        }
        .feature-card:hover {
            transform:translateY(-10px);
            box-shadow:0 25px 55px rgba(0,0,0,.55), 0 0 35px rgba(240,192,64,.12);
            border-color:rgba(240,192,64,.35);
        }
        .feature-icon {
            width:58px; height:58px; border-radius:16px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.5rem; margin-bottom:1.1rem;
        }
        .fi-gold  { background:rgba(240,192,64,.12); border:1px solid rgba(240,192,64,.3); color:var(--gold); }
        .fi-azure { background:rgba(66,165,245,.1);  border:1px solid rgba(66,165,245,.3);  color:var(--azure-light); }
        .fi-latte { background:rgba(200,149,108,.12);border:1px solid rgba(200,149,108,.35);color:var(--latte); }
        .feature-title { font-size:1.05rem; font-weight:700; color:var(--cream); margin-bottom:.6rem; }
        .feature-desc { font-size:.85rem; color:rgba(245,230,211,.55); line-height:1.8; }

        /* ── How it works ── */
        .steps-wrap { max-width:860px; margin:0 auto; position:relative; }
        .step-row {
            display:flex; gap:1.4rem; align-items:flex-start;
            padding:1.4rem 0; position:relative;
        }
        .step-row:not(:last-child)::before {
            content:''; position:absolute; top:4.4rem; bottom:-1rem; right:26px;
            width:2px; background:linear-gradient(180deg,rgba(240,192,64,.4),rgba(66,165,245,.15));
        }
        .step-num {
            width:54px; height:54px; border-radius:50%; flex-shrink:0;
            background:linear-gradient(135deg,var(--gold),#e6a817);
            color:var(--espresso); font-weight:900; font-size:1.2rem;
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 8px 25px rgba(240,192,64,.3);
            font-family:'Playfair Display',serif;
        }
        .step-body {
            background:rgba(44,21,3,.55); border:1px solid rgba(240,192,64,.1);
            border-radius:16px; padding:1.2rem 1.5rem; flex:1;
            transition:border-color .3s, background .3s;
        }
        .step-row:hover .step-body { border-color:rgba(240,192,64,.3); background:rgba(44,21,3,.8); }
        .step-title { font-size:1rem; font-weight:700; color:var(--gold-light); margin-bottom:.35rem; }
        .step-desc { font-size:.85rem; color:rgba(245,230,211,.6); line-height:1.8; }

        /* ── Categories chips ── */
        .cats-wrap { display:flex; flex-wrap:wrap; justify-content:center; gap:.8rem; max-width:760px; margin:0 auto; }
        .cat-chip {
            background:rgba(255,255,255,.05); border:1px solid rgba(240,192,64,.2);
            border-radius:50px; padding:.6rem 1.5rem; font-size:.9rem;
            display:inline-flex; align-items:center; gap:.5rem;
            transition:all .3s; cursor:default;
        }
        .cat-chip:hover {
            background:linear-gradient(135deg,rgba(240,192,64,.15),rgba(66,165,245,.1));
            border-color:rgba(240,192,64,.45); transform:translateY(-3px);
        }
        .cat-chip .cat-count {
            background:rgba(240,192,64,.15); color:var(--gold-light);
            border-radius:50px; font-size:.7rem; padding:.1rem .6rem;
        }

        /* ── Levels ── */
        .level-pill {
            display:inline-flex; align-items:center; gap:.5rem;
            font-size:.85rem; font-weight:700; border-radius:50px; padding:.55rem 1.5rem;
        }
        .lv-beginner     { background:linear-gradient(135deg,#2e7d32,#66bb6a); color:#fff; }
        .lv-intermediate { background:linear-gradient(135deg,var(--azure),var(--azure-light)); color:#fff; }
        .lv-advanced     { background:linear-gradient(135deg,#b71c1c,#ef5350); color:#fff; }

        /* ── Audience ── */
        .audience-card {
            background:linear-gradient(145deg,rgba(44,21,3,.9),rgba(26,10,0,.95));
            border:1px solid rgba(240,192,64,.12); border-radius:22px;
            padding:2.2rem; height:100%; text-align:center;
            transition:transform .4s, box-shadow .4s, border-color .4s;
        }
        .audience-card:hover {
            transform:translateY(-8px);
            border-color:rgba(240,192,64,.35);
            box-shadow:0 25px 55px rgba(0,0,0,.55);
        }
        .audience-icon {
            width:80px; height:80px; margin:0 auto 1.3rem; border-radius:50%;
            display:flex; align-items:center; justify-content:center; font-size:2rem;
        }
        .audience-title {
            font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700;
            color:var(--cream); margin-bottom:1rem;
        }
        .audience-list { list-style:none; text-align:right; margin:0 auto; max-width:300px; }
        .audience-list li {
            font-size:.87rem; color:rgba(245,230,211,.65); line-height:1.7;
            padding:.45rem 0; display:flex; align-items:flex-start; gap:.6rem;
        }
        .audience-list li i { color:var(--gold); margin-top:.3rem; font-size:.75rem; }

        /* ── CTA ── */
        .cta-box {
            max-width:820px; margin:0 auto; text-align:center;
            background:linear-gradient(145deg,rgba(44,21,3,.95),rgba(26,10,0,.98));
            border:1px solid rgba(240,192,64,.25); border-radius:28px;
            padding:3.5rem 2rem; position:relative; overflow:hidden;
        }
        .cta-box::before {
            content:''; position:absolute; top:-60px; left:50%; transform:translateX(-50%);
            width:300px; height:150px; background:rgba(240,192,64,.12); filter:blur(60px);
        }
        .cta-title {
            font-family:'Playfair Display',serif; font-size:clamp(1.5rem,4vw,2.2rem); font-weight:900;
            background:linear-gradient(135deg,var(--cream) 30%,var(--gold) 100%);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            margin-bottom:.8rem; position:relative;
        }
        .cta-sub { font-size:.92rem; color:rgba(245,230,211,.55); margin-bottom:1.8rem; position:relative; }

        /* ── Footer ── */
        .footer {
            position:relative; z-index:1; text-align:center;
            border-top:1px solid rgba(240,192,64,.12);
            padding:2.2rem 1rem; margin-top:3rem;
        }
        .footer .brand-logo { font-size:1.2rem; }
        .footer-note { font-size:.78rem; color:rgba(245,230,211,.35); margin-top:.6rem; }

        /* ── Reveal on scroll ── */
        .reveal { opacity:0; transform:translateY(35px); transition:opacity .7s ease, transform .7s ease; }
        .reveal.visible { opacity:1; transform:translateY(0); }
        .reveal-d1 { transition-delay:.1s; } .reveal-d2 { transition-delay:.2s; }
        .reveal-d3 { transition-delay:.3s; } .reveal-d4 { transition-delay:.4s; }

        /* ── Animations ── */
        @keyframes fadeDown  { from{opacity:0;transform:translateY(-30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeUp    { from{opacity:0;transform:translateY(30px)}  to{opacity:1;transform:translateY(0)} }
        @keyframes scaleIn   { from{opacity:0;transform:scaleX(0)}         to{opacity:1;transform:scaleX(1)} }
        @keyframes orbFloat  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)} }

        @media(max-width:768px){
            .navbar-custom { padding:.8rem 1rem; }
            .nav-menu .nav-item-link { display:none; }
            .hero { padding-top:4rem; }
        }
    </style>
</head>
<body>

<!-- Décor -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>
<canvas id="particles"></canvas>

<!-- ══ Navbar ══ -->
<nav class="navbar-custom">
    <span class="brand-logo"><i class="fa-solid fa-mug-hot ms-2"></i>Operation Manual</span>
    <div class="nav-menu">
        <a href="#features" class="nav-item-link">المميزات</a>
        <a href="#how" class="nav-item-link">كيف تعمل؟</a>
        <a href="#categories" class="nav-item-link">الأقسام</a>
        <a href="#audience" class="nav-item-link">لمن المنصة؟</a>
        @auth
            <a href="{{ route('dashboard') }}" class="btn-nav-solid"><i class="fa-solid fa-gauge-high ms-1"></i> لوحة التحكم</a>
        @else
            <a href="{{ route('login') }}" class="btn-nav-ghost">تسجيل الدخول</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav-solid">إنشاء حساب</a>
            @endif
        @endauth
    </div>
</nav>

<!-- ══ Hero ══ -->
<header class="hero">
    <div class="hero-eyebrow">☕ منصة التدريب التشغيلي</div>
    <h1 class="hero-title">Operation Manual</h1>
    <div class="hero-title-ar">دليل التشغيل الكامل لفريقك.. في مكان واحد</div>
    <p class="hero-sub">
        منصة تعليمية متكاملة تجمع كل إجراءات التشغيل الخاصة بشركاتك ومطاعمك في تيوتوريالز منظمة —
        دروس فيديو، محتوى مكتوب، مستويات تدريجية، ومتابعة لكل متدرب. درّب فريقك بشكل احترافي بدون فوضى الملفات والمجموعات.
    </p>
    <div class="hero-divider"></div>
    <div class="hero-actions">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-hero-main">ابدأ التعلم الآن <i class="fa-solid fa-arrow-left"></i></a>
        @else
            <a href="{{ route('login') }}" class="btn-hero-main">ابدأ الآن <i class="fa-solid fa-arrow-left"></i></a>
        @endauth
        <a href="#how" class="btn-hero-alt"><i class="fa-solid fa-circle-play"></i> اعرف كيف تعمل</a>
    </div>
</header>

<!-- Hero visual -->
<div class="hero-visual">
    <div class="mock-window">
        <div class="mock-bar">
            <span class="mock-dot" style="background:#ef5350"></span>
            <span class="mock-dot" style="background:#ffca28"></span>
            <span class="mock-dot" style="background:#66bb6a"></span>
            <span style="font-size:.72rem;color:rgba(245,230,211,.35);margin-right:.8rem;">operation-manual.app</span>
        </div>
        <div class="mock-body">
            <div class="mock-card">
                <i class="fa-solid fa-building" style="color:var(--azure-light)"></i>
                <div class="mc-title">اختر الشركة</div>
                <div class="mc-sub">شركات ومطاعم</div>
                <div class="mock-progress"><span style="width:100%"></span></div>
            </div>
            <div class="mock-card">
                <i class="fa-solid fa-book-open" style="color:var(--gold)"></i>
                <div class="mc-title">اختر التيوتوريال</div>
                <div class="mc-sub">حسب القسم والمستوى</div>
                <div class="mock-progress"><span style="width:65%"></span></div>
            </div>
            <div class="mock-card">
                <i class="fa-solid fa-circle-play" style="color:var(--latte)"></i>
                <div class="mc-title">تعلّم درس بدرس</div>
                <div class="mc-sub">فيديو + محتوى مكتوب</div>
                <div class="mock-progress"><span style="width:30%"></span></div>
            </div>
        </div>
    </div>
</div>

<!-- ══ Stats ══ -->
<div class="stats-bar">
    <div class="stat-item reveal">
        <div class="stat-num counter" data-target="{{ $stats['companies'] }}">0</div>
        <div class="stat-label">شركة ومطعم</div>
    </div>
    <div class="stat-item reveal reveal-d1">
        <div class="stat-num counter" data-target="{{ $stats['tutorials'] }}">0</div>
        <div class="stat-label">تيوتوريال</div>
    </div>
    <div class="stat-item reveal reveal-d2">
        <div class="stat-num counter" data-target="{{ $stats['lessons'] }}">0</div>
        <div class="stat-label">درس</div>
    </div>
    <div class="stat-item reveal reveal-d3">
        <div class="stat-num counter" data-target="{{ $stats['students'] }}">0</div>
        <div class="stat-label">متدرب</div>
    </div>
</div>

<!-- ══ Features ══ -->
<section class="section" id="features">
    <div class="section-head reveal">
        <span class="section-eyebrow">المميزات</span>
        <h2 class="section-title">كل ما تحتاجه لتدريب فريقك</h2>
        <p class="section-sub">صممنا المنصة لتغطي رحلة التدريب كاملة — من تنظيم المحتوى وحتى وصول كل متدرب للدروس المخصصة له فقط.</p>
    </div>
    <div class="container-xl">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            <div class="col reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-azure"><i class="fa-solid fa-building"></i></div>
                    <div class="feature-title">تنظيم حسب الشركة أو المطعم</div>
                    <p class="feature-desc">كل شركة أو مطعم له مساحته الخاصة بشعاره وتيوتوريالزه — فريق كل فرع يجد محتواه بسهولة بدون تشتيت.</p>
                </div>
            </div>
            <div class="col reveal reveal-d1">
                <div class="feature-card">
                    <div class="feature-icon fi-gold"><i class="fa-solid fa-book-open"></i></div>
                    <div class="feature-title">تيوتوريالز مقسمة بأقسام</div>
                    <p class="feature-desc">محتوى مرتب في أقسام واضحة مع فلترة فورية، وصورة غلاف لكل تيوتوريال، ووصف يشرح ماذا ستتعلم بالضبط.</p>
                </div>
            </div>
            <div class="col reveal reveal-d2">
                <div class="feature-card">
                    <div class="feature-icon fi-latte"><i class="fa-solid fa-circle-play"></i></div>
                    <div class="feature-title">دروس فيديو ومحتوى مكتوب</div>
                    <p class="feature-desc">كل تيوتوريال مقسم لدروس مرتبة: فيديوهات يوتيوب مدمجة داخل المنصة + شرح مكتوب، مع تنقل سابق/تالي سلس.</p>
                </div>
            </div>
            <div class="col reveal">
                <div class="feature-card">
                    <div class="feature-icon fi-gold"><i class="fa-solid fa-layer-group"></i></div>
                    <div class="feature-title">مستويات تدريجية</div>
                    <p class="feature-desc">كل تيوتوريال له مستوى واضح — مبتدئ، متوسط، أو متقدم — عشان المتدرب يبدأ من المكان الصح ويتدرج بثقة.</p>
                    <div class="d-flex gap-2 flex-wrap mt-3">
                        <span class="level-pill lv-beginner" style="font-size:.7rem;padding:.3rem 1rem;">مبتدئ</span>
                        <span class="level-pill lv-intermediate" style="font-size:.7rem;padding:.3rem 1rem;">متوسط</span>
                        <span class="level-pill lv-advanced" style="font-size:.7rem;padding:.3rem 1rem;">متقدم</span>
                    </div>
                </div>
            </div>
            <div class="col reveal reveal-d1">
                <div class="feature-card">
                    <div class="feature-icon fi-azure"><i class="fa-solid fa-user-shield"></i></div>
                    <div class="feature-title">وصول مخصص لكل متدرب</div>
                    <p class="feature-desc">الطالب يشوف بس التيوتوريالز المسندة له — خصوصية كاملة بين الفرق والشركات، وكل واحد مركّز في محتواه.</p>
                </div>
            </div>
            <div class="col reveal reveal-d2">
                <div class="feature-card">
                    <div class="feature-icon fi-latte"><i class="fa-solid fa-gears"></i></div>
                    <div class="feature-title">لوحة أدمن كاملة</div>
                    <p class="feature-desc">إدارة الشركات والأقسام والتيوتوريالز والدروس والمتدربين من مكان واحد — رفع صور، إسناد كورسات، وإدارة صلاحيات.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ How it works ══ -->
<section class="section" id="how" style="background:rgba(44,21,3,.25);">
    <div class="section-head reveal">
        <span class="section-eyebrow">كيف تعمل؟</span>
        <h2 class="section-title">أربع خطوات وتبدأ</h2>
        <p class="section-sub">رحلة المتدرب داخل المنصة بسيطة ومباشرة من أول تسجيل الدخول وحتى إنهاء آخر درس.</p>
    </div>
    <div class="steps-wrap">
        <div class="step-row reveal">
            <div class="step-num">1</div>
            <div class="step-body">
                <div class="step-title"><i class="fa-solid fa-right-to-bracket ms-1"></i> سجّل دخولك</div>
                <p class="step-desc">ادخل بحسابك الذي أنشأه لك الأدمن (أو أنشئ حسابًا جديدًا) وستصل مباشرة للوحة اختيار الشركات.</p>
            </div>
        </div>
        <div class="step-row reveal reveal-d1">
            <div class="step-num">2</div>
            <div class="step-body">
                <div class="step-title"><i class="fa-solid fa-building ms-1"></i> اختر الشركة أو المطعم</div>
                <p class="step-desc">استعرض الشركات والمطاعم المتاحة مع البحث والفلترة حسب النوع، واختر الجهة التي تريد التدرب على إجراءاتها.</p>
            </div>
        </div>
        <div class="step-row reveal reveal-d2">
            <div class="step-num">3</div>
            <div class="step-body">
                <div class="step-title"><i class="fa-solid fa-book-open ms-1"></i> اختر التيوتوريال المناسب</div>
                <p class="step-desc">تصفح التيوتوريالز المسندة لك، وفلترها حسب القسم، وشاهد مستوى كل واحد ومدته وعدد خطواته قبل أن تبدأ.</p>
            </div>
        </div>
        <div class="step-row reveal reveal-d3">
            <div class="step-num">4</div>
            <div class="step-body">
                <div class="step-title"><i class="fa-solid fa-graduation-cap ms-1"></i> تعلّم درسًا بدرس</div>
                <p class="step-desc">افتح صفحة الكورس وشاهد الفيديوهات واقرأ المحتوى، وتنقّل بين الدروس من القائمة الجانبية حتى تكمل التيوتوريال.</p>
            </div>
        </div>
    </div>
</section>

<!-- ══ Categories ══ -->
<section class="section" id="categories">
    <div class="section-head reveal">
        <span class="section-eyebrow">الأقسام</span>
        <h2 class="section-title">محتوى منظم في أقسام واضحة</h2>
        <p class="section-sub">كل تيوتوريال ينتمي لقسم محدد لتصل لما تحتاجه في ثوانٍ.</p>
    </div>
    <div class="cats-wrap reveal">
        @forelse($categories as $cat)
            <span class="cat-chip">
                {{ $cat->emoji }} {{ $cat->name }}
                <span class="cat-count">{{ $cat->tutorials_count }}</span>
            </span>
        @empty
            <span class="cat-chip">📚 الأقسام قيد الإعداد</span>
        @endforelse
    </div>
</section>

<!-- ══ Audience ══ -->
<section class="section" id="audience" style="background:rgba(44,21,3,.25);">
    <div class="section-head reveal">
        <span class="section-eyebrow">لمن المنصة؟</span>
        <h2 class="section-title">مصممة للمتدرب والإدارة معًا</h2>
    </div>
    <div class="container-lg">
        <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
            <div class="col reveal">
                <div class="audience-card">
                    <div class="audience-icon" style="background:rgba(66,165,245,.1);border:2px solid rgba(66,165,245,.3);color:var(--azure-light);">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="audience-title">المتدرب</div>
                    <ul class="audience-list">
                        <li><i class="fa-solid fa-check"></i> يشاهد التيوتوريالز المسندة له فقط</li>
                        <li><i class="fa-solid fa-check"></i> يتعلم بالفيديو والمحتوى المكتوب</li>
                        <li><i class="fa-solid fa-check"></i> يتدرج من المبتدئ للمتقدم</li>
                        <li><i class="fa-solid fa-check"></i> يعرف مدة وخطوات كل كورس قبل البدء</li>
                    </ul>
                </div>
            </div>
            <div class="col reveal reveal-d1">
                <div class="audience-card">
                    <div class="audience-icon" style="background:rgba(240,192,64,.1);border:2px solid rgba(240,192,64,.3);color:var(--gold);">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="audience-title">الأدمن / الإدارة</div>
                    <ul class="audience-list">
                        <li><i class="fa-solid fa-check"></i> يضيف الشركات والمطاعم بشعاراتها</li>
                        <li><i class="fa-solid fa-check"></i> ينشئ التيوتوريالز والدروس والأقسام</li>
                        <li><i class="fa-solid fa-check"></i> يسند الكورسات للمتدربين المناسبين</li>
                        <li><i class="fa-solid fa-check"></i> يدير المستخدمين والصلاحيات بسهولة</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ CTA ══ -->
<section class="section">
    <div class="cta-box reveal">
        <h2 class="cta-title">جاهز تبدأ رحلة التدريب؟ ☕</h2>
        <p class="cta-sub">انضم الآن وخلّي كل إجراءات التشغيل في متناول فريقك — منظمة، واضحة، وسهلة المتابعة.</p>
        <div class="hero-actions" style="animation:none;">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-hero-main">اذهب للوحة التحكم <i class="fa-solid fa-arrow-left"></i></a>
            @else
                <a href="{{ route('login') }}" class="btn-hero-main">تسجيل الدخول <i class="fa-solid fa-arrow-left"></i></a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-hero-alt">إنشاء حساب جديد</a>
                @endif
            @endauth
        </div>
    </div>
</section>

<!-- ══ Footer ══ -->
<footer class="footer">
    <span class="brand-logo"><i class="fa-solid fa-mug-hot ms-2"></i>Operation Manual</span>
    <div class="footer-note">© {{ date('Y') }} Operation Manual — منصة التدريب التشغيلي للشركات والمطاعم</div>
</footer>

<script>
// ── Particle system ──
const canvas = document.getElementById('particles'), ctx = canvas.getContext('2d');
let W, H, pts = [];
function resize(){ W = canvas.width = innerWidth; H = canvas.height = innerHeight; }
resize(); addEventListener('resize', resize);
for (let i = 0; i < 100; i++) pts.push({
    x: Math.random() * 1920, y: Math.random() * 1080,
    vx: (Math.random() - .5) * .3, vy: (Math.random() - .5) * .3,
    r: Math.random() * 1.5 + .5,
    col: Math.random() > .5 ? '240,192,64' : '66,165,245',
    a: Math.random() * .25 + .05
});
(function loop(){
    ctx.clearRect(0, 0, W, H);
    pts.forEach(p => {
        p.x += p.vx; p.y += p.vy;
        if (p.x < 0 || p.x > W) p.vx *= -1;
        if (p.y < 0 || p.y > H) p.vy *= -1;
        ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${p.col},${p.a})`; ctx.fill();
    });
    requestAnimationFrame(loop);
})();

// ── Reveal on scroll ──
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            observer.unobserve(e.target);
        }
    });
}, { threshold: .15 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// ── Animated counters ──
const counterObserver = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (!e.isIntersecting) return;
        counterObserver.unobserve(e.target);
        const el = e.target, target = parseInt(el.dataset.target) || 0;
        const dur = 1400, start = performance.now();
        (function tick(now){
            const p = Math.min((now - start) / dur, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    });
}, { threshold: .5 });
document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));
</script>
</body>
</html>
