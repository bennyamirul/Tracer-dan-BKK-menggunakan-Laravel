<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracer_alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('restrict');
            $table->foreignId('angkatan_id')->constrained('tahun_angkatan')->onDelete('restrict');
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('restrict');
            $table->string('posisi_peran', 100)->nullable();
            $table->enum('relevansi_jurusan', ['ya', 'tidak'])->nullable();
            $table->year('tahun_mulai')->nullable();
            $table->string('institusi_nama', 150)->nullable();
            $table->string('institusi_bidang', 100)->nullable();
            $table->string('institusi_alamat', 255)->nullable();
            $table->string('pendapatan_range', 50)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_alumni');
    }
};
