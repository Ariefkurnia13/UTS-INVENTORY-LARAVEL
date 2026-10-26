
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #166534;">
            <i class="bi bi-plus-circle me-2"></i>
            Tambah Penjualan
        </h2>
        <p class="text-muted mb-0">
            Tambahkan transaksi penjualan barang kepada pelanggan.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data berikut:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <strong>Barang yang Dijual</strong>
            </div>

            <div class="card-body">
                @for ($i = 0; $i < 3; $i++)
                    <div class="border rounded p-3 mb-3">
                        <h6>Barang {{ $i + 1 }}</h6>

                        <div class="mb-3">
                            <label class="form-label">Produk</label>
                            <select name="items[{{ $i }}][product_id]"
                                    class="form-select"
                                    @required($i === 0)>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
    data-selling-price="{{ $product->selling_price }}"
    @selected(old("items.$i.product_id") == $product->id)>
    {{ $product->name }} (Stok: {{ $product->quantity }})
</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Terjual</label>
                                <input type="number"
                                       name="items[{{ $i }}][quantity]"
                                       class="form-control"
                                       min="1"
                                       value="{{ old("items.$i.quantity") }}"
                                       @required($i === 0)>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Jual per Unit (Rp)</label>
                                <input type="number"
                                       name="items[{{ $i }}][unit_price]"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       value="{{ old("items.$i.unit_price") }}"
                                       @required($i === 0)>
                            </div>
                        </div>
                    </div>
                @endfor

                <p class="text-muted mb-0">
                    Isi minimal satu barang. Baris lainnya boleh dikosongkan.
                    Jumlah terjual tidak boleh melebihi stok tersedia.
                </p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Penjualan
        </button>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('select[name$="[product_id]"]').forEach(function (select) {
        function updatePrice() {
            const option = select.options[select.selectedIndex];
            const price = option ? option.dataset.sellingPrice : '';

            const itemName = select.name.match(/items\[(\d+)\]/);
            if (!itemName) return;

            const priceInput = document.querySelector(
                'input[name="items[' + itemName[1] + '][unit_price]"]'
            );

            if (priceInput && price !== '') {
                priceInput.value = price;
            }
        }

        select.addEventListener('change', updatePrice);
        updatePrice();
    });
});
</script>
@endsection
