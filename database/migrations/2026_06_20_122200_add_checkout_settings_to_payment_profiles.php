<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->string('website_url')->nullable()->after('email');
            $table->string('language')->default('en')->after('website_url');
            $table->string('success_url')->nullable()->after('language');
            $table->string('webhook_url')->nullable()->after('success_url');
            $table->boolean('require_email')->default(true)->after('webhook_url');
            $table->json('accepted_methods')->nullable()->after('require_email');
        });
    }

    public function down(): void
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->dropColumn(['website_url', 'language', 'success_url', 'webhook_url', 'require_email', 'accepted_methods']);
        });
    }
};
