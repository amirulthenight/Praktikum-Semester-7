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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            // Relasi ke pelapor (Menggunakan NIK agar konsisten dengan sistem login kita)
            $table->string('nik_pelapor', 16);

            // Data Laporan
            $table->string('foto'); // Menyimpan nama file gambar
            $table->string('koordinat'); // Menyimpan lat, long dalam satu string

            // Ktiteria untuk SPK Metode (disimpan dalam integer 1-5)
            $table->integer('c1'); // Volume
            $table->integer('c2'); // Kebauan
            $table->integer('c3'); // Jenis
            $table->integer('c4'); // Lokasi
            $table->integer('c5'); // Lama Tumpukan

            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->timestamps();

            $table->foreign('nik_pelapor')->references('nik')->on('masyarakats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
