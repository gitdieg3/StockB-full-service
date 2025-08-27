<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\TipeBarang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalisisExport;
use PDF;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = TipeBarang::all();

        $totalMasuk = Barang::sum('jumlah');
        $totalKeluar = BarangKeluar::sum('jumlah_keluar');

        $growthPercent = $totalMasuk > 0 ? number_format((($totalMasuk - $totalKeluar) / $totalMasuk) * 100, 2) : 0;

        $grafikLabels = ['Jan', 'Feb', 'Mar', 'Apr'];
        $grafikMasuk = [100, 200, 150, 300];
        $grafikKeluar = [80, 150, 100, 250];

        $pieData = TipeBarang::withCount('barangs')->get();
        $pieLabels = $pieData->pluck('nama_tipe');
        $pieCounts = $pieData->pluck('barangs_count');

        $topBarangKeluar = BarangKeluar::with('barang')
            ->selectRaw('barang_id, SUM(jumlah_keluar) as total_keluar')
            ->groupBy('barang_id')
            ->orderByDesc('total_keluar')
            ->take(5)
            ->get();

        return view('admin.analisis', compact(
            'kategoriList', 'totalMasuk', 'totalKeluar', 'growthPercent',
            'grafikLabels', 'grafikMasuk', 'grafikKeluar', 'pieLabels', 'pieCounts',
            'topBarangKeluar'
        ));
    }

    public function exportExcel()
    {
        return Excel::download(new AnalisisExport, 'analisis.xlsx');
    }

    public function exportPDF()
    {
        $data = [
            'totalMasuk' => Barang::sum('jumlah'),
            'totalKeluar' => BarangKeluar::sum('jumlah_keluar'),
            'topBarangKeluar' => BarangKeluar::with('barang')
                ->selectRaw('barang_id, SUM(jumlah_keluar) as total_keluar')
                ->groupBy('barang_id')
                ->orderByDesc('total_keluar')
                ->take(5)
                ->get()
        ];

        $pdf = PDF::loadView('admin.analisis_pdf', $data);
        return $pdf->download('analisis.pdf');
    }

    public function realtime()
    {
        return response()->json([
            'totalMasuk' => Barang::sum('jumlah'),
            'totalKeluar' => BarangKeluar::sum('jumlah_keluar')
        ]);
    }
        public function getAnalyticsData()
    {
        $topBarangKeluar = BarangKeluar::select('nama_barang', \DB::raw('SUM(jumlah_keluar) as total'))
            ->groupBy('nama_barang')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $stokPerKategori = Barang::select('kategori', \DB::raw('SUM(jumlah) as total'))
            ->groupBy('kategori')
            ->get();

        $mingguanGrowth = $this->calculateGrowth('weekly');
        $bulananGrowth = $this->calculateGrowth('monthly');

        return response()->json([
            'topBarangKeluar' => $topBarangKeluar,
            'stokPerKategori' => $stokPerKategori,
            'mingguanGrowth' => $mingguanGrowth,
            'bulananGrowth' => $bulananGrowth,
        ]);
    }
}
