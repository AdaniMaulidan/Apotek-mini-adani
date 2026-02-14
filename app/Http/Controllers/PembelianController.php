<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('supplier')->latest()->get();
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $obats = Obat::all();

        return view('pembelian.create', compact('suppliers', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kd_suplier' => 'required|exists:suppliers,id',
            'tgl_nota' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.kd_obat' => 'required|exists:obats,id',
            'items.*.jumlah' => 'required|numeric|min:1',
            'items.*.harga' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            $nota = $request->nota ?: 'PB-' . date('YmdHis');
            $diskon = $request->diskon ?: 0;

            $pembelian = Pembelian::create([
                'nota' => $nota,
                'tgl_nota' => $request->tgl_nota,
                'kd_suplier' => $request->kd_suplier,
                'diskon' => $diskon,
                'total' => 0
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $obat = Obat::findOrFail($item['kd_obat']);
                $jumlah = intval($item['jumlah']);
                $harga = floatval($item['harga']); // Mengambil harga dari input form pembelian
                $subtotal = $harga * $jumlah;

                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'kd_obat' => $obat->id,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'subtotal' => $subtotal
                ]);

                // Update stok obat DAN update harga beli induk
                $obat->stok += $jumlah;
                $obat->harga_beli = $harga; // Update harga beli terakhir
                $obat->save();

                $total += $subtotal;
            }

            $totalSetelahDiskon = $total - $diskon;
            if ($totalSetelahDiskon < 0) $totalSetelahDiskon = 0;

            $pembelian->update([
                'total' => $totalSetelahDiskon
            ]);

            DB::commit();

            return redirect()->route('pembelian.index')
                ->with('success', 'Transaksi pembelian ' . $nota . ' berhasil disimpan dan stok telah bertambah.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'pembelianDetails.obat'])->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }
}
