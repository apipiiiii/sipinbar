<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PeminjamanExport;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->filteredQuery($request)->latest('tanggal_pinjam')->paginate(15)->withQueryString();

        $rekap = [
            'total' => (clone $this->filteredQuery($request))->count(),
            'pending' => (clone $this->filteredQuery($request))->status('pending')->count(),
            // disetujui admin, sedang dipinjam, dan proses pengembalian (belum final)
            'approved' => (clone $this->filteredQuery($request))->whereIn('status', ['disetujui', 'approved', 'pengembalian', 'dicek_petugas'])->count(),
            'rejected' => (clone $this->filteredQuery($request))->status('rejected')->count(),
            'selesai' => (clone $this->filteredQuery($request))->status('selesai')->count(),
        ];

        return view('admin.laporan.index', compact('data', 'rekap'));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->filteredQuery($request)->latest('tanggal_pinjam')->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'data' => $data,
            'periode' => $this->labelPeriode($request),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-sipinbar-'.now()->format('Ymd_His').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->filteredQuery($request)->latest('tanggal_pinjam')->get();

        return Excel::download(new PeminjamanExport($data), 'laporan-peminjaman-sipinbar-'.now()->format('Ymd_His').'.xlsx');
    }

    private function filteredQuery(Request $request)
    {
        return Peminjaman::with(['siswa', 'barang'])
            ->when($request->filled('status'), function ($q) use ($request) {
                $request->status === 'terlambat' ? $q->terlambat() : $q->where('status', $request->status);
            })
            ->when($request->filled('dari'), fn ($q) => $q->whereDate('tanggal_pinjam', '>=', $request->dari))
            ->when($request->filled('sampai'), fn ($q) => $q->whereDate('tanggal_pinjam', '<=', $request->sampai));
    }

    private function labelPeriode(Request $request): string
    {
        if ($request->filled('dari') || $request->filled('sampai')) {
            return ($request->dari ?: '...').' s/d '.($request->sampai ?: '...');
        }
        return 'Semua Periode';
    }
}
