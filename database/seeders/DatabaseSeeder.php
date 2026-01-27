<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Optional: Factory-based test user
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 👉 Call your SuperAdminSeeder here
        $this->call([
            SuperAdminSeeder::class,
            // BlogSeeder::class,
        ]);
    }
}
