<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangHilang;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->when($request->filled('status'), function ($q) use ($request) {
                $request->status === 'terlambat' ? $q->terlambat() : $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('siswa.peminjaman.index', compact('peminjaman'));
    }

    public function create(Request $request)
    {
        $barangDipilih = null;
        if ($request->filled('barang_id')) {
            $barangDipilih = Barang::find($request->barang_id);
        }

        $barangList = Barang::where('stok_tersedia', '>', 0)->orderBy('nama_barang')->get();

        // Siswa hanya boleh punya 1 peminjaman aktif dalam satu waktu
        $peminjamanAktif = $this->peminjamanAktif();
        $lamaPinjam = (int) config('sipinbar.lama_pinjam_hari', 3);

        return view('siswa.peminjaman.create', compact('barangList', 'barangDipilih', 'peminjamanAktif', 'lamaPinjam'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'tanggal_pinjam' => ['required', 'date', 'after_or_equal:today'],
            'keperluan' => ['required', 'string', 'max:1000'],
        ]);

        // Batas 1 barang: tidak boleh mengajukan lagi selama masih ada peminjaman yang belum selesai
        if ($aktif = $this->peminjamanAktif()) {
            return back()->withInput()->with('error', 'Anda hanya dapat meminjam 1 barang. Selesaikan dulu peminjaman '.$aktif->kode_peminjaman.' sebelum mengajukan yang baru.');
        }

        $barang = Barang::findOrFail($validated['barang_id']);

        if ($barang->stok_tersedia < 1) {
            return back()->withInput()->with('error', 'Stok barang sedang habis.');
        }

        // Jumlah selalu 1 unit & tanggal kembali otomatis (tidak bisa diubah dari form)
        $validated['jumlah'] = 1;
        $validated['tanggal_kembali_rencana'] = Carbon::parse($validated['tanggal_pinjam'])
            ->addDays((int) config('sipinbar.lama_pinjam_hari', 3))
            ->toDateString();
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $peminjaman = Peminjaman::create($validated);

        return redirect()->route('siswa.peminjaman.show', $peminjaman)
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Silakan tunggu verifikasi dari admin, lalu ambil barang di petugas.');
    }

    /** Peminjaman siswa yang belum selesai (pending s.d. menunggu konfirmasi admin), atau null. */
    private function peminjamanAktif(): ?Peminjaman
    {
        return Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', Peminjaman::STATUS_AKTIF)
            ->latest()
            ->first();
    }

    public function show(Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->user_id === Auth::id(), 403);

        $peminjaman->load(['barang.kategori.petugas', 'verifikator', 'petugasPenyerah', 'petugasPenerima']);

        return view('siswa.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Siswa mengembalikan barang -> menunggu konfirmasi petugas, lalu admin.
     * Keterlambatan & denda dikunci pada saat siswa mengajukan pengembalian.
     */
    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->user_id === Auth::id(), 403);

        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Hanya barang yang sedang dipinjam yang dapat dikembalikan.');
        }

        $validated = $request->validate([
            'catatan_siswa' => ['nullable', 'string', 'max:1000'],
        ]);

        $hari = $peminjaman->hariTerlambat(now());

        $peminjaman->update([
            'status' => 'pengembalian',
            'tanggal_kembali_aktual' => now()->toDateString(),
            'tanggal_pengembalian_diajukan' => now(),
            'catatan_siswa' => $validated['catatan_siswa'] ?? null,
            'hari_telat' => $hari,
            'denda_telat' => Peminjaman::hitungDenda($hari),
            'denda_lunas' => false,
        ]);

        return redirect()->route('siswa.peminjaman.show', $peminjaman)
            ->with('success', 'Pengembalian dicatat. Serahkan barang ke petugas kategori terkait untuk dikonfirmasi, lalu admin akan menyelesaikan pengembalian.');
    }

    /** Siswa melaporkan barang yang sedang dipinjam hilang. */
    public function laporHilang(Request $request, Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->user_id === Auth::id(), 403);

        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Hanya barang yang sedang dipinjam yang dapat dilaporkan hilang.');
        }

        $validated = $request->validate([
            'keterangan' => ['required', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($peminjaman, $validated) {
            // Keterlambatan sampai hari laporan tetap dihitung
            $hari = $peminjaman->hariTerlambat();

            $peminjaman->update([
                'status' => 'hilang',
                'hari_telat' => $hari,
                'denda_telat' => Peminjaman::hitungDenda($hari),
                'denda_lunas' => false,
            ]);

            BarangHilang::create([
                'peminjaman_id' => $peminjaman->id,
                'barang_id' => $peminjaman->barang_id,
                'user_id' => $peminjaman->user_id,
                'jumlah' => $peminjaman->jumlah,
                'keterangan' => $validated['keterangan'],
                'tanggal_hilang' => now(),
            ]);
        });

        return redirect()->route('siswa.peminjaman.show', $peminjaman)
            ->with('success', 'Laporan barang hilang berhasil dikirim. Silakan hubungi petugas sarpras untuk penggantian dengan barang baru.');
    }
}
