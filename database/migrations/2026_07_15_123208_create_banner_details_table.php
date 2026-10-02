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
        Schema::create('banner_details', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('offer')->nullable();
            $table->string('short_description')->nullable();
            $table->string('redirect_link')->nullalble();
            $table->string('position');
            $table->string('image')->nullable();
            $table->string('public_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_details');
    }
};
