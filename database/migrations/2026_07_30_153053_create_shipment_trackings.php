<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipment_trackings', function (Blueprint $table) {
            $table->id();
            
            // Add order_id as foreign key
            $table->foreignId('order_id')
                  ->constrained()  // Automatically references orders table
                  ->onDelete('cascade') // Delete tracking when order is deleted
                  ->index();
            
            // Keep awb for reference (and if you need to search by AWB)
            $table->string('awb')->index();
            $table->string('reference_no')->nullable()->index();
            
            $table->string('status')->nullable();
            $table->string('status_type')->nullable();
            $table->string('location')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('status_date')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['order_id', 'created_at']); // Common query pattern
            $table->index(['awb', 'status_date']); // For AWB-based queries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_trackings');
    }
};