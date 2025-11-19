<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama jika ada
        Schema::dropIfExists('peminjamans');
        
        // Buat tabel baru dengan struktur baru
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained()->onDelete('cascade');
            $table->date('tanggal'); // Ganti dari datetime
            $table->integer('sesi'); // Ganti dari datetime, 1-12
            $table->text('keperluan');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['ruangan_id', 'tanggal', 'sesi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};