@extends('admin.layout')
@section('page-title', 'إضافة تيوتوريال')
@section('breadcrumb', 'إضافة تيوتوريال')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-plus" style="color:#2563eb;margin-left:.4rem;"></i> إضافة تيوتوريال جديد</h2>
    <a href="{{ route('admin.tutorials.page') }}" class="btn btn-ghost">
        <i class="fa-solid fa-arrow-right"></i> رجوع
    </a>
</div>

<div class="card" style="padding:1.5rem;max-width:700px;">
    <form method="POST" action="{{ route('admin.tutorials.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid2">
            <div class="form-group">
                <label class="form-label">العنوان <span style="color:#ef4444">*</span></label>
                <input class="form-control" name="title" placeholder="عنوان التيوتوريال" required value="{{ old('title') }}">
                @error('title')<span style="color:#ef4444;font-size:.78rem;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">الكاتيجوري <span style="color:#ef4444">*</span></label>
                <select class="form-control" name="category_id" required>
                    <option value="">اختر كاتيجوري</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->emoji }} {{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<span style="color:#ef4444;font-size:.78rem;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">الوصف <span style="color:#ef4444">*</span></label>
            <textarea class="form-control" name="description" rows="3" placeholder="وصف التيوتوريال" required>{{ old('description') }}</textarea>
            @error('description')<span style="color:#ef4444;font-size:.78rem;">{{ $message }}</span>@enderror
        </div>

        {{-- Cover Image --}}
        <div class="form-group">
            <label class="form-label"><i class="fa-solid fa-image" style="margin-left:.3rem;color:#7c3aed;"></i> صورة الغلاف</label>
            <div id="dropzone" onclick="document.getElementById('coverInput').click()"
                style="border:2px dashed #d1d5db;border-radius:10px;padding:2rem;text-align:center;cursor:pointer;transition:border-color .2s;background:#fafbff;">
                <i class="fa-solid fa-cloud-arrow-up" style="font-size:2rem;color:#94a3b8;display:block;margin-bottom:.5rem;"></i>
                <p style="color:#64748b;font-size:.88rem;">اسحب الصورة هنا أو <span style="color:#2563eb;font-weight:600;">اختر من جهازك</span></p>
                <p style="color:#94a3b8;font-size:.78rem;margin-top:.3rem;">PNG, JPG, WEBP — حد أقصى 2MB</p>
            </div>
            <input type="file" id="coverInput" name="cover" accept="image/*" style="display:none;" onchange="previewImage(this)">
            <div id="preview" style="display:none;margin-top:.8rem;position:relative;display:none;">
                <img id="previewImg" src="" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;border:1px solid #e5e9f2;">
                <button type="button" onclick="clearImage()" style="position:absolute;top:.4rem;left:.4rem;background:#ef4444;color:#fff;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:.8rem;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @error('cover')<span style="color:#ef4444;font-size:.78rem;">{{ $message }}</span>@enderror
        </div>

        <div class="grid2">
            <div class="form-group">
                <label class="form-label">Thumb Class <span style="color:#94a3b8;font-weight:400;">(اختياري)</span></label>
                <input class="form-control" name="thumb_class" placeholder="thumb-coffee" value="{{ old('thumb_class') }}">
            </div>
            <div class="form-group">
                <label class="form-label">المستوى</label>
                <select class="form-control" name="level">
                    <option value="beginner"     @selected(old('level')=='beginner')>مبتدئ</option>
                    <option value="intermediate" @selected(old('level')=='intermediate')>متوسط</option>
                    <option value="advanced"     @selected(old('level')=='advanced')>متقدم</option>
                </select>
            </div>
        </div>

        <div class="grid2">
            <div class="form-group">
                <label class="form-label">المدة</label>
                <input class="form-control" name="duration" placeholder="مثال: 15 دقيقة" value="{{ old('duration') }}">
            </div>
            <div class="form-group">
                <label class="form-label">عدد الخطوات</label>
                <input class="form-control" name="steps" type="number" min="0" placeholder="0" value="{{ old('steps', 0) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><i class="fa-solid fa-building" style="margin-left:.3rem;color:#2563eb;"></i> الشركة / المطعم <span style="color:#ef4444">*</span></label>
            <select class="form-control" name="company_id" required>
                <option value="">اختر شركة أو مطعم</option>
                @foreach($companies as $co)
                    <option value="{{ $co->id }}" @selected(old('company_id') == $co->id)>
                        {{ $co->name }}
                    </option>
                @endforeach
            </select>
            @error('company_id')<span style="color:#ef4444;font-size:.78rem;">{{ $message }}</span>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> إضافة</button>
            <a href="{{ route('admin.tutorials.page') }}" class="btn btn-ghost">إلغاء</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
            document.getElementById('dropzone').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function clearImage() {
    document.getElementById('coverInput').value = '';
    document.getElementById('preview').style.display = 'none';
    document.getElementById('dropzone').style.display = 'block';
}
const dz = document.getElementById('dropzone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.style.borderColor = '#2563eb'; });
dz.addEventListener('dragleave', () => { dz.style.borderColor = '#d1d5db'; });
dz.addEventListener('drop', e => {
    e.preventDefault();
    dz.style.borderColor = '#d1d5db';
    const file = e.dataTransfer.files[0];
    if (file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('coverInput').files = dt.files;
        previewImage(document.getElementById('coverInput'));
    }
});
</script>
@endpush
