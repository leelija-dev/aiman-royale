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
        Schema::create('offer', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('discount', 5, 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('duration')->default(0);
            $table->string('apply_on');
            $table->boolean('is_timer');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer');
    }
};
