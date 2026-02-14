<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obats';

    protected $fillable = [
        'kd_obat',
        'nm_obat',
        'jenis',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'kd_suplier'
    ];

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'kd_obat');
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class, 'kd_obat');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kd_suplier');
    }

    public static function generateKode()
    {
        $last = self::orderBy('id', 'desc')->first();
        if (!$last) {
            return 'OBT-001';
        }

        $lastNumber = (int) substr($last->kd_obat, 4);
        $nextNumber = $lastNumber + 1;

        return 'OBT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
