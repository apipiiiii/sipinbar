<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::with(['siswa', 'barang'])
            ->when($request->filled('status'), function ($q) use ($request) {
                // "terlambat" bukan status di database, tapi turunan dari approved + lewat tanggal
                $request->status === 'terlambat' ? $q->terlambat() : $q->where('status', $request->status);
            })
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('kode_peminjaman', 'like', "%{$request->q}%")
                        ->orWhereHas('siswa', fn ($s) => $s->where('name', 'like', "%{$request->q}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Jumlah per status untuk tab filter cepat
        $perStatus = Peminjaman::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $hitung = [
            '' => (int) $perStatus->sum(),
            'pending' => (int) ($perStatus['pending'] ?? 0),
            'disetujui' => (int) ($perStatus['disetujui'] ?? 0),
            'approved' => (int) ($perStatus['approved'] ?? 0),
            'terlambat' => Peminjaman::terlambat()->count(),
            'pengembalian' => (int) ($perStatus['pengembalian'] ?? 0),
            'dicek_petugas' => (int) ($perStatus['dicek_petugas'] ?? 0),
            'selesai' => (int) ($perStatus['selesai'] ?? 0),
        ];

        return view('admin.peminjaman.index', compact('peminjaman', 'hitung'));
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load([
            'siswa', 'barang.kategori.petugas', 'verifikator',
            'petugasPenyerah', 'petugasPenerima', 'adminPengembalian',
        ]);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function approve(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        // Setiap kategori harus punya petugas yang akan menyerahkan barang ke siswa
        $peminjaman->loadMissing('barang.kategori.petugas');
        $petugas = optional($peminjaman->barang->kategori)->petugas;
        if (! $petugas) {
            return back()->with('error', 'Kategori "'.optional($peminjaman->barang->kategori)->nama_kategori.'" belum memiliki petugas. Atur petugas kategori ini di menu Kategori Barang terlebih dahulu.');
        }

        if ($peminjaman->barang->stok_tersedia < $peminjaman->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi untuk menyetujui pengajuan ini.');
        }

        $request->validate(['catatan_admin' => ['nullable', 'string']]);

        DB::transaction(function () use ($request, $peminjaman) {
            // Disetujui admin -> menunggu petugas menyerahkan barang. Stok langsung dipesan (dikurangi).
            $peminjaman->update([
                'status' => 'disetujui',
                'catatan_admin' => $request->catatan_admin ?: 'Pengajuan disetujui.',
                'diverifikasi_oleh' => auth()->id(),
                'tanggal_verifikasi' => now(),
            ]);

            $peminjaman->barang->decrement('stok_tersedia', $peminjaman->jumlah);
        });

        return back()->with('success', 'Pengajuan disetujui. Menunggu petugas '.$petugas->name.' menyerahkan barang ke siswa.');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $request->validate(['catatan_admin' => ['required', 'string']]);

        $peminjaman->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'diverifikasi_oleh' => auth()->id(),
            'tanggal_verifikasi' => now(),
        ]);

        return back()->with('success', 'Pengajuan peminjaman telah ditolak.');
    }

    /**
     * Konfirmasi FINAL pengembalian oleh admin.
     * Hanya bisa setelah siswa mengembalikan dan petugas menerima/memeriksa barang.
     */
    public function kembali(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dicek_petugas') {
            return back()->with('error', 'Pengembalian baru bisa dikonfirmasi admin setelah siswa mengembalikan barang dan petugas mengonfirmasi penerimaannya.');
        }

        $validated = $request->validate([
            'catatan_pengembalian' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($peminjaman, $validated) {
            $peminjaman->update([
                'status' => 'selesai',
                'catatan_pengembalian' => $validated['catatan_pengembalian'] ?? null,
                'dikonfirmasi_kembali_oleh' => auth()->id(),
                'tanggal_konfirmasi_kembali' => now(),
            ]);

            // Stok barang bertambah kembali setelah admin mengonfirmasi
            $peminjaman->barang->increment('stok_tersedia', $peminjaman->jumlah);
        });

        $hari = (int) $peminjaman->hari_telat;
        $denda = (int) $peminjaman->denda_telat;

        $pesan = 'Pengembalian dikonfirmasi & stok telah diperbarui.';
        if ($denda > 0) {
            $pesan .= " Siswa terlambat {$hari} hari, denda ".Peminjaman::rupiah($denda).'.';
        }

        return back()->with('success', $pesan);
    }

    /** Tandai denda keterlambatan sudah dibayar. */
    public function lunas(Peminjaman $peminjaman)
    {
        if (! in_array($peminjaman->status, ['selesai', 'hilang', 'diganti'], true)) {
            return back()->with('error', 'Denda baru bisa dilunasi setelah pengembalian dikonfirmasi admin atau barang dilaporkan hilang.');
        }
        if ((int) $peminjaman->denda_telat <= 0) {
            return back()->with('error', 'Peminjaman ini tidak memiliki denda.');
        }
        if ($peminjaman->denda_lunas) {
            return back()->with('error', 'Denda sudah ditandai lunas sebelumnya.');
        }

        $peminjaman->update(['denda_lunas' => true]);

        return back()->with('success', 'Denda '.Peminjaman::rupiah((int) $peminjaman->denda_telat).' ditandai lunas.');
    }
}
