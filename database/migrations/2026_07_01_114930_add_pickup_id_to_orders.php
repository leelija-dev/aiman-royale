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
        // Migration to add pickup tracking fields
        Schema::table('orders', function ($table) {
            $table->string('pickup_id')->nullable()->after('pick_up_request_added');
            $table->date('pickup_scheduled_date')->nullable()->after('pickup_id');
            $table->time('pickup_scheduled_time')->nullable()->after('pickup_scheduled_date');
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn('pickup_id');
            $table->dropColumn('pickup_scheduled_date');
            $table->dropColumn('pickup_scheduled_time');
        });
    }
};
