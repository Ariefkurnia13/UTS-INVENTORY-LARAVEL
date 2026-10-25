@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('heading', 'ADMIN')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Tambah Produk</h2>
        <p class="text-secondary mb-0">
            Tambahkan data produk baru ke inventaris.
        </p>
    </div>

    <div class="panel">
        <form action="{{ route('products.store') }}" method="POST" novalidate>
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data yang dimasukkan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">
                        Nama Produk
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama produk"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label for="sku" class="form-label fw-semibold">
                        SKU / Kode Produk
                    </label>
                    <input
                        type="text"
                        id="sku"
                        name="sku"
                        class="form-control"
                        value="{{ old('sku') }}"
                        placeholder="Contoh: ELK-002"
                        required
                    >
                </div>
                
<div class="col-md-6">
    <label for="purchase_price" class="form-label fw-semibold">
        Harga Beli (Rp)
    </label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input
            type="number"
            id="purchase_price"
            name="purchase_price"
            class="form-control"
            min="0"
            step="0.01"
            value="{{ old('purchase_price', 0) }}"
            required
        >
    </div>
</div>

<div class="col-md-6">
    <label for="selling_price" class="form-label fw-semibold">
        Harga Jual (Rp)
    </label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input
            type="number"
            id="selling_price"
            name="selling_price"
            class="form-control"
            min="0"
            step="0.01"
            value="{{ old('selling_price', 0) }}"
            required
        >
    </div>
</div>


                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-semibold">
                        Kategori
                    </label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="form-select"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="quantity" class="form-label fw-semibold">
                        Jumlah Stok
                    </label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        class="form-control"
                        min="0"
                        value="{{ old('quantity', 0) }}"
                        required
                    >
                </div>

                <div class="col-md-6">
    <label for="minimum_stock" class="form-label fw-semibold">
        Stok Minimum
    </label>
    <input
        type="number"
        id="minimum_stock"
        name="minimum_stock"
        class="form-control"
        min="0"
        value="{{ old('minimum_stock', 5) }}"
        required
    >
</div>

        
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">
                        Deskripsi
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                        placeholder="Masukkan deskripsi produk (opsional)"
                    >{{ old('description') }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-green">
                    <i class="bi bi-check-circle me-1"></i>
                    Simpan Produk
                </button>

                <a href="{{ route('products.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection