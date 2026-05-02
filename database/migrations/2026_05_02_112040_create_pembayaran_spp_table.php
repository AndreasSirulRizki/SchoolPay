<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_spp', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('restrict');
            $table->foreignId('tarif_id')->constrained('tarif_spp')->onDelete('restrict');
            $table->tinyInteger('bulan'); // 1-12
            $table->year('tahun');
            $table->date('tanggal_bayar');
            $table->bigInteger('jumlah_bayar');
            $table->bigInteger('biaya_admin')->default(2500);
            $table->bigInteger('total_bayar');
            $table->string('metode_bayar')->default('tunai');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('restrict');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['lunas', 'belum'])->default('lunas');
            $table->timestamps();

            $table->unique(['siswa_id', 'bulan', 'tahun'], 'unique_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_spp');
    }
};
