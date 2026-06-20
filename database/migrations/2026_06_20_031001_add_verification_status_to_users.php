<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'business_address')) {
                $table->text('business_address')->nullable()->after('business_type');
            }
            if (!Schema::hasColumn('users', 'business_registration_number')) {
                $table->string('business_registration_number', 50)->nullable()->after('business_tin');
            }
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified')->after('business_registration_number');
            }
            if (!Schema::hasColumn('users', 'verification_notes')) {
                $table->text('verification_notes')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verification_notes');
            }
            if (!Schema::hasColumn('users', 'id_document_path')) {
                $table->string('id_document_path')->nullable()->after('verified_at');
            }
            if (!Schema::hasColumn('users', 'business_document_path')) {
                $table->string('business_document_path')->nullable()->after('id_document_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_address', 'business_registration_number', 'verification_status',
                'verification_notes', 'verified_at', 'id_document_path', 'business_document_path'
            ]);
        });
    }
};
