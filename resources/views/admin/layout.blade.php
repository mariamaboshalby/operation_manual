<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 220px;
            --dark: #1a2236;
            --dark2: #212d42;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --text-muted: #8a9bbf;
            --border: #e5e9f2;
            --bg: #f0f2f8;
        }

        body { font-family: 'Segoe UI', Arial, sans-serif; background: var(--bg); display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--dark);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; right: 0; bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar-logo {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: .6rem;
        }
        .sidebar-logo span { color: #fff; font-weight: 700; font-size: 1rem; }
        .sidebar-logo .logo-icon {
            width: 32px; height: 32px; background: var(--accent);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: .85rem;
        }

        .sidebar-section {
            padding: .5rem 1rem .2rem;
            font-size: .68rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: .5rem;
        }

        .sidebar-link {
            display: flex; align-items: center; justify-content: space-between;
            padding: .6rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: .88rem;
            transition: background .15s, color .15s;
            border-radius: 0;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255,255,255,.07);
            color: #fff;
        }
        .sidebar-link.active { color: #fff; }
        .sidebar-link .link-left { display: flex; align-items: center; gap: .6rem; }
        .sidebar-link .link-left i { width: 16px; text-align: center; font-size: .85rem; }
        .sidebar-badge {
            background: var(--accent);
            color: #fff;
            font-size: .68rem;
            padding: .1rem .4rem;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .sidebar-user {
            margin-top: auto;
            padding: .9rem 1rem;
            border-top: 1px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: .7rem;
        }
        .sidebar-user .avatar {
            width: 32px; height: 32px; background: var(--accent);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem; flex-shrink: 0;
        }
        .sidebar-user .user-info { flex: 1; min-width: 0; }
        .sidebar-user .user-name { color: #fff; font-size: .85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user .user-role { color: var(--text-muted); font-size: .72rem; }

        /* ── Main ── */
        .main { margin-right: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* ── Topbar ── */
        .topbar {
            background: #fff;
            padding: .75rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-title h1 { font-size: 1.1rem; font-weight: 700; color: #1e293b; }
        .breadcrumb { font-size: .78rem; color: var(--text-muted); margin-top: .1rem; }
        .breadcrumb a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb a:hover { color: var(--accent); }
        .topbar-icon {
            width: 34px; height: 34px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg); color: #475569; cursor: pointer;
            border: 1px solid var(--border); font-size: .85rem;
            text-decoration: none; transition: background .15s;
        }
        .topbar-icon:hover { background: #e2e8f0; }
        .topbar-avatar {
            width: 34px; height: 34px; background: var(--dark);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem; cursor: pointer;
        }

        /* ── Content ── */
        .content { padding: 1.5rem; flex: 1; }

        /* ── Page header ── */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; flex-wrap: wrap; gap: .8rem; }
        .page-header h2 { font-size: 1.15rem; font-weight: 700; color: #1e293b; }

        /* ── Toolbar ── */
        .toolbar { display: flex; align-items: center; gap: .6rem; margin-bottom: 1.2rem; flex-wrap: wrap; }
        .toolbar input[type=text] {
            flex: 1; min-width: 200px; padding: .55rem .9rem .55rem 2.2rem;
            border: 1px solid var(--border); border-radius: 8px;
            font-size: .88rem; background: #fff; outline: none;
            font-family: inherit;
        }
        .toolbar input[type=text]:focus { border-color: var(--accent); }
        .search-wrap { position: relative; flex: 1; min-width: 200px; }
        .search-wrap i { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: .85rem; }
        .toolbar select {
            padding: .55rem .9rem; border: 1px solid var(--border); border-radius: 8px;
            font-size: .88rem; background: #fff; outline: none; cursor: pointer;
            font-family: inherit; color: #374151;
        }
        .toolbar select:focus { border-color: var(--accent); }

        /* ── Buttons ── */
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem 1.1rem; border: none; border-radius: 8px; cursor: pointer; font-size: .88rem; font-family: inherit; font-weight: 600; transition: background .15s, opacity .15s; text-decoration: none; }
        .btn-primary { background: var(--dark); color: #fff; }
        .btn-primary:hover { background: #0f172a; }
        .btn-accent  { background: var(--accent); color: #fff; }
        .btn-accent:hover { background: var(--accent-hover); }
        .btn-danger  { background: #ef4444; color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-warning { background: #f59e0b; color: #fff; }
        .btn-warning:hover { background: #d97706; }
        .btn-success { background: #10b981; color: #fff; }
        .btn-success:hover { background: #059669; }
        .btn-ghost { background: transparent; color: #475569; border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg); }
        .btn-sm { padding: .3rem .7rem; font-size: .8rem; border-radius: 6px; }
        form.inline { display: inline; }

        /* ── Card ── */
        .card { background: #fff; border-radius: 10px; border: 1px solid var(--border); overflow: hidden; }

        /* ── Table ── */
        table { width: 100%; border-collapse: collapse; font-size: .88rem; }
        th { background: #f8fafc; color: #64748b; font-weight: 600; padding: .75rem 1rem; text-align: right; border-bottom: 1px solid var(--border); font-size: .8rem; }
        td { padding: .75rem 1rem; text-align: right; border-bottom: 1px solid var(--border); color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafbff; }

        /* ── Empty state ── */
        .empty-state { text-align: center; padding: 4rem 1rem; color: var(--text-muted); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: .35; display: block; }
        .empty-state p { margin-bottom: 1.2rem; font-size: .95rem; }

        /* ── Badges ── */
        .badge { display: inline-block; padding: .2rem .6rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
        .badge-beginner     { background: #d1fae5; color: #065f46; }
        .badge-intermediate { background: #fef3c7; color: #92400e; }
        .badge-advanced     { background: #fee2e2; color: #991b1b; }
        .badge-admin  { background: #ede9fe; color: #5b21b6; }
        .badge-user   { background: #e0f2fe; color: #0369a1; }

        /* ── Alert ── */
        .alert { padding: .8rem 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; align-items: center; gap: .6rem; font-size: .9rem; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error   { background: #fee2e2; color: #991b1b; }

        /* ── Modal ── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 200; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 12px; padding: 1.5rem; width: 100%; max-width: 520px; max-height: 90vh; overflow-y: auto; }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
        .modal-header h3 { font-size: 1rem; font-weight: 700; color: #1e293b; }
        .modal-close { background: none; border: none; cursor: pointer; color: #94a3b8; font-size: 1.1rem; }
        .modal-close:hover { color: #ef4444; }

        /* ── Form ── */
        .form-group { margin-bottom: .9rem; }
        .form-label { display: block; font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }
        .form-control {
            width: 100%; padding: .55rem .8rem; border: 1px solid var(--border);
            border-radius: 8px; font-size: .88rem; font-family: inherit; outline: none;
            transition: border-color .15s;
        }
        .form-control:focus { border-color: var(--accent); }
        .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: .8rem; }
        .grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .8rem; }

        /* ── Role select inline ── */
        .role-wrap { display: inline-flex; align-items: center; gap: .4rem; }
        .role-wrap select { padding: .28rem .5rem; border: 1px solid var(--border); border-radius: 6px; font-size: .8rem; font-family: inherit; outline: none; cursor: pointer; }
    </style>
</head>
<body>

{{-- ══ SIDEBAR ══ --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        <span>لوحة التحكم</span>
    </div>

    <a href="{{ route('admin.index') }}" class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-gauge"></i> لوحة التحكم</span>
    </a>

    <div class="sidebar-section">المحتوى</div>

    <a href="{{ route('admin.tutorials.page') }}" class="sidebar-link {{ request()->routeIs('admin.tutorials.page') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-book-open"></i> التيوتوريالز</span>
        <span class="sidebar-badge">{{ \App\Models\Tutorial::count() }}</span>
    </a>

    <a href="{{ route('admin.categories.page') }}" class="sidebar-link {{ request()->routeIs('admin.categories.page') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-tags"></i> الكاتيجوريز</span>
    </a>

    <a href="{{ route('admin.tutorials.create') }}" class="sidebar-link {{ request()->routeIs('admin.tutorials.create') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-plus"></i> إضافة تيوتوريال</span>
    </a>

    <div class="sidebar-section">النظام</div>

    <a href="{{ route('admin.users.page') }}" class="sidebar-link {{ request()->routeIs('admin.users.page') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-users"></i> المستخدمين</span>
        <span class="sidebar-badge">{{ \App\Models\User::count() }}</span>
    </a>

    <a href="{{ route('admin.students.page') }}" class="sidebar-link {{ request()->routeIs('admin.students.page') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-user-graduate"></i> الطلاب</span>
        <span class="sidebar-badge">{{ \App\Models\User::where('role', 'student')->count() }}</span>
    </a>

    <a href="{{ route('admin.companies.page') }}" class="sidebar-link {{ request()->routeIs('admin.companies.page') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-building"></i> الشركات والمطاعم</span>
        <span class="sidebar-badge">{{ \App\Models\Company::count() }}</span>
    </a>

    <a href="{{ route('admin.company-types.page') }}" class="sidebar-link {{ request()->routeIs('admin.company-types.page') ? 'active' : '' }}">
        <span class="link-left"><i class="fa-solid fa-list"></i> أنواع الشركات</span>
        <span class="sidebar-badge">{{ \App\Models\CompanyType::count() }}</span>
    </a>

    <div class="sidebar-user">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">Admin</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:#8a9bbf;font-size:.85rem;" title="خروج">
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</aside>

{{-- ══ MAIN ══ --}}
<div class="main">
    <div class="topbar">
        <div class="topbar-title">
            <h1>@yield('page-title', 'لوحة التحكم')</h1>
            <div class="breadcrumb">
                <a href="{{ route('admin.index') }}">لوحة التحكم</a>
                @hasSection('breadcrumb') &lsaquo; @yield('breadcrumb') @endif
            </div>
        </div>
        <div class="topbar-right">
            <a href="{{ route('tutorials') }}" class="topbar-icon" title="الموقع"><i class="fa-solid fa-globe"></i></a>
            <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

@stack('modals')
@stack('scripts')
</body>
</html>
