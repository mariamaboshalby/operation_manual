@extends('admin.layout')
@section('page-title', 'الشهادات')
@section('breadcrumb', 'الشهادات')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-certificate" style="color:#f59e0b;margin-left:.4rem;"></i> الشهادات</h2>
    <span style="font-size:.82rem;color:#64748b;">{{ $certificates->total() }} شهادة</span>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.certificates.page') }}">
    <div class="toolbar" style="margin-bottom:1.2rem;">
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" placeholder="ابحث باسم الطالب..."
                   value="{{ request('search') }}" style="padding-right:2.2rem;">
        </div>
        <input type="text" name="cert_number" placeholder="رقم الشهادة"
               value="{{ request('cert_number') }}"
               style="padding:.55rem .9rem;border:1px solid var(--border);border-radius:8px;font-size:.88rem;font-family:inherit;outline:none;min-width:180px;direction:ltr;">
        <select name="tutorial_id" style="padding:.55rem .9rem;border:1px solid var(--border);border-radius:8px;font-size:.88rem;background:#fff;outline:none;font-family:inherit;color:#374151;">
            <option value="">كل الكورسات</option>
            @foreach($tutorials as $tut)
                <option value="{{ $tut->id }}" @selected(request('tutorial_id') == $tut->id)>{{ $tut->title }}</option>
            @endforeach
        </select>
        <select name="status" style="padding:.55rem .9rem;border:1px solid var(--border);border-radius:8px;font-size:.88rem;background:#fff;outline:none;font-family:inherit;color:#374151;">
            <option value="">كل الحالات</option>
            <option value="valid"   @selected(request('status') === 'valid')>صالحة</option>
            <option value="revoked" @selected(request('status') === 'revoked')>محجوبة</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">بحث</button>
        @if(request()->hasAny(['search','cert_number','tutorial_id','status']))
        <a href="{{ route('admin.certificates.page') }}" class="btn btn-ghost btn-sm">مسح</a>
        @endif
    </div>
</form>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>الطالب</th>
                <th>الكورس</th>
                <th>رقم الشهادة</th>
                <th>تاريخ الإصدار</th>
                <th>تاريخ الإتمام</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
        @forelse($certificates as $cert)
        <tr>
            <td style="color:#94a3b8;font-size:.8rem;">{{ $cert->id }}</td>
            <td style="font-weight:600;">{{ $cert->user->name }}</td>
            <td style="font-size:.85rem;color:#475569;">{{ $cert->tutorial->title }}</td>
            <td>
                <code style="font-size:.78rem;background:#f1f5f9;padding:.2rem .5rem;border-radius:4px;color:#2563eb;">
                    {{ $cert->certificate_number }}
                </code>
            </td>
            <td style="font-size:.82rem;color:#64748b;">{{ $cert->issued_at?->format('Y-m-d') }}</td>
            <td style="font-size:.82rem;color:#64748b;">{{ $cert->completed_at?->format('Y-m-d') }}</td>
            <td>
                @if($cert->isValid())
                    <span class="badge" style="background:#d1fae5;color:#065f46;">
                        <i class="fa-solid fa-check-circle me-1"></i>صالحة
                    </span>
                @else
                    <span class="badge" style="background:#fee2e2;color:#991b1b;">
                        <i class="fa-solid fa-ban me-1"></i>محجوبة
                    </span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.certificates.show', $cert) }}" class="btn btn-ghost btn-sm">
                    <i class="fa-solid fa-eye"></i>
                </a>
                <a href="{{ route('certificates.verify', $cert->certificate_number) }}" target="_blank" class="btn btn-ghost btn-sm" title="التحقق">
                    <i class="fa-solid fa-shield-check"></i>
                </a>
                @if($cert->isValid())
                <form class="inline" method="POST"
                      action="{{ route('admin.certificates.revoke', $cert) }}"
                      onsubmit="return confirm('إلغاء الشهادة؟')">
                    @csrf @method('PATCH')
                    <button class="btn btn-danger btn-sm" type="submit" title="إلغاء">
                        <i class="fa-solid fa-ban"></i>
                    </button>
                </form>
                @else
                <form class="inline" method="POST"
                      action="{{ route('admin.certificates.restore', $cert) }}"
                      onsubmit="return confirm('استعادة الشهادة؟')">
                    @csrf @method('PATCH')
                    <button class="btn btn-success btn-sm" type="submit" title="استعادة">
                        <i class="fa-solid fa-undo"></i>
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="8">
            <div class="empty-state">
                <i class="fa-solid fa-certificate"></i>
                <p>لا توجد شهادات</p>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($certificates->hasPages())
<div style="margin-top:1rem;display:flex;justify-content:center;gap:.4rem;flex-wrap:wrap;">
    {{ $certificates->links() }}
</div>
@endif

@endsection
