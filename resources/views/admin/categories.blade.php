@extends('admin.layout')
@section('page-title', 'الكاتيجوريز')
@section('breadcrumb', 'الكاتيجوريز')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-tags" style="color:#d97706;margin-left:.4rem;"></i> الكاتيجوريز</h2>
    <button class="btn btn-primary" onclick="document.getElementById('addCatModal').classList.add('open')">
        <i class="fa-solid fa-plus"></i> إضافة كاتيجوري
    </button>
</div>

<div class="toolbar">
    <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="searchCat" placeholder="ابحث بالاسم أو السلاج..." oninput="filterTable()">
    </div>
</div>

<div class="card">
    <table id="categoriesTable">
        <thead>
            <tr>
                <th>#</th>
                <th>الإيموجي</th>
                <th>الاسم</th>
                <th>Slug</th>
                <th>التيوتوريالز</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $cat)
        <tr data-name="{{ strtolower($cat->name) }}" data-slug="{{ strtolower($cat->slug) }}">
            <td style="color:#94a3b8;font-size:.8rem;">{{ $cat->id }}</td>
            <td style="font-size:1.3rem;">{{ $cat->emoji }}</td>
            <td style="font-weight:600;">{{ $cat->name }}</td>
            <td style="direction:ltr;text-align:left;font-size:.82rem;color:#64748b;font-family:monospace;">{{ $cat->slug }}</td>
            <td>
                <span class="badge" style="background:#ede9fe;color:#5b21b6;">{{ $cat->tutorials_count }}</span>
            </td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="openEditCat({{ $cat->id }})">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <form class="inline" method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                      onsubmit="return confirm('حذف الكاتيجوري؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">
            <div class="empty-state">
                <i class="fa-solid fa-tags"></i>
                <p>لا توجد كاتيجوريز</p>
                <button class="btn btn-primary" onclick="document.getElementById('addCatModal').classList.add('open')">إضافة كاتيجوري</button>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('modals')
{{-- Add Modal --}}
<div class="modal-overlay" id="addCatModal">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus" style="margin-left:.4rem;color:#2563eb;"></i> إضافة كاتيجوري</h3>
            <button class="modal-close" onclick="closeModal('addCatModal')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">الاسم <span style="color:#ef4444">*</span></label>
                    <input class="form-control" name="name" placeholder="اسم الكاتيجوري" required>
                </div>
                <div class="form-group">
                    <label class="form-label">إيموجي</label>
                    <input class="form-control" name="emoji" placeholder="📂">
                </div>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('addCatModal')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> إضافة</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modals --}}
@foreach($categories as $cat)
<div class="modal-overlay" id="editCat-{{ $cat->id }}">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen" style="margin-left:.4rem;color:#f59e0b;"></i> تعديل الكاتيجوري</h3>
            <button class="modal-close" onclick="closeModal('editCat-{{ $cat->id }}')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.categories.update', $cat) }}">
            @csrf @method('PUT')
            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">الاسم</label>
                    <input class="form-control" name="name" value="{{ $cat->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">إيموجي</label>
                    <input class="form-control" name="emoji" value="{{ $cat->emoji }}">
                </div>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('editCat-{{ $cat->id }}')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> حفظ</button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endpush

@push('scripts')
<script>
function filterTable() {
    const query = document.getElementById('searchCat').value.toLowerCase();
    document.querySelectorAll('#categoriesTable tbody tr[data-name]').forEach(row => {
        const name = row.dataset.name;
        const slug = row.dataset.slug;
        row.style.display = (name.includes(query) || slug.includes(query)) ? '' : 'none';
    });
}

function openEditCat(id) { document.getElementById('editCat-' + id).classList.add('open'); }
function closeModal(id)   { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('open'); });
});
</script>
@endpush
