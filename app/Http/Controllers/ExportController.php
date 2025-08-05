<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportExcel(Request $request)
    {
 //       return Excel::download(new BarangExport($request), 'data-barang.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Barang::with(['tipe', 'status', 'jasa']);

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tipe')) {
            $query->where('tipe_barang_id', $request->tipe);
        }

        if ($request->filled('status')) {
            $query->where('status_barang_id', $request->status);
        }

        if ($request->filled('jasa_pengiriman')) {
            $query->whereHas('jasa', function ($q) use ($request) {
                $q->where('nama_jasa', 'like', '%' . $request->jasa_pengiriman . '%');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_masuk', [$request->start_date, $request->end_date]);
        }

        $barangs = $query->get();

        $pdf = Pdf::loadView('exports.barang-pdf', compact('barangs'))->setPaper('A4', 'landscape');
        return $pdf->download('data-barang.pdf');
    }
}
