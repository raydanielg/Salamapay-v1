<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->enum('page_type', ['catalog', 'fixed'])->default('fixed')->after('logo');
            $table->boolean('allow_custom_amount')->default(false)->after('page_type');
            $table->json('products')->nullable()->after('allow_custom_amount');
        });
    }

    public function down(): void
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->dropColumn(['page_type', 'allow_custom_amount', 'products']);
        });
    }
};
