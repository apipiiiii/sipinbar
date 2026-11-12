<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Petugas hanya menangani peminjaman untuk barang pada kategori yang ia ampu.
 *  - serahkan : konfirmasi barang sudah diserahkan ke siswa (setelah admin menyetujui)
 *  - terima   : konfirmasi barang sudah dikembalikan siswa & periksa kondisi (sebelum admin mengonfirmasi)
 */
class PeminjamanController extends Controller
{
    private const FILTER = [
        'tugas' => 'Perlu Tindakan Saya',
        'approved' => 'Sedang Dipinjam',
        'dicek_petugas' => 'Menunggu Konfirmasi Admin',
        'selesai' => 'Selesai',
        'semua' => 'Semua',
    ];

    public function index(Request $request)
    {
        $tampil = array_key_exists((string) $request->tampil, self::FILTER) ? $request->tampil : 'tugas';

        $peminjaman = Peminjaman::with(['siswa', 'barang.kategori'])
            ->untukPetugas(auth()->id())
            ->when($tampil === 'tugas', fn ($q) => $q->whereIn('status', ['disetujui', 'pengembalian']))
            ->when(! in_array($tampil, ['tugas', 'semua'], true), fn ($q) => $q->where('status', $tampil))
            // "semua" hanya menampilkan transaksi yang sudah melibatkan petugas
            ->when($tampil === 'semua', fn ($q) => $q->whereIn('status', ['disetujui', 'approved', 'pengembalian', 'dicek_petugas', 'selesai', 'hilang', 'diganti']))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('kode_peminjaman', 'like', "%{$request->q}%")
                        ->orWhereHas('siswa', fn ($s) => $s->where('name', 'like', "%{$request->q}%"));
                });
            })
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.peminjaman.index', [
            'peminjaman' => $peminjaman,
            'filter' => self::FILTER,
            'tampil' => $tampil,
        ]);
    }

    public function show(Peminjaman $peminjaman)
    {
        $this->pastikanMilikPetugas($peminjaman);

        $peminjaman->load(['siswa', 'barang.kategori', 'verifikator', 'petugasPenyerah', 'petugasPenerima', 'adminPengembalian']);

        return view('petugas.peminjaman.show', compact('peminjaman'));
    }

    /** Barang diserahkan ke siswa -> status menjadi "Sedang Dipinjam". */
    public function serahkan(Request $request, Peminjaman $peminjaman)
    {
        $this->pastikanMilikPetugas($peminjaman);

        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Penyerahan hanya bisa dikonfirmasi untuk pengajuan yang sudah disetujui admin.');
        }

        $validated = $request->validate([
            'catatan_penyerahan' => ['nullable', 'string', 'max:1000'],
        ]);

        $peminjaman->update([
            'status' => 'approved',
            'diserahkan_oleh' => auth()->id(),
            'tanggal_diserahkan' => now(),
            'catatan_penyerahan' => $validated['catatan_penyerahan'] ?? null,
        ]);

        return back()->with('success', 'Penyerahan barang ke siswa berhasil dikonfirmasi. Status: Sedang Dipinjam.');
    }

    /** Barang diterima dari siswa -> menunggu konfirmasi final admin. */
    public function terima(Request $request, Peminjaman $peminjaman)
    {
        $this->pastikanMilikPetugas($peminjaman);

        if ($peminjaman->status !== 'pengembalian') {
            return back()->with('error', 'Penerimaan hanya bisa dikonfirmasi setelah siswa mengajukan pengembalian.');
        }

        $validated = $request->validate([
            'kondisi_kembali' => ['required', Rule::in(['baik', 'rusak ringan', 'rusak berat'])],
            'catatan_petugas' => ['nullable', 'string', 'max:1000'],
        ]);

        $peminjaman->update([
            'status' => 'dicek_petugas',
            'kondisi_kembali' => $validated['kondisi_kembali'],
            'catatan_petugas' => $validated['catatan_petugas'] ?? null,
            'diterima_oleh' => auth()->id(),
            'tanggal_diterima_petugas' => now(),
        ]);

        return back()->with('success', 'Penerimaan barang dikonfirmasi. Menunggu konfirmasi akhir dari admin.');
    }

    /** Petugas hanya boleh mengakses transaksi pada kategori yang ia ampu. */
    private function pastikanMilikPetugas(Peminjaman $peminjaman): void
    {
        $milik = Peminjaman::untukPetugas(auth()->id())->whereKey($peminjaman->getKey())->exists();

        abort_unless($milik, 403, 'Barang ini bukan dari kategori yang menjadi tanggung jawab Anda.');
    }
}
