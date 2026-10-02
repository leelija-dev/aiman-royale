<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCloudinaryFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('featured_image_public_id')->nullable()->after('featured_image');
        });
        
        Schema::table('product_images', function (Blueprint $table) {
            $table->string('public_id')->nullable()->after('image');
            $table->boolean('is_primary')->default(false)->after('public_id');
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('featured_image_public_id');
        });
        
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['public_id', 'is_primary']);
        });
    }
}