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
        Schema::create('captain_wallets', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['in', 'out'])->default('in');
            $table->string('description')->nullable(); // وصف المعاملة
            $table->foreignId('captain_id')->constrained('captains')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captain_wallets');
    }
};
