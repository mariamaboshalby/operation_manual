<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('emoji')->nullable();
            $table->string('thumb_class')->default('thumb-coffee');
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->string('duration')->nullable();
            $table->unsignedInteger('steps')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutorials');
    }
};
