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
        Schema::table('faqs', function (Blueprint $table) {
            // Drop the existing foreign key constraint first
            $table->dropForeign(['category_id']);
            
            // Make the column nullable if it's not already
            $table->unsignedBigInteger('category_id')->nullable()->change();
            
            // Add new foreign key constraint to categories table (nullable)
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null'); // Set null when category is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            // Drop the foreign key to categories
            $table->dropForeign(['category_id']);
            
            // Restore the original foreign key to faq_category
            $table->foreign('category_id')
                  ->references('id')
                  ->on('faq_category')
                  ->onDelete('cascade');
        });
    }
};
