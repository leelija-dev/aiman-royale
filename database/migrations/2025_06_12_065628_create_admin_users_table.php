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
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('user_id'); // Primary key
            $table->string('username', 32);
            $table->string('password', 128);
            $table->dateTime('last_logon')->nullable(); // Fix here
            $table->integer('no_logon')->default(0);
            $table->string('fname', 32);
            $table->string('lname', 32);
            $table->string('address', 255);
            $table->string('email', 64);
            $table->string('image', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
