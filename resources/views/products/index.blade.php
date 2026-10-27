@extends('layouts.app')

@section('title', 'Dashboard Inventory')
@section('heading', '')

@section('content')




@if(session('error'))
    <div class="alert alert-danger bg-white border-danger-subtle">
        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
        {{ session('error') }}
    </div>
@endif


@if($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa kembali data yang dimasukkan:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- DAFTAR PRODUK --}}
<div class="panel">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        
<div>
    <div class="d-flex align-items-center gap-3">
        <i class="bi bi-box-seam page-title-icon"></i>
        <h1 class="page-title mb-0">Daftar Produk</h1>
    </div>

    <p class="page-subtitle mb-0">
        Kelola data dan pantau persediaan barang.
    </p>
</div>


            
    <a href="{{ route('products.create') }}" class="btn-green">
        <i class="bi bi-plus-circle me-2"></i>
        Tambah Produk
    </a>

    </div>

    {{-- PENCARIAN --}}
    <form method="GET" action="{{ route('products.index') }}"
      class="row g-2 mb-4 align-items-center">

    {{-- Kolom pencarian --}}
    <div class="col-12 col-md-5">
        <div class="input-group">
            <span class="input-group-text bg-white">
                <i class="bi bi-search text-secondary"></i>
            </span>
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                class="form-control"
                placeholder="Cari nama produk atau SKU..."
            >
        </div>
    </div>

    {{-- Kategori di sebelah kanan kolom pencarian --}}
    <div class="col-12 col-md-4">
        <select name="category_id" class="form-select">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected((string) $categoryId === (string) $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Tombol Cari di sebelah kanan kategori --}}
    <div class="col-auto">
        <button type="submit" class="btn-green">
            Cari
        </button>
    </div>

    {{-- Reset tetap berfungsi seperti sebelumnya --}}
    @if($search || $categoryId)
        <div class="col-auto">
            <a href="{{ route('products.index') }}"
               class="btn btn-light border py-2">
                Reset
            </a>
        </div>
    @endif


    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga jual</th>
                    <th>Tindakan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="text-secondary">
                            {{ $products->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="product-name">{{ $product->name }}</div>
                            <small class="text-secondary">
                                ID #{{ $product->id }}
                            </small>
                        </td>

                        <td>
                            <span class="sku-badge">{{ $product->sku }}</span>
                        </td>

                        <td>{{ $product->category->name }}</td>

                        <td>
                            @if($product->quantity == 0)
                                <span class="stock-badge stock-empty">Habis</span>
                            @elseif($product->quantity <= $product->minimum_stock)
                                <span class="stock-badge stock-low">
                                    {{ $product->quantity }} unit
                                </span>
                            @else
                                <span class="stock-badge stock-ok">
                                    {{ $product->quantity }} unit
                                </span>
                            @endif
                        </td>

                        <td class="fw-semibold text-nowrap">
                            Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                        </td>

                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.show', $product) }}"
                                   class="action-btn"
                                   title="Detail"
                                   aria-label="Detail produk">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if(auth()->user()->isAdmin())
    <a href="{{ route('products.edit', $product) }}"
       class="action-btn"
       title="Edit"
       aria-label="Edit produk">
        <i class="bi bi-pencil"></i>
    </a>
@endif

                                @if(auth()->user()->isAdmin())
    
<form action="{{ route('products.destroy', $product) }}"
      method="POST"
      class="form-konfirmasi-hapus m-0">
    @csrf
    @method('DELETE')

    <button type="submit"
            class="action-btn action-delete"
            title="Hapus"
            aria-label="Hapus produk">
        <i class="bi bi-trash"></i>
    </button>
</form>
@endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            <strong>Belum ada produk</strong>
                            <div class="mt-1">
                                Coba ubah kata pencarian atau tambahkan produk baru.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
        <small class="text-secondary">
            Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk
        </small>

        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection