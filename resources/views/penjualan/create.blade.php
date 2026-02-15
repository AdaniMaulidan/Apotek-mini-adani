@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaksi Penjualan Baru</h1>
    <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-history fa-sm text-white-50 mr-1"></i> Riwayat Transaksi
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Kasir / Penjualan Obat</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger border-left-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf
            
            @if(auth()->user()->role == 'pelanggan')
                <div class="alert alert-info border-left-info shadow-sm py-3 mb-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-user-circle fa-2x text-info"></i>
                        </div>
                        <div class="col">
                            <h6 class="m-0 font-weight-bold text-dark">Data Pemesan: {{ auth()->user()->name }}</h6>
                            <small class="text-muted">ID Pelanggan: <strong>{{ auth()->user()->pelanggan->kd_pelanggan ?? '-' }}</strong></small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="customer_type" value="existing">
                <input type="hidden" name="kd_pelanggan" value="{{ auth()->user()->pelanggan->id ?? '' }}">
                <input type="hidden" name="tgl_nota" value="{{ date('Y-m-d') }}">
            @else
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="font-weight-bold">Pilih Tipe Pelanggan:</label>
                        <div class="d-flex align-items-center mt-1">
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="typeExisting" name="customer_type" value="existing" class="custom-control-input" checked onchange="toggleCustomerForm('existing')">
                                <label class="custom-control-label" for="typeExisting">Pelanggan Lama</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="typeNew" name="customer_type" value="new" class="custom-control-input" onchange="toggleCustomerForm('new')">
                                <label class="custom-control-label" for="typeNew">Pelanggan Baru</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing Customer -->
                <div id="existingCustomerSection">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold text-uppercase">Pilih Pelanggan</label>
                                <select name="kd_pelanggan" class="form-control custom-select">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}" {{ old('kd_pelanggan') == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nm_pelanggan }} ({{ $pelanggan->kd_pelanggan }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold text-uppercase">Tgl Nota</label>
                                <input type="date" name="tgl_nota" class="form-control" value="{{ old('tgl_nota', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Customer -->
                <div id="newCustomerSection" style="display: none;">
                    <div class="alert alert-info py-2 px-3 small border-left-info shadow-sm mb-4">
                        <i class="fas fa-info-circle mr-2"></i> Masukkan data lengkap untuk pelanggan baru.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Nama Pelanggan</label>
                                <input type="text" name="new_nm_pelanggan" class="form-control form-control-sm" value="{{ old('new_nm_pelanggan') }}" placeholder="Contoh: Budi Santoso">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="small font-weight-bold">Telepon</label>
                                <input type="text" name="new_telpon" class="form-control form-control-sm" value="{{ old('new_telpon') }}" placeholder="08xxxxx">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="small font-weight-bold">Kota</label>
                                <input type="text" name="new_kota" class="form-control form-control-sm" value="{{ old('new_kota') }}" placeholder="Jember">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="small font-weight-bold">Alamat Lengkap</label>
                                <input type="text" name="new_alamat" class="form-control form-control-sm" value="{{ old('new_alamat') }}" placeholder="Jl. Raya No. 123...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="small font-weight-bold">Tgl Nota</label>
                                <input type="date" name="tgl_nota_new" class="form-control form-control-sm" value="{{ old('tgl_nota', date('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-weight-bold text-primary m-0"><i class="fas fa-shopping-basket mr-2"></i>Daftar Belanja</h5>
                <button type="button" id="addRow" class="btn btn-sm btn-outline-success shadow-sm"><i class="fas fa-plus mr-1"></i> Tambah Obat</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="itemsTable">
                    <thead class="bg-light text-center small font-weight-bold text-uppercase">
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
                                <select name="obat_id[]" class="form-control form-control-sm obat-select custom-select-sm" required onchange="updateUnits(this)">
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
                                <select name="satuan_jual[]" class="form-control form-control-sm satuan-select custom-select-sm" required onchange="updatePrice(this)">
                                    <option value="kecil">Eceran</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm price-input bg-light" readonly value="0">
                            </td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control form-control-sm qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm subtotal-input bg-light font-weight-bold" readonly value="0">
                            </td>
                            <td class="text-center">-</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        @if(auth()->user()->role != 'pelanggan')
                        <tr>
                            <td colspan="4" class="text-right font-weight-bold">Diskon (Rp):</td>
                            <td>
                                <input type="number" name="diskon" id="diskonInput" class="form-control form-control-sm" value="{{ old('diskon', 0) }}" oninput="calculateGrandTotal()">
                            </td>
                            <td></td>
                        </tr>
                        @else
                            <input type="hidden" name="diskon" id="diskonInput" value="0">
                        @endif
                        <tr class="bg-light">
                            <td colspan="4" class="text-right font-weight-bold text-success" style="font-size: 1.1rem;">TOTAL BAYAR:</td>
                            <td>
                                <input type="text" id="grandTotal" class="form-control form-control-sm border-0 bg-transparent font-weight-bold text-success" style="font-size: 1.1rem;" readonly value="Rp 0">
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-right mt-4">
                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm font-weight-bold">
                    <i class="fas fa-check-circle mr-2"></i> Proses Transaksi Penjualan
                </button>
            </div>
        </form>
    </div>
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

    @php
        $obatOptions = "";
        foreach($obats as $obat) {
            $obatOptions .= "<option value='{$obat->id}' 
                data-price-besar='{$obat->harga_jual_besar}'
                data-price-menengah='{$obat->harga_jual_menengah}'
                data-price-kecil='{$obat->harga_jual_kecil}'
                data-satuan-besar='{$obat->satuan_besar}'
                data-satuan-menengah='{$obat->satuan_menengah}'
                data-satuan-kecil='{$obat->satuan_kecil}'
                data-konversi-menengah='{$obat->isi_menengah}'
                data-konversi-kecil='{$obat->isi_kecil}'
                data-stok='{$obat->stok}'>
                {$obat->nm_obat} (Stok: {$obat->formatStok()})
            </option>";
        }
    @endphp

    let rowTemplateObatOptions = `{!! $obatOptions !!}`;

    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.getElementById('itemsBody');
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <td>
                <select name="obat_id[]" class="form-control form-control-sm obat-select custom-select-sm" required onchange="updateUnits(this)">
                    <option value="">-- Pilih Obat --</option>
                    ${rowTemplateObatOptions}
                </select>
            </td>
            <td>
                <select name="satuan_jual[]" class="form-control form-control-sm satuan-select custom-select-sm" required onchange="updatePrice(this)">
                    <option value="kecil">Eceran</option>
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm price-input bg-light" readonly value="0">
            </td>
            <td>
                <input type="number" name="jumlah[]" class="form-control form-control-sm qty-input" min="1" value="1" required oninput="calculateSubtotal(this)">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm subtotal-input bg-light font-weight-bold" readonly value="0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
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
        document.getElementById('typeNew').checked = true;
    @endif
</script>
@endsection
