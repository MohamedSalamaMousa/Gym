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
        Schema::table('members', function (Blueprint $table) {
            //
            // Adding the 'updated_by' column to the 'members' table
            $table->string('updated_by')->nullable()->after('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            //
            // Dropping the 'updated_by' column from the 'members' table
            $table->dropColumn('updated_by');
        });
    }
};