<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_occasions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('occasion_id');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');

            $table->foreign('occasion_id')
                  ->references('id')
                  ->on('ocassions')
                  ->onDelete('cascade');

            // Prevent duplicate entries
            $table->unique(['product_id', 'occasion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_occasions');
    }
};