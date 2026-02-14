<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'kd_suplier',
        'nm_suplier',
        'alamat',
        'kota',
        'telpon'
    ];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'kd_suplier');
    }

    public function obats()
    {
        return $this->hasMany(Obat::class, 'kd_suplier');
    }

    public static function generateKode()
    {
        $last = self::orderBy('id', 'desc')->first();
        if (!$last) {
            return 'SUP-001';
        }

        $lastNumber = (int) substr($last->kd_suplier, 4);
        $nextNumber = $lastNumber + 1;

        return 'SUP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
