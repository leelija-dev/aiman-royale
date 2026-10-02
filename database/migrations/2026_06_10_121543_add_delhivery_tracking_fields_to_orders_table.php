<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Delhivery shipping fields
            $table->string('waybill_number')->nullable()->after('order_status');
            $table->string('shipment_id')->nullable()->after('waybill_number');
            $table->string('courier_name')->default('Delhivery')->after('shipment_id');
            $table->string('tracking_status')->nullable()->after('courier_name');
            $table->json('tracking_data')->nullable()->after('tracking_status');
            $table->string('last_tracking_location')->nullable()->after('tracking_data');
            
            // Timeline fields
            $table->timestamp('shipped_at')->nullable()->after('last_tracking_location');
            $table->timestamp('out_for_delivery_at')->nullable()->after('shipped_at');
            $table->timestamp('delivered_at')->nullable()->after('out_for_delivery_at');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'waybill_number', 'shipment_id', 'courier_name',
                'tracking_status', 'tracking_data', 'last_tracking_location',
                'shipped_at', 'out_for_delivery_at', 'delivered_at'
            ]);
        });
    }
};