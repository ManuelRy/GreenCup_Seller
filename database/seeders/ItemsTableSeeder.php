<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeds the items table with eco-friendly products that customers can purchase
     * to earn points in the GreenCup system.
     */
    public function run(): void
    {
        // Clear existing items
        DB::table('items')->truncate();

        $now = Carbon::now();

        // Define eco-friendly items with their point values
        $items = [
            // BEVERAGES & CUPS (1-5 points)
            [
                'name' => 'Coffee',
                'points_per_unit' => 3,
                'category' => 'beverages'
            ],
            [
                'name' => 'Smoothie', 
                'points_per_unit' => 4,
                'category' => 'beverages'
            ],
            [
                'name' => 'Reusable Cup',
                'points_per_unit' => 5,
                'category' => 'reusable_items'
            ],
            [
                'name' => 'Coffee Cup',
                'points_per_unit' => 2,
                'category' => 'disposable_eco'
            ],
            [
                'name' => 'Water Bottle',
                'points_per_unit' => 6,
                'category' => 'reusable_items'
            ],

            // STRAWS & UTENSILS (2-8 points)
            [
                'name' => 'Metal Straw',
                'points_per_unit' => 8,
                'category' => 'reusable_items'
            ],
            [
                'name' => 'Straw',
                'points_per_unit' => 2,
                'category' => 'disposable_eco'
            ],
            [
                'name' => 'Bamboo Utensils',
                'points_per_unit' => 7,
                'category' => 'reusable_items'
            ],
            [
                'name' => 'Utensils Set',
                'points_per_unit' => 9,
                'category' => 'reusable_items'
            ],

            // CONTAINERS & BAGS (3-10 points)
            [
                'name' => 'Eco Bag',
                'points_per_unit' => 10,
                'category' => 'reusable_items'
            ],
            [
                'name' => 'Shopping Bag',
                'points_per_unit' => 7,
                'category' => 'reusable_items'
            ],
            [
                'name' => 'Glass Container',
                'points_per_unit' => 9,
                'category' => 'reusable_items'
            ],
            [
                'name' => 'Food Container',
                'points_per_unit' => 8,
                'category' => 'reusable_items'
            ],
            [
                'name' => 'Takeout Container',
                'points_per_unit' => 3,
                'category' => 'disposable_eco'
            ],

            // FOOD ITEMS (4-6 points)
            [
                'name' => 'Organic Vegetables',
                'points_per_unit' => 6,
                'category' => 'organic_food'
            ]
        ];

        // Prepare data for batch insert
        $insertData = [];
        foreach ($items as $item) {
            $insertData[] = [
                'name' => $item['name'],
                'points_per_unit' => $item['points_per_unit'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert all items in batches for better performance
        $chunks = array_chunk($insertData, 10);
        foreach ($chunks as $chunk) {
            DB::table('items')->insert($chunk);
        }

        // Output summary
        $this->command->info('✅ Successfully seeded ' . count($insertData) . ' eco-friendly items!');
        
        // Show some statistics
        $categories = [];
        foreach ($items as $item) {
            $categories[$item['category']] = ($categories[$item['category']] ?? 0) + 1;
        }
        
        $this->command->info('📊 Items by category:');
        foreach ($categories as $category => $count) {
            $this->command->line("   • " . ucwords(str_replace('_', ' ', $category)) . ": {$count} items");
        }
        
        // Show point ranges
        $minPoints = min(array_column($items, 'points_per_unit'));
        $maxPoints = max(array_column($items, 'points_per_unit'));
        $avgPoints = round(array_sum(array_column($items, 'points_per_unit')) / count($items), 1);
        
        $this->command->info("💰 Point values: {$minPoints}-{$maxPoints} points (avg: {$avgPoints})");
        
        // Show high-value items (50+ points)
        $highValueItems = array_filter($items, fn($item) => $item['points_per_unit'] >= 50);
        if (!empty($highValueItems)) {
            $this->command->info('🌟 High-value items (50+ points):');
            foreach ($highValueItems as $item) {
                $this->command->line("   • {$item['name']}: {$item['points_per_unit']} points");
            }
        }
    }
}