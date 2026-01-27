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
        Schema::create('user_application', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_number');
            $table->string('email');
            $table->string('linkedin_profile')->default(null);
            $table->string('job_role');
            $table->string('exprience');
            $table->integer('current_ctc');
            $table->integer('expected_ctc');
            $table->string('uploadcv');
            $table->string('status')->default('Pending');
            $table->string('cover_letter');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
        
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_application');
    }
};
