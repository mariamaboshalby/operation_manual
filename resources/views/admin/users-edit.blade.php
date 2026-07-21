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
                <option value="">-- اختر الشركة --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">التوتوريالات المربوطة</label>
            <select class="form-control" name="tutorials[]" id="tutorialSelect" multiple size="8">
                @foreach($tutorials as $tutorial)
                    <option value="{{ $tutorial->id }}"
                        data-company-id="{{ $tutorial->companies->pluck('id')->implode(',') }}"
                        @selected(in_array($tutorial->id, old('tutorials', $user->tutorials->pluck('id')->toArray())))>
                        {{ $tutorial->title }}
                    </option>
                @endforeach
            </select>
            <p style="font-size:.82rem;color:#64748b;margin-top:.4rem;">اختر شركة أولًا حتى تظهر التوتوريالات المرتبطة بها.</p>
        </div>

        <button class="btn btn-primary" type="submit">حفظ التغييرات</button>
        <a href="{{ route('admin.users.page') }}" class="btn btn-ghost">عودة</a>
    </form>
</div>
@endsection
