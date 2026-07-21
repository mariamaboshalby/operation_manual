<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'categories' => Category::withCount('tutorials')->get(),
            'tutorials'  => Tutorial::with('category')->latest()->get(),
            'users'      => User::latest()->get(),
            'admins'     => User::where('role', 'admin')->latest()->get(),
        ]);
    }

    public function tutorialsPage()
    {
        return view('admin.tutorials', [
            'tutorials'  => Tutorial::with(['category', 'companies'])->latest()->get(),
            'categories' => Category::all(),
            'companies'  => Company::orderBy('name')->get(),
        ]);
    }

    public function tutorialsCreate()
    {
        return view('admin.tutorials-create', [
            'categories' => Category::all(),
            'companies'  => Company::orderBy('name')->get(),
        ]);
    }

    public function categoriesPage()
    {
        return view('admin.categories', [
            'categories' => Category::withCount('tutorials')->get(),
        ]);
    }

    public function usersPage()
    {
        return view('admin.users', [
            'users'  => User::where('role', 'user')->latest()->get(),
            'admins' => User::where('role', 'admin')->latest()->get(),
        ]);
    }

    public function studentsPage()
    {
        return view('admin.students', [
            'students'  => User::where('role', 'student')->latest()->get(),
            'tutorials' => Tutorial::orderBy('title')->get(),
            'companies' => Company::orderBy('name')->get(),
        ]);
    }

    public function studentsCreate()
    {
        return view('admin.students-create', [
            'companies' => Company::orderBy('name')->get(),
            'tutorials' => Tutorial::orderBy('title')->get(),
        ]);
    }

    // ── Categories ──────────────────────────────────────────────
    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'emoji' => 'nullable|string|max:10',
        ]);
        $data['slug'] = Str::slug($data['name']);
        Category::create($data);
        return back()->with('success', 'تم إضافة الكاتيجوري');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'emoji' => 'nullable|string|max:10',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return back()->with('success', 'تم تعديل الكاتيجوري');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'تم حذف الكاتيجوري');
    }

    // ── Tutorials ────────────────────────────────────────────────
    public function storeTutorial(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
            'cover'       => 'nullable|image|max:2048',
            'thumb_class' => 'nullable|string|max:50',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'duration'    => 'nullable|string|max:50',
            'steps'       => 'nullable|integer|min:0',
            'company_id'  => 'required|exists:companies,id',
        ]);

        $tutorial = Tutorial::create($request->except(['cover', 'company_id']));

        if ($request->hasFile('cover')) {
            $tutorial->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        if ($request->filled('company_id')) {
            $tutorial->companies()->sync([$request->company_id]);
        }

        return redirect()->route('admin.tutorials.page')->with('success', 'تم إضافة التيوتوريال');
    }

    public function updateTutorial(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
            'cover'       => 'nullable|image|max:2048',
            'thumb_class' => 'nullable|string|max:50',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'duration'    => 'nullable|string|max:50',
            'steps'       => 'nullable|integer|min:0',
            'company_id'  => 'required|exists:companies,id',
        ]);

        $tutorial->update($request->except(['cover', 'company_id']));

        if ($request->hasFile('cover')) {
            $tutorial->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        $tutorial->companies()->sync([$request->company_id]);

        return back()->with('success', 'تم تعديل التيوتوريال');
    }

    public function destroyTutorialCover(Tutorial $tutorial)
    {
        $tutorial->clearMediaCollection('cover');
        return back()->with('success', 'تم حذف الصورة');
    }

    public function destroyTutorial(Tutorial $tutorial)
    {
        $tutorial->delete();
        return back()->with('success', 'تم حذف التيوتوريال');
    }

    // ── Companies ────────────────────────────────────────────────
    public function companiesPage()
    {
        return view('admin.companies', [
            'companies'     => Company::with('tutorials')->withCount('tutorials')->latest()->get(),
            'tutorials'     => Tutorial::orderBy('title')->get(),
            'companyTypes' => CompanyType::orderBy('name')->get(),
        ]);
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'type' => 'required|exists:company_types,slug',
            'logo' => 'nullable|image|max:2048',
        ]);
        $company = Company::create($request->only('name', 'type'));
        if ($request->hasFile('logo')) {
            $company->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        return back()->with('success', 'تم إضافة الشركة');
    }

    public function updateCompany(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'type' => 'required|exists:company_types,slug',
            'logo' => 'nullable|image|max:2048',
        ]);
        $company->update($request->only('name', 'type'));
        if ($request->hasFile('logo')) {
            $company->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        return back()->with('success', 'تم تعديل الشركة');
    }

    public function destroyCompanyLogo(Company $company)
    {
        $company->clearMediaCollection('logo');
        return back()->with('success', 'تم حذف اللوجو');
    }

    public function destroyCompany(Company $company)
    {
        $company->delete();
        return back()->with('success', 'تم حذف الشركة');
    }

    // ── Users: create ─────────────────────────────────────────────
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'role'  => 'nullable|in:user,admin,student',
            'tutorials' => 'nullable|array',
            'tutorials.*' => 'exists:tutorials,id',
        ]);

        $password = Str::random(10);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? 'user',
            'password' => bcrypt($password),
        ]);

        if (!empty($data['tutorials'])) {
            $user->tutorials()->sync($data['tutorials']);
        }

        return back()->with('success', 'تم إضافة المستخدم');
    }

    public function editUser(User $user)
    {
        return view('admin.users-edit', [
            'user' => $user->load('tutorials'),
            'tutorials' => Tutorial::orderBy('title')->get(),
            'companies' => Company::orderBy('name')->get(),
        ]);
    }

    public function storeStudent(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'tutorials' => 'nullable|array',
            'tutorials.*' => 'exists:tutorials,id',
        ]);

        $student = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'student',
            'password' => bcrypt($data['password']),
        ]);

        if (!empty($data['tutorials'])) {
            $student->tutorials()->sync($data['tutorials']);
        }

        return redirect()->route('admin.students.page')->with('success', 'تم إضافة الطالب');
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:150',
            'email' => ['required','email', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'  => 'nullable|in:user,admin,student',
            'tutorials' => 'nullable|array',
            'tutorials.*' => 'exists:tutorials,id',
        ]);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? 'user',
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = bcrypt($data['password']);
        }

        $user->update($updateData);

        $user->tutorials()->sync($data['tutorials'] ?? []);

        return redirect()->route('admin.users.page')->with('success', 'تم تعديل المستخدم');
    }

    // ── Company Types ────────────────────────────────────────────
    public function companyTypesPage()
    {
        return view('admin.company-types', [
            'companyTypes' => CompanyType::withCount('companies')->orderBy('name')->get(),
        ]);
    }

    public function storeCompanyType(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $slug = Str::slug($data['name']);
        $request->merge(['slug' => $slug]);
        $request->validate([
            'slug' => ['required', 'string', 'max:100', Rule::unique('company_types', 'slug')],
        ]);

        $data['slug'] = $slug;
        CompanyType::create($data);

        return back()->with('success', 'تم إضافة نوع الشركة');
    }

    public function updateCompanyType(Request $request, CompanyType $companyType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $slug = Str::slug($data['name']);
        $request->merge(['slug' => $slug]);
        $request->validate([
            'slug' => ['required', 'string', 'max:100', Rule::unique('company_types', 'slug')->ignore($companyType->id)],
        ]);

        $companyType->update([
            'name' => $data['name'],
            'slug' => $slug,
        ]);

        return back()->with('success', 'تم تعديل نوع الشركة');
    }

    public function destroyCompanyType(CompanyType $companyType)
    {
        if ($companyType->companies()->exists()) {
            return back()->with('error', 'لا يمكن حذف هذا النوع لأن هناك شركات تستخدمه');
        }

        $companyType->delete();
        return back()->with('success', 'تم حذف نوع الشركة');
    }

    // ── Users ────────────────────────────────────────────────────
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:user,admin,student']);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك تغيير رولك بنفسك');
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', 'تم تغيير الرول');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف نفسك');
        }

        $user->delete();
        return back()->with('success', 'تم حذف المستخدم');
    }
}
