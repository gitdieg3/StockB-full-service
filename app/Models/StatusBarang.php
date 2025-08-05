<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusBarang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_status'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'status_barang_id');
    }
}
