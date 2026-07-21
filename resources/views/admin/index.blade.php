@extends('admin.layout')
@section('page-title', 'لوحة التحكم')

@section('content')
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem;">
    <div class="card" style="padding:1.2rem;display:flex;align-items:center;gap:1rem;">
        <div style="width:48px;height:48px;background:#ede9fe;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:1.2rem;">
            <i class="fa-solid fa-book-open"></i>
        </div>
        <div>
            <div style="font-size:1.6rem;font-weight:700;color:#1e293b;">{{ $tutorials->count() }}</div>
            <div style="font-size:.82rem;color:#64748b;">التيوتوريالز</div>
        </div>
    </div>
    <div class="card" style="padding:1.2rem;display:flex;align-items:center;gap:1rem;">
        <div style="width:48px;height:48px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#d97706;font-size:1.2rem;">
            <i class="fa-solid fa-tags"></i>
        </div>
        <div>
            <div style="font-size:1.6rem;font-weight:700;color:#1e293b;">{{ $categories->count() }}</div>
            <div style="font-size:.82rem;color:#64748b;">الكاتيجوريز</div>
        </div>
    </div>
    <div class="card" style="padding:1.2rem;display:flex;align-items:center;gap:1rem;">
        <div style="width:48px;height:48px;background:#d1fae5;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#059669;font-size:1.2rem;">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <div style="font-size:1.6rem;font-weight:700;color:#1e293b;">{{ $users->count() }}</div>
            <div style="font-size:.82rem;color:#64748b;">المستخدمين</div>
        </div>
    </div>
    <div class="card" style="padding:1.2rem;display:flex;align-items:center;gap:1rem;">
        <div style="width:48px;height:48px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#dc2626;font-size:1.2rem;">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div>
            <div style="font-size:1.6rem;font-weight:700;color:#1e293b;">{{ $admins->count() }}</div>
            <div style="font-size:.82rem;color:#64748b;">الأدمنز</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
    <div class="card">
        <div style="padding:1rem 1.2rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-weight:700;font-size:.95rem;"><i class="fa-solid fa-book-open" style="color:#7c3aed;margin-left:.4rem;"></i> آخر التيوتوريالز</span>
            <a href="{{ route('admin.tutorials.page') }}" class="btn btn-ghost btn-sm">عرض الكل</a>
        </div>
        <table>
            <thead><tr><th>الصورة</th><th>العنوان</th><th>الكاتيجوري</th><th>المستوى</th></tr></thead>
            <tbody>
            @forelse($tutorials->take(5) as $t)
            <tr>
                <td>
                    @if($t->cover_url)
                        <img src="{{ $t->cover_url }}" style="width:48px;height:34px;object-fit:cover;border-radius:6px;border:1px solid #e5e9f2;">
                    @else
                        <div style="width:48px;height:34px;background:#f1f5f9;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:.75rem;border:1px solid #e5e9f2;">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    @endif
                </td>
                <td>{{ $t->title }}</td>
                <td>{{ $t->category->name ?? '-' }}</td>
                <td><span class="badge badge-{{ $t->level }}">{{ $t->level }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:2rem;">لا يوجد تيوتوريالز</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <div style="padding:1rem 1.2rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-weight:700;font-size:.95rem;"><i class="fa-solid fa-users" style="color:#059669;margin-left:.4rem;"></i> آخر المستخدمين</span>
            <a href="{{ route('admin.users.page') }}" class="btn btn-ghost btn-sm">عرض الكل</a>
        </div>
        <table>
            <thead><tr><th>الاسم</th><th>الإيميل</th><th>الرول</th></tr></thead>
            <tbody>
            @forelse($users->take(5) as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td style="direction:ltr;text-align:left;font-size:.8rem;color:#64748b;">{{ $u->email }}</td>
                <td><span class="badge badge-{{ $u->role }}">{{ $u->role === 'admin' ? 'أدمن' : ($u->role === 'student' ? 'طالب' : 'مستخدم') }}</span></td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center;color:#94a3b8;padding:2rem;">لا يوجد مستخدمين</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
