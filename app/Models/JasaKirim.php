<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasaKirim extends Model
{
    use HasFactory;

    protected $fillable = ['nama_jasa'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'jasa_kirim_id');
    }
}

