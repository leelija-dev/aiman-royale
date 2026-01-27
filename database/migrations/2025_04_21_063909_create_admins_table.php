<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('admin_users')) {
            Schema::create('admin_users', function (Blueprint $table) {
                $table->string('username', 32)->primary();
                $table->string('password', 128);
                $table->dateTime('last_logon')->useCurrent();
                $table->integer('no_logon')->default(0);
                $table->string('fname', 32);
                $table->string('lname', 32);
                $table->string('address', 255);
                $table->tinyInteger('usertype')->default(0);
                $table->string('email', 64);
                $table->string('image', 255);
                $table->dateTime('added_on')->useCurrent();
                $table->dateTime('modified_on')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
