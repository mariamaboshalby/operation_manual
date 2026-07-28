@extends('admin.layout')
@section('page-title', 'الشركات والمطاعم')
@section('breadcrumb', 'الشركات والمطاعم')

@section('content')
<div class="page-header">
    <h2><i class="fa-solid fa-building" style="color:#2563eb;margin-left:.4rem;"></i> الشركات والمطاعم</h2>
    <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('open')">
        <i class="fa-solid fa-plus"></i> إضافة
    </button>
</div>

<div class="toolbar">
    <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="search" placeholder="ابحث بالاسم..." oninput="filterTable()">
    </div>
    <select id="filterType" onchange="filterTable()">
        <option value="">الكل</option>
        @foreach($companyTypes as $type)
            <option value="{{ $type->slug }}">{{ $type->name }}</option>
        @endforeach
    </select>
    <a href="{{ route('admin.company-types.page') }}" class="btn btn-ghost">
        <i class="fa-solid fa-list"></i> إدارة الأنواع
    </a>
</div>

<div class="card">
    <table id="compTable">
        <thead>
            <tr>
                <th>#</th>
                <th>اللوجو</th>
                <th>الاسم</th>
                <th>النوع</th>
                <th>التيوتوريالز</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
        @forelse($companies as $c)
        <tr data-name="{{ strtolower($c->name) }}" data-type="{{ $c->type }}">
            <td style="color:#94a3b8;font-size:.8rem;">{{ $c->id }}</td>
            <td>
                @if($c->logo_url)
                    <img src="{{ $c->logo_url }}" style="width:40px;height:40px;object-fit:cover;border-radius:8px;border:1px solid #e5e9f2;">
                @else
                    <div style="width:40px;height:40px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;border:1px solid #e5e9f2;color:#94a3b8;">
                        <i class="fa-solid fa-{{ $c->type === 'restaurant' ? 'utensils' : 'building' }}"></i>
                    </div>
                @endif
            </td>
            <td style="font-weight:600;">{{ $c->name }}</td>
            <td>
                @php $companyType = $c->companyType; @endphp
                @if($companyType && $companyType->slug === 'restaurant')
                    <span class="badge" style="background:#fef3c7;color:#92400e;">
                        <i class="fa-solid fa-utensils" style="margin-left:.3rem;"></i> {{ $companyType->name }}
                    </span>
                @else
                    <span class="badge" style="background:#e0f2fe;color:#0369a1;">
                        <i class="fa-solid fa-building" style="margin-left:.3rem;"></i> {{ $companyType?->name ?? ($c->type === 'restaurant' ? 'مطعم' : 'شركة') }}
                    </span>
                @endif
            </td>
            <td><span class="badge" style="background:#ede9fe;color:#5b21b6;">{{ $c->tutorials_count }}</span></td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="openEdit({{ $c->id }})">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <form class="inline" method="POST" action="{{ route('admin.companies.destroy', $c) }}"
                      onsubmit="return confirm('حذف الشركة؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">
            <div class="empty-state">
                <i class="fa-solid fa-building"></i>
                <p>لا توجد شركات أو مطاعم</p>
                <button class="btn btn-primary" onclick="document.getElementById('addModal').classList.add('open')">إضافة</button>
            </div>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('modals')
{{-- Add Modal --}}
<div class="modal-overlay" id="addModal">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus" style="margin-left:.4rem;color:#2563eb;"></i> إضافة شركة / مطعم</h3>
            <button class="modal-close" onclick="closeModal('addModal')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.companies.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">الاسم <span style="color:#ef4444">*</span></label>
                    <input class="form-control" name="name" placeholder="اسم الشركة أو المطعم" required>
                </div>
                <div class="form-group">
                    <label class="form-label">النوع <span style="color:#ef4444">*</span></label>
                    <select class="form-control" name="company_type_id" required>
                        @foreach($companyTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-image" style="margin-left:.3rem;color:#7c3aed;"></i> اللوجو</label>
                <div style="border:2px dashed #d1d5db;border-radius:8px;padding:1.2rem;text-align:center;cursor:pointer;background:#fafbff;"
                     onclick="document.getElementById('logoAdd').click()">
                    <i class="fa-solid fa-cloud-arrow-up" style="color:#94a3b8;font-size:1.4rem;display:block;margin-bottom:.3rem;"></i>
                    <span style="font-size:.82rem;color:#64748b;">اختر صورة <span style="color:#2563eb;font-weight:600;">من جهازك</span></span>
                </div>
                <input type="file" id="logoAdd" name="logo" accept="image/*" style="display:none;"
                       onchange="previewLogo(this,'previewAdd')">
                <div id="previewAdd" style="display:none;margin-top:.5rem;text-align:center;">
                    <img style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #e5e9f2;">
                </div>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('addModal')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> إضافة</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modals --}}
@foreach($companies as $c)
<div class="modal-overlay" id="editModal-{{ $c->id }}">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen" style="margin-left:.4rem;color:#f59e0b;"></i> تعديل: {{ $c->name }}</h3>
            <button class="modal-close" onclick="closeModal('editModal-{{ $c->id }}')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.companies.update', $c) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">الاسم</label>
                    <input class="form-control" name="name" value="{{ $c->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">النوع</label>
                    <select class="form-control" name="company_type_id" required>
                        @foreach($companyTypes as $type)
                            <option value="{{ $type->id }}" @selected($c->company_type_id === $type->id)>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fa-solid fa-image" style="margin-left:.3rem;color:#7c3aed;"></i> اللوجو</label>
                @if($c->logo_url)
                <div style="margin-bottom:.6rem;display:flex;align-items:center;gap:.8rem;">
                    <img src="{{ $c->logo_url }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #e5e9f2;">
                    <button type="button" class="btn btn-danger btn-sm"
                            onclick="deleteLogo({{ $c->id }})">
                        <i class="fa-solid fa-trash"></i> حذف اللوجو
                    </button>
                </div>
                @endif
                <div style="border:2px dashed #d1d5db;border-radius:8px;padding:1rem;text-align:center;cursor:pointer;background:#fafbff;"
                     onclick="document.getElementById('logoEdit{{ $c->id }}').click()">
                    <i class="fa-solid fa-cloud-arrow-up" style="color:#94a3b8;font-size:1.2rem;display:block;margin-bottom:.3rem;"></i>
                    <span style="font-size:.82rem;color:#64748b;">{{ $c->logo_url ? 'استبدال اللوجو' : 'رفع لوجو' }}</span>
                </div>
                <input type="file" id="logoEdit{{ $c->id }}" name="logo" accept="image/*" style="display:none;"
                       onchange="previewLogo(this,'previewEdit{{ $c->id }}')">
                <div id="previewEdit{{ $c->id }}" style="display:none;margin-top:.5rem;text-align:center;">
                    <img style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #e5e9f2;">
                </div>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('editModal-{{ $c->id }}')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> حفظ</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete logo form (outside modal to avoid nested forms) --}}
<form id="deleteLogoForm-{{ $c->id }}" method="POST"
      action="{{ route('admin.companies.logo.destroy', $c) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach
@endpush

@push('scripts')
<script>
function filterTable() {
    const search = document.getElementById('search').value.toLowerCase();
    const type   = document.getElementById('filterType').value;
    document.querySelectorAll('#compTable tbody tr[data-name]').forEach(row => {
        const matchName = row.dataset.name.includes(search);
        const matchType = !type || row.dataset.type === type;
        row.style.display = (matchName && matchType) ? '' : 'none';
    });
}
function openEdit(id) { document.getElementById('editModal-' + id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
function deleteLogo(id) {
    if (confirm('حذف اللوجو؟')) {
        document.getElementById('deleteLogoForm-' + id).submit();
    }
}
function previewLogo(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.getElementById(previewId);
            wrap.querySelector('img').src = e.target.result;
            wrap.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('open'); });
});
</script>
@endpush
