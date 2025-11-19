<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained()->onDelete('cascade');
            $table->date('tanggal'); // Tipe data date
            $table->integer('sesi'); // Tipe data integer untuk sesi 1-12
            $table->text('keperluan');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Mencegah duplikasi peminjaman pada ruangan, tanggal, dan sesi yang sama
            $table->unique(['ruangan_id', 'tanggal', 'sesi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};