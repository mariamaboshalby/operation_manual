@extends('admin.layout')
@section('page-title', 'التيوتوريالز')
@section('breadcrumb', 'التيوتوريالز')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-book-open" style="color:#7c3aed;margin-left:.4rem;"></i> التيوتوريالز</h2>
    <a href="{{ route('admin.tutorials.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> إضافة تيوتوريال
    </a>
</div>

<div class="toolbar">
    <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="search" placeholder="ابحث بالعنوان..." oninput="filterTable()">
    </div>
    <select id="filterCat" onchange="filterTable()">
        <option value="">كل الكاتيجوريز</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->name }}">{{ $cat->emoji }} {{ $cat->name }}</option>
        @endforeach
    </select>
    <select id="filterLevel" onchange="filterTable()">
        <option value="">كل المستويات</option>
        <option value="beginner">مبتدئ</option>
        <option value="intermediate">متوسط</option>
        <option value="advanced">متقدم</option>
    </select>
</div>

<div class="card">
    <table id="tutTable">
        <thead>
            <tr>
                <th>#</th>
                <th>الصورة</th>
                <th>العنوان</th>
                <th>الكاتيجوري</th>
                <th>المستوى</th>
                <th>المدة</th>
                <th>الخطوات</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tutorials as $t)
        <tr data-title="{{ strtolower($t->title) }}" data-cat="{{ $t->category->name ?? '' }}" data-level="{{ $t->level }}">
            <td style="color:#94a3b8;font-size:.8rem;">{{ $t->id }}</td>
            <td>
                @if($t->cover_url)
                    <img src="{{ $t->cover_url }}" style="width:56px;height:40px;object-fit:cover;border-radius:6px;border:1px solid #e5e9f2;">
                @else
                    <div style="width:56px;height:40px;background:#f1f5f9;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:.75rem;border:1px solid #e5e9f2;">
                        <i class="fa-solid fa-image"></i>
                    </div>
                @endif
            </td>
            <td style="font-weight:600;">{{ $t->title }}</td>
            <td>{{ $t->category->name ?? '-' }}</td>
            <td><span class="badge badge-{{ $t->level }}">
                {{ ['beginner'=>'مبتدئ','intermediate'=>'متوسط','advanced'=>'متقدم'][$t->level] ?? $t->level }}
            </span></td>
            <td>{{ $t->duration ?? '-' }}</td>
            <td>{{ $t->steps }}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="openEditTutorial({{ $t->id }})">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <a href="{{ route('admin.lessons.index', $t) }}" class="btn btn-accent btn-sm" title="الدروس">
                    <i class="fa-solid fa-list-check"></i>
                </a>
                <form class="inline" method="POST" action="{{ route('admin.tutorials.destroy', $t) }}"
                      onsubmit="return confirm('حذف التيوتوريال؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="8">
            <div class="empty-state">
                <i class="fa-solid fa-box-open"></i>
                <p>لا توجد تيوتوريالز</p>
                <a href="{{ route('admin.tutorials.create') }}" class="btn btn-primary">إضافة تيوتوريال</a>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Edit Modals --}}
@foreach($tutorials as $t)
@push('modals')
<div class="modal-overlay" id="editModal-{{ $t->id }}">
    <div class="modal" style="max-width:580px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen" style="margin-left:.4rem;color:#f59e0b;"></i> تعديل التيوتوريال</h3>
            <button class="modal-close" onclick="closeModal('editModal-{{ $t->id }}')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.tutorials.update', $t) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">العنوان</label>
                    <input class="form-control" name="title" value="{{ $t->title }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">الكاتيجوري</label>
                    <select class="form-control" name="category_id" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected($cat->id == $t->category_id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-building" style="margin-left:.3rem;color:#2563eb;"></i> الشركة / المطعم <span style="color:#ef4444">*</span></label>
                <select class="form-control" name="company_id" required>
                    <option value="">اختر شركة أو مطعم</option>
                    @foreach($companies as $co)
                        <option value="{{ $co->id }}" @selected($t->companies->contains($co->id))>{{ $co->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">الوصف</label>
                <textarea class="form-control" name="description" rows="2">{{ $t->description }}</textarea>
            </div>

            {{-- Cover Image --}}
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-image" style="margin-left:.3rem;color:#7c3aed;"></i> صورة الغلاف</label>

                @if($t->cover_url)
                <div style="margin-bottom:.6rem;position:relative;display:inline-block;">
                    <img src="{{ $t->cover_url }}" style="width:120px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #e5e9f2;">
                    <button type="button"
                        style="position:absolute;top:-6px;left:-6px;background:#ef4444;color:#fff;border:none;border-radius:50%;width:22px;height:22px;cursor:pointer;font-size:.7rem;display:flex;align-items:center;justify-content:center;"
                        onclick="deleteCover({{ $t->id }})">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <p style="font-size:.78rem;color:#64748b;margin-bottom:.4rem;">رفع صورة جديدة سيستبدل الحالية</p>
                @endif

                <div style="border:2px dashed #d1d5db;border-radius:8px;padding:1rem;text-align:center;cursor:pointer;background:#fafbff;"
                     onclick="document.getElementById('coverEdit{{ $t->id }}').click()">
                    <i class="fa-solid fa-cloud-arrow-up" style="color:#94a3b8;margin-bottom:.3rem;display:block;"></i>
                    <span style="font-size:.82rem;color:#64748b;">اختر صورة <span style="color:#2563eb;font-weight:600;">من جهازك</span></span>
                </div>
                <input type="file" id="coverEdit{{ $t->id }}" name="cover" accept="image/*" style="display:none;"
                       onchange="previewEdit(this, {{ $t->id }})">
                <div id="previewEdit{{ $t->id }}" style="display:none;margin-top:.5rem;">
                    <img id="previewEditImg{{ $t->id }}" src="" style="width:100%;max-height:150px;object-fit:cover;border-radius:8px;border:1px solid #e5e9f2;">
                </div>
            </div>

            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">Thumb Class</label>
                    <input class="form-control" name="thumb_class" value="{{ $t->thumb_class }}">
                </div>
                <div class="form-group">
                    <label class="form-label">المستوى</label>
                    <select class="form-control" name="level">
                        @foreach(['beginner'=>'مبتدئ','intermediate'=>'متوسط','advanced'=>'متقدم'] as $val=>$label)
                            <option value="{{ $val }}" @selected($t->level == $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">المدة</label>
                    <input class="form-control" name="duration" value="{{ $t->duration }}">
                </div>
                <div class="form-group">
                    <label class="form-label">عدد الخطوات</label>
                    <input class="form-control" name="steps" type="number" min="0" value="{{ $t->steps }}">
                </div>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('editModal-{{ $t->id }}')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> حفظ</button>
            </div>
        </form>
    </div>
</div>
{{-- Cover delete form outside modal --}}
<form id="deleteCoverForm-{{ $t->id }}" method="POST"
      action="{{ route('admin.tutorials.cover.destroy', $t) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endpush
@endforeach
@endsection

@push('scripts')
<script>
function filterTable() {
    const search = document.getElementById('search').value.toLowerCase();
    const cat    = document.getElementById('filterCat').value;
    const level  = document.getElementById('filterLevel').value;
    document.querySelectorAll('#tutTable tbody tr[data-title]').forEach(row => {
        const matchSearch = row.dataset.title.includes(search);
        const matchCat    = !cat   || row.dataset.cat   === cat;
        const matchLevel  = !level || row.dataset.level === level;
        row.style.display = (matchSearch && matchCat && matchLevel) ? '' : 'none';
    });
}
function openEditTutorial(id) {
    document.getElementById('editModal-' + id).classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}
function deleteCover(id) {
    if (confirm('حذف الصورة؟')) {
        document.getElementById('deleteCoverForm-' + id).submit();
    }
}
function previewEdit(input, id) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewEditImg' + id).src = e.target.result;
            document.getElementById('previewEdit' + id).style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
});
</script>
@endpush
