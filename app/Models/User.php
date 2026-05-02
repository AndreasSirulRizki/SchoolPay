<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'role', 'foto', 'last_login_at'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['password' => 'hashed', 'last_login_at' => 'datetime'];

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isPetugas(): bool { return $this->role === 'petugas'; }

    public function petugasProfile() { return $this->hasOne(Petugas::class); }
    public function pembayaran() { return $this->hasMany(PembayaranSpp::class, 'petugas_id'); }

    public function getIdPetugasAttribute(): string
    {
        $prefix = $this->role === 'admin' ? 'ADM' : 'PTG';
        return $prefix . '-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
