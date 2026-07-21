<?php

use Illuminate\Support\Facades\Route;

it('registers the admin companies page route', function () {
    expect(Route::has('admin.companies.page'))->toBeTrue();
});

it('registers the admin students page route', function () {
    expect(Route::has('admin.students.page'))->toBeTrue();
});
