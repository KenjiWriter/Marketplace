<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\product;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    private $unsplashAccessKey = 'TCFROF9UU0G8uOW9aC2ptQLDWx6vXnjdjxhrBOJb38Y'; // Get from https://unsplash.com/developers

    public function run()
    {
        // Get all leaf categories (categories without children)
        $categories = Category::whereNotIn('id', function ($query) {
            $query->select('parent_id')->from('categories')->whereNotNull('parent_id');
        })->get();

        foreach ($categories as $category) {
            // Create 3-5 products per category
            $productCount = rand(3, 5);

            for ($i = 0; $i < $productCount; $i++) {
                // Fetch images related to category name
                $images = $this->fetchImagesForCategory($category->name, rand(1, 4));

                // Create product
                product::create([
                    'Active' => 1,
                    'name' => $this->generateProductName($category->name),
                    'description' => $this->generateDescription(),
                    'user_id' => rand(1, 5), // Assuming you have users with IDs 1-5
                    'First_owner' => rand(0, 1),
                    'Owner' => 'Sample User ' . rand(1, 10),
                    'price' => rand(10, 1000),
                    'category_id' => $category->id,
                    'category' => $category->id,
                    'images' => json_encode($images),
                    'promote' => rand(0, 5) > 3 ? 1 : 0, // 40% chance to be promoted
                    'promote_to' => now()->addDays(rand(1, 30)), // Random promotion period
                ]);
            }
        }
    }

    private function fetchImagesForCategory($category, $count = 3)
    {
        $images = [];

        try {
            // Search Unsplash for category-related images
            $response = Http::get("https://api.unsplash.com/search/photos", [
                'query' => $category,
                'per_page' => $count,
                'client_id' => $this->unsplashAccessKey,
            ]);

            if ($response->successful()) {
                $results = $response->json()['results'];

                foreach ($results as $image) {
                    $imageUrl = $image['urls']['regular'];
                    $filename = 'seed_' . uniqid() . '.jpg';

                    // Download image
                    $imageContent = file_get_contents($imageUrl);

                    // Store image
                    Storage::disk('public')->put('images/' . $filename, $imageContent);

                    $images[] = $filename;
                }
            }
        } catch (\Exception $e) {
            // Fallback to a placeholder if API fails
            $images[] = 'noImg.jpg';
        }

        // Ensure we have at least one image
        if (empty($images)) {
            $images[] = 'noImg.jpg';
        }

        return $images;
    }

    private function generateProductName($category)
    {
        $adjectives = ['Amazing', 'Fantastic', 'Great', 'Premium', 'Luxury', 'Budget', 'Used', 'New', 'Professional'];
        $nouns = ['Item', 'Product', 'Deal', 'Set', 'Collection', 'Package'];

        return $adjectives[array_rand($adjectives)] . ' ' . $category . ' ' . $nouns[array_rand($nouns)];
    }

    private function generateDescription()
    {
        $descriptions = [
            'Great product in excellent condition. Barely used and well maintained.',
            'Perfect for everyday use. Minor signs of wear but fully functional.',
            'Like new condition. Original packaging included.',
            'Good value for money. Selling because I upgraded to a newer model.',
            'Works perfectly. No damages or issues. Fast shipping available.'
        ];

        return $descriptions[array_rand($descriptions)];
    }
}
