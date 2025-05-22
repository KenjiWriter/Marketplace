<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks to allow truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing categories
        Category::truncate();

        // Main categories structure
        $categories = [
            [
                'name' => 'Services',
                'icon' => 'ti ti-tools',
                'subcategories' => [
                    ['name' => 'Cleaning', 'icon' => 'ti ti-wash'],
                    ['name' => 'Repair', 'icon' => 'ti ti-hammer'],
                    ['name' => 'Transport', 'icon' => 'ti ti-truck'],
                    ['name' => 'IT Services', 'icon' => 'ti ti-device-laptop'],
                    ['name' => 'Beauty & Health', 'icon' => 'ti ti-heart'],
                ]
            ],
            [
                'name' => 'Job Offers',
                'icon' => 'ti ti-briefcase',
                'subcategories' => [
                    ['name' => 'Full-time', 'icon' => 'ti ti-clock'],
                    ['name' => 'Part-time', 'icon' => 'ti ti-clock-hour-4'],
                    ['name' => 'Remote', 'icon' => 'ti ti-home'],
                    ['name' => 'Internship', 'icon' => 'ti ti-school'],
                    ['name' => 'Freelance', 'icon' => 'ti ti-user'],
                ]
            ],
            [
                'name' => 'Agriculture',
                'icon' => 'ti ti-plant',
                'subcategories' => [
                    ['name' => 'Farm Equipment', 'icon' => 'ti ti-tractor'],
                    ['name' => 'Animals', 'icon' => 'ti ti-cow'],
                    ['name' => 'Plants & Seeds', 'icon' => 'ti ti-seeding'],
                    ['name' => 'Farm Products', 'icon' => 'ti ti-apple'],
                ]
            ],
            [
                'name' => 'Items',
                'icon' => 'ti ti-box',
                'subcategories' => [
                    [
                        'name' => 'Sports',
                        'icon' => 'ti ti-ball-football',
                        'subcategories' => [
                            ['name' => 'Winter Sports', 'icon' => 'ti ti-snowflake'],
                            ['name' => 'Water Sports', 'icon' => 'ti ti-swim'],
                            ['name' => 'Team Sports', 'icon' => 'ti ti-ball-basketball'],
                            ['name' => 'Outdoor', 'icon' => 'ti ti-tent'],
                            ['name' => 'Fitness', 'icon' => 'ti ti-barbell'],
                        ]
                    ],
                    [
                        'name' => 'Music',
                        'icon' => 'ti ti-music',
                        'subcategories' => [
                            ['name' => 'Instruments', 'icon' => 'ti ti-guitar'],
                            ['name' => 'Records & CDs', 'icon' => 'ti ti-disc'],
                            ['name' => 'Audio Equipment', 'icon' => 'ti ti-headphones'],
                        ]
                    ],
                    [
                        'name' => 'Kids',
                        'icon' => 'ti ti-baby-carriage',
                        'subcategories' => [
                            ['name' => 'Toys', 'icon' => 'ti ti-toys'],
                            ['name' => 'Baby Equipment', 'icon' => 'ti ti-baby-bottle'],
                            ['name' => 'Children Clothing', 'icon' => 'ti ti-shirt'],
                        ]
                    ],
                    [
                        'name' => 'Clothing',
                        'icon' => 'ti ti-shirt',
                        'subcategories' => [
                            ['name' => 'Men', 'icon' => 'ti ti-user'],
                            ['name' => 'Women', 'icon' => 'ti ti-user'],
                            ['name' => 'Shoes', 'icon' => 'ti ti-shoe'],
                            ['name' => 'Accessories', 'icon' => 'ti ti-tie'],
                        ]
                    ],
                    [
                        'name' => 'Electronics',
                        'icon' => 'ti ti-device-mobile',
                        'subcategories' => [
                            ['name' => 'Smartphones', 'icon' => 'ti ti-phone'],
                            ['name' => 'Computers', 'icon' => 'ti ti-device-laptop'],
                            ['name' => 'TV & Audio', 'icon' => 'ti ti-device-tv'],
                            ['name' => 'Photo & Video', 'icon' => 'ti ti-camera'],
                            [
                                'name' => 'Smart Home',
                                'icon' => 'ti ti-home-automation',
                                'subcategories' => [
                                    ['name' => 'Smart Lighting', 'icon' => 'ti ti-bulb'],
                                    ['name' => 'Security', 'icon' => 'ti ti-lock'],
                                    ['name' => 'Thermostats', 'icon' => 'ti ti-temperature'],
                                ]
                            ],
                            ['name' => 'Industrial Electronics', 'icon' => 'ti ti-building-factory'],
                            ['name' => 'Gadgets', 'icon' => 'ti ti-device-watch'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Automotive',
                'icon' => 'ti ti-car',
                'subcategories' => [
                    ['name' => 'Cars', 'icon' => 'ti ti-car'],
                    ['name' => 'Motorcycles', 'icon' => 'ti ti-motorbike'],
                    ['name' => 'Car Parts', 'icon' => 'ti ti-engine'],
                    ['name' => 'Accessories', 'icon' => 'ti ti-tools'],
                    ['name' => 'Commercial Vehicles', 'icon' => 'ti ti-truck'],
                ]
            ],
            [
                'name' => 'Real Estate',
                'icon' => 'ti ti-building',
                'subcategories' => [
                    [
                        'name' => 'For Rent',
                        'icon' => 'ti ti-key',
                        'subcategories' => [
                            ['name' => 'Apartments', 'icon' => 'ti ti-building'],
                            ['name' => 'Houses', 'icon' => 'ti ti-home'],
                            ['name' => 'Commercial', 'icon' => 'ti ti-building-store'],
                            ['name' => 'Rooms', 'icon' => 'ti ti-door'],
                        ]
                    ],
                    [
                        'name' => 'For Sale',
                        'icon' => 'ti ti-cash',
                        'subcategories' => [
                            ['name' => 'Apartments', 'icon' => 'ti ti-building'],
                            ['name' => 'Houses', 'icon' => 'ti ti-home'],
                            ['name' => 'Commercial', 'icon' => 'ti ti-building-store'],
                            ['name' => 'Land', 'icon' => 'ti ti-map'],
                        ]
                    ],
                ]
            ],
        ];

        $this->createCategories($categories, null, 0, '');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Create categories recursively
     */
    private function createCategories($categories, $parentId = null, $level = 0, $parentSlug = '')
    {
        foreach ($categories as $index => $categoryData) {
            // Create a unique slug by combining parent slug and current name
            $baseSlug = Str::slug($categoryData['name']);
            $slug = $parentSlug ? $parentSlug . '-' . $baseSlug : $baseSlug;

            // Check if slug exists already
            $count = 1;
            $originalSlug = $slug;
            while (Category::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $slug,
                'icon' => $categoryData['icon'] ?? null,
                'parent_id' => $parentId,
                'level' => $level,
                'active' => true,
                'display_order' => $index,
            ]);

            if (isset($categoryData['subcategories'])) {
                // Pass the current category's slug as the parent slug for subcategories
                $this->createCategories(
                    $categoryData['subcategories'],
                    $category->id,
                    $level + 1,
                    $baseSlug
                );
            }
        }
    }
}
