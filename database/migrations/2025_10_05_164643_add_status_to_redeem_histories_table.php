<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('redeem_histories', function (Blueprint $table) {
            // Add quantity column to track how many items were redeemed (only if not exists)
            if (!Schema::hasColumn('redeem_histories', 'quantity')) {
                $table->integer('quantity')->default(1)->after('reward_id');
            }

            // Add status column: 'pending', 'approved', 'rejected' (only if not exists)
            if (!Schema::hasColumn('redeem_histories', 'status')) {
                $table->string('status', 20)->default('pending')->after('is_redeemed');
            }

            // Add approved_at and rejected_at timestamps (only if not exist)
            if (!Schema::hasColumn('redeem_histories', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('redeem_histories', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_at');
            }

            // Add rejection reason (optional, only if not exists)
            if (!Schema::hasColumn('redeem_histories', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('rejected_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redeem_histories', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'status', 'approved_at', 'rejected_at', 'rejection_reason']);
        });
    }
};
