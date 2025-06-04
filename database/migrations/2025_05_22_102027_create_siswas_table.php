<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->string('nis_siswa')->primary();
            $table->string('nama_siswa');
            $table->integer('absen_siswa');
            $table->unsignedBigInteger('id_kelas_siswa');
            $table->unsignedBigInteger('id_jurusan_siswa');
            
            $table->foreign('id_kelas_siswa')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_jurusan_siswa')->references('id_jurusan')->on('jurusans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
