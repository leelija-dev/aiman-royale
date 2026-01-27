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
        // Set auto-increment starting value to 100
        DB::statement('ALTER TABLE shops AUTO_INCREMENT = 100;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally reset back to 1
        DB::statement('ALTER TABLE shops AUTO_INCREMENT = 1;');
    }
};
