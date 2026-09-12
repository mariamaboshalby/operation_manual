<?php

use App\Http\Controllers\AdminCertificateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LessonCompletionController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Tutorial;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

// ── Public ───────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome', [
        'stats' => [
            'companies' => \App\Models\Company::query()->count(),
            'tutorials' => Tutorial::query()->count(),
            'lessons'   => \App\Models\Lesson::query()->count(),
            'students'  => \App\Models\User::query()->where('role', 'student')->count(),
        ],
        'categories' => Category::query()->withCount('tutorials')->orderBy('name')->get(),
    ]);
})->name('welcome');

// Public certificate verification — no login required
Route::get('/certificates/verify/{certificateNumber}', [CertificateController::class, 'verify'])
    ->name('certificates.verify');

// ── Authenticated ─────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard — admins → /admin, students → /tutorials, users → company dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.index');
        }

        if ($user->isStudent()) {
            return redirect()->route('tutorials');
        }

        $companies = \App\Models\Company::with(['companyType', 'tutorials' => function ($q) {
            $q->with('category');
        }])->orderBy('name')->get();

        return view('dashboard', ['companies' => $companies]);
    })->name('dashboard');

    // Tutorials list
    Route::get('/tutorials', function () {
        Gate::authorize('viewAny', Tutorial::class);

        $categories = \App\Models\Category::all();
        $company    = request('company') ? \App\Models\Company::findOrFail(request('company')) : null;
        $user       = auth()->user();

        $tutorialsQuery = Tutorial::with('category');

        if ($company) {
            $tutorialsQuery->whereHas('companies', function ($q) use ($company) {
                $q->where('companies.id', $company->id);
            });
        }

        if ($user->isStudent()) {
            $tutorialsQuery->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        $tutorials = $tutorialsQuery->get();

        return view('tutorials', compact('categories', 'tutorials', 'company'));
    })->name('tutorials');

    // Individual tutorial / course page
    Route::get('/tutorials/{tutorial}', [LessonController::class, 'show'])->name('tutorials.show');

    // Lesson completion
    Route::post('/lessons/{lesson}/complete', [LessonCompletionController::class, 'store'])
        ->name('lessons.complete');

    // User certificates
    Route::get('/certificates',              [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{certificate}',[CertificateController::class, 'show'])->name('certificates.show');

    // Profile management
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Enrollment — students are blocked inside the controller
    Route::post('/tutorials/{tutorial}/enroll',
        [\App\Http\Controllers\TutorialEnrollmentController::class, 'store'])
        ->name('tutorials.enroll');
    Route::delete('/tutorials/{tutorial}/enroll',
        [\App\Http\Controllers\TutorialEnrollmentController::class, 'destroy'])
        ->name('tutorials.unenroll');
});

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Tutorials
    Route::get('/tutorials',                     [AdminController::class, 'tutorialsPage'])->name('tutorials.page');
    Route::get('/tutorials/create',              [AdminController::class, 'tutorialsCreate'])->name('tutorials.create');
    Route::post('/tutorials',                    [AdminController::class, 'storeTutorial'])->name('tutorials.store');
    Route::put('/tutorials/{tutorial}',          [AdminController::class, 'updateTutorial'])->name('tutorials.update');
    Route::delete('/tutorials/{tutorial}/cover', [AdminController::class, 'destroyTutorialCover'])->name('tutorials.cover.destroy');
    Route::delete('/tutorials/{tutorial}',       [AdminController::class, 'destroyTutorial'])->name('tutorials.destroy');

    // Lessons (nested under tutorial)
    Route::get('/tutorials/{tutorial}/lessons',             [LessonController::class, 'index'])->name('lessons.index');
    Route::post('/tutorials/{tutorial}/lessons',            [LessonController::class, 'store'])->name('lessons.store');
    Route::put('/tutorials/{tutorial}/lessons/{lesson}',    [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/tutorials/{tutorial}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
    Route::post('/tutorials/{tutorial}/lessons/reorder',    [LessonController::class, 'reorder'])->name('lessons.reorder');

    // Categories
    Route::get('/categories',               [AdminController::class, 'categoriesPage'])->name('categories.page');
    Route::post('/categories',              [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}',    [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Companies
    Route::get('/companies',                   [AdminController::class, 'companiesPage'])->name('companies.page');
    Route::post('/companies',                  [AdminController::class, 'storeCompany'])->name('companies.store');
    Route::put('/companies/{company}',         [AdminController::class, 'updateCompany'])->name('companies.update');
    Route::delete('/companies/{company}/logo', [AdminController::class, 'destroyCompanyLogo'])->name('companies.logo.destroy');
    Route::delete('/companies/{company}',      [AdminController::class, 'destroyCompany'])->name('companies.destroy');

    // Company Types
    Route::get('/company-types',                  [AdminController::class, 'companyTypesPage'])->name('company-types.page');
    Route::post('/company-types',                 [AdminController::class, 'storeCompanyType'])->name('company-types.store');
    Route::put('/company-types/{companyType}',    [AdminController::class, 'updateCompanyType'])->name('company-types.update');
    Route::delete('/company-types/{companyType}', [AdminController::class, 'destroyCompanyType'])->name('company-types.destroy');

    // Users (role = user / admin)
    Route::get('/users',               [AdminController::class, 'usersPage'])->name('users.page');
    Route::post('/users',              [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit',   [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}',        [AdminController::class, 'updateUser'])->name('users.update');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::delete('/users/{user}',     [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Students (dedicated flow)
    Route::get('/students',                [AdminController::class, 'studentsPage'])->name('students.page');
    Route::get('/students/create',         [AdminController::class, 'studentsCreate'])->name('students.create');
    Route::post('/students',               [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{student}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{student}',      [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{student}',   [AdminController::class, 'destroyStudent'])->name('students.destroy');

    // Certificates
    Route::get('/certificates',                              [AdminCertificateController::class, 'index'])->name('certificates.page');
    Route::get('/certificates/{certificate}',                [AdminCertificateController::class, 'show'])->name('certificates.show');
    Route::patch('/certificates/{certificate}/revoke',       [AdminCertificateController::class, 'revoke'])->name('certificates.revoke');
    Route::patch('/certificates/{certificate}/restore',      [AdminCertificateController::class, 'restore'])->name('certificates.restore');
});

require __DIR__.'/auth.php';
