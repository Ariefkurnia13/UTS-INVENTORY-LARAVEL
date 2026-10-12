@extends('layouts.app')

@section('title', 'Detail Produk')
@section('heading', 'Detail Produk')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Produk</h2>
            <p class="text-secondary mb-0">
                Informasi lengkap produk dalam inventaris.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a
                href="{{ route('products.edit', $product) }}"
                class="btn btn-green"
            >
                <i class="bi bi-pencil-square me-1"></i>
                Edit Produk
            </a>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-secondary"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Tutup"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="panel h-100">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div
                        class="rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 58px; height: 58px; background: #dcfce7; color: #15803d;"
                    >
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>

                    <div>
                        <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                        <span class="text-secondary">
                            SKU: {{ $product->sku }}
                        </span>
                    </div>
                </div>

                <hr>

                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">Nama Produk</div>
                        <div class="fw-semibold">{{ $product->name }}</div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">SKU / Kode Produk</div>
                        <div class="fw-semibold">{{ $product->sku }}</div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">Kategori</div>
                        <div class="fw-semibold">
                            {{ $product->category?->name ?? 'Tidak berkategori' }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">Harga Satuan</div>
                        <div class="fw-bold" style="color: #15803d;">
                            Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">Jumlah Stok</div>
                        <div class="fw-semibold">
                            {{ number_format($product->quantity, 0, ',', '.') }} unit
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">Nilai Total Stok</div>
                        <div class="fw-bold">
                            Rp {{ number_format(
                                (float) $product->price * $product->quantity,
                                0,
                                ',',
                                '.'
                            ) }}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-secondary small mb-2">Deskripsi Produk</div>
                        <div class="p-3 rounded-3" style="background: #f8fafc;">
                            {{ $product->description ?: 'Tidak ada deskripsi produk.' }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">Tanggal Dibuat</div>
                        <div>
                            {{ $product->created_at?->format('d-m-Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small mb-1">Terakhir Diperbarui</div>
                        <div>
                            {{ $product->updated_at?->format('d-m-Y H:i') ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel mb-4">
                <div class="text-secondary small mb-2">Status Persediaan</div>

                @if ($product->quantity <= 0)
                    <span class="badge bg-danger fs-6">Stok Habis</span>
                    <p class="text-secondary mt-3 mb-0">
                        Produk ini tidak memiliki stok yang tersedia.
                    </p>
                @elseif ($product->quantity <= 5)
                    <span class="badge bg-warning text-dark fs-6">Stok Menipis</span>
                    <p class="text-secondary mt-3 mb-0">
                        Stok produk tinggal sedikit. Pertimbangkan untuk melakukan pengadaan.
                    </p>
                @else
                    <span class="badge bg-success fs-6">Stok Tersedia</span>
                    <p class="text-secondary mt-3 mb-0">
                        Persediaan produk masih tersedia.
                    </p>
                @endif
            </div>

            <div class="panel">
                <div class="text-secondary small mb-2">Ringkasan Nilai Persediaan</div>

                <h3 class="fw-bold mb-1" style="color: #15803d;">
                    Rp {{ number_format(
                        (float) $product->price * $product->quantity,
                        0,
                        ',',
                        '.'
                    ) }}
                </h3>

                <p class="text-secondary small mb-0">
                    Harga satuan dikalikan jumlah stok saat ini.
                </p>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Harga satuan</span>
                    <span>
                        Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                    </span>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="text-secondary">Jumlah stok</span>
                    <span>{{ number_format($product->quantity, 0, ',', '.') }} unit</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection