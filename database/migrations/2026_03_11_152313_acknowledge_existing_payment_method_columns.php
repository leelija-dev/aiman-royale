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
        Schema::table('orders', function (Blueprint $table) {
            // Add payment_method column to track payment type
            $table->enum('payment_method', [
                'cashfree',
                'cash_on_delivery',
                'razorpay',
                'paypal',
                'stripe',
                'other'
            ])->nullable()->after('payment_status');
            
            // Add delivery notes for COD orders
            $table->text('delivery_notes')->nullable()->after('pincode');
            
            // Add COD fee column
            $table->decimal('cod_fee', 8, 2)->default(0.00)->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // $table->dropColumn([
            //     'payment_method',
            //     'delivery_notes',
            //     'cod_fee'
            // ]);
        });
    }
};
