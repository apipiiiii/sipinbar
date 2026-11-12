<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangHilang extends Model
{
    protected $table = 'barang_hilang';

    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'user_id',
        'jumlah',
        'keterangan',
        'tanggal_hilang',
        'status',
        'tanggal_diganti',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_hilang' => 'date',
        'tanggal_diganti' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sudahDiganti(): bool
    {
        return $this->status === 'sudah_diganti';
    }
}
