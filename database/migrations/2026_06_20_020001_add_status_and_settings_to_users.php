<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('role');
            }
            if (!Schema::hasColumn('users', 'settings')) {
                $table->json('settings')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name')->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('users', 'business_type')) {
                $table->string('business_type')->nullable()->after('business_name');
            }
            if (!Schema::hasColumn('users', 'business_tin')) {
                $table->string('business_tin')->nullable()->after('business_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'settings', 'business_name', 'business_type', 'business_tin']);
        });
    }
};
