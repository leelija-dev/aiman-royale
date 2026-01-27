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
        Schema::table('bills', function (Blueprint $table) {
            // Drop the 'item_count' column
            if (Schema::hasColumn('bills', 'item_count')) {
                $table->dropColumn('item_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            // Recreate the 'item_count' column
            if (!Schema::hasColumn('bills', 'item_count')) {
                $table->integer('item_count')->nullable()->after('id');
            }
        });
    }
};
