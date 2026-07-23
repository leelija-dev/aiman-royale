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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('fixed_price', 12, 2)->nullable()->after('price')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable()->after('fixed_price');
            $table->decimal('final_price', 12, 2)->nullable()->after('coupon_id');
            $table->decimal('discount', 8, 5)->after('price')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('fixed_price');
            $table->dropColumn('coupon_id');
            $table->dropColumn('final_price');
            $table->decimal('discount', 5, 2)->change();
        });
    }
};
