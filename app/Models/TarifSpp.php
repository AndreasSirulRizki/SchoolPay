<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifSpp extends Model
{
    protected $table = 'tarif_spp';
    protected $fillable = ['siswa_id', 'nominal', 'tahun_ajaran', 'is_aktif'];
    protected $casts = ['is_aktif' => 'boolean'];

    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function pembayaran() { return $this->hasMany(PembayaranSpp::class, 'tarif_id'); }
}
