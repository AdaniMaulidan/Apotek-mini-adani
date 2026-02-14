<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\Obat;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Supplier
        $supplier = Supplier::create([
            'kd_suplier' => 'SUP-001',
            'nm_suplier' => 'PT. Kimia Farma',
            'alamat' => 'Jl. Kebon Kacang No. 1',
            'kota' => 'Jakarta',
            'telpon' => '021-123456'
        ]);

        // 2. Seed Pelanggan
        Pelanggan::create([
            'kd_pelanggan' => 'PLG-001',
            'nm_pelanggan' => 'Umum / Cash',
            'alamat' => '-',
            'kota' => 'Local',
            'telpon' => '-'
        ]);

        // 3. Seed Obat
        Obat::create([
            'kd_obat' => 'OBT-001',
            'nm_obat' => 'Paracetamol 500mg',
            'jenis' => 'Tablet',
            'satuan' => 'Strip',
            'harga_beli' => 5000,
            'harga_jual' => 7500,
            'stok' => 100,
            'kd_suplier' => $supplier->id
        ]);

        Obat::create([
            'kd_obat' => 'OBT-002',
            'nm_obat' => 'Amoxicillin 500mg',
            'jenis' => 'Kapsul',
            'satuan' => 'Strip',
            'harga_beli' => 12000,
            'harga_jual' => 15000,
            'stok' => 50,
            'kd_suplier' => $supplier->id
        ]);
    }
}
