<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_details';

    protected $fillable = [
        'penjualan_id',
        'kd_obat',
        'jumlah',
        'satuan',
        'harga',
        'subtotal'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'kd_obat');
    }
}
