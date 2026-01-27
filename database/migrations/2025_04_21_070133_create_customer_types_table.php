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
        if (!Schema::hasTable('customer_type')) { 
        Schema::create('customer_type', function (Blueprint $table) {
            $table->integer('customer_type_id', true);
            $table->integer('parent_id')->default(0);
            $table->string('cus_type', 64)->nullable();
            $table->string('cus_type_code', 16)->nullable();
            $table->mediumText('remarks')->nullable();
            $table->string('images', 255)->nullable();
            $table->dateTime('added_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_type');
    }
};
