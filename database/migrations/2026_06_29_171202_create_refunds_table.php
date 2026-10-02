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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('refund_id')->unique();
            $table->string('cf_refund_id')->nullable();
            $table->string('cf_payment_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('status', 50)->default('pending');
            $table->text('reason')->nullable();
            $table->json('refund_data')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');
            
            // Indexes for faster queries
            $table->index('order_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};