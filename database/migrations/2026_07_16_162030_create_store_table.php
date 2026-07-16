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
        Schema::create('store', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('state');
            $table->string('country');
            $table->string('gst_number')->nullable();
            $table->decimal('gst_percentage', 5, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store');
    }
};
