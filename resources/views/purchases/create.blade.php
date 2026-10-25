
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Pembelian</h2>

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

    

<form action="{{ route('purchases.store') }}" method="POST"
      onsubmit="return validasiPembelian(this);"
      novalidate>
    @csrf

    
<script>
    function validasiPembelian(form) {
        const supplier = form.querySelector('[name="supplier_id"]');
        const produk = form.querySelector('[name="items[0][product_id]"]');
        const jumlah = form.querySelector('[name="items[0][quantity]"]');
        const harga = form.querySelector('[name="items[0][unit_cost]"]');

        let pesan = '';

        if (!supplier.value) {
            pesan = 'Silakan pilih supplier terlebih dahulu.';
            supplier.focus();
        } else if (!produk.value) {
            pesan = 'Silakan pilih minimal satu produk untuk pembelian.';
            produk.focus();
        } else if (!jumlah.value || Number(jumlah.value) < 1) {
            pesan = 'Jumlah pembelian minimal 1.';
            jumlah.focus();
        } else if (harga.value === '' || Number(harga.value) < 0) {
            pesan = 'Silakan isi harga beli yang valid.';
            harga.focus();
        }

        const lama = document.getElementById('alert-validasi-pembelian');
        if (lama) lama.remove();

        if (pesan) {
            const alertBox = document.createElement('div');
            alertBox.id = 'alert-validasi-pembelian';
            alertBox.className = 'alert alert-danger alert-dismissible fade show';
            alertBox.setAttribute('role', 'alert');
            alertBox.innerHTML =
                '<strong>Periksa kembali data berikut:</strong> ' +
                pesan +
                '<button type="button" class="btn-close" ' +
                'data-bs-dismiss="alert" aria-label="Tutup"></button>';

            form.parentNode.insertBefore(alertBox, form);
            return false;
        }

        return true;
    }
</script>

    

</script>


        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select name="supplier_id" id="supplier_id"
                            class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                @selected(old('supplier_id') == $supplier->id)>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="purchased_at" class="form-label">
                        Tanggal Pembelian
                    </label>
                    <input type="datetime-local" name="purchased_at"
                           id="purchased_at" class="form-control"
                           value="{{ old('purchased_at', now()->format('Y-m-d\TH:i')) }}">
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>Barang yang Dibeli</strong>
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
                                        @selected(old("items.$i.product_id") == $product->id)>
                                        {{ $product->name }} (Stok: {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number"
                                       name="items[{{ $i }}][quantity]"
                                       class="form-control"
                                       min="1"
                                       value="{{ old("items.$i.quantity") }}"
                                       @required($i === 0)>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Beli per Unit (Rp)</label>
                                <input type="number"
                                       name="items[{{ $i }}][unit_cost]"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       value="{{ old("items.$i.unit_cost") }}"
                                       @required($i === 0)>
                            </div>
                        </div>
                    </div>
                @endfor

                <p class="text-muted mb-0">
                    Isi minimal satu barang. Baris barang lainnya boleh dikosongkan.
                </p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Pembelian
        </button>

        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection
