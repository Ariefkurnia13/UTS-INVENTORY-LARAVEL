
@extends('layouts.app')

@section('title', 'Stok Menipis')
@section('heading', 'Stok Menipis')

@section('content')

<div class="panel">
    <div class="mb-4">
        <h5 class="panel-heading">Daftar Produk Stok Menipis</h5>
        <div class="panel-description">
            Produk dengan jumlah stok yang mencapai atau berada di bawah batas minimum.
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Kategori</th>
                    <th>Stok Saat Ini</th>
                    <th>Batas Minimum</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="product-name">{{ $product->name }}</div>
                        </td>

                        <td>{{ $product->sku }}</td>

                        <td>{{ $product->category->name ?? '-' }}</td>

                        <td>
                            <span class="fw-semibold text-danger">
                                {{ $product->quantity }}
                            </span>
                        </td>

                        <td>{{ $product->minimum_stock }}</td>

                        <td>
                            <span class="badge text-bg-danger">
                                Stok Menipis
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-check-circle text-success fs-1 d-block mb-2"></i>
                            <strong>Semua stok aman!</strong>
                            <div class="text-secondary mt-1">
                                Belum ada produk yang mencapai batas minimum stok.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
        <small class="text-secondary">
            Total produk stok menipis: {{ $products->total() }}
        </small>

        {{ $products->links() }}
    </div>
</div>

@endsection
