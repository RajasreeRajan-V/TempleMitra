<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('temples_registration', function (Blueprint $table) {
            $table->timestamp('one_month_notification_sent_at')
                ->nullable()
                ->after('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('temples_registration', function (Blueprint $table) {
            $table->dropColumn('one_month_notification_sent_at');
        });
    }
};