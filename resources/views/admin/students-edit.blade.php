@extends('admin.layout')
@section('page-title', 'تعديل طالب')
@section('breadcrumb', 'تعديل طالب')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-user-pen" style="color:#0f766e;margin-left:.4rem;"></i> تعديل الطالب: {{ $student->name }}</h2>
</div>

<div class="card" style="padding:1.5rem;max-width:900px;">
    <form method="POST" action="{{ route('admin.students.update', $student) }}">
        @csrf
        @method('PUT')

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
                <input class="form-control" name="name" value="{{ old('name', $student->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">الإيميل</label>
                <input class="form-control" name="email" value="{{ old('email', $student->email) }}" required style="direction:ltr;text-align:left;">
            </div>
        </div>

        <div class="grid2">
            <div class="form-group">
                <label class="form-label">كلمة المرور الجديدة</label>
                <input class="form-control" type="password" name="password"
                       placeholder="اتركها فارغة إن لم تريد تغييرها"
                       autocomplete="new-password" style="direction:ltr;text-align:left;">
            </div>
            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input class="form-control" type="password" name="password_confirmation"
                       placeholder="تأكيد كلمة المرور"
                       autocomplete="new-password" style="direction:ltr;text-align:left;">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">فلترة حسب الشركة</label>
            <select id="companySelect" class="form-control">
                <option value="">كل الشركات</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">التوتوريالات المربوطة بالطالب</label>
            <div class="check-list" id="tutorialList">
                @forelse($tutorials as $tutorial)
                    <label class="check-item" data-company-id="{{ $tutorial->companies->pluck('id')->implode(',') }}">
                        <input type="checkbox" name="tutorials[]" value="{{ $tutorial->id }}"
                            @checked(in_array($tutorial->id, old('tutorials', $student->tutorials->pluck('id')->toArray())))>
                        {{ $tutorial->title }}
                    </label>
                @empty
                    <div class="check-list-empty"><i class="fa-solid fa-book-open"></i> لا توجد توتوريالات بعد</div>
                @endforelse
                <div class="check-list-empty" id="noTutorialsMsg" hidden>
                    <i class="fa-solid fa-filter-circle-xmark"></i> لا توجد توتوريالات مرتبطة بهذه الشركة
                </div>
            </div>
            <p class="form-hint">اختر شركة لفلترة التوتوريالات، واختياراتك المخفية تظل محفوظة.</p>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">
                <i class="fa-solid fa-floppy-disk"></i> حفظ التغييرات
            </button>
            <a href="{{ route('admin.students.page') }}" class="btn btn-ghost">
                <i class="fa-solid fa-arrow-right"></i> عودة
            </a>
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
