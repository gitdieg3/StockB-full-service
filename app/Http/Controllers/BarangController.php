<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\TipeBarang;
use App\Models\StatusBarang;
use App\Models\JasaKirim;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
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

        if ($request->filled('jasa_kirim_id')) {
            $query->where('jasa_kirim_id', $request->jasa_kirim_id);
        }

        $barangs = $query->paginate(10);
        $tipes = TipeBarang::all();
        $statuses = StatusBarang::all();
        $jasas = JasaKirim::all();

        return view('admin.barang.index', compact('barangs', 'tipes', 'statuses', 'jasas'));
    }

    public function create()
    {
        $tipes = TipeBarang::all();
        $statuses = StatusBarang::all();
        $jasas = JasaKirim::all();
        $barangs = Barang::with(['tipe', 'status', 'jasa'])->latest()->get();

        return view('admin.tambah-barang-masuk', compact('tipes', 'statuses', 'jasas', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'tipe_barang_id' => 'required|exists:tipe_barangs,id',
            'merek_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
            'status_barang_id' => 'required|exists:status_barangs,id',
            'jasa_kirim_id' => 'nullable|exists:jasa_kirims,id',
            'tanggal_masuk' => 'required|date',
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'tipe_barang_id' => $request->tipe_barang_id,
            'merek' => $request->merek_barang,
            'jumlah' => $request->jumlah_barang,
            'status_barang_id' => $request->status_barang_id,
            'jasa_kirim_id' => $request->jasa_kirim_id,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('tambahData')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $tipes = TipeBarang::all();
        $statuses = StatusBarang::all();
        $jasas = JasaKirim::all();
        $barangs = Barang::with(['tipe', 'status', 'jasa'])->latest()->get();

        return view('admin.tambah-barang-masuk', compact('barang', 'tipes', 'statuses', 'jasas', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'tipe_barang_id' => 'required|exists:tipe_barangs,id',
            'merek_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
            'status_barang_id' => 'required|exists:status_barangs,id',
            'jasa_kirim_id' => 'nullable|exists:jasa_kirims,id',
            'tanggal_masuk' => 'required|date',
        ]);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'tipe_barang_id' => $request->tipe_barang_id,
            'merek' => $request->merek_barang,
            'jumlah' => $request->jumlah_barang,
            'status_barang_id' => $request->status_barang_id,
            'jasa_kirim_id' => $request->jasa_kirim_id,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('tambahData')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('tambahData')->with('success', 'Barang berhasil dihapus!');
    }
}
