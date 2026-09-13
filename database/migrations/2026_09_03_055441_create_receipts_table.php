<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Restructures booking so ONE receipt (one devotee) can contain
 * MANY vazhipad line items ("1+ vazhipad, 1 person").
 *
 * receipts        -> parent record: devotee info + totals (no more single vazhipad_id/amount)
 * receipt_items   -> child rows: one row per vazhipad chosen on that receipt
 */
return new class extends Migration
{
    public function up(): void
    {     
        Schema::table('receipts', function (Blueprint $table) {
            if (Schema::hasColumn('receipts', 'vazhipad_id')) {
                $table->dropConstrainedForeignId('vazhipad_id');
            }
            if (Schema::hasColumn('receipts', 'amount')) {
                $table->renameColumn('amount', 'total_amount');
            } else {
                $table->decimal('total_amount', 10, 2)->default(0)->after('nakshatram');
            }
        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->foreignId('vazhipad_id')->nullable()->constrained('vazhipads');
            $table->renameColumn('total_amount', 'amount');
        });

    }
};