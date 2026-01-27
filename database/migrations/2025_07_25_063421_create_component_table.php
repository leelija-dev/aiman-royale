<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentTable extends Migration
{
    public function up()
    {
        Schema::create('component_table', function (Blueprint $table) {
            $table->increments('id'); // Primary Key (INT UNSIGNED AUTO_INCREMENT)
            $table->unsignedInteger('page_id'); // Foreign Key (INT UNSIGNED)
            $table->string('component_name');
            $table->integer('order')->default(0);
            $table->string('title');
            $table->json('cards_data')->nullable();
            $table->timestamps();

            $table->foreign('page_id')->references('page_id')->on('pages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('component_table');
    }
}
