<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->unsignedBigInteger('temple_id')
                ->nullable()
                ->after('id');

            $table->foreign('temple_id')
                ->references('id')
                ->on('temples_registration')
                ->cascadeOnDelete();

            $table->index('temple_id');
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['temple_id']);
            $table->dropIndex(['temple_id']);
            $table->dropColumn('temple_id');
        });
    }
};