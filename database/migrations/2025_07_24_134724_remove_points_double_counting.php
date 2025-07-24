<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemovePointsDoubleCounting extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove the problematic trigger that's causing double counting
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_point_tx_after_insert`;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the original trigger (but we don't want this)
        DB::unprepared(<<<SQL
CREATE TRIGGER `trg_point_tx_after_insert`
AFTER INSERT ON `point_transactions`
FOR EACH ROW
BEGIN
    IF NEW.seller_id IS NOT NULL THEN
        UPDATE `sellers`
        SET `total_points` = `total_points` + NEW.points
        WHERE `id` = NEW.seller_id;
    END IF;
END;
SQL
        );
    }
}