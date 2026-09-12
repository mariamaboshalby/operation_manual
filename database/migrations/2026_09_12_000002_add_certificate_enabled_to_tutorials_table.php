<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Guard: only add the column if it does not already exist
        if (!Schema::hasColumn('tutorials', 'certificate_enabled')) {
            Schema::table('tutorials', function (Blueprint $table) {
                $table->boolean('certificate_enabled')->default(false)->after('steps');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tutorials', 'certificate_enabled')) {
            Schema::table('tutorials', function (Blueprint $table) {
                $table->dropColumn('certificate_enabled');
            });
        }
    }
};
