<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranSpp extends Model
{
    protected $table = 'pembayaran_spp';
    protected $fillable = [
        'no_transaksi', 'siswa_id', 'tarif_id', 'bulan', 'tahun',
        'tanggal_bayar', 'jumlah_bayar', 'biaya_admin', 'total_bayar',
        'metode_bayar', 'petugas_id', 'keterangan', 'status',
    ];

    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function tarif() { return $this->belongsTo(TarifSpp::class, 'tarif_id'); }
    public function petugas() { return $this->belongsTo(User::class, 'petugas_id'); }

    public static function generateNoTransaksi(): string
    {
        $date = now()->format('Ymd');
        $last = static::whereDate('created_at', today())->count() + 1;
        return 'SPP-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getNamaBulanAttribute(): string
    {
        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $bulan[$this->bulan] ?? '';
    }
}
