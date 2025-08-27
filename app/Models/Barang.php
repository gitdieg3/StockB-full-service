<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'tipe_barang_id',
        'status_barang_id',
        'jasa_kirim_id',
        'jumlah',
        'tanggal_masuk',
    ];

    // Relasi ke TipeBarang// app/Models/Barang.php

    public function tipe()
    {
        return $this->belongsTo(TipeBarang::class, 'tipe_barang_id');
    }
    

    public function status()
    {
        return $this->belongsTo(StatusBarang::class, 'status_barang_id');
    }

    public function jasa()
    {
        return $this->belongsTo(JasaKirim::class, 'jasa_kirim_id');
    }
}
