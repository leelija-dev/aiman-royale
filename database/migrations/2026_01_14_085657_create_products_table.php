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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('design_no', 40);

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('ocassion_id')->nullable();

            $table->string('name', 200);
            $table->text('description')->nullable();

            $table->string('brand', 100)->nullable();
            $table->string('fabric', 100)->nullable();
            $table->string('fit', 50)->nullable(); // Slim, Regular, A-line

            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();

            $table->integer('stock')->default(0);

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
            // $table->softDeletes();

            // Foreign key
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
