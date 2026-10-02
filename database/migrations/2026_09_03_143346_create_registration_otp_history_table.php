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
        Schema::create('registration_otp_history', function (Blueprint $table) {
            $table->id();
            $table->string('otp_send_to')->nullable();
            $table->string('otp')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->string('failed_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_otp_history');
    }
};
