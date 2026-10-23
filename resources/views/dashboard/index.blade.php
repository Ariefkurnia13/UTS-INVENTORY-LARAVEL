
@extends('layouts.app')

@section('title', 'Dashboard - InventorySI')
@section('heading', 'Dashboard')

@section('content')
@php
    $totalProduk = \App\Models\Product::count();
    $totalKategori = \App\Models\Category::count();
    $totalStok = \App\Models\Product::sum('quantity');
    $stokMenipis = \App\Models\Product::whereColumn(
    'quantity',
    '<=',
    'minimum_stock'
)->count();

    $kategoriStok = \App\Models\Category::withSum('products', 'quantity')
        ->orderBy('name')
        ->get();

    $namaKategori = $kategoriStok->pluck('name');
    $jumlahStokKategori = $kategoriStok->map(
        fn ($kategori) => (int) ($kategori->products_sum_quantity ?? 0)
    );
@endphp

<div class="container-fluid px-0">
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary mb-3">Total Produk</p>
                            <h2 class="fw-bold mb-0">{{ $totalProduk }}</h2>
                        </div>
                        <span class="rounded-4 p-3 text-success"
                              style="background:#dcfce7;font-size:25px">
                            <i class="bi bi-box-seam"></i>
                        </span>
                    </div>
                    <p class="text-secondary small mt-3 mb-0">Jumlah jenis produk</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary mb-3">Kategori</p>
                            <h2 class="fw-bold mb-0">{{ $totalKategori }}</h2>
                        </div>
                        <span class="rounded-4 p-3 text-success"
                              style="background:#dcfce7;font-size:25px">
                            <i class="bi bi-collection"></i>
                        </span>
                    </div>
                    <p class="text-secondary small mt-3 mb-0">Kategori terdaftar</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary mb-3">Total Stok</p>
                            <h2 class="fw-bold mb-0">{{ number_format($totalStok, 0, ',', '.') }}</h2>
                        </div>
                        <span class="rounded-4 p-3 text-success"
                              style="background:#dcfce7;font-size:25px">
                            <i class="bi bi-boxes"></i>
                        </span>
                    </div>
                    <p class="text-secondary small mt-3 mb-0">Total unit barang</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary mb-3">Stok Menipis</p>
                            <h2 class="fw-bold mb-0 text-success">{{ $stokMenipis }}</h2>
                        </div>
                        <span class="rounded-4 p-3 text-success"
                              style="background:#dcfce7;font-size:25px">
                            <i class="bi bi-exclamation-triangle"></i>
                        </span>
                    </div>
                    <p class="text-secondary small mt-3 mb-0">Stok mencapai batas minimum</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-2">Ringkasan Persediaan</h5>
            <p class="text-secondary small mb-4">
                Jumlah stok barang berdasarkan kategori.
            </p>

            <div style="height:350px; position:relative">
                <canvas id="stokKategoriChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const namaKategori = @json($namaKategori);
    const jumlahStokKategori = @json($jumlahStokKategori);

    new Chart(document.getElementById('stokKategoriChart'), {
        type: 'bar',
        data: {
            labels: namaKategori,
            datasets: [{
                data: jumlahStokKategori,
                backgroundColor: '#20a15a',
                borderRadius: 8,
                maxBarThickness: 60
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush
