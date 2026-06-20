<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('message');
            $table->text('reply')->nullable();
            $table->foreignId('replied_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('replied_at')->nullable();
            $table->enum('status', ['open', 'replied', 'closed'])->default('open');
            $table->string('ip_address', 45)->nullable();
            $table->string('source')->default('website');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_messages');
    }
};
