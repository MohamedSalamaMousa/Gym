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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('whatsapp')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('barcode')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};