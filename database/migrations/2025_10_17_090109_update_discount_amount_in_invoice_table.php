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
        // Step 1: Replace all NULL values with 0.00 (to prevent truncation warning)
        DB::table('invoice')->whereNull('discount_amount')->update(['discount_amount' => 0.00]);

        Schema::table('invoice', function (Blueprint $table) {
           $table->decimal('discount_amount', 8, 2)
                  ->default(0.00)
                  ->nullable(false)
                  ->change();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->decimal('discount_amount', 8, 2)
                  ->nullable()
                  ->default(null)
                  ->change();
        
        });
    }
};
