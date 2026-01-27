<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->decimal('total_amount', 10, 2);

            $table->enum('order_status', [
                'pending', 
                'paid',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            $table->string('transaction_id', 40)->nullable();

            $table->enum('payment_status', [
                'pending',
                'success',
                'failed'
            ])->default('pending');

            $table->string('address_1', 100);
            $table->string('address_2', 100)->nullable();

            $table->string('state', 50);
            $table->string('city', 25);

            $table->string('pincode', 6);
            $table->string('phone_no', 12);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
