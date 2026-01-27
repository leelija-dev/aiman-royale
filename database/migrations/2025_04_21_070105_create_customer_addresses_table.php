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
    {   if (!Schema::hasTable('customer_address')){
        Schema::create('customer_address', function (Blueprint $table) {
            $table->integer('customer_id')->primary();
            $table->string('address1', 64)->index();
            $table->string('address2', 64);
            $table->string('address3', 64);
            $table->string('town', 128)->default('0');
            $table->string('province', 128)->default('0');
            $table->string('postal_code', 16);
            $table->integer('countries_id')->default(0);
            $table->string('phone1', 20);
            $table->string('phone2', 20);
            $table->string('fax', 20);
            $table->string('mobile', 32);
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_address');
    }
};
