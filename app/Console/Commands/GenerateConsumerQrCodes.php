<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateConsumerQrCodes extends Command
{
    protected $signature = 'qr:generate-consumer {--force : Regenerate QR codes for all consumers}';
    protected $description = 'Generate QR codes for consumers who don\'t have them';

    public function handle()
    {
        $this->info('🌱 GreenCup QR Code Generator');
        $this->info('=============================');

        // Get consumers without QR codes
        $consumersWithoutQR = DB::table('consumers as c')
            ->leftJoin('qr_codes as qc', function ($join) {
                $join->on('c.id', '=', 'qc.consumer_id')
                    ->where('qc.type', '=', 'consumer_profile')
                    ->where('qc.active', '=', true);
            })
            ->whereNull('qc.id')
            ->select('c.id', 'c.email')
            ->get();

        if ($consumersWithoutQR->isEmpty()) {
            $this->info('✅ All consumers already have QR codes!');
            return 0;
        }

        $this->info("Found {$consumersWithoutQR->count()} consumers to process...\n");

        $bar = $this->output->createProgressBar($consumersWithoutQR->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($consumersWithoutQR as $consumer) {
            try {
                $uniqueHash = strtoupper(substr(md5(uniqid($consumer->id . $consumer->email, true)), 0, 8));
                $qrCodeValue = url('/award-points/GC_' . $consumer->id . '_' . $uniqueHash);

                DB::table('qr_codes')->insert([
                    'consumer_id' => $consumer->id,
                    'type' => 'consumer_profile',
                    'code' => $qrCodeValue,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $success++;
            } catch (\Exception $e) {
                $failed++;
                $this->error("\nError for consumer {$consumer->id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);
        $this->info('QR Code Generation Complete!');
        $this->info('============================');
        $this->info("✅ Successfully generated: {$success}");

        if ($failed > 0) {
            $this->error("❌ Failed: {$failed}");
        }

        return 0;
    }
}