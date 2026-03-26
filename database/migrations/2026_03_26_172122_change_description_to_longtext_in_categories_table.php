<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL
        Schema::table('categories', function (Blueprint $table) {
            // $table->longText('description')->change();
            $table->longText('description')->nullable()->change();
        });

        // Alternative: Using raw SQL (if the above doesn't work)
        // DB::statement('ALTER TABLE categories MODIFY description LONGTEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change back to TEXT (or whatever it was before)
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->change();
        });

        // Alternative: Using raw SQL
        // DB::statement('ALTER TABLE categories MODIFY description TEXT');
    }
};
