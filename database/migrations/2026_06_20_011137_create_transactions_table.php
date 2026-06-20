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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tx_id', 20)->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('TZS');
            $table->string('method'); // M-Pesa, Tigo Pesa, Airtel Money, Card, Bank
            $table->enum('status', ['success', 'pending', 'failed'])->default('pending');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
