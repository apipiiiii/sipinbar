<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'barang_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'keperluan',
        'status',
        'catatan_admin',
        'diverifikasi_oleh',
        'tanggal_verifikasi',
        'tanggal_kembali_aktual',
        'kondisi_kembali',
        'catatan_pengembalian',
        'hari_telat',
        'denda_telat',
        'denda_lunas',
        // Alur konfirmasi petugas & admin
        'diserahkan_oleh',
        'tanggal_diserahkan',
        'catatan_penyerahan',
        'tanggal_pengembalian_diajukan',
        'catatan_siswa',
        'diterima_oleh',
        'tanggal_diterima_petugas',
        'catatan_petugas',
        'dikonfirmasi_kembali_oleh',
        'tanggal_konfirmasi_kembali',
    ];

    /**
     * Alur status:
     *  pending        : siswa mengajukan, menunggu verifikasi admin
     *  disetujui      : admin sudah setuju, menunggu petugas menyerahkan barang ke siswa
     *  approved       : barang sudah diserahkan petugas = SEDANG DIPINJAM
     *  pengembalian   : siswa sudah mengembalikan, menunggu konfirmasi petugas
     *  dicek_petugas  : petugas sudah menerima & memeriksa, menunggu konfirmasi admin
     *  selesai        : admin mengonfirmasi barang sudah dikembalikan
     *  rejected / hilang / diganti : seperti sebelumnya
     */
    public const STATUS_AKTIF = ['pending', 'disetujui', 'approved', 'pengembalian', 'dicek_petugas'];

    /** Daftar status untuk dropdown filter (satu sumber untuk semua halaman). */
    public static function daftarStatus(): array
    {
        return [
            'pending' => 'Menunggu Verifikasi Admin',
            'disetujui' => 'Menunggu Penyerahan Petugas',
            'approved' => 'Sedang Dipinjam',
            'terlambat' => 'Terlambat',
            'pengembalian' => 'Pengembalian: Menunggu Petugas',
            'dicek_petugas' => 'Pengembalian: Menunggu Admin',
            'rejected' => 'Ditolak',
            'selesai' => 'Selesai',
            'hilang' => 'Hilang (Belum Diganti)',
            'diganti' => 'Hilang (Sudah Diganti)',
        ];
    }

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'tanggal_verifikasi' => 'datetime',
        'tanggal_diserahkan' => 'datetime',
        'tanggal_pengembalian_diajukan' => 'datetime',
        'tanggal_diterima_petugas' => 'datetime',
        'tanggal_konfirmasi_kembali' => 'datetime',
        'denda_lunas' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function (Peminjaman $peminjaman) {
            if (empty($peminjaman->kode_peminjaman)) {
                $peminjaman->kode_peminjaman = 'PJM-'.now()->format('Ymd').'-'.strtoupper(Str::random(4));
            }
        });
    }

    /* ================= Relasi ================= */

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function petugasPenyerah()
    {
        return $this->belongsTo(User::class, 'diserahkan_oleh');
    }

    public function petugasPenerima()
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }

    public function adminPengembalian()
    {
        return $this->belongsTo(User::class, 'dikonfirmasi_kembali_oleh');
    }

    public function barangHilang()
    {
        return $this->hasOne(BarangHilang::class, 'peminjaman_id');
    }

    /* ================= Scope & Helper ================= */

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /** Hanya transaksi untuk barang pada kategori yang diampu petugas tertentu. */
    public function scopeUntukPetugas($query, int $petugasId)
    {
        return $query->whereHas('barang.kategori', fn ($q) => $q->where('petugas_id', $petugasId));
    }

    /** Sedang dipinjam (approved) dan sudah lewat tanggal rencana kembali. */
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'approved')
            ->whereDate('tanggal_kembali_rencana', '<', now()->toDateString());
    }

    /* ================= Keterlambatan & Denda ================= */

    /** Jumlah hari terlambat sampai tanggal $sampai (default: hari ini). */
    public function hariTerlambat(?Carbon $sampai = null): int
    {
        $sampai = ($sampai ?? now())->copy()->startOfDay();
        $batas = $this->tanggal_kembali_rencana->copy()->startOfDay();

        return $sampai->greaterThan($batas) ? $batas->diffInDays($sampai) : 0;
    }

    public function isTerlambat(): bool
    {
        return $this->status === 'approved' && $this->hariTerlambat() > 0;
    }

    public static function hitungDenda(int $hari): int
    {
        if ($hari <= 0) {
            return 0;
        }

        $tarif = (int) config('sipinbar.denda_telat', 5000);

        return config('sipinbar.denda_telat_per_hari', true) ? $tarif * $hari : $tarif;
    }

    public static function infoTarifDenda(): string
    {
        $tarif = self::rupiah((int) config('sipinbar.denda_telat', 5000));

        return config('sipinbar.denda_telat_per_hari', true)
            ? $tarif.' per hari keterlambatan'
            : $tarif.' (sekali denda)';
    }

    /** Hari terlambat: dihitung langsung jika masih dipinjam, selain itu pakai nilai tersimpan. */
    public function hariTelatSaatIni(): int
    {
        return $this->status === 'approved' ? $this->hariTerlambat() : (int) $this->hari_telat;
    }

    /** Denda: dihitung langsung jika masih dipinjam, selain itu pakai nilai tersimpan. */
    public function dendaSaatIni(): int
    {
        return $this->status === 'approved'
            ? self::hitungDenda($this->hariTerlambat())
            : (int) $this->denda_telat;
    }

    public function statusDenda(): string
    {
        if ($this->dendaSaatIni() <= 0) {
            return '-';
        }
        if ($this->status === 'approved') {
            return 'Berjalan';
        }

        return $this->denda_lunas ? 'Lunas' : 'Belum Lunas';
    }

    public static function rupiah(int $nominal): string
    {
        return 'Rp '.number_format($nominal, 0, ',', '.');
    }

    /* ================= Tampilan ================= */

    public function badgeColor(): string
    {
        if ($this->isTerlambat()) {
            return 'danger';
        }

        return match ($this->status) {
            'pending' => 'warning',
            'disetujui' => 'info',
            'approved' => 'primary',
            'pengembalian' => 'warning',
            'dicek_petugas' => 'dark',
            'rejected' => 'danger',
            'selesai' => 'success',
            'hilang' => 'danger',
            'diganti' => 'info',
            default => 'secondary',
        };
    }

    public function labelStatus(): string
    {
        if ($this->isTerlambat()) {
            return 'Terlambat '.$this->hariTerlambat().' hari';
        }

        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi Admin',
            'disetujui' => 'Disetujui, Menunggu Petugas',
            'approved' => 'Sedang Dipinjam',
            'pengembalian' => 'Pengembalian: Menunggu Petugas',
            'dicek_petugas' => 'Pengembalian: Menunggu Admin',
            'rejected' => 'Ditolak',
            'selesai' => 'Selesai / Dikembalikan',
            'hilang' => 'Hilang (Belum Diganti)',
            'diganti' => 'Hilang (Sudah Diganti)',
            default => $this->status,
        };
    }
}
