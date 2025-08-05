<?php

namespace App\Http\Controllers;

use App\Models\TipeBarang;
use App\Models\StatusBarang;
use App\Models\JasaKirim;
use Illuminate\Http\Request;

class MasterBarangController extends Controller
{
    public function index()
    {
        $tipes = TipeBarang::all();
        $statuses = StatusBarang::all();
        $jasas = JasaKirim::all(); // Tambah ini
        return view('admin.master-barang.index', compact('tipes', 'statuses', 'jasas'));
    }

    public function storeTipe(Request $request)
    {
        $request->validate([
            'nama_tipe' => 'required|unique:tipe_barangs,nama_tipe'
        ], [
            'nama_tipe.required' => 'Nama tipe wajib diisi.',
            'nama_tipe.unique' => 'Nama tipe sudah ada.',
        ]);

        TipeBarang::create(['nama_tipe' => $request->nama_tipe]);

        return redirect()->route('master.index')->with('success', 'Tipe berhasil ditambahkan!');
    }

    public function deleteTipe($id)
    {
        TipeBarang::findOrFail($id)->delete();
        return redirect()->route('master.index')->with('success', 'Tipe dihapus');
    }

    public function storeStatus(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|unique:status_barangs,nama_status'
        ], [
            'nama_status.required' => 'Nama status wajib diisi.',
            'nama_status.unique' => 'Nama status sudah ada.',
        ]);

        StatusBarang::create(['nama_status' => $request->nama_status]);

        return redirect()->route('master.index')->with('success', 'Status berhasil ditambahkan!');
    }

    public function deleteStatus($id)
    {
        StatusBarang::findOrFail($id)->delete();
        return redirect()->route('master.index')->with('success', 'Status dihapus');
    }

    public function storeJasa(Request $request)
    {
        $request->validate([
            'nama_jasa' => 'required|unique:jasa_kirims,nama_jasa'
        ], [
            'nama_jasa.required' => 'Nama jasa wajib diisi.',
            'nama_jasa.unique' => 'Nama jasa sudah ada.',
        ]);

        JasaKirim::create(['nama_jasa' => $request->nama_jasa]);

        return redirect()->route('master.index')->with('success', 'Jasa kirim berhasil ditambahkan!');
    }

    public function deleteJasa($id)
    {
        JasaKirim::findOrFail($id)->delete();
        return redirect()->route('master.index')->with('success', 'Jasa kirim dihapus!');
    }
}
