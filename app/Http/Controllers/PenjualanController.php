<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('pelanggan')->latest()->get();
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $obats = Obat::all();
        $pelanggans = Pelanggan::all();

        return view('penjualan.create', compact('obats', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $rules = [
            'tgl_nota' => 'required|date',
            'obat_id' => 'required|array',
            'satuan_jual' => 'required|array',
            'jumlah' => 'required|array',
            'diskon' => 'nullable|numeric|min:0'
        ];

        // Jika pelanggan baru
        if ($request->customer_type == 'new') {
            $rules['new_nm_pelanggan'] = 'required';
        } else {
            $rules['kd_pelanggan'] = 'required|exists:pelanggans,id';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            $pelangganId = $request->kd_pelanggan;

            // Jika pelanggan baru, buat dulu datanya
            if ($request->customer_type == 'new') {
                $pelanggan = Pelanggan::create([
                    'kd_pelanggan' => Pelanggan::generateKode(),
                    'nm_pelanggan' => $request->new_nm_pelanggan,
                    'alamat' => $request->new_alamat,
                    'kota' => $request->new_kota,
                    'telpon' => $request->new_telpon,
                ]);
                $pelangganId = $pelanggan->id;
            }

            $nota = 'NOTA-' . time();
            $diskon = $request->diskon ?: 0;

            $penjualan = Penjualan::create([
                'nota' => $nota,
                'tgl_nota' => $request->tgl_nota,
                'kd_pelanggan' => $pelangganId,
                'diskon' => $diskon,
                'total' => 0
            ]);

            $total = 0;

            foreach ($request->obat_id as $key => $obat_id) {
                $obat = Obat::findOrFail($obat_id);
                $jumlahInput = $request->jumlah[$key];
                $satuanJual = $request->satuan_jual[$key];

                // Hitung jumlah pengurangan stok dalam satuan terkecil
                $jumlahStok = $jumlahInput;
                if ($satuanJual == 'besar') {
                    $jumlahStok = $jumlahInput * ($obat->isi_menengah * $obat->isi_kecil);
                } elseif ($satuanJual == 'menengah') {
                    $jumlahStok = $jumlahInput * $obat->isi_kecil;
                }

                if ($jumlahStok > $obat->stok) {
                    throw new \Exception('Stok tidak cukup untuk ' . $obat->nm_obat);
                }

                $harga = $obat->getHargaByUnit($satuanJual);
                $subtotal = $harga * $jumlahInput;

                // Nama satuan asli yang dijual
                $namaSatuan = match($satuanJual) {
                    'besar' => $obat->satuan_besar,
                    'menengah' => $obat->satuan_menengah,
                    'kecil' => $obat->satuan_kecil,
                };

                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'kd_obat' => $obat->id,
                    'jumlah' => $jumlahInput,
                    'satuan' => $namaSatuan,
                    'harga' => $harga,
                    'subtotal' => $subtotal
                ]);

                $obat->stok -= $jumlahStok;
                $obat->save();

                $total += $subtotal;
            }

            $totalAkhir = max(0, $total - $diskon);

            $penjualan->update([
                'total' => $totalAkhir
            ]);

            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Transaksi berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $penjualan = Penjualan::with(['pelanggan', 'penjualanDetails.obat'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }
}
