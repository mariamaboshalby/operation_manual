<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>التحقق من الشهادة — Operation Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --espresso:#1a0a00; --gold:#f0c040; --gold-light:#ffe082; --cream:#f5e6d3; --azure-light:#42a5f5; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Cairo',sans-serif; background:var(--espresso); color:var(--cream); min-height:100vh; display:flex; flex-direction:column; }
        .navbar-custom { background:rgba(26,10,0,.9); backdrop-filter:blur(18px); border-bottom:1px solid rgba(240,192,64,.2); padding:.9rem 2rem; display:flex; align-items:center; justify-content:space-between; }
        .brand-logo { font-family:'Playfair Display',serif; font-size:1.4rem; background:linear-gradient(135deg,var(--gold),var(--azure-light)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; text-decoration:none; }
        .main { flex:1; display:flex; align-items:center; justify-content:center; padding:2rem 1rem; }
        .verify-card { background:linear-gradient(145deg,rgba(44,21,3,.9),rgba(26,10,0,.95)); border-radius:24px; padding:3rem 2.5rem; text-align:center; max-width:560px; width:100%; }
        .verify-icon { font-size:4rem; margin-bottom:1.2rem; display:block; }
        .icon-valid   { color:#22c55e; filter:drop-shadow(0 0 20px rgba(34,197,94,.4)); }
        .icon-revoked { color:#ef4444; filter:drop-shadow(0 0 20px rgba(239,68,68,.4)); }
        .icon-notfound{ color:rgba(245,230,211,.3); }
        .verify-status { font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:900; margin-bottom:.5rem; }
        .status-valid   { color:#86efac; }
        .status-revoked { color:#fca5a5; }
        .status-notfound{ color:rgba(245,230,211,.5); }
        .cert-num-label { font-size:.78rem; letter-spacing:3px; text-transform:uppercase; color:rgba(245,230,211,.4); margin-bottom:.2rem; margin-top:1.5rem; }
        .cert-num-val { font-size:1rem; font-weight:700; color:var(--gold); letter-spacing:2px; margin-bottom:1.5rem; }
        .divider { width:60px; height:2px; background:linear-gradient(90deg,transparent,rgba(240,192,64,.4),transparent); margin:0 auto 1.5rem; }
        .detail-row { display:flex; align-items:center; justify-content:space-between; padding:.55rem 0; border-bottom:1px solid rgba(255,255,255,.05); font-size:.88rem; }
        .detail-row:last-child { border-bottom:none; }
        .detail-label { color:rgba(245,230,211,.45); }
        .detail-value { font-weight:600; color:var(--cream); }
        .btn-back { display:inline-flex; align-items:center; gap:.5rem; padding:.6rem 1.5rem; border-radius:50px; background:rgba(255,255,255,.07); border:1px solid rgba(240,192,64,.2); color:var(--gold-light); font-size:.9rem; text-decoration:none; font-family:'Cairo',sans-serif; margin-top:1.5rem; }
        .btn-back:hover { background:rgba(255,255,255,.12); color:var(--gold-light); }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <a href="/" class="brand-logo">☕ Operation Manual</a>
    <span style="font-size:.82rem;color:rgba(245,230,211,.4);">التحقق من الشهادة</span>
</nav>

<div class="main">
    @if(isset($certificate) && $certificate)

        {{-- ── Certificate found ──────────────────────────────── --}}
        <div class="verify-card" style="border:2px solid {{ $certificate->isValid() ? 'rgba(34,197,94,.35)' : 'rgba(239,68,68,.35)' }};">

            <i class="fas fa-{{ $certificate->isValid() ? 'check-circle' : 'ban' }} verify-icon {{ $certificate->isValid() ? 'icon-valid' : 'icon-revoked' }}"></i>

            <div class="verify-status {{ $certificate->isValid() ? 'status-valid' : 'status-revoked' }}">
                {{ $certificate->isValid() ? 'شهادة صالحة' : 'شهادة محجوبة' }}
            </div>
            <p style="font-size:.85rem;color:rgba(245,230,211,.55);margin-bottom:.5rem;">
                {{ $certificate->isValid() ? 'تم التحقق من صحة هذه الشهادة' : 'هذه الشهادة لم تعد سارية المفعول' }}
            </p>

            <div class="cert-num-label">رقم الشهادة</div>
            <div class="cert-num-val">{{ $certificate->certificate_number }}</div>

            <div class="divider"></div>

            <div class="detail-row">
                <span class="detail-label">اسم المتدرب</span>
                <span class="detail-value">{{ $certificate->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">الكورس</span>
                <span class="detail-value">{{ $certificate->tutorial->title }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">تاريخ الإتمام</span>
                <span class="detail-value">{{ $certificate->completed_at?->format('Y-m-d') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">تاريخ الإصدار</span>
                <span class="detail-value">{{ $certificate->issued_at?->format('Y-m-d') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">الحالة</span>
                <span class="detail-value" style="color:{{ $certificate->isValid() ? '#86efac' : '#fca5a5' }};">
                    {{ $certificate->isValid() ? 'صالحة' : 'محجوبة' }}
                </span>
            </div>

            <a href="/" class="btn-back"><i class="fas fa-home me-1"></i> الرئيسية</a>
        </div>

    @else

        {{-- ── Certificate NOT found ───────────────────────────── --}}
        <div class="verify-card" style="border:1px solid rgba(255,255,255,.08);">
            <i class="fas fa-question-circle verify-icon icon-notfound"></i>
            <div class="verify-status status-notfound">شهادة غير موجودة</div>
            <p style="font-size:.85rem;color:rgba(245,230,211,.45);margin-bottom:1rem;">
                لم يتم العثور على شهادة برقم:
            </p>
            @isset($certificateNumber)
            <div class="cert-num-val" style="color:rgba(245,230,211,.6);">{{ $certificateNumber }}</div>
            @endisset
            <p style="font-size:.8rem;color:rgba(245,230,211,.35);margin-top:.5rem;">
                تأكد من صحة رقم الشهادة وأعد المحاولة.
            </p>
            <a href="/" class="btn-back"><i class="fas fa-home me-1"></i> الرئيسية</a>
        </div>

    @endif
</div>

</body>
</html>
