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
        Schema::create('offer_banner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_component_id')->constrained('banner_component')->cascadeOnDelete();
            $table->string('sale_type');
            $table->string('event_type');
            $table->string('tips_type');
            $table->decimal('discount');
            $table->string('event_focus');
            $table->string('sale_range');
            $table->string('cupon_code')->nullable();
            $table->integer('allow_website_link')->default(0);
            $table->string('website_link')->nullable();
            $table->integer('sequence')->default(0);
            $table->string('referral_path')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_banner');
    }
};
