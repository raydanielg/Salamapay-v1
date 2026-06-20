<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->foreignId('template_id')->nullable()->after('color')->constrained('templates')->nullOnDelete();
            $table->json('template_settings')->nullable()->after('template_id');
        });
    }

    public function down(): void
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropColumn(['template_id', 'template_settings']);
        });
    }
};
