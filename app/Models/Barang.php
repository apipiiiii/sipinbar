<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_barang_id',
        'kode_barang',
        'nama_barang',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'deskripsi',
        'foto',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function getStatusStokAttribute(): string
    {
        if ($this->stok_tersedia <= 0) {
            return 'Habis';
        }
        if ($this->stok_tersedia <= 2) {
            return 'Menipis';
        }
        return 'Tersedia';
    }
}
