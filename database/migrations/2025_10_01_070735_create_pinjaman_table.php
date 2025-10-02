<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_buku');
            $table->date('tanggal_pinjam');
            $table->date('batas_kembali');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'hilang', 'terlambat'])->default('dipinjam');
            $table->decimal('denda', 10, 2)->default(0.00);
            $table->text('keterangan')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
