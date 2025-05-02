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
        Schema::table('captain_wallets', function (Blueprint $table) {
            //
            $table->foreignId('subscription_id')->after('captain_id')->constrained('subscriptions')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('captain_wallets', function (Blueprint $table) {
            //
        });
    }
};
