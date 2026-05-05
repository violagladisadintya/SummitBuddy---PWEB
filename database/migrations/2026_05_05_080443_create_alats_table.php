<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama', 100);
            $table->enum('kategori', ['Tenda', 'Carrier', 'Sleeping', 'Kompor', 'Aksesoris']);
            $table->integer('stok')->default(0);
            $table->decimal('harga', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->date('tgl_masuk');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
