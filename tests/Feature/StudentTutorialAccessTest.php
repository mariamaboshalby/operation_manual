<?php

use App\Models\Category;
use App\Models\Company;
use App\Models\Tutorial;
use App\Models\User;

it('shows only tutorials assigned to a student for the selected company', function () {
    $category = Category::create([
        'name' => 'Coffee Basics',
        'slug' => 'coffee-basics',
    ]);

    $company = Company::create([
        'name' => 'Company One',
        'company_type_id' => \App\Models\CompanyType::where('slug', 'company')->value('id'),
    ]);

    $accessibleTutorial = Tutorial::create([
        'category_id' => $category->id,
        'title' => 'Intro to Espresso',
        'description' => 'Intro',
        'level' => 'beginner',
        'duration' => '10 mins',
        'steps' => 1,
    ]);

    $blockedTutorial = Tutorial::create([
        'category_id' => $category->id,
        'title' => 'Advanced Latte Art',
        'description' => 'Advanced',
        'level' => 'advanced',
        'duration' => '20 mins',
        'steps' => 2,
    ]);

    $accessibleTutorial->companies()->sync([$company->id]);
    $blockedTutorial->companies()->sync([$company->id]);

    $student = User::factory()->create(['role' => 'student']);
    $student->tutorials()->sync([$accessibleTutorial->id]);

    $response = $this->actingAs($student)->get(route('tutorials', ['company' => $company->id]));

    $response->assertOk();
    $response->assertSee($accessibleTutorial->title);
    $response->assertDontSee($blockedTutorial->title);
});
