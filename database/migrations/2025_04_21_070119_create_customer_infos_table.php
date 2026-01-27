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
        if (!Schema::hasTable('customer_info')) {
        Schema::create('customer_info', function (Blueprint $table) {
            $table->integer('info_id', true);
            $table->integer('customer_id')->default(0);
            $table->integer('no_logon')->default(0);
            $table->dateTime('last_logon')->nullable();
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
        Schema::dropIfExists('customer_info');
    }
};
