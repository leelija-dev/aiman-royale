<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reverse_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reverse_order_id')->constrained('reverse_orders')->cascadeOnDelete();
            $table->foreignId('order_product_id')->nullable()->constrained('ordered_products')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->string('sku_code', 100);
            $table->string('sku_name', 191);
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reverse_order_items');
    }
};
