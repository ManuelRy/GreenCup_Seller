<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class CheckItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check items in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $items = Item::all();
        $this->info('Total items: ' . $items->count());

        if ($items->count() > 0) {
            $this->info('Items:');
            foreach ($items as $item) {
                $this->line("- {$item->name} (Points: {$item->points_per_unit})");
            }
        } else {
            $this->info('No items found in the database.');
        }

        return 0;
    }
}
