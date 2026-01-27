<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('code', 16)->unique(); // e.g. pcs, kg, m
            $table->string('name', 64);
            $table->boolean('allow_decimal')->default(false);
            $table->timestamps();


            $table->index('code');
        });
    }


    public function down()
    {
        Schema::dropIfExists('units');
    }
};
