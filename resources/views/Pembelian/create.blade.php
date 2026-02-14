@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Transaksi Pembelian Baru</h2>
        <a href="{{ route('pembelian.index') }}" class="btn btn-outline">Kembali</a>
    </div>

    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">No. Nota (Auto-generated if empty)</label>
                <input type="text" name="nota" class="form-control" placeholder="PB-XXXXXXXX" value="{{ old('nota') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tgl Nota</label>
                <input type="date" name="tgl_nota" class="form-control" value="{{ old('tgl_nota', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Supplier</label>
            <select name="kd_suplier" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('kd_suplier') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->nm_suplier }} ({{ $supplier->kota }})
                    </option>
                @endforeach
            </select>
        </div>

        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid var(--border);">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3>Daftar Item Obat</h3>
            <button type="button" id="addRow" class="btn btn-outline" style="color: var(--primary); border-color: var(--primary);">+ Tambah Item</button>
        </div>

        <table id="itemsTable">
            <thead>
                <tr>
                    <th style="width: 40%;">Nama Obat</th>
                    <th style="width: 20%;">Harga Beli</th>
                    <th style="width: 15%;">Jumlah</th>
                    <th style="width: 20%;">Subtotal</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody id="itemsBody">
                <tr class="item-row">
                    <td>
                        <select name="items[0][kd_obat]" class="form-control obat-select" required onchange="updatePrice(this)">
                            <option value="">-- Pilih Obat --</option>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}" data-price="{{ $obat->harga_beli }}">
                                    {{ $obat->nm_obat }} (Stok: {{ $obat->stok }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[0][harga]" class="form-control price-input" value="0" required oninput="calculateSubtotal(this)">
                    </td>
                    <td>
                        <input type="number" name="items[0][jumlah]" class="form-control qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
                    </td>
                    <td>
                        <input type="text" class="form-control subtotal-input" readonly value="0">
                    </td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: 700;">Diskon (Rp)</td>
                    <td>
                        <input type="number" name="diskon" id="diskonInput" class="form-control" value="{{ old('diskon', 0) }}" oninput="calculateGrandTotal()">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: 700; font-size: 1.1rem; color: var(--primary);">TOTAL BAYAR</td>
                    <td>
                        <input type="text" id="grandTotal" class="form-control" style="font-weight: 700; font-size: 1.1rem; color: var(--primary);" readonly value="0">
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Simpan Transaksi</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    @php
        $obatOptions = "";
        foreach($obats as $obat) {
            $obatOptions .= "<option value='{$obat->id}' data-price='{$obat->harga_beli}'>{$obat->nm_obat} (Stok: {$obat->stok})</option>";
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
                <select name="items[${rowCount}][kd_obat]" class="form-control obat-select" required onchange="updatePrice(this)">
                    <option value="">-- Pilih Obat --</option>
                    ${rowTemplateObatOptions}
                </select>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][harga]" class="form-control price-input" value="0" required oninput="calculateSubtotal(this)">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][jumlah]" class="form-control qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
            </td>
            <td>
                <input type="text" class="form-control subtotal-input" readonly value="0">
            </td>
            <td>
                <button type="button" class="btn btn-outline" style="color: var(--danger); border: none;" onclick="removeRow(this)">×</button>
            </td>
        `;
        tbody.appendChild(newRow);
        rowCount++;
    });

    function removeRow(btn) {
        btn.closest('tr').remove();
        calculateGrandTotal();
    }

    function updatePrice(select) {
        const row = select.closest('tr');
        const price = select.options[select.selectedIndex].dataset.price || 0;
        row.querySelector('.price-input').value = price;
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
