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
        //
        Schema::table('sizes', function (Blueprint $table) {
            $table->string('hip')->nullable()->after('waist_size');
            $table->string('arm')->nullable()->after('hip');
            $table->string('uk_size')->nullable()->after('arm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('sizes', function (Blueprint $table) {
            $table->dropColumn('hip');
            $table->dropColumn('arm');
            $table->dropColumn('uk_size');
        });
    }
};
