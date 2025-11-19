<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_regulers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained()->onDelete('cascade');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->integer('sesi'); // Tipe data integer untuk sesi 1-12
            $table->string('kegiatan');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Mencegah duplikasi jadwal pada ruangan, hari, dan sesi yang sama
            $table->unique(['ruangan_id', 'hari', 'sesi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_regulers');
    }
};