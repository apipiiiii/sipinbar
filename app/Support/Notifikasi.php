<?php

namespace App\Support;

use App\Models\Barang;
use App\Models\BarangHilang;
use App\Models\Peminjaman;
use App\Models\User;

/**
 * Notifikasi peringatan per role (lonceng di navbar).
 *
 * Tidak memerlukan tabel baru: semua notifikasi dihitung langsung dari kondisi data saat ini,
 * jadi selalu sinkron dengan keadaan sebenarnya (mis. hilang sendiri setelah barang dikembalikan).
 * Status "sudah dibaca" disimpan di browser pengguna (localStorage) berdasarkan `key`.
 *
 * Setiap item: key, level (danger|warning|info), icon, title, message, url.
 */
class Notifikasi
{
    private const URUTAN = ['danger' => 0, 'warning' => 1, 'info' => 2];

    /** Hasil per pengguna untuk satu request (lonceng dan banner dashboard memakai data yang sama). */
    private static array $memo = [];

    public static function untuk(User $user): array
    {
        return self::$memo[$user->id] ??= self::hitung($user);
    }

    private static function hitung(User $user): array
    {
        $items = match (true) {
            $user->isAdmin() => self::admin(),
            $user->isPetugas() => self::petugas($user),
            default => self::siswa($user),
        };

        usort($items, fn ($a, $b) => self::URUTAN[$a['level']] <=> self::URUTAN[$b['level']]);

        return $items;
    }

    private static function item(string $key, string $level, string $icon, string $title, string $message, string $url): array
    {
        return compact('key', 'level', 'icon', 'title', 'message', 'url');
    }

    /* ---------------------------------------------------------------- Siswa */

    private static function siswa(User $user): array
    {
        $out = [];
        $rp = fn ($n) => Peminjaman::rupiah((int) $n);

        // Terlambat dikembalikan
        $terlambat = Peminjaman::with('barang')->where('user_id', $user->id)->terlambat()->orderBy('tanggal_kembali_rencana')->get();
        foreach ($terlambat as $p) {
            $out[] = self::item(
                'late:'.$p->id, 'danger', 'fa-triangle-exclamation',
                'Terlambat '.$p->hariTerlambat().' hari',
                $p->barang->nama_barang.' ('.$p->kode_peminjaman.') · denda '.$rp($p->dendaSaatIni()).'. Segera kembalikan ke petugas.',
                route('siswa.peminjaman.show', $p)
            );
        }

        // Barang hilang belum diganti
        $hilang = Peminjaman::with('barang')->where('user_id', $user->id)->status('hilang')->get();
        foreach ($hilang as $p) {
            $out[] = self::item(
                'lost:'.$p->id, 'danger', 'fa-box-open',
                'Barang hilang belum diganti',
                'Ganti '.$p->barang->nama_barang.' ('.$p->jumlah.' unit) dengan barang baru dan serahkan ke petugas.',
                route('siswa.peminjaman.show', $p)
            );
        }

        // Denda belum lunas
        $denda = (int) Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['pengembalian', 'dicek_petugas', 'selesai', 'hilang', 'diganti'])
            ->where('denda_telat', '>', 0)->where('denda_lunas', false)->sum('denda_telat');
        if ($denda > 0) {
            $out[] = self::item('fine:'.$denda, 'warning', 'fa-money-bill-wave', 'Denda belum dibayar', $rp($denda).' belum lunas. Silakan bayar ke petugas sarpras.', route('siswa.peminjaman.index'));
        }

        // Jatuh tempo hari ini / besok (belum terlambat)
        $aktif = Peminjaman::with('barang')->where('user_id', $user->id)->where('status', 'approved')
            ->whereDate('tanggal_kembali_rencana', '>=', now()->toDateString())
            ->whereDate('tanggal_kembali_rencana', '<=', now()->addDay()->toDateString())->get();
        foreach ($aktif as $p) {
            $hariIni = $p->tanggal_kembali_rencana->isToday();
            $out[] = self::item(
                'due:'.$p->id.':'.$p->tanggal_kembali_rencana->format('Ymd'), 'warning', 'fa-clock',
                $hariIni ? 'Jatuh tempo hari ini' : 'Jatuh tempo besok',
                'Kembalikan '.$p->barang->nama_barang.' ('.$p->kode_peminjaman.') sebelum '.$p->tanggal_kembali_rencana->format('d M Y').'.',
                route('siswa.peminjaman.show', $p)
            );
        }

        // Pengajuan disetujui, tinggal diambil
        $disetujui = Peminjaman::with(['barang.kategori.petugas'])->where('user_id', $user->id)->status('disetujui')->get();
        foreach ($disetujui as $p) {
            $petugas = optional(optional($p->barang->kategori)->petugas)->name ?? 'petugas sarpras';
            $out[] = self::item('ok:'.$p->id, 'info', 'fa-circle-check', 'Pengajuan disetujui', 'Ambil '.$p->barang->nama_barang.' di '.$petugas.'.', route('siswa.peminjaman.show', $p));
        }

        // Pengajuan ditolak (7 hari terakhir)
        $ditolak = Peminjaman::with('barang')->where('user_id', $user->id)->status('rejected')->where('updated_at', '>=', now()->subDays(7))->get();
        foreach ($ditolak as $p) {
            $out[] = self::item('rej:'.$p->id, 'info', 'fa-circle-xmark', 'Pengajuan ditolak', $p->barang->nama_barang.($p->catatan_admin ? ': '.$p->catatan_admin : '.'), route('siswa.peminjaman.show', $p));
        }

        return $out;
    }

    /* ---------------------------------------------------------------- Admin */

    private static function admin(): array
    {
        $out = [];

        $terlambat = Peminjaman::terlambat()->get();
        if ($terlambat->isNotEmpty()) {
            $denda = (int) $terlambat->sum(fn ($p) => $p->dendaSaatIni());
            $out[] = self::item('late:'.$terlambat->count(), 'danger', 'fa-triangle-exclamation', $terlambat->count().' peminjaman terlambat', 'Denda berjalan '.Peminjaman::rupiah($denda).'.', route('admin.peminjaman.index', ['status' => 'terlambat']));
        }

        $hilang = BarangHilang::where('status', 'belum_diganti');
        if (($n = (clone $hilang)->count()) > 0) {
            $out[] = self::item('lost:'.$n, 'danger', 'fa-box-open', $n.' barang hilang belum diganti', (int) (clone $hilang)->sum('jumlah').' unit menunggu penggantian dari siswa.', route('admin.hilang.index'));
        }

        if (($n = Peminjaman::status('pending')->count()) > 0) {
            $out[] = self::item('pending:'.$n, 'warning', 'fa-hourglass-half', $n.' pengajuan menunggu verifikasi', 'Setujui atau tolak pengajuan peminjaman siswa.', route('admin.peminjaman.index', ['status' => 'pending']));
        }

        if (($n = Peminjaman::status('dicek_petugas')->count()) > 0) {
            $out[] = self::item('confirm:'.$n, 'warning', 'fa-clipboard-check', $n.' pengembalian menunggu konfirmasi', 'Barang sudah diterima petugas, tinggal konfirmasi akhir.', route('admin.peminjaman.index', ['status' => 'dicek_petugas']));
        }

        if (($n = Barang::where('stok_tersedia', '<=', 2)->count()) > 0) {
            $habis = Barang::where('stok_tersedia', 0)->count();
            $out[] = self::item('stock:'.$n.':'.$habis, 'warning', 'fa-cubes', $n.' barang stok menipis', $habis > 0 ? $habis.' di antaranya sudah habis.' : 'Sisa tersedia 2 unit atau kurang.', route('admin.barang.index'));
        }

        $denda = (int) Peminjaman::whereIn('status', ['pengembalian', 'dicek_petugas', 'selesai', 'hilang', 'diganti'])
            ->where('denda_telat', '>', 0)->where('denda_lunas', false)->sum('denda_telat');
        if ($denda > 0) {
            $out[] = self::item('fine:'.$denda, 'info', 'fa-money-bill-wave', 'Denda belum lunas', Peminjaman::rupiah($denda).' belum dibayar siswa.', route('admin.laporan.index'));
        }

        return $out;
    }

    /* -------------------------------------------------------------- Petugas */

    private static function petugas(User $user): array
    {
        $out = [];
        $kategoriIds = $user->kategoriDiampu()->pluck('id');

        if ($kategoriIds->isEmpty()) {
            return [self::item('nocat', 'warning', 'fa-user-gear', 'Belum ada kategori yang diampu', 'Minta admin menetapkan Anda sebagai petugas pada sebuah kategori.', route('profile.edit'))];
        }

        $untukSaya = fn () => Peminjaman::untukPetugas($user->id);

        $terlambat = $untukSaya()->terlambat()->count();
        if ($terlambat > 0) {
            $out[] = self::item('late:'.$terlambat, 'danger', 'fa-triangle-exclamation', $terlambat.' peminjaman terlambat', 'Hubungi siswa untuk segera mengembalikan barang.', route('petugas.peminjaman.index', ['tampil' => 'approved']));
        }

        if (($n = $untukSaya()->status('disetujui')->count()) > 0) {
            $out[] = self::item('serve:'.$n, 'warning', 'fa-hand-holding-hand', $n.' barang perlu diserahkan', 'Pengajuan sudah disetujui admin, tunggu siswa mengambil barang.', route('petugas.peminjaman.index', ['tampil' => 'tugas']));
        }

        if (($n = $untukSaya()->status('pengembalian')->count()) > 0) {
            $out[] = self::item('recv:'.$n, 'warning', 'fa-rotate-left', $n.' pengembalian perlu diterima', 'Periksa kondisi barang yang dikembalikan siswa.', route('petugas.peminjaman.index', ['tampil' => 'tugas']));
        }

        $menipis = Barang::whereIn('kategori_barang_id', $kategoriIds)->where('stok_tersedia', '<=', 2)->count();
        if ($menipis > 0) {
            $out[] = self::item('stock:'.$menipis, 'info', 'fa-cubes', $menipis.' barang stok menipis', 'Pada kategori yang Anda ampu.', route('petugas.dashboard'));
        }

        return $out;
    }
}
