<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSeo;

class HomeSeoSeeder extends Seeder
{
    public function run()
    {
        $schema = json_encode([
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "@id" => "https://aiman-royale.com/#organization",
            "name" => "Aiman Royale",
            "url" => "https://aiman-royale.com/",
            "description" => "Premium fashion collection with designer wear, traditional outfits, and contemporary styles.",
            "logo" => "https://aiman-royale.com/web/images/company-logo/aiman-royal-logo.png"
        ]);

        PageSeo::updateOrCreate(
            ['slug' => 'home'],
            [
                'meta_title' => 'Aiman Royale - Premium Fashion Collection',
                'meta_description' => 'Discover premium fashion collections at Aiman Royale. Shop our exclusive range of designer wear, traditional outfits, and contemporary styles.',
                'meta_keywords' => 'fashion, designer wear, traditional clothing, premium fashion, aiman royale',
                'meta_tags' => 'fashion, clothing, designer, premium, traditional, contemporary',
                'schema_markup' => $schema,
                'is_active' => true
            ]
        );
    }
}
