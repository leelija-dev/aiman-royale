<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'fname' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@leelija.com',
            'address' => '123 Admin Street',
            'image' => ''
        ]);
    }
}
