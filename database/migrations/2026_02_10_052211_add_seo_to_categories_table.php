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
        Schema::table('categories', function (Blueprint $table) {
           $table->string('meta_title')->nullable()->after('home_position'); // meta_title
           $table->string('keywords')->nullable()->after('meta_title'); // keywords
           $table->string('tags')->nullable()->after('keywords'); // tags
           $table->string('meta_description')->nullable()->after('tags'); // meta_description
           $table->string('schema_markup')->nullable()->after('meta_description'); // schema_markup
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('keywords');
            $table->dropColumn('tags');
            $table->dropColumn('meta_description');
            $table->dropColumn('schema_markup');
        });
    }
};
