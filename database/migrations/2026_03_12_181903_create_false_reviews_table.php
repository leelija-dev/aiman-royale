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
        Schema::create('false_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reviewer_name')->nullable();
            $table->string('reviewer_email')->nullable();
            $table->integer('rating')->default(5); // 1-5 stars
            $table->text('review_text');
            $table->text('admin_notes')->nullable();
            $table->timestamp('review_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('false_reviews');
    }
};
