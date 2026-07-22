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
        Schema::table('banner_details', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('redirect_link')->nullable()->change();
            $table->string('position')->nullable()->after('redirect_link')->change();
            $table->string('mobile_screen_image')->nullable()->after('image');
            $table->string('mobile_screen_image_public_id')->nullable()->after('mobile_screen_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_details', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('redirect_link')->change();
            $table->string('position')->change();
            $table->dropColumn('mobile_screen_image');
            $table->dropColumn('mobile_screen_image_public_id');
        });
    }
};
