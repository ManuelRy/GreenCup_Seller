<?php

namespace App\Console\Commands;

use App\Models\Seller;
use App\Models\PointTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixSellerPointsNow extends Command
{
    protected $signature = 'fix:points-now';
    protected $description = 'Immediately fix all seller points after removing trigger';

    public function handle()
    {
        $this->info('🔧 Fixing seller points after removing trigger...');
        
        $sellers = Seller::all();
        $this->info("Found {$sellers->count()} sellers to fix.");
        
        $bar = $this->output->createProgressBar($sellers->count());
        $bar->start();
        
        foreach ($sellers as $seller) {
            // Calculate correct points (only from 'earn' transactions)
            $correctPoints = PointTransaction::where('seller_id', $seller->id)
                ->where('type', 'earn')
                ->sum('points') ?? 0;
            
            $oldPoints = $seller->total_points;
            
            // Update to correct value
            $seller->update(['total_points' => $correctPoints]);
            
            if ($oldPoints != $correctPoints) {
                $this->newLine();
                $this->info("Fixed Seller {$seller->id} ({$seller->business_name}): {$oldPoints} → {$correctPoints}");
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info('✅ All seller points have been recalculated correctly!');
        
        return 0;
    }
}