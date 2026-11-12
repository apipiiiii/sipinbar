<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'kategori_barangs';

    protected $fillable = [
        'nama_kategori',
        'keterangan',
        'petugas_id',
    ];

    /** Petugas yang bertanggung jawab atas kategori ini (satu kategori = satu petugas). */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_barang_id');
    }
}
