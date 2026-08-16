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
        Schema::create('payout', function (Blueprint $table) {
            $table->id('payout_id');
            $table->foreignId('owner_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('workspace_id')->constrained('workspaces', 'id')->cascadeOnDelete();
            $table->decimal('amount');
            $table->date('period_start');
            $table->date('period_end');
            $table->enum('status', ['pending', 'paid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout');
    }
};
