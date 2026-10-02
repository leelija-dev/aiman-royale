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
        Schema::create('coupon', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->decimal('discount', 5, 2)->default(0.00);
            $table->string('code_type'); // Code types: user, influencer, special_discount
            $table->decimal('minimum_amount', 10, 2)->default(0.00);  // this is for if code type is special discount then minimum amount is required
            $table->string('code_for')->nullable();  //reason for code
            $table->decimal('validity', 5, 2)->default(0.00);  // validity in days
            $table->dateTime('expiry_date')->nullable();  
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon');
    }
};
