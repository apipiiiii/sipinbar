<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nis_nip',
        'kelas',
        'no_hp',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* ================= Relasi ================= */

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /** Kategori barang yang menjadi tanggung jawab petugas ini. */
    public function kategoriDiampu()
    {
        return $this->hasMany(KategoriBarang::class, 'petugas_id');
    }

    /** Data profil petugas (tabel petugas), hanya ada untuk role petugas. */
    public function dataPetugas()
    {
        return $this->hasOne(Petugas::class, 'user_id');
    }

    public function peminjamanDiverifikasi()
    {
        return $this->hasMany(Peminjaman::class, 'diverifikasi_oleh');
    }

    /* ================= Helper Role ================= */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopePetugas($query)
    {
        return $query->where('role', 'petugas');
    }

    /** Nama route dashboard sesuai role. */
    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'petugas' => 'petugas.dashboard',
            default => 'siswa.dashboard',
        };
    }

    public function labelRole(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'petugas' => 'Petugas',
            default => 'Siswa',
        };
    }

    public function scopeSiswa($query)
    {
        return $query->where('role', 'siswa');
    }
}
