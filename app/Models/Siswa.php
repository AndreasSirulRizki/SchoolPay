<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'siswa';
    protected $fillable = [
        'nis', 'nisn', 'nama', 'kelas_id', 'jenis_kelamin',
        'alamat', 'no_hp', 'foto', 'password', 'status',
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['password' => 'hashed'];

    public function getAuthIdentifierName(): string { return 'nis'; }

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function pembayaran() { return $this->hasMany(PembayaranSpp::class); }
    public function tarifSpp() { return $this->hasOne(TarifSpp::class)->where('is_aktif', true)->latest(); }

    public function getTarifAktifAttribute(): ?TarifSpp
    {
        return $this->tarifSpp()->first();
    }

    public function getNominalSppAttribute(): int
    {
        return $this->tarifAktif?->nominal ?? 150000;
    }

    public function getTahunAngkatanAttribute(): string
    {
        // Derive from NIS: first 4 chars
        return substr($this->nis, 0, 4) ?: date('Y');
    }
}
