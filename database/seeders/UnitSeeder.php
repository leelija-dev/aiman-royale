<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $units = [
            ['name' => 'Pieces', 'code' => 'pcs', 'allow_decimal' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kilogram', 'code' => 'kg', 'allow_decimal' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Milliliter', 'code' => 'ml', 'allow_decimal' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gram', 'code' => 'g', 'allow_decimal' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Liter', 'code' => 'l', 'allow_decimal' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        Unit::insert($units);
        $this->command->info('Units seeded successfully');
    }
}
