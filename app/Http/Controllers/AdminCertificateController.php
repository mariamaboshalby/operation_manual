<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class AdminCertificateController extends Controller
{
    /**
     * GET /admin/certificates
     * List all certificates with search/filter support.
     */
    public function index(Request $request)
    {
        $query = Certificate::with(['user', 'tutorial'])
            ->latest('issued_at');

        // Filter by student name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        // Filter by certificate number
        if ($request->filled('cert_number')) {
            $query->where('certificate_number', 'like', '%' . $request->cert_number . '%');
        }

        // Filter by tutorial
        if ($request->filled('tutorial_id')) {
            $query->where('tutorial_id', $request->tutorial_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $certificates = $query->paginate(20)->withQueryString();
        $tutorials    = Tutorial::orderBy('title')->get();

        return view('admin.certificates', compact('certificates', 'tutorials'));
    }

    /**
     * GET /admin/certificates/{certificate}
     * View certificate details.
     */
    public function show(Certificate $certificate)
    {
        $certificate->load(['user', 'tutorial', 'tutorial.category']);
        return view('certificates.show', compact('certificate'));
    }

    /**
     * PATCH /admin/certificates/{certificate}/revoke
     * Revoke a valid certificate. Does NOT delete it.
     */
    public function revoke(Certificate $certificate)
    {
        if ($certificate->isRevoked()) {
            return back()->with('error', 'الشهادة محجوبة بالفعل');
        }

        $certificate->update(['status' => 'revoked']);
        return back()->with('success', 'تم إلغاء الشهادة');
    }

    /**
     * PATCH /admin/certificates/{certificate}/restore
     * Restore a revoked certificate.
     */
    public function restore(Certificate $certificate)
    {
        if ($certificate->isValid()) {
            return back()->with('error', 'الشهادة صالحة بالفعل');
        }

        $certificate->update(['status' => 'valid']);
        return back()->with('success', 'تم استعادة الشهادة');
    }
}
