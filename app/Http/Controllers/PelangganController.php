<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar pelanggan yang PERNAH melakukan transaksi penjualan.
     */
    public function index()
    {
        // Query pelanggan yang memiliki minimal 1 transaksi penjualan
        $pelanggans = Pelanggan::has('penjualans')->latest()->get();

        return view('pelanggan.index', compact('pelanggans'));
    }

    /**
     * Menampilkan daftar semua pelanggan (untuk manajemen).
     */
    public function list()
    {
        $pelanggans = Pelanggan::latest()->get();
        return view('pelanggan.list', compact('pelanggans'));
    }

    public function create()
    {
        $nextKode = Pelanggan::generateKode();
        return view('pelanggan.create', compact('nextKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_pelanggan' => 'required',
            'alamat' => 'nullable',
            'kota' => 'nullable',
            'telpon' => 'nullable',
        ]);

        $data = $request->all();
        $data['kd_pelanggan'] = Pelanggan::generateKode();

        Pelanggan::create($data);

        return redirect()->route('pelanggan.list')
            ->with('success', 'Pelanggan berhasil ditambahkan dengan kode: ' . $data['kd_pelanggan']);
    }
}
