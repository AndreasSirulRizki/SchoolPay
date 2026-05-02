<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop FK on pembayaran_spp first
        Schema::table('pembayaran_spp', function (Blueprint $table) {
            $table->dropForeign(['tarif_id']);
            $table->unsignedBigInteger('tarif_id')->nullable()->change();
        });

        Schema::dropIfExists('tarif_spp');
        Schema::create('tarif_spp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->nullable()->constrained('siswa')->onDelete('cascade');
            $table->bigInteger('nominal');
            $table->string('tahun_ajaran');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // Re-add FK on pembayaran_spp (nullable)
        Schema::table('pembayaran_spp', function (Blueprint $table) {
            $table->foreign('tarif_id')->references('id')->on('tarif_spp')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_spp', function (Blueprint $table) {
            $table->dropForeign(['tarif_id']);
        });
        Schema::dropIfExists('tarif_spp');
        Schema::create('tarif_spp', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tarif');
            $table->bigInteger('nominal');
            $table->text('keterangan')->nullable();
            $table->string('tahun_ajaran');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }
};
