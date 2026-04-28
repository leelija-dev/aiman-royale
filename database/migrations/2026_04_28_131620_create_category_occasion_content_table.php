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
        Schema::create('category_occasion_content', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete()
                  ->comment('Reference to categories table');
                  
            $table->foreignId('occasion_id')
                  ->constrained('ocassions')
                  ->cascadeOnDelete()
                  ->comment('Reference to occasions table');
                  
            $table->text('content')
                  ->nullable()
                  ->comment('Content for category-occasion combination');
            
            // Add unique constraint to prevent duplicate category-occasion combinations
            $table->unique(['category_id', 'occasion_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_occasion_content');
    }
};
