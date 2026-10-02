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
            $table->decimal('gst_percentage', 5, 2)->nullable()->after('total_amount');
            $table->decimal('gst_amount', 10, 2)->nullable()->after('gst_percentage');
            $table->decimal('special_discount', 5, 2)->nullable()->after('gst_amount');
            $table->unsignedBigInteger('special_discount_id')->nullable()->after('special_discount');  // if special discount is applicable then this field is required()
            $table->string('special_discount_name')->nullable()->after('special_discount');  // if special discount is applicable then this field is required
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('gst_percentage');
            $table->dropColumn('gst_amount');
            $table->dropColumn('special_discount');
            $table->dropColumn('special_discount_id');
            $table->dropColumn('special_discount_name');
        });
    }
};
