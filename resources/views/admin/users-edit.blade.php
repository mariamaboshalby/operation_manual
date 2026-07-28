@extends('admin.layout')
@section('page-title', 'تعديل مستخدم')
@section('breadcrumb', 'تعديل مستخدم')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-user-pen" style="color:#2563eb;margin-left:.4rem;"></i> تعديل المستخدم</h2>
</div>

<div class="card" style="padding:1.5rem;max-width:720px;">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="grid2">
            <div class="form-group">
                <label class="form-label">الاسم</label>
                <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">الإيميل</label>
                <input class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>

        <div class="grid2">
            <div class="form-group">
                <label class="form-label">كلمة المرور</label>
                <input class="form-control" type="password" name="password" placeholder="اتركها فارغة إن لم تريد تغييرها" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input class="form-control" type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" autocomplete="new-password">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">الرول</label>
            <select class="form-control" name="role">
                <option value="user" @selected(old('role', $user->role)==='user')>مستخدم</option>
                <option value="student" @selected(old('role', $user->role)==='student')>طالب</option>
                <option value="admin" @selected(old('role', $user->role)==='admin')>أدمن</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">اختيار الشركة</label>
            <select id="companySelect" class="form-control">
                <option value="">كل الشركات</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">التوتوريالات المربوطة</label>
            <div class="check-list" id="tutorialList">
                @forelse($tutorials as $tutorial)
                    <label class="check-item" data-company-id="{{ $tutorial->companies->pluck('id')->implode(',') }}">
                        <input type="checkbox" name="tutorials[]" value="{{ $tutorial->id }}"
                            @checked(in_array($tutorial->id, old('tutorials', $user->tutorials->pluck('id')->toArray())))>
                        {{ $tutorial->title }}
                    </label>
                @empty
                    <div class="check-list-empty"><i class="fa-solid fa-book-open"></i> لا توجد توتوريالات بعد</div>
                @endforelse
                <div class="check-list-empty" id="noTutorialsMsg" hidden><i class="fa-solid fa-filter-circle-xmark"></i> لا توجد توتوريالات مرتبطة بهذه الشركة</div>
            </div>
            <p class="form-hint">اختر شركة لفلترة التوتوريالات، واختياراتك المخفية تظل محفوظة.</p>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> حفظ التغييرات</button>
            <a href="{{ route('admin.users.page') }}" class="btn btn-ghost"><i class="fa-solid fa-arrow-right"></i> عودة</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const companySelect = document.getElementById('companySelect');
        const items = document.querySelectorAll('#tutorialList .check-item');
        const noMsg = document.getElementById('noTutorialsMsg');

        if (!companySelect) return;

        companySelect.addEventListener('change', function () {
            const companyId = this.value;
            let visible = 0;

            items.forEach(function (item) {
                const companyIds = (item.getAttribute('data-company-id') || '').split(',').filter(Boolean);
                const isMatch = !companyId || companyIds.includes(companyId);
                item.hidden = !isMatch;
                if (isMatch) visible++;
            });

            if (noMsg) noMsg.hidden = visible > 0;
        });
    });
</script>
@endsection
