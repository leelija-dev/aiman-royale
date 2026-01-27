<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lookup maps from other seeders (Brands, Categories, Units)
        $brandIdBySlug = Brand::pluck('id', 'slug')->all();
        $brandIdByName = Brand::pluck('id', 'name')->all();
        $categoryIdBySlug = Category::pluck('id', 'slug')->all();
        $categoryIdByName = Category::pluck('id', 'name')->all();
        $unitIdByCode = Unit::pluck('id', 'code')->all();
        $unitIdByName = Unit::pluck('id', 'name')->all();

        // Define products with human-friendly references to be resolved dynamically
        $productInputs = [
            ['sku' => '001', 'name' => 'Dove Bar Soap', 'brand' => 'unilever', 'category' => 'personal-care', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Moisturizing bar soap for gentle cleansing'],
            ['sku' => '002', 'name' => 'Tide Laundry Detergent', 'brand' => 'procter-and-gamble', 'category' => 'home-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Liquid laundry detergent for stain removal'],
            ['sku' => '003', 'name' => "Lay's Classic Potato Chips", 'brand' => 'pepsico', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'g', 'description' => 'Classic salted potato chips'],
            ['sku' => '004', 'name' => 'Coca-Cola Classic', 'brand' => 'coca-cola', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Carbonated cola beverage'],
            ['sku' => '005', 'name' => 'Listerine Mouthwash', 'brand' => 'johnson-and-johnson', 'category' => 'personal-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Antiseptic mouthwash for oral hygiene'],
            ['sku' => '006', 'name' => 'Pampers Swaddlers Diapers', 'brand' => 'procter-and-gamble', 'category' => 'baby-care', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Disposable diapers for newborns'],
            ['sku' => '007', 'name' => 'Pedigree Dog Food', 'brand' => 'mars', 'category' => 'pet-food', 'unit_amount' => 1, 'unit' => 'kg', 'description' => 'Dry dog food for adult dogs'],
            ['sku' => '008', 'name' => 'Tylenol Extra Strength', 'brand' => 'johnson-and-johnson', 'category' => 'healthcare', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Pain reliever and fever reducer'],
            ['sku' => '009', 'name' => 'Kleenex Facial Tissues', 'brand' => 'kimberly-clark', 'category' => 'paper-products', 'unit_amount' => 1, 'unit' => 'box', 'description' => 'Soft facial tissues for everyday use'],
            ['sku' => '010', 'name' => 'Colgate Total Toothpaste', 'brand' => 'colgate-palmolive', 'category' => 'personal-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Toothpaste for cavity protection and fresh breath'],
            ['sku' => '011', 'name' => 'Head & Shoulders Shampoo', 'brand' => 'procter-and-gamble', 'category' => 'personal-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Anti-dandruff shampoo'],
            ['sku' => '012', 'name' => 'Bounty Paper Towels', 'brand' => 'procter-and-gamble', 'category' => 'home-care', 'unit_amount' => 1, 'unit' => 'roll', 'description' => 'Strong and absorbent paper towels'],
            ['sku' => '013', 'name' => 'Kit Kat Chocolate Bar', 'brand' => 'nestle', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Chocolate-covered wafer bar'],
            ['sku' => '014', 'name' => 'Tropicana Orange Juice', 'brand' => 'pepsico', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'ml', 'description' => '100% pure orange juice'],
            ['sku' => '015', 'name' => 'Band-Aid Adhesive Bandages', 'brand' => 'johnson-and-johnson', 'category' => 'healthcare', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Adhesive bandages for minor cuts and scrapes'],
            ['sku' => '016', 'name' => 'Charmin Toilet Paper', 'brand' => 'procter-and-gamble', 'category' => 'paper-products', 'unit_amount' => 1, 'unit' => 'roll', 'description' => 'Soft and absorbent toilet paper'],
            ['sku' => '017', 'name' => 'Huggies Baby Wipes', 'brand' => 'kimberly-clark', 'category' => 'baby-care', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Gentle and hypoallergenic baby wipes'],
            ['sku' => '018', 'name' => 'Whiskas Cat Food', 'brand' => 'mars', 'category' => 'pet-food', 'unit_amount' => 1, 'unit' => 'g', 'description' => 'Wet cat food for adult cats'],
            ['sku' => '019', 'name' => 'Advil Ibuprofen', 'brand' => 'pfizer', 'category' => 'healthcare', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Pain reliever and fever reducer'],
            ['sku' => '020', 'name' => 'Bic Cristal Ballpoint Pens', 'brand' => 'bic', 'category' => 'stationery', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Classic ballpoint pens for writing'],
            ['sku' => '021', 'name' => 'Crest 3D White Toothpaste', 'brand' => 'procter-and-gamble', 'category' => 'personal-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Whitening toothpaste for a brighter smile'],
            ['sku' => '022', 'name' => 'Febreze Air Effects Air Freshener', 'brand' => 'procter-and-gamble', 'category' => 'home-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Air freshener to eliminate odors and freshen the air'],
            ['sku' => '023', 'name' => 'Doritos Nacho Cheese Chips', 'brand' => 'pepsico', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'g', 'description' => 'Nacho cheese flavored tortilla chips'],
            ['sku' => '024', 'name' => 'Sprite Lemon-Lime Soda', 'brand' => 'coca-cola', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Lemon-lime flavored carbonated beverage'],
            ['sku' => '025', 'name' => 'Benadryl Allergy Relief', 'brand' => 'johnson-and-johnson', 'category' => 'healthcare', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Antihistamine for allergy symptom relief'],
            ['sku' => '026', 'name' => 'Luvs Diapers', 'brand' => 'procter-and-gamble', 'category' => 'baby-care', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Affordable disposable diapers for babies'],
            ['sku' => '027', 'name' => 'Iams Dog Food', 'brand' => 'mars', 'category' => 'pet-food', 'unit_amount' => 1, 'unit' => 'kg', 'description' => 'Dry dog food for senior dogs'],
            ['sku' => '028', 'name' => 'Motrin IB Pain Reliever', 'brand' => 'johnson-and-johnson', 'category' => 'healthcare', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Ibuprofen pain reliever and fever reducer'],
            ['sku' => '029', 'name' => 'Puffs Basic Facial Tissues', 'brand' => 'procter-and-gamble', 'category' => 'paper-products', 'unit_amount' => 1, 'unit' => 'box', 'description' => 'Basic facial tissues for everyday use'],
            ['sku' => '030', 'name' => 'Irish Spring Bar Soap', 'brand' => 'colgate-palmolive', 'category' => 'personal-care', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Deodorant bar soap for men'],
            ['sku' => '031', 'name' => 'Pantene Pro-V Shampoo', 'brand' => 'procter-and-gamble', 'category' => 'personal-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'Shampoo for damaged hair'],
            ['sku' => '032', 'name' => 'Mr. Clean Multi-Surface Cleaner', 'brand' => 'procter-and-gamble', 'category' => 'home-care', 'unit_amount' => 1, 'unit' => 'ml', 'description' => 'All-purpose cleaner for various surfaces'],
            ['sku' => '033', 'name' => 'Oreo Cookies', 'brand' => 'nabisco', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Chocolate sandwich cookies with cream filling'],
            ['sku' => '034', 'name' => 'Minute Maid Orange Juice', 'brand' => 'coca-cola', 'category' => 'food-beverage', 'unit_amount' => 1, 'unit' => 'ml', 'description' => '100% pure orange juice'],
            ['sku' => '035', 'name' => 'Neosporin Ointment', 'brand' => 'johnson-and-johnson', 'category' => 'healthcare', 'unit_amount' => 1, 'unit' => 'g', 'description' => 'First aid antibiotic ointment for minor cuts and scrapes'],
            ['sku' => '036', 'name' => 'Angel Soft Toilet Paper', 'brand' => 'georgia-pacific', 'category' => 'paper-products', 'unit_amount' => 1, 'unit' => 'roll', 'description' => 'Soft and strong toilet paper'],
            ['sku' => '037', 'name' => 'Gerber Baby Food Pouches', 'brand' => 'nestle', 'category' => 'baby-care', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Fruit and vegetable puree pouches for babies'],
            ['sku' => '038', 'name' => 'Temptations Cat Treats', 'brand' => 'mars', 'category' => 'pet-food', 'unit_amount' => 1, 'unit' => 'g', 'description' => 'Chicken flavored cat treats'],
            ['sku' => '039', 'name' => 'Aleve Pain Reliever', 'brand' => 'bayer', 'category' => 'healthcare', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Naproxen sodium pain reliever'],
            ['sku' => '040', 'name' => 'Sharpie Permanent Markers', 'brand' => 'sanford', 'category' => 'stationery', 'unit_amount' => 1, 'unit' => 'pcs', 'description' => 'Permanent markers for various surfaces'],
        ];

        $records = [];
        foreach ($productInputs as $input) {
            $brandId = $brandIdBySlug[$input['brand']] ?? ($brandIdByName[$input['brand']] ?? null);
            $categoryId = $categoryIdBySlug[$input['category']] ?? ($categoryIdByName[$input['category']] ?? null);
            $unitId = $unitIdByCode[$input['unit']] ?? ($unitIdByName[$input['unit']] ?? null);

            if ($brandId === null || $categoryId === null || $unitId === null) {
                // Skip if references are missing to avoid seeding invalid foreign keys
                continue;
            }

            $records[] = [
                'sku' => $input['sku'],
                'name' => $input['name'],
                'brand_id' => $brandId,
                'category_id' => $categoryId,
                'unit_amount' => $input['unit_amount'],
                'unit_id' => $unitId,
                'description' => $input['description'],
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($records)) {
            Product::insert($records);
        }
        $this->command->info('Products seeded successfully');
    }
}
