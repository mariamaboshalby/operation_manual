<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_tutorial', function (Blueprint $table) {
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tutorial_id')->constrained()->cascadeOnDelete();
            $table->primary(['company_id', 'tutorial_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_tutorial');
    }
};
