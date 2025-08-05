<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Exports\BarangKeluarExport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Http\Request;


class BarangKeluarController extends Controller
{
    // Menampilkan daftar barang keluar
    public function index()
    {
        $barangKeluars = BarangKeluar::with('barang')->paginate(10);
        $barangs = Barang::all();  // <-- Tambahkan ini

        return view('admin.barangKeluar.indexBarangKeluar', compact('barangKeluars', 'barangs'));
    }


    // Form input barang keluar
    public function create(Request $request)
    {
        $barangs = Barang::all();
        $selectedBarang = null;

        if ($request->has('barang_id')) {
            $selectedBarang = Barang::find($request->barang_id);
        }

        return view('admin.barangKeluar.create', compact('barangs', 'selectedBarang'));
    }

    // Proses simpan barang keluar
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->jumlah < $request->jumlah_keluar) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Simpan data barang keluar
        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'jumlah_keluar' => $request->jumlah_keluar,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
        ]);

        // Update stok barang di tabel barang
        $barang->decrement('jumlah', $request->jumlah_keluar);

        return redirect()->route('barangKeluar.index')->with('success', 'Barang berhasil dikeluarkan');
    }

    // Export Excel
}
