<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Tutorial;
use Illuminate\Support\Facades\Route;

 
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});


Route::get('/dashboard', function () {
    $companies = \App\Models\Company::with(['tutorials' => function ($query) {
        $query->with('category');
    }])->orderBy('name')->get();

    return view('dashboard', [
        'companies' => $companies,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tutorials', function () {
    $categories = \App\Models\Category::all();
    $company    = request('company') ? \App\Models\Company::findOrFail(request('company')) : null;

    $tutorialsQuery = Tutorial::with('category');

    if ($company) {
        $tutorialsQuery->whereHas('companies', function ($query) use ($company) {
            $query->where('companies.id', $company->id);
        });
    }

    $tutorials = $tutorialsQuery->get();

    return view('tutorials', compact('categories', 'tutorials', 'company'));
})->middleware(['auth', 'verified'])->name('tutorials');

Route::get('/tutorials/{tutorial}', [LessonController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('tutorials.show');

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                              [AdminController::class, 'index'])->name('index');
    Route::get('/tutorials',                     [AdminController::class, 'tutorialsPage'])->name('tutorials.page');
    Route::get('/tutorials/create',              [AdminController::class, 'tutorialsCreate'])->name('tutorials.create');
    Route::get('/categories',                    [AdminController::class, 'categoriesPage'])->name('categories.page');
    Route::get('/users',                         [AdminController::class, 'usersPage'])->name('users.page');
    Route::get('/students',                      [AdminController::class, 'studentsPage'])->name('students.page');
    Route::get('/students/create',               [AdminController::class, 'studentsCreate'])->name('students.create');
    Route::post('/students',                     [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/users/{user}/edit',             [AdminController::class, 'editUser'])->name('users.edit');
    Route::post('/tutorials',                    [AdminController::class, 'storeTutorial'])->name('tutorials.store');
    Route::put('/tutorials/{tutorial}',          [AdminController::class, 'updateTutorial'])->name('tutorials.update');
    Route::delete('/tutorials/{tutorial}/cover', [AdminController::class, 'destroyTutorialCover'])->name('tutorials.cover.destroy');
    Route::delete('/tutorials/{tutorial}',       [AdminController::class, 'destroyTutorial'])->name('tutorials.destroy');

    Route::patch('/users/{user}/role',           [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::delete('/users/{user}',               [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/companies',                     [AdminController::class, 'companiesPage'])->name('companies.page');
    Route::post('/companies',                    [AdminController::class, 'storeCompany'])->name('companies.store');
    Route::put('/companies/{company}',           [AdminController::class, 'updateCompany'])->name('companies.update');
    Route::delete('/companies/{company}/logo',   [AdminController::class, 'destroyCompanyLogo'])->name('companies.logo.destroy');
    Route::delete('/companies/{company}',        [AdminController::class, 'destroyCompany'])->name('companies.destroy');

    // Users management
    Route::post('/users',                         [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}',                   [AdminController::class, 'updateUser'])->name('users.update');

    Route::get('/company-types',                 [AdminController::class, 'companyTypesPage'])->name('company-types.page');
    Route::post('/company-types',                [AdminController::class, 'storeCompanyType'])->name('company-types.store');
    Route::put('/company-types/{companyType}',   [AdminController::class, 'updateCompanyType'])->name('company-types.update');
    Route::delete('/company-types/{companyType}',[AdminController::class, 'destroyCompanyType'])->name('company-types.destroy');

    // Lessons
    Route::get('/tutorials/{tutorial}/lessons',          [LessonController::class, 'index'])->name('lessons.index');
    Route::post('/tutorials/{tutorial}/lessons',         [LessonController::class, 'store'])->name('lessons.store');
    Route::put('/tutorials/{tutorial}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/tutorials/{tutorial}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Enrollment routes
    Route::post('/tutorials/{tutorial}/enroll', [\App\Http\Controllers\TutorialEnrollmentController::class, 'store'])
        ->name('tutorials.enroll');
    Route::delete('/tutorials/{tutorial}/enroll', [\App\Http\Controllers\TutorialEnrollmentController::class, 'destroy'])
        ->name('tutorials.unenroll');
});

require __DIR__.'/auth.php';
