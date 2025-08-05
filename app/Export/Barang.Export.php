<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangKeluarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BarangKeluar::with('barang')->get()->map(function($item) {
            return [
                'Nama Barang' => $item->barang->nama_barang,
                'Jumlah Keluar' => $item->jumlah_keluar,
                'Tanggal Keluar' => $item->tanggal_keluar,
                'Keterangan' => $item->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ["Nama Barang", "Jumlah Keluar", "Tanggal Keluar", "Keterangan"];
    }
}
