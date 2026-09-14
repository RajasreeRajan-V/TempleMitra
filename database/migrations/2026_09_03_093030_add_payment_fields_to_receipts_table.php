<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * IMPORTANT: This migration ONLY adds the `transaction_id` column to the
     * existing `receipts` table and extends the `payment_method` enum to
     * include 'other'. It does not touch any other existing column. The new
     * column is guarded with a Schema::hasColumn() check so it is safe to
     * run even if it already exists.
     */
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            if (!Schema::hasColumn('receipts', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('payment_method');
            }
        });

        // Extend the payment_method enum to include 'other'.
        // Raw SQL is required here because Laravel's schema builder can't
        // alter an existing enum's allowed values directly.
        if (Schema::hasColumn('receipts', 'payment_method')) {
            DB::statement("ALTER TABLE receipts MODIFY payment_method ENUM('cash', 'upi', 'card', 'bank_transfer', 'other') NULL");
        }
    }

    /**
     * Reverse the migrations.
     *
     * Drops transaction_id if present, and reverts payment_method back to
     * its original allowed values. Reverting the enum will fail if any row
     * currently has payment_method = 'other' — clean up that data first if
     * you need to roll back.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            if (Schema::hasColumn('receipts', 'transaction_id')) {
                $table->dropColumn('transaction_id');
            }
        });

        if (Schema::hasColumn('receipts', 'payment_method')) {
            DB::statement("ALTER TABLE receipts MODIFY payment_method ENUM('cash', 'upi', 'card', 'bank_transfer') NULL");
        }
    }
};