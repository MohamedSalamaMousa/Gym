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
            //
            // Adding the 'updated_by' column to the 'captains' table
            $table->string('created_by')->nullable()->after('status');
            $table->string('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('captains', function (Blueprint $table) {
            //
            // Dropping the 'updated_by' column from the 'captains' table
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
};