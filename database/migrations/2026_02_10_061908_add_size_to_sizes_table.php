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
        Schema::table('sizes', function (Blueprint $table) {
            $table->decimal('chest_size', 5, 2)->nullable()->after('code');
            $table->decimal('neck_size', 5, 2)->nullable()->after('chest_size');
            $table->decimal('waist_size', 5, 2)->nullable()->after('neck_size');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->dropColumn('chest_size');
            $table->dropColumn('neck_size');
            $table->dropColumn('waist_size');
        });
    }
};
