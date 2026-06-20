<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_links', 'profile_id')) {
                $table->foreignId('profile_id')->nullable()->after('user_id')->constrained('payment_profiles')->nullOnDelete();
            }
            if (!Schema::hasColumn('payment_links', 'custom_fields')) {
                $table->json('custom_fields')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
            $table->dropColumn('custom_fields');
        });
    }
};
