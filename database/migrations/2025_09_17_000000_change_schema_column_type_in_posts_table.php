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
        // First, make the column nullable to avoid NOT NULL constraint issues
        Schema::table('posts', function (Blueprint $table) {
            $table->text('schema')->nullable()->change();
        });

        // Then update any existing data if needed
        // For example, if you want to ensure all values are valid JSON:
        // DB::table('posts')->whereNotNull('schema')->update([
        //     'schema' => DB::raw('IF(JSON_VALID(`schema`), `schema`, NULL)')
        // ]);

        // Finally, if you want to make it not nullable again:
        // Schema::table('posts', function (Blueprint $table) {
        //     $table->text('schema')->nullable(false)->change();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First make the column nullable
        Schema::table('posts', function (Blueprint $table) {
            $table->string('schema', 10000)->nullable()->change();
        });

        // Then change it back to string with a large enough length
        // Note: You might need to adjust the length (10000) based on your needs
        Schema::table('posts', function (Blueprint $table) {
            $table->string('schema', 10000)->change();
        });
    }
};
