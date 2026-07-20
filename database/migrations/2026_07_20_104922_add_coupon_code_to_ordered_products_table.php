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
        Schema::table('ordered_products', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')->nullable()->after('price');
            $table->string('coupon_code')->nullable()->after('coupon_id');
            $table->decimal('coupon_discount', 5, 2)->nullable()->after('coupon_code');
            $table->decimal('coupon_discount_amount', 10, 2)->nullable()->after('coupon_discount');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordered_products', function (Blueprint $table) {
            $table->dropColumn('coupon_id');
            $table->dropColumn('coupon_code');
            $table->dropColumn('coupon_discount');
            $table->dropColumn('coupon_discount_amount');
        });
    }
};
