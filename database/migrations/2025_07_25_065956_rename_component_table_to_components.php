<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameComponentTableToComponents extends Migration
{
    public function up()
    {
        Schema::rename('component_table', 'components');
    }

    public function down()
    {
        Schema::rename('components', 'component_table');
    }
}
