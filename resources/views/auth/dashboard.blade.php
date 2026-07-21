<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f3f4f6; }
        nav { background: #6366f1; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; color: #fff; }
        nav span { font-size: 1.1rem; }
        nav form button { background: transparent; border: 1px solid #fff; color: #fff; padding: .4rem 1rem; border-radius: 6px; cursor: pointer; }
        nav form button:hover { background: #4f46e5; }
        .container { max-width: 800px; margin: 3rem auto; padding: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,.1); }
        h1 { color: #1f2937; margin-bottom: 1rem; }
        p { color: #6b7280; }
    </style>
</head>
<body>
<nav>
    <span>مرحباً، {{ Auth::user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">تسجيل الخروج</button>
    </form>
</nav>
<div class="container">
    <h1>لوحة التحكم</h1>
    <p>أنت مسجل الدخول بنجاح بالبريد: {{ Auth::user()->email }}</p>
</div>
</body>
</html>
