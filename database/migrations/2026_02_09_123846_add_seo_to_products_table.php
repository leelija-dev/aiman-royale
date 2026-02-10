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
        Schema::table('products', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('is_featured');
            $table->string('keywords')->nullable()->after('meta_title');
            $table->string('tags')->nullable()->after('keywords');
            $table->text('meta_description')->nullable()->after('tags');
            $table->text('schema_markup')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('keywords');
            $table->dropColumn('tags');
            $table->dropColumn('meta_description');
            $table->dropColumn('schema_markup');
        });
    }
};
