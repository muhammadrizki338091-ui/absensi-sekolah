<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa')->onUpdate('cascade')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alfa'])->default('Hadir');
            $table->timestamps();

            $table->index('tanggal');
            $table->index(['id_siswa', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
