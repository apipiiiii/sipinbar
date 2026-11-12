<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'no_hp',
        'alamat',
        'jabatan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /** Akun login petugas. */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Kategori barang yang diampu petugas ini. */
    public function kategori()
    {
        return $this->hasMany(KategoriBarang::class, 'petugas_id', 'user_id');
    }

    /**
     * Samakan tabel petugas dengan data akun user.
     * Role petugas -> dibuat/diperbarui; bukan petugas lagi -> baris dihapus.
     */
    public static function sinkronDariUser(User $user): void
    {
        if ($user->role !== 'petugas') {
            static::where('user_id', $user->id)->delete();

            return;
        }

        static::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nip' => $user->nis_nip,
                'nama' => $user->name,
                'no_hp' => $user->no_hp,
                'alamat' => $user->alamat,
            ]
        );
    }
}
