<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(protected Collection $data)
    {
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Kode Peminjaman',
            'Nama Siswa',
            'Kelas',
            'Nama Barang',
            'Jumlah',
            'Tanggal Pinjam',
            'Rencana Kembali',
            'Tanggal Kembali Aktual',
            'Status',
            'Kondisi Saat Kembali',
            'Catatan Admin',
            'Hari Terlambat',
            'Denda (Rp)',
            'Status Denda',
        ];
    }

    public function map($row): array
    {
        return [
            $row->kode_peminjaman,
            $row->siswa->name ?? '-',
            $row->siswa->kelas ?? '-',
            $row->barang->nama_barang ?? '-',
            $row->jumlah,
            optional($row->tanggal_pinjam)->format('d-m-Y'),
            optional($row->tanggal_kembali_rencana)->format('d-m-Y'),
            $row->tanggal_kembali_aktual ? $row->tanggal_kembali_aktual->format('d-m-Y') : '-',
            $row->labelStatus(),
            $row->kondisi_kembali ?? '-',
            $row->catatan_admin ?? '-',
            $row->hariTelatSaatIni(),
            $row->dendaSaatIni(),
            $row->statusDenda(),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
