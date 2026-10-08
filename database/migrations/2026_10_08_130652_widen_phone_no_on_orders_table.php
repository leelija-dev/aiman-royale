<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Widen to 20 to fit E.164 international numbers (+15 digits + plus sign)
            // Do NOT add ->nullable() — the column is NOT NULL and must stay that way
            $table->string('phone_no', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Roll back to the original definition
            $table->string('phone_no', 12)->change();
        });
    }
};