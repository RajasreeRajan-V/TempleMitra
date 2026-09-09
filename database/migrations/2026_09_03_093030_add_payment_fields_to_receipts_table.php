<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * IMPORTANT: This migration ONLY adds new payment-related columns to the
     * existing `receipts` table. It does NOT touch, rename, or drop any
     * existing columns (including `vazhipad_id` and `amount`, which live on
     * ReceiptItem, not here). Each column is guarded with a
     * Schema::hasColumn() check so it is safe to run even if one or more of
     * these columns already exist.
     */
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            if (!Schema::hasColumn('receipts', 'payment_status')) {
                $table->enum('payment_status', [
                    'pending',
                    'paid',
                    'partially_paid',
                    'cancelled',
                ])->default('pending')->after('total_amount');
            }

            if (!Schema::hasColumn('receipts', 'payment_method')) {
                $table->enum('payment_method', [
                    'cash',
                    'upi',
                    'card',
                    'bank_transfer',
                ])->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('receipts', 'paid_amount')) {
                $table->decimal('paid_amount', 12, 2)->default(0)->after('payment_method');
            }

            if (!Schema::hasColumn('receipts', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('paid_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * Only drops the columns this migration itself added, and only if they
     * exist. This will never touch any pre-existing column on `receipts`.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $columns = ['payment_status', 'payment_method', 'paid_amount', 'paid_at'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('receipts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};