@extends('admin.layout')
@section('page-title', 'المستخدمين')
@section('breadcrumb', 'المستخدمين')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-users" style="color:#059669;margin-left:.4rem;"></i> المستخدمين والأدمنز</h2>
</div>

{{-- Users --}}
<div style="margin-bottom:.6rem;font-weight:700;color:#475569;font-size:.9rem;">
    <i class="fa-solid fa-user" style="margin-left:.4rem;"></i> المستخدمين ({{ $users->count() }})
</div>
{{-- Add user form --}}
<div style="margin-bottom:1rem;">
    <form method="POST" action="{{ route('admin.users.store') }}" class="card" style="padding:1rem;display:flex;gap:.5rem;align-items:center;">
        @csrf
        <input name="name" placeholder="الاسم" required style="padding:.5rem;border:1px solid #e2e8f0;border-radius:6px;">
        <input name="email" placeholder="الايميل" required style="padding:.5rem;border:1px solid #e2e8f0;border-radius:6px;direction:ltr;text-align:left;">
        <select name="role" style="padding:.5rem;border:1px solid #e2e8f0;border-radius:6px;">
            <option value="user">مستخدم</option>
            <option value="student">طالب</option>
            <option value="admin">أدمن</option>
        </select>
        <button class="btn btn-primary" type="submit">إضافة مستخدم</button>
    </form>
</div>
<div class="card" style="margin-bottom:1.5rem;">
    <table>
        <thead>
            <tr><th>#</th><th>الاسم</th><th>الإيميل</th><th>تاريخ التسجيل</th><th>الرول</th><th>الإجراءات</th></tr>
        </thead>
        <tbody>
        @forelse($users as $user)
        <tr>
            <td style="color:#94a3b8;font-size:.8rem;">{{ $user->id }}</td>
            <td style="font-weight:600;">{{ $user->name }}</td>
            <td style="direction:ltr;text-align:left;font-size:.82rem;color:#64748b;">{{ $user->email }}</td>
            <td style="font-size:.82rem;color:#64748b;">{{ $user->created_at->format('Y-m-d') }}</td>
            <td><span class="badge badge-user">مستخدم</span></td>
            <td>
                <form class="inline role-wrap" method="POST" action="{{ route('admin.users.role', $user) }}">
                    @csrf @method('PATCH')
                    <select name="role">
                        <option value="user"  @selected($user->role==='user')>مستخدم</option>
                        <option value="student" @selected($user->role==='student')>طالب</option>
                        <option value="admin" @selected($user->role==='admin')>أدمن</option>
                    </select>
                    <button class="btn btn-success btn-sm" type="submit"><i class="fa-solid fa-check"></i></button>
                </form>
                <form class="inline" method="POST" action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('حذف المستخدم؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">
            <div class="empty-state">
                <i class="fa-solid fa-users"></i>
                <p>لا يوجد مستخدمين</p>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Admins --}}
<div style="margin-bottom:.6rem;font-weight:700;color:#475569;font-size:.9rem;">
    <i class="fa-solid fa-shield-halved" style="margin-left:.4rem;color:#7c3aed;"></i> الأدمنز ({{ $admins->count() }})
</div>
<div class="card">
    <table>
        <thead>
            <tr><th>#</th><th>الاسم</th><th>الإيميل</th><th>تاريخ التسجيل</th><th>الرول</th><th>الإجراءات</th></tr>
        </thead>
        <tbody>
        @forelse($admins as $admin)
        <tr>
            <td style="color:#94a3b8;font-size:.8rem;">{{ $admin->id }}</td>
            <td style="font-weight:600;">
                {{ $admin->name }}
                @if($admin->id === auth()->id())
                    <span class="badge badge-admin" style="font-size:.7rem;">أنت</span>
                @endif
            </td>
            <td style="direction:ltr;text-align:left;font-size:.82rem;color:#64748b;">{{ $admin->email }}</td>
            <td style="font-size:.82rem;color:#64748b;">{{ $admin->created_at->format('Y-m-d') }}</td>
            <td><span class="badge badge-admin">أدمن</span></td>
            <td>
                @if($admin->id !== auth()->id())
                    <form class="inline role-wrap" method="POST" action="{{ route('admin.users.role', $admin) }}">
                        @csrf @method('PATCH')
                        <select name="role">
                            <option value="user"  @selected($admin->role==='user')>مستخدم</option>
                            <option value="student" @selected($admin->role==='student')>طالب</option>
                            <option value="admin" @selected($admin->role==='admin')>أدمن</option>
                        </select>
                        <button class="btn btn-success btn-sm" type="submit"><i class="fa-solid fa-check"></i></button>
                    </form>
                    <form class="inline" method="POST" action="{{ route('admin.users.destroy', $admin) }}"
                          onsubmit="return confirm('حذف الأدمن؟')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                @else
                    <span style="color:#94a3b8;font-size:.85rem;">—</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:2rem;">لا يوجد أدمنز</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
