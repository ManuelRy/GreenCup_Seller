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
        Schema::table('sellers', function (Blueprint $table) {
            // Add status field (pending, approved, suspended, rejected)
            $table->enum('status', ['pending', 'approved', 'suspended', 'rejected'])
                  ->default('pending')
                  ->after('is_active');

            // Update existing records: if is_active = true, status = approved, else pending
            // This will be done in a separate raw query after the column is added
        });

        // Update existing sellers: active sellers -> approved, inactive -> pending
        DB::statement("UPDATE sellers SET status = CASE WHEN is_active = 1 THEN 'approved' ELSE 'pending' END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
