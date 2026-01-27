<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id(); // BIGINT unsigned primary key for invoice
            $table->date('bill_date');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->integer('total_items')->default(0);

            // Match admin_users.user_id (INT unsigned)
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('admin_users')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice');
    }
};