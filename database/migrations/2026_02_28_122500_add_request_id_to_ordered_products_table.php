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
            $table->unsignedBigInteger('request_id')->nullable()->after('product_id');
            $table->foreign('request_id')->references('id')->on('custom_dimensions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordered_products', function (Blueprint $table) {
            $table->dropForeign(['request_id']);
            $table->dropColumn('request_id');
        });
    }
};
