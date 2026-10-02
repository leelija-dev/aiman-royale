<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaybillToReverseOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('reverse_orders', function (Blueprint $table) {
            $table->string('waybill')->nullable()->after('reverse_order_number');
            $table->json('delhivery_response')->nullable()->after('waybill');
            $table->string('awb_status')->nullable()->after('delhivery_response');
        });
    }

    public function down()
    {
        Schema::table('reverse_orders', function (Blueprint $table) {
            $table->dropColumn(['waybill', 'delhivery_response', 'awb_status']);
        });
    }
}