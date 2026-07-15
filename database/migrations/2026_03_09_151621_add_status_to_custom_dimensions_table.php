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
        Schema::table('custom_dimensions', function (Blueprint $table) {
            $table->enum('status', ['requested', 'viewed', 'processing', 'accepted', 'canceled'])->default('requested')->after('color_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_dimensions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
