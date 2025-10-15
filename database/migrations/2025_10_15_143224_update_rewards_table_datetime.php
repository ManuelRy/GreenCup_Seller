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
        Schema::table('rewards', function (Blueprint $table) {
            // Change valid_from and valid_until from date to datetime
            $table->dateTime('valid_from')->change();
            $table->dateTime('valid_until')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rewards', function (Blueprint $table) {
            // Revert back to date
            $table->date('valid_from')->change();
            $table->date('valid_until')->change();
        });
    }
};
