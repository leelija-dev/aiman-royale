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
        Schema::create('product_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('part_name'); // e.g., "Lehenga", "Choli", "Dupatta", "Blouse", "Pallu"
            $table->string('fabric')->nullable();
            $table->string('color')->nullable();
            $table->string('pattern')->nullable();
            $table->string('embroidery')->nullable();
            $table->string('lining')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0); // For ordering parts
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_parts');
    }
};
