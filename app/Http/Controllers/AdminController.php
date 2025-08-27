<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $stokTersedia = Barang::sum('jumlah');
        $totalKeluar = BarangKeluar::sum('jumlah_keluar');
        $totalMasuk = $stokTersedia + $totalKeluar;

        $stokHampirHabis = Barang::where('jumlah', '<=', 5)->get();

        $grafikLabels = ['Jan', 'Feb', 'Mar', 'Apr'];
        $grafikMasuk = [10, 20, 15, 30];
        $grafikKeluar = [5, 10, 7, 20];

        $calendarEvents = [];

        $today = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6);
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Rekap Harian
        $harianMasuk = Barang::whereDate('created_at', $today)->sum('jumlah');
        $harianKeluar = BarangKeluar::whereDate('created_at', $today)->sum('jumlah_keluar');

        // Rekap Mingguan
        $mingguanMasuk = Barang::whereBetween('created_at', [$sevenDaysAgo, $today])->sum('jumlah');
        $mingguanKeluar = BarangKeluar::whereBetween('created_at', [$sevenDaysAgo, $today])->sum('jumlah_keluar');

        // Rekap Bulanan
        $bulananMasuk = Barang::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('jumlah');
        $bulananKeluar = BarangKeluar::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('jumlah_keluar');

        return view('admin.index', compact(
            'totalMasuk',
            'totalKeluar',
            'stokTersedia',
            'stokHampirHabis',
            'grafikLabels',
            'grafikMasuk',
            'grafikKeluar',
            'calendarEvents',
            'harianMasuk',
            'harianKeluar',
            'mingguanMasuk',
            'mingguanKeluar',
            'bulananMasuk',
            'bulananKeluar'
        ));
    }

    // AdminController.php


    private function calculateGrowth($period)
    {
        $model = new BarangKeluar;

        if ($period === 'weekly') {
            $startDate = now()->subWeeks(1);
        } else {
            $startDate = now()->subMonths(1);
        }

        $total = $model->where('created_at', '>=', $startDate)->sum('jumlah_keluar');
        $prevTotal = $model->where('created_at', '<', $startDate)->sum('jumlah_keluar');

        if ($prevTotal == 0) return 100;
        return round((($total - $prevTotal) / $prevTotal) * 100, 2);
    }
}
