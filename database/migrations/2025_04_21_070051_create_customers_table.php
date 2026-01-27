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
        if (!Schema::hasTable('customer')){
        Schema::create('customer', function (Blueprint $table) {
            $table->integer('customer_id', true);
            $table->enum('customer_type', ['1', '2', '3'])->default('1');
            $table->string('member_id', 32)->default('0')->index();
            $table->string('user_name', 64);
            $table->string('email', 96);
            $table->string('password', 128);
            $table->string('billing_name', 100)->nullable();
            $table->string('fname', 32);
            $table->string('lname', 32);
            $table->enum('gender', ['male', 'female', 'na'])->default('na');
            $table->date('dob')->nullable();
            $table->enum('status', ['a', 'd'])->default('a');
            $table->string('image', 128);
            $table->string('brief', 255);
            $table->text('description')->nullable();
            $table->string('organization', 128);
            $table->enum('featured', ['Y', 'N'])->default('N');
            $table->string('profession', 32);
            $table->integer('sort_order')->default(0);
            $table->string('verification_no', 64)->nullable();
            $table->enum('acc_verified', ['Y', 'N'])->default('N');
            $table->string('verified_by', 128)->nullable();
            $table->dateTime('verified_on')->nullable();
            $table->float('discount_offered', 4, 2)->default(0.00);
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
