<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckQrCodes extends Command
{
    protected $signature = 'qr:check {--consumer= : Check specific consumer by ID or email}';
    protected $description = 'Check QR codes status and debug issues';

    public function handle()
    {
        $this->info('🔍 QR Code Status Check');
        $this->info('======================');
        
        if ($consumerId = $this->option('consumer')) {
            // Check specific consumer
            $consumer = DB::table('consumers')
                ->where('id', $consumerId)
                ->orWhere('email', $consumerId)
                ->first();
            
            if (!$consumer) {
                $this->error("Consumer not found: {$consumerId}");
                return 1;
            }
            
            $this->checkConsumer($consumer);
        } else {
            // Overall statistics
            $this->showOverallStats();
        }
        
        return 0;
    }
    
    private function checkConsumer($consumer)
    {
        $this->info("\nConsumer Details:");
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', $consumer->id],
                ['Name', $consumer->full_name],
                ['Email', $consumer->email],
                ['Created', $consumer->created_at],
            ]
        );
        
        $qrCode = DB::table('qr_codes')
            ->where('consumer_id', $consumer->id)
            ->where('type', 'consumer_profile')
            ->where('active', true)
            ->first();
        
        if (!$qrCode) {
            $this->error("\n❌ This consumer has NO QR code!");
            return;
        }
        
        $this->info("\nQR Code Details:");
        $this->table(
            ['Field', 'Value'],
            [
                ['QR ID', $qrCode->id],
                ['Code', $qrCode->code],
                ['Type', $qrCode->type],
                ['Active', $qrCode->active ? 'Yes' : 'No'],
                ['Created', $qrCode->created_at],
            ]
        );
        
        // Show recent transactions
        $transactions = DB::table('point_transactions')
            ->where('consumer_id', $consumer->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        if ($transactions->isNotEmpty()) {
            $this->info("\nRecent Transactions:");
            $this->table(
                ['Date', 'Seller ID', 'Points', 'Type'],
                $transactions->map(function ($t) {
                    return [
                        $t->created_at,
                        $t->seller_id,
                        $t->points,
                        $t->type
                    ];
                })
            );
        }
    }
    
    private function showOverallStats()
    {
        $totalConsumers = DB::table('consumers')->count();
        $consumersWithQR = DB::table('consumers as c')
            ->join('qr_codes as qc', function($join) {
                $join->on('c.id', '=', 'qc.consumer_id')
                     ->where('qc.type', '=', 'consumer_profile')
                     ->where('qc.active', '=', true);
            })
            ->count();
        $consumersWithoutQR = $totalConsumers - $consumersWithQR;
        
        $this->info("\nOverall Statistics:");
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Consumers', $totalConsumers],
                ['With QR Codes', $consumersWithQR],
                ['Without QR Codes', $consumersWithoutQR],
            ]
        );
        
        // Show sample QR codes
        $sampleQRs = DB::table('qr_codes')
            ->where('type', 'consumer_profile')
            ->limit(5)
            ->get();
        
        if ($sampleQRs->isNotEmpty()) {
            $this->info("\nSample Consumer QR Codes:");
            $this->table(
                ['Consumer ID', 'Code', 'Active'],
                $sampleQRs->map(function ($qr) {
                    return [
                        $qr->consumer_id,
                        substr($qr->code, 0, 50) . '...',
                        $qr->active ? 'Yes' : 'No'
                    ];
                })
            );
        }
        
        if ($consumersWithoutQR > 0) {
            $this->newLine();
            $this->warn("⚠️  {$consumersWithoutQR} consumers don't have QR codes.");
            $this->info("Run 'php artisan qr:generate-consumer' to generate them.");
        }
    }
}