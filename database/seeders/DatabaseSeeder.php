<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Seed items first (no dependencies)
            ItemsTableSeeder::class,
            
            // Add other seeders here as needed
            // RanksTableSeeder::class,
            // SampleDataSeeder::class,
        ]);
        
        $this->command->info('🌱 GreenCup database seeding completed successfully!');
    }
}