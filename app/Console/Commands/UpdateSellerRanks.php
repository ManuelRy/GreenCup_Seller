<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seller;

class UpdateSellerRanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranks:update {seller_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update seller ranks based on their current points';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sellerId = $this->argument('seller_id');

        if ($sellerId) {
            // Update specific seller
            $seller = Seller::find($sellerId);

            if (!$seller) {
                $this->error("Seller with ID {$sellerId} not found.");
                return 1;
            }

            $oldRank = $seller->getCurrentRank();
            $seller->updateRank();
            $newRank = $seller->getCurrentRank();

            $this->info("Updated {$seller->business_name}:");
            $this->info("  Points: {$seller->total_points}");
            $this->info("  Old Rank: " . ($oldRank ? $oldRank->name : 'None'));
            $this->info("  New Rank: " . ($newRank ? $newRank->name : 'None'));
        } else {
            // Update all sellers
            $sellers = Seller::all();
            $this->info("Updating ranks for {$sellers->count()} sellers...");

            $bar = $this->output->createProgressBar($sellers->count());
            $bar->start();

            $updated = 0;
            foreach ($sellers as $seller) {
                $oldRank = $seller->getCurrentRank();
                $seller->updateRank();
                $newRank = $seller->getCurrentRank();

                if ($oldRank?->id !== $newRank?->id) {
                    $updated++;
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);
            $this->info("Successfully updated ranks for {$sellers->count()} sellers.");
            $this->info("{$updated} sellers had their rank changed.");
        }

        return 0;
    }
}
