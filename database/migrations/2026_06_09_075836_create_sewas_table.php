<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code', 30);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->string('nama', 100);
            $table->string('no_hp', 15);
            $table->integer('jumlah');
            $table->date('tgl_sewa');
            $table->date('tgl_kembali');
            $table->decimal('total_harga', 10, 2);
            $table->string('status', 20)->default('aktif'); // 'aktif', 'selesai', 'dibatalkan'
            $table->text('keterangan')->nullable();
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->json('custom_answers')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
