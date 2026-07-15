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
        Schema::table('product_parts', function (Blueprint $table) {
            $table->string('work_type')->nullable()->after('fabric');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_parts', function (Blueprint $table) {
            $table->dropColumn('work_type');
        });
    }
};
