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
        // Rename table from 'bills' to 'invoice_items'
        if (Schema::hasTable('bills')) {
            Schema::rename('bills', 'invoice_items');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the table name if rolling back
        if (Schema::hasTable('invoice_items')) {
            Schema::rename('invoice_items', 'bills');
        }
    }
};
