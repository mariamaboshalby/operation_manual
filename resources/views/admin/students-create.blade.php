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
            </div>
        </div>

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
            <div class="check-list" id="tutorialList">
                <div class="check-list-empty" id="pickCompanyMsg"><i class="fa-solid fa-building"></i> اختر شركة أولًا حتى تظهر التوتوريالات المرتبطة بها</div>
                @foreach($tutorials as $tutorial)
                    <label class="check-item" data-company-id="{{ $tutorial->companies->pluck('id')->implode(',') }}" hidden>
                        <input type="checkbox" name="tutorials[]" value="{{ $tutorial->id }}">
                        {{ $tutorial->title }}
                    </label>
                @endforeach
                <div class="check-list-empty" id="noTutorialsMsg" hidden><i class="fa-solid fa-filter-circle-xmark"></i> لا توجد توتوريالات مرتبطة بهذه الشركة</div>
            </div>
            <p class="form-hint">اختر شركة أولًا حتى تظهر التوتوريالات المرتبطة بها.</p>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-user-plus"></i> حفظ الطالب</button>
            <a href="{{ route('admin.students.page') }}" class="btn btn-ghost"><i class="fa-solid fa-arrow-right"></i> عودة</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const companySelect = document.getElementById('companySelect');
        const items = document.querySelectorAll('#tutorialList .check-item');
        const pickMsg = document.getElementById('pickCompanyMsg');
        const noMsg = document.getElementById('noTutorialsMsg');

        if (!companySelect) return;

        companySelect.addEventListener('change', function () {
            const companyId = this.value;
            let visible = 0;

            items.forEach(function (item) {
                const companyIds = (item.getAttribute('data-company-id') || '').split(',').filter(Boolean);
                const isMatch = companyId && companyIds.includes(companyId);
                item.hidden = !isMatch;
                if (!isMatch) item.querySelector('input').checked = false;
                if (isMatch) visible++;
            });

            pickMsg.hidden = !!companyId;
            noMsg.hidden = !companyId || visible > 0;
        });
    });
</script>
@endsection
