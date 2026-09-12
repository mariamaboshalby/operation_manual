<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شهاداتي — Operation Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --espresso:#1a0a00; --dark-roast:#2c1503; --gold:#f0c040; --gold-light:#ffe082; --cream:#f5e6d3; --azure:#1565c0; --azure-light:#42a5f5; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Cairo',sans-serif; background:var(--espresso); color:var(--cream); min-height:100vh; }
        .navbar-custom { background:rgba(26,10,0,.9); backdrop-filter:blur(18px); border-bottom:1px solid rgba(240,192,64,.2); padding:.9rem 2rem; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; }
        .brand-logo { font-family:'Playfair Display',serif; font-size:1.4rem; background:linear-gradient(135deg,var(--gold),var(--azure-light)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-links { display:flex; align-items:center; gap:1rem; }
        .nav-links a { color:rgba(245,230,211,.6); text-decoration:none; font-size:.85rem; }
        .nav-links a:hover { color:var(--gold); }
        .page-wrap { max-width:900px; margin:0 auto; padding:2rem 1rem; }
        .page-title { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; background:linear-gradient(135deg,var(--cream),var(--gold)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:1.5rem; }
        .cert-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1.2rem; }
        .cert-card { background:linear-gradient(145deg,rgba(44,21,3,.9),rgba(26,10,0,.95)); border:1px solid rgba(240,192,64,.2); border-radius:16px; padding:1.5rem; transition:border-color .3s, transform .3s; }
        .cert-card:hover { border-color:rgba(240,192,64,.5); transform:translateY(-4px); }
        .cert-icon-wrap { font-size:2.5rem; color:var(--gold); margin-bottom:.8rem; }
        .cert-tutorial { font-size:1rem; font-weight:700; color:var(--cream); margin-bottom:.3rem; }
        .cert-number { font-size:.75rem; color:rgba(245,230,211,.45); letter-spacing:2px; margin-bottom:.8rem; }
        .cert-meta { font-size:.78rem; color:rgba(245,230,211,.55); margin-bottom:.8rem; display:flex; flex-direction:column; gap:.25rem; }
        .status-badge { display:inline-block; font-size:.72rem; font-weight:700; padding:.2rem .7rem; border-radius:50px; }
        .status-valid { background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.4); color:#86efac; }
        .status-revoked { background:rgba(239,68,68,.15); border:1px solid rgba(239,68,68,.4); color:#fca5a5; }
        .cert-actions { display:flex; gap:.6rem; flex-wrap:wrap; }
        .btn-view { display:inline-flex; align-items:center; gap:.4rem; padding:.45rem 1rem; border-radius:50px; background:linear-gradient(135deg,var(--gold),#e6a817); color:var(--espresso); font-weight:700; font-size:.82rem; text-decoration:none; font-family:'Cairo',sans-serif; }
        .btn-verify { display:inline-flex; align-items:center; gap:.4rem; padding:.45rem 1rem; border-radius:50px; background:rgba(255,255,255,.07); border:1px solid rgba(240,192,64,.2); color:var(--gold-light); font-size:.82rem; text-decoration:none; font-family:'Cairo',sans-serif; }
        .btn-verify:hover { background:rgba(255,255,255,.12); color:var(--gold-light); }
        .empty-state { text-align:center; padding:5rem 1rem; color:rgba(245,230,211,.4); }
        .empty-state i { font-size:4rem; display:block; margin-bottom:1.5rem; opacity:.3; }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <span class="brand-logo">☕ Operation Manual</span>
    <div class="nav-links">
        <a href="{{ route('tutorials') }}"><i class="fas fa-arrow-right me-1"></i> الكورسات</a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="background:none;border:none;color:rgba(245,230,211,.5);font-size:.85rem;cursor:pointer;font-family:'Cairo',sans-serif;">
                <i class="fas fa-sign-out-alt me-1"></i> خروج
            </button>
        </form>
    </div>
</nav>

<div class="page-wrap">
    <h1 class="page-title"><i class="fas fa-certificate me-2" style="font-size:1.4rem;color:var(--gold);"></i>شهاداتي</h1>

    @if($certificates->isEmpty())
    <div class="empty-state">
        <i class="fas fa-certificate"></i>
        <p>لا توجد شهادات بعد</p>
        <a href="{{ route('tutorials') }}" style="color:var(--gold);font-size:.9rem;">
            <i class="fas fa-arrow-left me-1"></i> تصفح الكورسات
        </a>
    </div>
    @else
    <div class="cert-grid">
        @foreach($certificates as $cert)
        <div class="cert-card">
            <div class="cert-icon-wrap"><i class="fas fa-certificate"></i></div>
            <div class="cert-tutorial">{{ $cert->tutorial->title }}</div>
            <div class="cert-number">{{ $cert->certificate_number }}</div>
            <div class="cert-meta">
                <span><i class="fas fa-calendar-check me-1" style="color:var(--gold);"></i>
                    تاريخ الإصدار: {{ $cert->issued_at?->format('Y-m-d') }}</span>
                <span><i class="fas fa-flag-checkered me-1" style="color:var(--gold);"></i>
                    تاريخ الإتمام: {{ $cert->completed_at?->format('Y-m-d') }}</span>
            </div>
            <div style="margin-bottom:.8rem;">
                <span class="status-badge {{ $cert->isValid() ? 'status-valid' : 'status-revoked' }}">
                    <i class="fas {{ $cert->isValid() ? 'fa-check-circle' : 'fa-ban' }} me-1"></i>
                    {{ $cert->isValid() ? 'صالحة' : 'محجوبة' }}
                </span>
            </div>
            <div class="cert-actions">
                <a href="{{ route('certificates.show', $cert) }}" class="btn-view">
                    <i class="fas fa-eye"></i> عرض
                </a>
                <a href="{{ route('certificates.verify', $cert->certificate_number) }}" class="btn-verify">
                    <i class="fas fa-shield-check"></i> تحقق
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

</body>
</html>
