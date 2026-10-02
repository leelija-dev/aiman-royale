<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reverse_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reverse_order_number')->unique();
            $table->enum('status', [
                'ready_for_pickup',
                'in_transit',
                'out_for_delivery',
                'delivered'
            ])->default('ready_for_pickup');
            $table->string('return_contact_name', 100);
            $table->string('return_phone_no', 20);
            $table->string('return_address_1', 150);
            $table->string('return_address_2', 150)->nullable();
            $table->string('return_city', 75);
            $table->string('return_state', 75);
            $table->string('return_pincode', 10);
            $table->text('return_reason')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reverse_orders');
    }
};
