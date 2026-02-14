<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        $nextKode = Supplier::generateKode();
        return view('supplier.create', compact('nextKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_suplier' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'telpon' => 'required',
        ]);

        $data = $request->all();
        $data['kd_suplier'] = Supplier::generateKode();

        Supplier::create($data);

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan dengan kode: ' . $data['kd_suplier']);
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nm_suplier' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'telpon' => 'required',
        ]);

        $supplier->update($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus');
    }
}
