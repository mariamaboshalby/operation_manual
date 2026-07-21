<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
        });

        DB::table('company_types')->insert([
            ['name' => 'شركة', 'slug' => 'company'],
            ['name' => 'مطعم', 'slug' => 'restaurant'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('company_types');
    }
};
