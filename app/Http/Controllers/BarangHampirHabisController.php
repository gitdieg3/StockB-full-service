<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangHampirHabisController extends Controller
{
    public function index()
    {
        $stokHampirHabis = Barang::where('jumlah', '<=', 5)->paginate(10);

        return view('admin.barang-hampir-habis', compact('stokHampirHabis'));
    }
}