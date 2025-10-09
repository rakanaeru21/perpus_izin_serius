<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('kode_buku', 20)->unique();
            $table->string('judul_buku', 200);
            $table->string('penulis', 100);
            $table->string('penerbit', 100)->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('kategori', 100)->nullable();
            $table->string('rak', 50)->nullable();
            $table->integer('jumlah_total')->default(1);
            $table->integer('jumlah_tersedia')->default(1);
            $table->text('deskripsi')->nullable();
            $table->string('cover', 255)->default('default_cover.png');
            $table->timestamp('tanggal_input')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
