<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap', 100);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('email', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('role', ['admin', 'petugas', 'anggota'])->default('anggota');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('foto_profil', 255)->default('default.png');
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->rememberToken(); // Add remember token column
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
