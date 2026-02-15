@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Transaksi Penjualan Baru</h2>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline">Riwayat Transaksi</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 2rem;">
            <label class="form-label" style="font-weight: 700;">Tipe Pelanggan:</label>
            <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="radio" name="customer_type" value="existing" checked onchange="toggleCustomerForm('existing')"> Pelanggan Lama
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="radio" name="customer_type" value="new" onchange="toggleCustomerForm('new')"> Pelanggan Baru
                </label>
            </div>
        </div>

        <div id="existingCustomerSection" style="display: block;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Pilih Pelanggan</label>
                    <select name="kd_pelanggan" class="form-control">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" {{ old('kd_pelanggan') == $pelanggan->id ? 'selected' : '' }}>
                                {{ $pelanggan->nm_pelanggan }} ({{ $pelanggan->kd_pelanggan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tgl Nota</label>
                    <input type="date" name="tgl_nota" class="form-control" value="{{ old('tgl_nota', date('Y-m-d')) }}" required>
                </div>
            </div>
        </div>

        <div id="newCustomerSection" style="display: none;">
            <h3 style="margin-bottom: 1rem; color: var(--primary);">Data Pelanggan Baru</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Kode Pelanggan (Otomatis)</label>
                    <input type="text" name="new_kd_pelanggan" class="form-control" value="PLG-XXXX" readonly style="background: var(--background);">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="new_nm_pelanggan" class="form-control" value="{{ old('new_nm_pelanggan') }}" placeholder="Nama Lengkap">
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="new_telpon" class="form-control" value="{{ old('new_telpon') }}" placeholder="08xxxxxxxx">
                </div>
                <div class="form-group">
                    <label class="form-label">Kota</label>
                    <input type="text" name="new_kota" class="form-control" value="{{ old('new_kota') }}" placeholder="Nama Kota">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="new_alamat" class="form-control" rows="2" placeholder="Alamat lengkap...">{{ old('new_alamat') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Tgl Nota</label>
                <input type="date" name="tgl_nota" class="form-control" value="{{ old('tgl_nota', date('Y-m-d')) }}">
            </div>
        </div>

        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid var(--border);">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3>Daftar Belanja</h3>
            <button type="button" id="addRow" class="btn btn-outline" style="color: var(--success); border-color: var(--success);">+ Tambah Obat</button>
        </div>

        <table id="itemsTable">
            <thead>
                <tr>
                    <th style="width: 40%;">Nama Obat</th>
                    <th style="width: 15%;">Satuan</th>
                    <th style="width: 15%;">Harga Satuan</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 15%;">Subtotal</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody id="itemsBody">
                <tr class="item-row">
                    <td>
                        <select name="obat_id[]" class="form-control obat-select" required onchange="updateUnits(this)">
                            <option value="">-- Pilih Obat --</option>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}" 
                                    data-price-besar="{{ $obat->harga_jual_besar }}"
                                    data-price-menengah="{{ $obat->harga_jual_menengah }}"
                                    data-price-kecil="{{ $obat->harga_jual_kecil }}"
                                    data-satuan-besar="{{ $obat->satuan_besar }}"
                                    data-satuan-menengah="{{ $obat->satuan_menengah }}"
                                    data-satuan-kecil="{{ $obat->satuan_kecil }}"
                                    data-konversi-menengah="{{ $obat->isi_menengah }}"
                                    data-konversi-kecil="{{ $obat->isi_kecil }}"
                                    data-stok="{{ $obat->stok }}">
                                    {{ $obat->nm_obat }} (Stok: {{ $obat->formatStok() }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="satuan_jual[]" class="form-control satuan-select" required onchange="updatePrice(this)">
                            <option value="kecil">Eceran</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control price-input" readonly value="0">
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" class="form-control qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
                    </td>
                    <td>
                        <input type="text" class="form-control subtotal-input" readonly value="0">
                    </td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: 700;">Diskon (Rp)</td>
                    <td>
                        <input type="number" name="diskon" id="diskonInput" class="form-control" value="{{ old('diskon', 0) }}" oninput="calculateGrandTotal()">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: 700; font-size: 1.1rem; color: var(--success);">TOTAL BAYAR</td>
                    <td>
                        <input type="text" id="grandTotal" class="form-control" style="font-weight: 700; font-size: 1.1rem; color: var(--success);" readonly value="0">
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="background-color: var(--success); padding: 1rem 3rem;">Proses Transaksi</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleCustomerForm(type) {
        const existingSection = document.getElementById('existingCustomerSection');
        const newSection = document.getElementById('newCustomerSection');
        
        if (type === 'new') {
            existingSection.style.display = 'none';
            newSection.style.display = 'block';
        } else {
            existingSection.style.display = 'block';
            newSection.style.display = 'none';
        }
    }

    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.getElementById('itemsBody');
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <td>
                <select name="obat_id[]" class="form-control obat-select" required onchange="updateUnits(this)">
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" 
                            data-price-besar="{{ $obat->harga_jual_besar }}"
                            data-price-menengah="{{ $obat->harga_jual_menengah }}"
                            data-price-kecil="{{ $obat->harga_jual_kecil }}"
                            data-satuan-besar="{{ $obat->satuan_besar }}"
                            data-satuan-menengah="{{ $obat->satuan_menengah }}"
                            data-satuan-kecil="{{ $obat->satuan_kecil }}"
                            data-konversi-menengah="{{ $obat->isi_menengah }}"
                            data-konversi-kecil="{{ $obat->isi_kecil }}"
                            data-stok="{{ $obat->stok }}">
                            {{ $obat->nm_obat }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="satuan_jual[]" class="form-control satuan-select" required onchange="updatePrice(this)">
                    <option value="kecil">Eceran</option>
                </select>
            </td>
            <td>
                <input type="number" class="form-control price-input" readonly value="0">
            </td>
            <td>
                <input type="number" name="jumlah[]" class="form-control qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
            </td>
            <td>
                <input type="text" class="form-control subtotal-input" readonly value="0">
            </td>
            <td>
                <button type="button" class="btn btn-outline" style="color: var(--danger); border: none;" onclick="removeRow(this)">×</button>
            </td>
        `;
        tbody.appendChild(newRow);
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
        const totalStokKecil = parseInt(option.dataset.stok) || 0;
        
        let price = 0;
        let maxQty = 0;

        if (unitType === 'besar') {
            price = option.dataset.priceBesar;
            const konversiBesar = (parseInt(option.dataset.konversiMenengah) || 1) * (parseInt(option.dataset.konversiKecil) || 1);
            maxQty = Math.floor(totalStokKecil / konversiBesar);
        } else if (unitType === 'menengah') {
            price = option.dataset.priceMenengah;
            const konversiMenengah = (parseInt(option.dataset.konversiKecil) || 1);
            maxQty = Math.floor(totalStokKecil / konversiMenengah);
        } else {
            price = option.dataset.priceKecil;
            maxQty = totalStokKecil;
        }

        row.querySelector('.price-input').value = price;
        const qtyInput = row.querySelector('.qty-input');
        qtyInput.max = maxQty;
        if (parseInt(qtyInput.value) > maxQty) qtyInput.value = maxQty;
        
        calculateSubtotal(qtyInput);
    }

    function calculateSubtotal(qtyInput) {
        const row = qtyInput.closest('tr');
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const qty = parseFloat(qtyInput.value) || 0;
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

    // Handle initial state if validation fails
    @if(old('customer_type') == 'new')
        toggleCustomerForm('new');
        document.querySelector('input[value="new"]').checked = true;
    @endif
</script>
@endsection
