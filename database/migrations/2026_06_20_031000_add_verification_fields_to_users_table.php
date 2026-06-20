<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable()->after('phone');
            $table->string('business_type')->nullable()->after('business_name');
            $table->text('business_address')->nullable()->after('business_type');
            $table->string('business_tin', 50)->nullable()->after('business_address');
            $table->string('business_registration_number', 50)->nullable()->after('business_tin');
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified')->after('business_registration_number');
            $table->text('verification_notes')->nullable()->after('verification_status');
            $table->timestamp('verified_at')->nullable()->after('verification_notes');
            $table->string('id_document_path')->nullable()->after('verified_at');
            $table->string('business_document_path')->nullable()->after('id_document_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name', 'business_type', 'business_address', 'business_tin',
                'business_registration_number', 'verification_status', 'verification_notes',
                'verified_at', 'id_document_path', 'business_document_path'
            ]);
        });
    }
};
