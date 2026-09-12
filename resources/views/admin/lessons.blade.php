@extends('admin.layout')
@section('page-title', 'دروس: ' . $tutorial->title)
@section('breadcrumb', 'دروس: ' . $tutorial->title)

@section('content')
<div class="page-header">
    <div>
        <h2><i class="fa-solid fa-list-check" style="color:#7c3aed;margin-left:.4rem;"></i> دروس: {{ $tutorial->title }}</h2>
        <div style="font-size:.82rem;color:#64748b;margin-top:.3rem;">
            <span class="badge badge-{{ $tutorial->level }}">{{ ['beginner'=>'مبتدئ','intermediate'=>'متوسط','advanced'=>'متقدم'][$tutorial->level] }}</span>
            &nbsp;{{ $tutorial->category->name ?? '' }} &nbsp;·&nbsp; {{ $tutorial->lessons->count() }} درس
        </div>
    </div>
    <div style="display:flex;gap:.6rem;">
        <a href="{{ route('tutorials.show', $tutorial) }}" target="_blank" class="btn btn-ghost btn-sm">
            <i class="fa-solid fa-eye"></i> معاينة
        </a>
        <a href="{{ route('admin.tutorials.page') }}" class="btn btn-ghost">
            <i class="fa-solid fa-arrow-right"></i> رجوع
        </a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:1.2rem;align-items:start;">

    {{-- Lessons List --}}
    <div class="card">
        @if($tutorial->lessons->isEmpty())
        <div class="empty-state">
            <i class="fa-solid fa-book-open"></i>
            <p>لا توجد دروس بعد — أضف أول درس من الجانب</p>
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>عنوان الدرس</th>
                    <th>المدة</th>
                    <th>فيديو</th>
                    <th>الترتيب</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tutorial->lessons as $lesson)
            <tr>
                <td style="color:#94a3b8;font-size:.8rem;">{{ $lesson->id }}</td>
                <td style="font-weight:600;">{{ $lesson->title }}</td>
                <td>
                    @if($lesson->duration_minutes)
                        <span style="font-size:.82rem;color:#64748b;">
                            <i class="fa-solid fa-clock" style="color:#f59e0b;"></i>
                            {{ $lesson->duration_minutes }} د
                        </span>
                    @else
                        <span style="color:#94a3b8;">—</span>
                    @endif
                </td>
                <td>
                    @if($lesson->video_url)
                        <a href="{{ $lesson->video_url }}" target="_blank" class="btn btn-ghost btn-sm">
                            <i class="fa-brands fa-youtube" style="color:#ef4444;"></i>
                        </a>
                    @else
                        <span style="color:#94a3b8;">—</span>
                    @endif
                </td>
                <td>
                    <span style="background:#f1f5f9;padding:.2rem .6rem;border-radius:6px;font-size:.8rem;font-weight:600;">{{ $lesson->order }}</span>
                </td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="openEdit({{ $lesson->id }})">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <form class="inline" method="POST"
                          action="{{ route('admin.lessons.destroy', [$tutorial, $lesson]) }}"
                          onsubmit="return confirm('حذف الدرس؟')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Add Lesson Form --}}
    <div class="card" style="padding:1.2rem;position:sticky;top:80px;">
        <div style="font-weight:700;font-size:.95rem;margin-bottom:1rem;color:#1e293b;">
            <i class="fa-solid fa-plus" style="color:#2563eb;margin-left:.4rem;"></i> إضافة درس جديد
        </div>
        <form method="POST" action="{{ route('admin.lessons.store', $tutorial) }}">
            @csrf
            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:.8rem;font-size:.82rem;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            <div class="form-group">
                <label class="form-label">عنوان الدرس <span style="color:#ef4444">*</span></label>
                <input class="form-control" name="title" placeholder="مثال: مقدمة عن القهوة" required>
            </div>
            <div class="form-group">
                <label class="form-label">المحتوى</label>
                <textarea class="form-control" name="content" rows="4" placeholder="شرح الدرس..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fa-brands fa-youtube" style="color:#ef4444;margin-left:.3rem;"></i> رابط يوتيوب</label>
                <input class="form-control" name="video_url" type="url" placeholder="https://www.youtube.com/watch?v=...">
                <p class="form-hint">فقط روابط YouTube — youtube.com أو youtu.be</p>
            </div>
            <div class="form-group">
                <label class="form-label">المدة (دقائق)</label>
                <input class="form-control" name="duration_minutes" type="number" min="0" placeholder="0">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">
                <i class="fa-solid fa-floppy-disk"></i> إضافة الدرس
            </button>
        </form>
    </div>

</div>

{{-- Edit Modals --}}
@foreach($tutorial->lessons as $lesson)
@push('modals')
<div class="modal-overlay" id="editLesson-{{ $lesson->id }}">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen" style="color:#f59e0b;margin-left:.4rem;"></i> تعديل الدرس</h3>
            <button class="modal-close" onclick="closeModal('editLesson-{{ $lesson->id }}')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.lessons.update', [$tutorial, $lesson]) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">عنوان الدرس</label>
                <input class="form-control" name="title" value="{{ $lesson->title }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">المحتوى</label>
                <textarea class="form-control" name="content" rows="4">{{ $lesson->content }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">رابط يوتيوب</label>
                <input class="form-control" name="video_url" type="url" value="{{ $lesson->video_url }}" placeholder="https://www.youtube.com/watch?v=...">
                <p class="form-hint">فقط روابط YouTube. اتركه فارغًا لإزالة الفيديو.</p>
            </div>
            <div class="grid2">
                <div class="form-group">
                    <label class="form-label">المدة (دقائق)</label>
                    <input class="form-control" name="duration_minutes" type="number" min="0" value="{{ $lesson->duration_minutes }}">
                </div>
                <div class="form-group">
                    <label class="form-label">الترتيب</label>
                    <input class="form-control" name="order" type="number" min="0" value="{{ $lesson->order }}">
                </div>
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end;">
                <button type="button" class="btn btn-ghost" onclick="closeModal('editLesson-{{ $lesson->id }}')">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> حفظ</button>
            </div>
        </form>
    </div>
</div>
@endpush
@endforeach
@endsection

@push('scripts')
<script>
function openEdit(id)    { document.getElementById('editLesson-' + id).classList.add('open'); }
function closeModal(id)  { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) el.classList.remove('open'); });
});
</script>
@endpush
