@extends('admin.layout')
@section('page-title', 'أنواع الشركات')
@section('breadcrumb', 'أنواع الشركات')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-list" style="color:#2563eb;margin-left:.4rem;"></i> أنواع الشركات</h2>
    <button class="btn btn-primary" onclick="document.getElementById('addTypeModal').classList.add('open')">
        <i class="fa-solid fa-plus"></i> إضافة نوع
    </button>
</div>

<div class="toolbar">
    <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="searchType" placeholder="ابحث بالاسم أو القيمة..." oninput="filterTable()">
    </div>
</div>

<div class="card">
    <table id="typesTable">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>القيمة</th>
                <th>الشركات</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
        @forelse($companyTypes as $type)
        <tr data-name="{{ strtolower($type->name) }}" data-slug="{{ strtolower($type->slug) }}">
            <td style="color:#94a3b8;font-size:.8rem;">{{ $type->id }}</td>
            <td style="font-weight:600;">{{ $type->name }}</td>
            <td style="direction:ltr;text-align:left;font-size:.82rem;color:#64748b;font-family:monospace;">{{ $type->slug }}</td>
            <td><span class="badge" style="background:#ede9fe;color:#5b21b6;">{{ $type->companies_count }}</span></td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="openEditType({{ $type->id }})">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <form class="inline" method="POST" action="{{ route('admin.company-types.destroy', $type) }}"
                      onsubmit="return confirm('حذف نوع الشركة؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">
            <div class="empty-state">
                <i class="fa-solid fa-list"></i>
                <p>لا توجد أنواع شركة</p>
                <button class="btn btn-primary" onclick="document.getElementById('addTypeModal').classList.add('open')">إضافة نوع</button>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('modals')
{{-- Add Modal --}}
<div class="modal-overlay" id="addTypeModal">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus" style="margin-left:.4rem;color:#2563eb;"></i> إضافة نوع جديد</h3>
            <button class="modal-close" onclick="closeModal('addTypeModal')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.company-types.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">الاسم <span style="color:#ef4444">*</span></label>
                <input class="form-control" name="name" placeholder="اسم النوع" required>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('addTypeModal')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> إضافة</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modals --}}
@foreach($companyTypes as $type)
<div class="modal-overlay" id="editType-{{ $type->id }}">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen" style="margin-left:.4rem;color:#f59e0b;"></i> تعديل النوع</h3>
            <button class="modal-close" onclick="closeModal('editType-{{ $type->id }}')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.company-types.update', $type) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">الاسم</label>
                <input class="form-control" name="name" value="{{ $type->name }}" required>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('editType-{{ $type->id }}')">إلغاء</button>
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
    const query = document.getElementById('searchType').value.toLowerCase();
    document.querySelectorAll('#typesTable tbody tr[data-name]').forEach(row => {
        const name = row.dataset.name;
        const slug = row.dataset.slug;
        row.style.display = (name.includes(query) || slug.includes(query)) ? '' : 'none';
    });
}

function openEditType(id) { document.getElementById('editType-' + id).classList.add('open'); }
function closeModal(id)   { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('open'); });
});
</script>
@endpush
