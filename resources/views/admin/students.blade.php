@extends('admin.layout')
@section('page-title', 'الطلاب')
@section('breadcrumb', 'الطلاب')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-user-graduate" style="color:#0f766e;margin-left:.4rem;"></i> الطلاب</h2>
</div>

<div style="margin-bottom:1rem;display:flex;justify-content:flex-end;">
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">إضافة طالب جديد</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr><th>#</th><th>الاسم</th><th>الإيميل</th><th>التوتوريالات</th><th>تاريخ التسجيل</th><th>الإجراءات</th></tr>
        </thead>
        <tbody>
        @forelse($students as $student)
        <tr>
            <td style="color:#94a3b8;font-size:.8rem;">{{ $student->id }}</td>
            <td style="font-weight:600;">{{ $student->name }}</td>
            <td style="direction:ltr;text-align:left;font-size:.82rem;color:#64748b;">{{ $student->email }}</td>
            <td>
                @if($student->tutorials->isNotEmpty())
                    <div style="display:flex;flex-wrap:wrap;gap:.3rem;">
                        @foreach($student->tutorials as $tutorial)
                            <span class="badge badge-info">{{ $tutorial->title }}</span>
                        @endforeach
                    </div>
                @else
                    <span style="color:#94a3b8;">—</span>
                @endif
            </td>
            <td style="font-size:.82rem;color:#64748b;">{{ $student->created_at->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-ghost btn-sm">تعديل</a>
                <form class="inline" method="POST" action="{{ route('admin.students.destroy', $student) }}"
                      onsubmit="return confirm('حذف الطالب؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:2rem;">لا يوجد طلاب</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
