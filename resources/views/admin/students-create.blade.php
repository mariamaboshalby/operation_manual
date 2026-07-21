@extends('admin.layout')
@section('page-title', 'إضافة طالب')
@section('breadcrumb', 'إضافة طالب')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-user-plus" style="color:#2563eb;margin-left:.4rem;"></i> إضافة طالب جديد</h2>
</div>

<div class="card" style="padding:1.5rem;max-width:900px;">
    <form method="POST" action="{{ route('admin.students.store') }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-error" style="margin-bottom:1rem;">
                <ul style="margin:0; padding:0 1rem; list-style:disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid2">
            <div class="form-group">
                <label class="form-label">الاسم</label>
                <input class="form-control" name="name" value="{{ old('name') }}" placeholder="اسم الطالب" required>
            </div>
            <div class="form-group">
                <label class="form-label">الإيميل</label>
                <input class="form-control" name="email" value="{{ old('email') }}" placeholder="email@example.com" required style="direction:ltr;text-align:left;">
        <div class="grid2">
            <div class="form-group">
                <label class="form-label">كلمة المرور</label>
                <input class="form-control" type="password" name="password" placeholder="كلمة المرور" required autocomplete="new-password" style="direction:ltr;text-align:left;">
            </div>
            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input class="form-control" type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" required autocomplete="new-password" style="direction:ltr;text-align:left;">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">اختيار الشركة</label>
            <select id="companySelect" class="form-control">
                <option value="">-- اختر الشركة --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">التوتوريالات الخاصة بالشركة</label>
            <select class="form-control" name="tutorials[]" id="tutorialSelect" multiple size="8" disabled>
                @foreach($tutorials as $tutorial)
                    <option value="{{ $tutorial->id }}" data-company-id="{{ $tutorial->companies->pluck('id')->implode(',') }}">{{ $tutorial->title }}</option>
                @endforeach
            </select>
            <p style="font-size:.82rem;color:#64748b;margin-top:.4rem;">اختر شركة أولًا حتى تظهر التوتوريالات المرتبطة بها.</p>
        </div>

        <button class="btn btn-primary" type="submit">حفظ الطالب</button>
        <a href="{{ route('admin.students.page') }}" class="btn btn-ghost">عودة</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const companySelect = document.getElementById('companySelect');
        const tutorialSelect = document.getElementById('tutorialSelect');

        if (!companySelect || !tutorialSelect) return;

        companySelect.addEventListener('change', function () {
            const companyId = this.value;
            const options = tutorialSelect.querySelectorAll('option');

            tutorialSelect.disabled = !companyId;
            tutorialSelect.selectedIndex = -1;

            options.forEach(function (option) {
                const companyIds = (option.getAttribute('data-company-id') || '').split(',').filter(Boolean);
                const isMatch = companyId && companyIds.includes(companyId);
                option.hidden = !isMatch;
                option.disabled = !isMatch;
            });
        });
    });
</script>
@endsection
