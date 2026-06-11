<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sewas', function (Blueprint $table) {
            $table->string('metode_pembayaran', 30)->default('Transfer')->after('bukti_pembayaran');
            $table->string('status_pembayaran', 30)->default('Belum Bayar')->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('sewas', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'status_pembayaran']);
        });
    }
};
