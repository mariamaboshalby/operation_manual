<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * GET /certificates
     * Show the authenticated user's own certificates.
     */
    public function index(Request $request)
    {
        $certificates = $request->user()
            ->certificates()
            ->with(['tutorial', 'tutorial.category'])
            ->latest('issued_at')
            ->get();

        return view('certificates.index', compact('certificates'));
    }

    /**
     * GET /certificates/{certificate}
     * Show certificate details — owner or admin only.
     */
    public function show(Request $request, Certificate $certificate)
    {
        $user = $request->user();

        // Only the owner or an admin may view certificate details
        if (! $user->isAdmin() && $certificate->user_id !== $user->id) {
            abort(403, 'غير مصرح لك بعرض هذه الشهادة');
        }

        $certificate->load(['user', 'tutorial', 'tutorial.category']);

        return view('certificates.show', compact('certificate'));
    }

    /**
     * GET /certificates/verify/{certificateNumber}
     * Publicly accessible certificate verification page — no login required.
     */
    public function verify(string $certificateNumber)
    {
        $certificate = Certificate::where('certificate_number', $certificateNumber)
            ->with(['user', 'tutorial'])
            ->first();

        if (! $certificate) {
            return view('certificates.verify', ['certificate' => null, 'certificateNumber' => $certificateNumber]);
        }

        return view('certificates.verify', compact('certificate'));
    }
}
