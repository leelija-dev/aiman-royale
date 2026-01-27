<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Add the column
            // $table->unsignedBigInteger('service_id')
            //       ->nullable()              // drop `nullable()` if it must be required
            //       ->after('page_id');       // place it where you like

            // Add the FK constraint
            $table->foreign('service_id')
                  ->references('id')
                  ->on('services')
                  ->cascadeOnDelete();      // or ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            // $table->dropColumn('service_id');
        });
    }
};
