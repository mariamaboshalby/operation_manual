<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('company_type_id')->nullable()->after('name')
                  ->constrained('company_types')->nullOnDelete();
        });

        foreach (DB::table('company_types')->get() as $ct) {
            DB::table('companies')->where('type', $ct->slug)->update(['company_type_id' => $ct->id]);
        }

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('type')->default('company');
        });

        foreach (DB::table('company_types')->get() as $ct) {
            DB::table('companies')->where('company_type_id', $ct->id)->update(['type' => $ct->slug]);
        }

        Schema::table('companies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_type_id');
        });
    }
};
