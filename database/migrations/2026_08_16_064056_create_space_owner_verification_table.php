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
        Schema::create('space_owner_verification', function (Blueprint $table) {
            $table->id('verification_id');
            $table->foreignId('owner_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('proof_document_url');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->dateTime('reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('space_owner_verification');
    }
};
