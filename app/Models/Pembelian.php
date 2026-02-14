<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelians';

    protected $fillable = [
        'nota',
        'tgl_nota',
        'kd_suplier',
        'diskon',
        'total'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kd_suplier');
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }
}
