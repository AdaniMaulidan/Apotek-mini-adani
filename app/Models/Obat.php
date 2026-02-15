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
        'satuan_besar',
        'satuan_menengah',
        'satuan_kecil',
        'isi_menengah',
        'isi_kecil',
        'harga_beli',
        'harga_jual_besar',
        'harga_jual_menengah',
        'harga_jual_kecil',
        'stok',
        'kd_suplier',
        'tgl_kadaluarsa'
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

    public function formatStok()
    {
        $stok_total = $this->stok;
        $konversi_menengah = $this->isi_kecil; // Tablet per Strip
        $konversi_besar = $this->isi_menengah * $this->isi_kecil; // Tablet per Box

        $box = floor($stok_total / $konversi_besar);
        $sisa_box = $stok_total % $konversi_besar;

        $strip = floor($sisa_box / $konversi_menengah);
        $sisa_strip = $sisa_box % $konversi_menengah;

        $tablet = $sisa_strip;

        $result = [];
        if ($box > 0) $result[] = "$box $this->satuan_besar";
        if ($strip > 0) $result[] = "$strip $this->satuan_menengah";
        if ($tablet > 0 || empty($result)) $result[] = "$tablet $this->satuan_kecil";

        return implode(', ', $result);
    }

    public function getHargaByUnit($unitType)
    {
        return match ($unitType) {
            'besar' => $this->harga_jual_besar,
            'menengah' => $this->harga_jual_menengah,
            'kecil' => $this->harga_jual_kecil,
            default => $this->harga_jual_kecil,
        };
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
