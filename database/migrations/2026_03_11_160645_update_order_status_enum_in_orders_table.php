<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY order_status ENUM(
            'pending',
            'confirmed',
            'paid',
            'shipped',
            'delivered',
            'cancelled',
            'returned'
        ) DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY order_status ENUM(
            'pending',
            'paid',
            'shipped',
            'delivered',
            'cancelled'
        ) DEFAULT 'pending'");
    }
};