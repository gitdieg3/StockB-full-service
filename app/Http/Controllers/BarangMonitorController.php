<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\TipeBarang;
use App\Models\StatusBarang;
use App\Models\JasaKirim;

class BarangMonitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['tipe', 'status', 'jasa']);

        // FILTER
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

        $barangs = $query->latest()->paginate(10);

        // Kirim semua variabel ke view
        return view('admin.barang.index', [
            'barangs' => $barangs,
            'tipes' => TipeBarang::all(),
            'statuses' => StatusBarang::all(),
            'totalBarang' => $query->count()
        ]);
    }
}
