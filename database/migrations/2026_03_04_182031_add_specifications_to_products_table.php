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
        Schema::table('products', function (Blueprint $table) {
            $table->string('lehenga_fabric')->nullable();
            $table->string('choli_fabric')->nullable();
            $table->string('dupatta_fabric')->nullable();
            $table->string('type')->nullable();
            $table->string('stitching_type')->nullable();
            $table->string('pattern')->nullable();
            $table->string('sales_package')->nullable();
            $table->string('color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'lehenga_fabric',
                'choli_fabric', 
                'dupatta_fabric',
                'type',
                'stitching_type',
                'pattern',
                'sales_package',
                'color'
            ]);
        });
    }
};
