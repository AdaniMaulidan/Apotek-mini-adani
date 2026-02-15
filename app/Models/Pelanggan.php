<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';

    protected $fillable = [
        'user_id',
        'kd_pelanggan',
        'nm_pelanggan',
        'alamat',
        'kota',
        'telpon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'kd_pelanggan');
    }

    public static function generateKode()
    {
        $last = self::orderBy('id', 'desc')->first();
        if (!$last) {
            return 'PLG-001';
        }

        $lastNumber = (int) substr($last->kd_pelanggan, 4);
        $nextNumber = $lastNumber + 1;

        return 'PLG-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
