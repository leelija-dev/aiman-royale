<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Personal Care', 'slug' => 'personal-care', 'description' => 'Includes items like soap, shampoo, toothpaste, deodorant, skincare, and cosmetics.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Home Care', 'slug' => 'home-care', 'description' => 'Covers cleaning products, laundry detergents, dish soap, and air fresheners.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Food & Beverage', 'slug' => 'food-beverage', 'description' => 'Encompasses a wide range of products, including packaged foods, snacks, beverages (both alcoholic and non-alcoholic), and dairy products.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Healthcare', 'slug' => 'healthcare', 'description' => 'Includes over-the-counter medications, vitamins, supplements, and first-aid products.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tobacco Products', 'slug' => 'tobacco-products', 'description' => 'Cigarettes, cigars, and other tobacco-related items.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paper Products', 'slug' => 'paper-products', 'description' => 'Toilet paper, paper towels, facial tissues, and napkins.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baby Care', 'slug' => 'baby-care', 'description' => 'Diapers, baby wipes, baby food, and other products specifically for infants and toddlers.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pet Food', 'slug' => 'pet-food', 'description' => 'Food and treats for pets, such as dogs, cats, and other animals.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Over-the-Counter (OTC) Pharmaceuticals', 'slug' => 'otc-pharmaceuticals', 'description' => 'Non-prescription medications for common ailments.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stationery', 'slug' => 'stationery', 'description' => 'Pens, paper, notebooks and other writing and office supplies.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        Category::insert($categories);
        $this->command->info('Product categories seeded successfully');
    }
}
