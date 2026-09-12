<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شهادة — {{ $certificate->certificate_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --espresso:#1a0a00; --dark-roast:#2c1503; --gold:#f0c040; --gold-light:#ffe082; --cream:#f5e6d3; --azure:#1565c0; --azure-light:#42a5f5; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Cairo',sans-serif; background:var(--espresso); color:var(--cream); min-height:100vh; }
        .navbar-custom { background:rgba(26,10,0,.9); backdrop-filter:blur(18px); border-bottom:1px solid rgba(240,192,64,.2); padding:.9rem 2rem; display:flex; align-items:center; justify-content:space-between; }
        .brand-logo { font-family:'Playfair Display',serif; font-size:1.4rem; background:linear-gradient(135deg,var(--gold),var(--azure-light)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .nav-links { display:flex; align-items:center; gap:1rem; }
        .nav-links a { color:rgba(245,230,211,.6); text-decoration:none; font-size:.85rem; }
        .nav-links a:hover { color:var(--gold); }
        .cert-wrap { max-width:760px; margin:3rem auto; padding:1rem; }
        .cert-doc {
            background:linear-gradient(145deg,rgba(44,21,3,.95),rgba(26,10,0,.98));
            border:2px solid rgba(240,192,64,.4);
            border-radius:24px;
            padding:3rem 2.5rem;
            text-align:center;
            position:relative;
            box-shadow:0 0 60px rgba(240,192,64,.1), 0 30px 60px rgba(0,0,0,.5);
        }
        .cert-doc::before {
            content:'';
            position:absolute; inset:12px;
            border:1px solid rgba(240,192,64,.15);
            border-radius:16px;
            pointer-events:none;
        }
        .cert-platform { font-size:.78rem; letter-spacing:4px; text-transform:uppercase; color:rgba(245,230,211,.4); margin-bottom:1.5rem; }
        .cert-heading { font-size:.9rem; letter-spacing:3px; text-transform:uppercase; color:rgba(240,192,64,.7); margin-bottom:.5rem; }
        .cert-recipient { font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:900; background:linear-gradient(135deg,var(--cream),var(--gold-light)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:.4rem; }
        .cert-subtitle { font-size:.9rem; color:rgba(245,230,211,.6); margin-bottom:2rem; }
        .cert-course-label { font-size:.8rem; color:rgba(245,230,211,.45); text-transform:uppercase; letter-spacing:2px; margin-bottom:.4rem; }
        .cert-course-name { font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:var(--gold-light); margin-bottom:2rem; }
        .cert-divider { width:80px; height:2px; background:linear-gradient(90deg,transparent,var(--gold),transparent); margin:0 auto 2rem; }
        .cert-details { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-bottom:2rem; }
        .cert-detail-item { text-align:center; }
        .cert-detail-label { font-size:.72rem; letter-spacing:2px; text-transform:uppercase; color:rgba(245,230,211,.4); margin-bottom:.3rem; }
        .cert-detail-value { font-size:.9rem; font-weight:700; color:var(--cream); }
        .cert-number-box { background:rgba(240,192,64,.08); border:1px solid rgba(240,192,64,.2); border-radius:10px; padding:.75rem 1.5rem; display:inline-block; margin-bottom:2rem; }
        .cert-number-label { font-size:.7rem; letter-spacing:3px; text-transform:uppercase; color:rgba(245,230,211,.4); margin-bottom:.2rem; }
        .cert-number-val { font-size:1rem; font-weight:700; color:var(--gold); letter-spacing:2px; }
        .cert-status { margin-bottom:1.5rem; }
        .status-badge { font-size:.82rem; font-weight:700; padding:.35rem 1.2rem; border-radius:50px; }
        .status-valid { background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.4); color:#86efac; }
        .status-revoked { background:rgba(239,68,68,.15); border:1px solid rgba(239,68,68,.4); color:#fca5a5; }
        .cert-icon-main { font-size:3.5rem; color:var(--gold); display:block; margin-bottom:1.5rem; filter:drop-shadow(0 0 20px rgba(240,192,64,.4)); }
        .cert-actions { display:flex; gap:.8rem; justify-content:center; flex-wrap:wrap; margin-top:2rem; }
        .btn-gold { display:inline-flex; align-items:center; gap:.5rem; padding:.6rem 1.5rem; border-radius:50px; background:linear-gradient(135deg,var(--gold),#e6a817); color:var(--espresso); font-weight:700; font-size:.9rem; text-decoration:none; font-family:'Cairo',sans-serif; }
        .btn-outline { display:inline-flex; align-items:center; gap:.5rem; padding:.6rem 1.5rem; border-radius:50px; background:rgba(255,255,255,.06); border:1px solid rgba(240,192,64,.25); color:var(--gold-light); font-size:.9rem; text-decoration:none; font-family:'Cairo',sans-serif; }
        .btn-outline:hover { background:rgba(255,255,255,.1); color:var(--gold-light); }
        @media print {
            .navbar-custom, .cert-actions { display:none !important; }
            body { background:#fff; color:#000; }
            .cert-doc { border-color:#c9a227; box-shadow:none; background:#fffdf5; }
            .cert-recipient, .cert-course-name { -webkit-text-fill-color:#1a0a00; }
        }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <span class="brand-logo">☕ Operation Manual</span>
    <div class="nav-links">
        @auth
        <a href="{{ route('certificates.index') }}"><i class="fas fa-arrow-right me-1"></i> شهاداتي</a>
        @endauth
        <a href="{{ route('certificates.verify', $certificate->certificate_number) }}">
            <i class="fas fa-shield-check me-1"></i> تحقق
        </a>
    </div>
</nav>

<div class="cert-wrap">
    <div class="cert-doc">
        <i class="fas fa-certificate cert-icon-main"></i>

        <div class="cert-platform">Operation Manual Platform</div>

        <div class="cert-heading">يُشهد بأن</div>
        <div class="cert-recipient">{{ $certificate->user->name }}</div>
        <div class="cert-subtitle">قد أتم بنجاح دراسة الكورس التالي</div>

        <div class="cert-course-label">الكورس</div>
        <div class="cert-course-name">{{ $certificate->tutorial->title }}</div>

        <div class="cert-divider"></div>

        <div class="cert-details">
            <div class="cert-detail-item">
                <div class="cert-detail-label">الفئة</div>
                <div class="cert-detail-value">{{ $certificate->tutorial->category->name ?? '—' }}</div>
            </div>
            <div class="cert-detail-item">
                <div class="cert-detail-label">تاريخ الإتمام</div>
                <div class="cert-detail-value">{{ $certificate->completed_at?->format('Y-m-d') }}</div>
            </div>
            <div class="cert-detail-item">
                <div class="cert-detail-label">تاريخ الإصدار</div>
                <div class="cert-detail-value">{{ $certificate->issued_at?->format('Y-m-d') }}</div>
            </div>
        </div>

        <div class="cert-number-box">
            <div class="cert-number-label">رقم الشهادة</div>
            <div class="cert-number-val">{{ $certificate->certificate_number }}</div>
        </div>

        <div class="cert-status">
            <span class="status-badge {{ $certificate->isValid() ? 'status-valid' : 'status-revoked' }}">
                <i class="fas {{ $certificate->isValid() ? 'fa-check-circle' : 'fa-ban' }} me-1"></i>
                {{ $certificate->isValid() ? 'شهادة صالحة' : 'شهادة محجوبة' }}
            </span>
        </div>
    </div>

    <div class="cert-actions">
        <a href="{{ route('certificates.verify', $certificate->certificate_number) }}" class="btn-gold">
            <i class="fas fa-shield-check"></i> التحقق من الشهادة
        </a>
        <button onclick="window.print()" class="btn-outline">
            <i class="fas fa-print"></i> طباعة
        </button>
        @auth
        @if(auth()->user()->isAdmin())
        @if($certificate->isValid())
        <form method="POST" action="{{ route('admin.certificates.revoke', $certificate) }}"
              onsubmit="return confirm('إلغاء الشهادة؟')">
            @csrf @method('PATCH')
            <button type="submit" class="btn-outline" style="border-color:rgba(239,68,68,.4);color:#fca5a5;">
                <i class="fas fa-ban"></i> إلغاء
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('admin.certificates.restore', $certificate) }}">
            @csrf @method('PATCH')
            <button type="submit" class="btn-outline" style="border-color:rgba(34,197,94,.4);color:#86efac;">
                <i class="fas fa-undo"></i> استعادة
            </button>
        </form>
        @endif
        @endif
        @endauth
    </div>
</div>

</body>
</html>
