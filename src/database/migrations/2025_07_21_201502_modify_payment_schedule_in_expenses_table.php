<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Ganti nama kolom due_date menjadi payment_schedule dan ubah tipenya
            $table->renameColumn('due_date', 'payment_schedule');
        });

        // Lakukan perubahan tipe data di statement terpisah
        Schema::table('expenses', function (Blueprint $table) {
            $table->dateTime('payment_schedule')->nullable()->change();
            // Tambahkan kolom untuk menandai notifikasi sudah terkirim
            $table->timestamp('notification_sent_at')->nullable()->after('payment_schedule');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('notification_sent_at');
            $table->date('payment_schedule')->nullable()->change();
            $table->renameColumn('payment_schedule', 'due_date');
        });
    }
};