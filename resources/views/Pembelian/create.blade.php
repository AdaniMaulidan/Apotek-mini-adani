@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaksi Pembelian Baru</h1>
    <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Input Stok Dari Supplier</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger border-left-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">No. Nota (Auto-generated if empty)</label>
                        <input type="text" name="nota" class="form-control bg-light" placeholder="PB-XXXXXXXX" value="{{ old('nota') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Tgl Nota</label>
                        <input type="date" name="tgl_nota" class="form-control" value="{{ old('tgl_nota', date('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Supplier</label>
                        <select name="kd_suplier" class="form-control custom-select" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('kd_suplier') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nm_suplier }} ({{ $supplier->kota }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-weight-bold text-primary"><i class="fas fa-list-ul mr-2"></i>Daftar Item Obat</h5>
                <button type="button" id="addRow" class="btn btn-sm btn-outline-primary shadow-sm"><i class="fas fa-plus mr-1"></i> Tambah Item</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="itemsTable">
                    <thead class="bg-light text-center small font-weight-bold text-uppercase">
                        <tr>
                            <th style="width: 35%;">Nama Obat</th>
                            <th style="width: 20%;">Satuan</th>
                            <th style="width: 15%;">Harga Satuan</th>
                            <th style="width: 10%;">Jumlah</th>
                            <th style="width: 15%;">Subtotal</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr class="item-row">
                            <td>
                                <select name="items[0][kd_obat]" class="form-control obat-select custom-select-sm" required onchange="updateUnits(this)">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach($obats as $obat)
                                        <option value="{{ $obat->id }}" 
                                            data-price-besar="{{ $obat->harga_beli }}"
                                            data-satuan-besar="{{ $obat->satuan_besar }}"
                                            data-satuan-menengah="{{ $obat->satuan_menengah }}"
                                            data-satuan-kecil="{{ $obat->satuan_kecil }}"
                                            data-konversi-menengah="{{ $obat->isi_menengah }}"
                                            data-konversi-kecil="{{ $obat->isi_kecil }}">
                                            {{ $obat->nm_obat }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="items[0][satuan_beli]" class="form-control satuan-select custom-select-sm" required onchange="updatePrice(this)">
                                    <option value="besar">Satuan Besar</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="items[0][harga]" class="form-control form-control-sm price-input" value="0" required oninput="calculateSubtotal(this)">
                            </td>
                            <td>
                                <input type="number" name="items[0][jumlah]" class="form-control form-control-sm qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm subtotal-input bg-light font-weight-bold" readonly value="0">
                            </td>
                            <td class="text-center">-</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right font-weight-bold">Diskon (Rp):</td>
                            <td>
                                <input type="number" name="diskon" id="diskonInput" class="form-control form-control-sm" value="{{ old('diskon', 0) }}" oninput="calculateGrandTotal()">
                            </td>
                            <td></td>
                        </tr>
                        <tr class="bg-light">
                            <td colspan="4" class="text-right font-weight-bold text-primary" style="font-size: 1.1rem;">TOTAL BAYAR:</td>
                            <td>
                                <input type="text" id="grandTotal" class="form-control form-control-sm border-0 bg-transparent font-weight-bold text-primary" style="font-size: 1.1rem;" readonly value="Rp 0">
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm font-weight-bold">
                    <i class="fas fa-check-circle mr-2"></i> Simpan Transaksi Pembelian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    @php
        $obatOptions = "";
        foreach($obats as $obat) {
            $obatOptions .= "<option value='{$obat->id}' 
                data-price-besar='{$obat->harga_beli}'
                data-satuan-besar='{$obat->satuan_besar}'
                data-satuan-menengah='{$obat->satuan_menengah}'
                data-satuan-kecil='{$obat->satuan_kecil}'
                data-konversi-menengah='{$obat->isi_menengah}'
                data-konversi-kecil='{$obat->isi_kecil}'>
                {$obat->nm_obat}
            </option>";
        }
    @endphp

    let rowTemplateObatOptions = `{!! $obatOptions !!}`;
    let rowCount = 1;

    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.getElementById('itemsBody');
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <td>
                <select name="items[${rowCount}][kd_obat]" class="form-control obat-select custom-select-sm" required onchange="updateUnits(this)">
                    <option value="">-- Pilih Obat --</option>
                    ${rowTemplateObatOptions}
                </select>
            </td>
            <td>
                <select name="items[${rowCount}][satuan_beli]" class="form-control satuan-select custom-select-sm" required onchange="updatePrice(this)">
                    <option value="besar">Satuan Besar</option>
                </select>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][harga]" class="form-control form-control-sm price-input" value="0" required oninput="calculateSubtotal(this)">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][jumlah]" class="form-control form-control-sm qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm subtotal-input bg-light font-weight-bold" readonly value="0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
            </td>
        `;
        tbody.appendChild(newRow);
        rowCount++;
    });

    function removeRow(btn) {
        btn.closest('tr').remove();
        calculateGrandTotal();
    }

    function updateUnits(select) {
        const row = select.closest('tr');
        const option = select.options[select.selectedIndex];
        const satuanSelect = row.querySelector('.satuan-select');
        
        if (!option.value) return;

        const units = [
            { val: 'besar', label: option.dataset.satuanBesar },
            { val: 'menengah', label: option.dataset.satuanMenengah },
            { val: 'kecil', label: option.dataset.satuanKecil }
        ];

        satuanSelect.innerHTML = '';
        units.forEach(u => {
            if (u.label) {
                const opt = document.createElement('option');
                opt.value = u.val;
                opt.text = u.label;
                satuanSelect.add(opt);
            }
        });

        updatePrice(satuanSelect);
    }

    function updatePrice(satuanSelect) {
        const row = satuanSelect.closest('tr');
        const obatSelect = row.querySelector('.obat-select');
        const option = obatSelect.options[obatSelect.selectedIndex];
        const unitType = satuanSelect.value;
        
        let price = parseFloat(option.dataset.priceBesar) || 0;
        
        if (unitType === 'menengah') {
            price = price / (parseFloat(option.dataset.konversiMenengah) || 1);
        } else if (unitType === 'kecil') {
            const totalEceran = (parseFloat(option.dataset.konversiMenengah) || 1) * (parseFloat(option.dataset.konversiKecil) || 1);
            price = price / (totalEceran || 1);
        }

        row.querySelector('.price-input').value = Math.round(price);
        calculateSubtotal(row.querySelector('.price-input'));
    }

    function calculateSubtotal(input) {
        const row = input.closest('tr');
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const subtotal = price * qty;
        row.querySelector('.subtotal-input').value = subtotal.toLocaleString('id-ID');
        row.querySelector('.subtotal-input').dataset.raw = subtotal;
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal-input').forEach(input => {
            total += parseFloat(input.dataset.raw) || 0;
        });
        
        const diskon = parseFloat(document.getElementById('diskonInput').value) || 0;
        const grandTotal = Math.max(0, total - diskon);
        
        document.getElementById('grandTotal').value = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }
</script>
@endsection
