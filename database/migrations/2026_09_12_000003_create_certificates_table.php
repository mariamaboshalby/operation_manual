<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tutorial_id')->constrained()->cascadeOnDelete();
            $table->string('certificate_number')->unique();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['valid', 'revoked'])->default('valid');
            $table->timestamps();

            // One certificate per user per tutorial
            $table->unique(['user_id', 'tutorial_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
