<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('receipt_id')
                ->constrained('receipts')
                ->cascadeOnDelete();

            $table->foreignId('vazhipad_id')
                ->constrained('vazhipads')
                ->restrictOnDelete();

            $table->unsignedInteger('quantity')
                ->default(1);

            $table->decimal('amount', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipt_items');
    }
};