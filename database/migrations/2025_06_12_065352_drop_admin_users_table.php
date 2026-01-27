<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the admin_users table if it exists
        Schema::dropIfExists('admin_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the admin_users table if needed (structure can be added here)
        Schema::create('admin_users', function ($table) {
            $table->string('username', 32)->primary();
            $table->string('password', 128);
            $table->dateTime('last_logon')->nullable();
            $table->integer('no_logon')->default(0);
            $table->string('fname', 32);
            $table->string('lname', 32);
            $table->string('address', 255);
            $table->tinyInteger('usertype')->default(0);
            $table->string('email', 64);
            $table->string('image', 255);
            $table->dateTime('added_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }
};
