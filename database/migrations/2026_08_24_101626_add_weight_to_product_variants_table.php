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
            $table->decimal('weight', 12, 2)->nullable()->after('discount_price');
            $table->unsignedBigInteger('weight_unit_id')->nullable()->after('weight');
            $table->decimal('height', 12, 2)->nullable()->after('weight_unit_id');
            $table->unsignedBigInteger('height_unit_id')->nullable()->after('height');
            $table->decimal('width', 12, 2)->nullable()->after('height_unit_id');
            $table->unsignedBigInteger('width_unit_id')->nullable()->after('width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('weight');
            $table->dropColumn('weight_unit_id');
            $table->dropColumn('height');
            $table->dropColumn('height_unit_id');
            $table->dropColumn('width');
            $table->dropColumn('width_unit_id');
        });
    }
};
