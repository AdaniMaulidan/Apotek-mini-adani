<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Supplier;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $obats = Obat::with('supplier')
            ->when($search, function($query) use ($search) {
                return $query->where('nm_obat', 'like', "%{$search}%")
                             ->orWhere('kd_obat', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $nextKode = Obat::generateKode();
        return view('obat.create', compact('suppliers', 'nextKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_obat' => 'required',
            'jenis' => 'required',
            'satuan_besar' => 'required',
            'satuan_menengah' => 'nullable',
            'satuan_kecil' => 'required',
            'isi_menengah' => 'required|numeric|min:1',
            'isi_kecil' => 'required|numeric|min:1',
            'harga_jual_besar' => 'required|numeric',
            'harga_jual_menengah' => 'nullable|numeric',
            'harga_jual_kecil' => 'required|numeric',
            'kd_suplier' => 'required|exists:suppliers,id'
        ]);

        $data = $request->all();
        $data['kd_obat'] = Obat::generateKode();
        $data['harga_beli'] = 0; 
        $data['stok'] = 0;       

        Obat::create($data);

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan dengan kode: ' . $data['kd_obat']);
    }

    public function show(string $id)
    {
        $obat = Obat::with(['supplier', 'pembelianDetails.pembelian', 'penjualanDetails.penjualan'])->findOrFail($id);
        return view('obat.show', compact('obat'));
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        $suppliers = Supplier::all();
        return view('obat.edit', compact('obat', 'suppliers'));
    }

    public function update(Request $request, string $id)
    {
        $obat = Obat::findOrFail($id);

        $request->validate([
            'kd_obat' => 'required|unique:obats,kd_obat,' . $id,
            'nm_obat' => 'required',
            'jenis' => 'required',
            'satuan_besar' => 'required',
            'satuan_menengah' => 'nullable',
            'satuan_kecil' => 'required',
            'isi_menengah' => 'required|numeric|min:1',
            'isi_kecil' => 'required|numeric|min:1',
            'harga_beli' => 'required|numeric',
            'harga_jual_besar' => 'required|numeric',
            'harga_jual_menengah' => 'nullable|numeric',
            'harga_jual_kecil' => 'required|numeric',
            'stok' => 'required|numeric',
            'kd_suplier' => 'required|exists:suppliers,id'
        ]);

        $obat->update($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}
