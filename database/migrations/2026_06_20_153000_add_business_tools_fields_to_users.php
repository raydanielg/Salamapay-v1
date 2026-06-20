<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'logo')) {
                $table->string('logo')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'receipt_footer')) {
                $table->string('receipt_footer')->default('Thank you for your business!')->after('logo');
            }
            if (!Schema::hasColumn('users', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->default(18.00)->after('receipt_footer');
            }
            if (!Schema::hasColumn('users', 'currency')) {
                $table->string('currency')->default('TZS')->after('tax_rate');
            }
            if (!Schema::hasColumn('users', 'pos_enabled')) {
                $table->boolean('pos_enabled')->default(true)->after('currency');
            }
            if (!Schema::hasColumn('users', 'auto_receipt')) {
                $table->boolean('auto_receipt')->default(false)->after('pos_enabled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'logo', 'receipt_footer', 'tax_rate', 'currency', 'pos_enabled', 'auto_receipt']);
        });
    }
};
