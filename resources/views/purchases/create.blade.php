@extends('layouts.app')

@section('title', 'Restock Bahan Baku & Pembelian - Nazelle Délices')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-bakery-100 flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-bakery-600 mb-1">
                    <i class="fa-solid fa-dolly"></i>
                    <span>Pengadaan Stok (Stock-In)</span>
                </div>
                <h1 class="text-2xl font-serif font-bold text-bakery-950">
                    Formulir Restock Bahan & Pastry Baru
                </h1>
                <p class="text-xs text-stone-500 mt-1">Stok produk akan bertambah otomatis setelah transaksi pembelian berhasil dikonfirmasi secara atomik.</p>
            </div>
            <a href="{{ route('purchases.index') }}" class="text-xs font-semibold text-stone-500 hover:text-stone-800">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Header Info: Supplier & Date -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 bg-bakery-50/70 p-5 rounded-2xl border border-bakery-200">
                <div class="sm:col-span-2">
                    <label for="supplier_id" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Pemasok / Supplier Bahan <span class="text-rose-500">*</span>
                    </label>
                    <select name="supplier_id" id="supplier_id" required
                        class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="">-- Pilih Supplier Pemasok --</option>
                        @foreach ($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }} {{ $sup->phone ? "({$sup->phone})" : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="purchased_at" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Waktu Pengadaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="datetime-local" name="purchased_at" id="purchased_at"
                        value="{{ old('purchased_at', now()->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div class="sm:col-span-3">
                    <label for="notes" class="block text-[11px] font-semibold text-stone-600 mb-1">Catatan Pengadaan / No. Faktur Pemasok (Opsional)</label>
                    <input type="text" name="notes" id="notes" value="{{ old('notes') }}"
                        placeholder="Contoh: Faktur No. 2026/ELV/10, Batch Mentega Normandy"
                        class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <!-- Items Section -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-serif font-bold text-bakery-950 flex items-center">
                        <span class="mr-2">📦</span> Daftar Item Produk / Bahan Restock
                    </h2>
                    <button type="button" id="addRowBtn"
                        class="inline-flex items-center px-3.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl text-xs font-semibold transition">
                        <i class="fa-solid fa-plus mr-1.5"></i> Tambah Baris Item
                    </button>
                </div>

                <div class="overflow-x-auto border border-bakery-200 rounded-2xl">
                    <table class="min-w-full divide-y divide-bakery-200 text-xs" id="itemsTable">
                        <thead class="bg-bakery-50 text-stone-600 font-semibold text-left">
                            <tr>
                                <th class="px-4 py-3 w-5/12">Varian Produk</th>
                                <th class="px-4 py-3 w-2/12 text-center">Kuantitas</th>
                                <th class="px-4 py-3 w-3/12 text-right">Harga Beli Satuan (Rp)</th>
                                <th class="px-4 py-3 w-2/12 text-right">Subtotal (Rp)</th>
                                <th class="px-2 py-3 w-10 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-bakery-100 bg-white" id="itemsBody">
                            <!-- Dynamic Rows -->
                        </tbody>
                        <tfoot class="bg-bakery-50/80 font-bold text-stone-800 border-t border-bakery-200">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right uppercase text-[11px] text-stone-600">Total Pembelian:</td>
                                <td class="px-4 py-3 text-right text-base font-serif text-amber-700" id="grandTotalDisplay">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-bakery-100">
                <a href="{{ route('purchases.index') }}" class="px-4 py-2 border border-bakery-200 rounded-xl text-xs font-semibold text-stone-600 hover:bg-bakery-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md transition">
                    <i class="fa-solid fa-check mr-1.5"></i> Konfirmasi & Simpan Restock
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    const availableProducts = @json($products);
    let rowCount = 0;

    function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function addRow() {
        const tbody = document.getElementById('itemsBody');
        const rowIndex = rowCount++;

        let productOptions = '<option value="">-- Pilih Produk --</option>';
        availableProducts.forEach(p => {
            productOptions += `<option value="${p.id}" data-cost="${p.purchase_price}">${p.name} (Stok saat ini: ${p.stock})</option>`;
        });

        const tr = document.createElement('tr');
        tr.id = `row-${rowIndex}`;
        tr.className = 'hover:bg-bakery-50/30 transition';
        tr.innerHTML = `
            <td class="px-4 py-3">
                <select name="items[${rowIndex}][product_id]" required
                    onchange="onProductChange(${rowIndex})" id="prod-select-${rowIndex}"
                    class="w-full px-2.5 py-1.5 border border-bakery-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                    ${productOptions}
                </select>
            </td>
            <td class="px-4 py-3 text-center">
                <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" required
                    oninput="calculateRow(${rowIndex})" id="qty-input-${rowIndex}"
                    class="w-20 text-center px-2 py-1.5 border border-bakery-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">
            </td>
            <td class="px-4 py-3 text-right">
                <input type="number" name="items[${rowIndex}][unit_cost]" value="0" min="0" step="100" required
                    oninput="calculateRow(${rowIndex})" id="cost-input-${rowIndex}"
                    class="w-32 text-right px-2 py-1.5 border border-bakery-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">
            </td>
            <td class="px-4 py-3 text-right font-serif font-bold text-bakery-900" id="subtotal-${rowIndex}">
                Rp 0
            </td>
            <td class="px-2 py-3 text-center">
                <button type="button" onclick="removeRow(${rowIndex})" class="text-stone-400 hover:text-rose-500 text-xs">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
    }

    function removeRow(index) {
        const row = document.getElementById(`row-${index}`);
        if (row) {
            row.remove();
            calculateGrandTotal();
        }
    }

    function onProductChange(index) {
        const select = document.getElementById(`prod-select-${index}`);
        const selectedOption = select.options[select.selectedIndex];
        const defaultCost = selectedOption.getAttribute('data-cost') || 0;

        document.getElementById(`cost-input-${index}`).value = defaultCost;
        calculateRow(index);
    }

    function calculateRow(index) {
        const qty = parseFloat(document.getElementById(`qty-input-${index}`).value) || 0;
        const cost = parseFloat(document.getElementById(`cost-input-${index}`).value) || 0;
        const subtotal = qty * cost;

        const subtotalEl = document.getElementById(`subtotal-${index}`);
        if (subtotalEl) {
            subtotalEl.textContent = formatRupiah(subtotal);
            subtotalEl.setAttribute('data-value', subtotal);
        }

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        const subtotalEls = document.querySelectorAll('[id^="subtotal-"]');
        subtotalEls.forEach(el => {
            total += parseFloat(el.getAttribute('data-value')) || 0;
        });

        document.getElementById('grandTotalDisplay').textContent = formatRupiah(total);
    }

    document.getElementById('addRowBtn').addEventListener('click', addRow);
    // Add first row by default
    addRow();
</script>
@endpush
@endsection
