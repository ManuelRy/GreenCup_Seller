<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('redeem_histories', function (Blueprint $table) {
            // Add expires_at column - redemption expires when reward expires
            if (!Schema::hasColumn('redeem_histories', 'expires_at')) {
                $table->dateTime('expires_at')->nullable()->after('created_at');
            }
        });

        // Update existing records to set expires_at from their reward's valid_until
        DB::statement('
            UPDATE redeem_histories rh
            INNER JOIN rewards r ON rh.reward_id = r.id
            SET rh.expires_at = r.valid_until
            WHERE rh.expires_at IS NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redeem_histories', function (Blueprint $table) {
            if (Schema::hasColumn('redeem_histories', 'expires_at')) {
                $table->dropColumn('expires_at');
            }
        });
    }
};
