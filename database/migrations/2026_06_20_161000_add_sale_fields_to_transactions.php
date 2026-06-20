<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'source_type')) {
                $table->string('source_type')->nullable()->after('method'); // 'product' or 'service'
            }
            if (!Schema::hasColumn('transactions', 'source_id')) {
                $table->unsignedBigInteger('source_id')->nullable()->after('source_type');
            }
            if (!Schema::hasColumn('transactions', 'items')) {
                $table->json('items')->nullable()->after('source_id'); // cart items
            }
            if (!Schema::hasColumn('transactions', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_email');
            }
            if (!Schema::hasColumn('transactions', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->after('amount');
            }
            if (!Schema::hasColumn('transactions', 'tax')) {
                $table->decimal('tax', 10, 2)->default(0)->after('discount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'source_id', 'items', 'customer_phone', 'discount', 'tax']);
        });
    }
};
