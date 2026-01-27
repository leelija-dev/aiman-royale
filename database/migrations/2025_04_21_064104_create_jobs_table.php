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
        if (!Schema::hasTable('all_jobs')){
        Schema::create('all_jobs', function (Blueprint $table) {
            $table->integer('id', 8)->autoIncrement();
            $table->string('job_name', 150);
            $table->string('details', 300);
            $table->dateTime('date');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_jobs');
    }
};
