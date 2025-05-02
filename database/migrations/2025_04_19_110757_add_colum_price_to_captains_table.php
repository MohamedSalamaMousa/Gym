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
        Schema::table('captains', function (Blueprint $table) {
            $table->integer('price')->after('city')->comment('Captain price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('captains', function (Blueprint $table) {
            //
            // Drop the column if it exists
            $table->dropColumn('price');
        });
    }
};
