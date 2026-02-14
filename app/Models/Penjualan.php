<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualans';

    protected $fillable = [
        'nota',
        'tgl_nota',
        'kd_pelanggan',
        'diskon',
        'total'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'kd_pelanggan');
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }
}
