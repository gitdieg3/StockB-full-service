<?php

namespace App\Http\Controllers;

use App\Models\Barang; // <- Ini WAJIB!
use App\Models\BarangKeluar; // <- Pastikan model ini ADA!

class AdminController extends Controller
{


    public function index()
    {
        $stokTersedia = Barang::sum('jumlah'); // Barang yang ada di gudang sekarang
        $totalKeluar = BarangKeluar::sum('jumlah_keluar'); // Barang yang sudah keluar

        $totalMasuk = $stokTersedia + $totalKeluar; // Barang Masuk = stok sekarang + barang keluar

        $stokHampirHabis = Barang::where('jumlah', '<=', 5)->get();

        $grafikLabels = ['Jan', 'Feb', 'Mar', 'Apr'];
        $grafikMasuk = [10, 20, 15, 30];
        $grafikKeluar = [5, 10, 7, 20];

        $calendarEvents = []; // kosong dulu

        return view('admin.index', compact(
            'totalMasuk',
            'totalKeluar',
            'stokTersedia',
            'stokHampirHabis',
            'grafikLabels',
            'grafikMasuk',
            'grafikKeluar',
            'calendarEvents'
        ));
    }
    

   
}
