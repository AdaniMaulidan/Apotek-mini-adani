<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $table = 'pembelian_details';

    protected $fillable = [
        'pembelian_id',
        'kd_obat',
        'jumlah',
        'harga',
        'subtotal'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'kd_obat');
    }
}
