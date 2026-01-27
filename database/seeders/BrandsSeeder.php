<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [

            ['name' => 'Nestlé', 'slug' => 'nestle', 'description' => 'A multinational food and beverage conglomerate.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'Procter & Gamble (P&G)', 'slug' => 'procter-and-gamble', 'description' => 'Known for a wide range of household and personal care products.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'Unilever', 'slug' => 'unilever', 'description' => 'Another major player with a diverse portfolio of food, personal care, and home care brands.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'PepsiCo', 'slug' => 'pepsico', 'description' => 'Primarily known for beverages and snack foods.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'Coca-Cola', 'slug' => 'coca-cola', 'description' => 'Primarily a beverage company, famous for its flagship cola.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'Johnson & Johnson', 'slug' => 'johnson-and-johnson', 'description' => 'Focuses on pharmaceuticals, medical devices, and consumer health products.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'L\'Oréal', 'slug' => 'loreal', 'description' => 'A leading company in the cosmetics and beauty industry.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'Kraft Heinz', 'slug' => 'kraft-heinz', 'description' => 'Specializes in packaged foods, including condiments, sauces, and dairy products.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'Mars', 'slug' => 'mars', 'description' => 'A major manufacturer of confectionery, pet food, and other food products.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            ['name' => 'Colgate-Palmolive', 'slug' => 'colgate-palmolive', 'description' => 'Focuses on oral care, personal care, and home care products.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        Brand::insert($brands);
        $this->command->info('Brands seeded successfully');
    }
}
