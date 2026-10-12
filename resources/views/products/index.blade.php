@extends('layouts.app')

@section('title', 'Dashboard Inventory')
@section('heading', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success bg-white border-success-subtle">
        <i class="bi bi-check-circle-fill text-success me-2"></i>
        {{ session('success') }}
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

{{-- KARTU STATISTIK --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <div class="stat-label">Total Produk</div>
                    <h2 class="stat-value">{{ $totalProducts }}</h2>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="stat-note">Jumlah jenis produk</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <div class="stat-label">Kategori</div>
                    <h2 class="stat-value">{{ $totalCategories }}</h2>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-collection"></i>
                </div>
            </div>
            <div class="stat-note">Kategori terdaftar</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <div class="stat-label">Total Stok</div>
                    <h2 class="stat-value">{{ number_format($totalStock, 0, ',', '.') }}</h2>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-boxes"></i>
                </div>
            </div>
            <div class="stat-note">Total unit barang</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div>
                    <div class="stat-label">Stok Menipis</div>
                    <h2 class="stat-value {{ $lowStock > 0 ? 'text-danger' : 'text-success' }}">
                        {{ $lowStock }}
                    </h2>
                </div>
                <div class="stat-icon"
                     style="background:{{ $lowStock > 0 ? '#fee2e2' : '#dcfce7' }};
                            color:{{ $lowStock > 0 ? '#dc2626' : '#15803d' }}">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
            <div class="stat-note">Stok 5 unit atau kurang</div>
        </div>
    </div>
</div>

{{-- GRAFIK --}}
<div class="panel mb-4">
    <div class="mb-3">
        <h5 class="panel-heading">Ringkasan Persediaan</h5>
        <div class="panel-description">
            Jumlah stok barang berdasarkan kategori.
        </div>
    </div>

    <div style="height:280px; position:relative;">
        <canvas id="stockChart"
                role="img"
                aria-label="Grafik jumlah stok berdasarkan kategori"></canvas>
    </div>
</div>

{{-- DAFTAR PRODUK --}}
<div class="panel">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h5 class="panel-heading">Daftar Produk</h5>
            <div class="panel-description">
                Kelola data dan pantau persediaan barang.
            </div>
        </div>

        <a href="{{ route('products.create') }}" class="btn-green">
            <i class="bi bi-plus-lg"></i>
            Tambah Produk
        </a>
    </div>

    {{-- PENCARIAN --}}
    <form method="GET" action="{{ route('products.index') }}"
          class="row g-2 mb-4">
        <div class="col-12 col-md-6">
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

        <div class="col-auto">
            <button type="submit" class="btn-green">
                Cari
            </button>
        </div>

        @if($search)
            <div class="col-auto">
                <a href="{{ route('products.index') }}"
                   class="btn btn-light border py-2">
                    Reset
                </a>
            </div>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
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
                            @elseif($product->quantity <= 5)
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
                            Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                        </td>

                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.show', $product) }}"
                                   class="action-btn"
                                   title="Detail"
                                   aria-label="Detail produk">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('products.edit', $product) }}"
                                   class="action-btn"
                                   title="Edit"
                                   aria-label="Edit produk">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="action-btn action-delete"
                                            title="Hapus"
                                            aria-label="Hapus produk">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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

        {{ $products->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($chartLabels);
    const values = @json($chartValues);
    const canvas = document.getElementById('stockChart');

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah stok',
                data: values,
                backgroundColor: '#22a05a',
                hoverBackgroundColor: '#166534',
                borderRadius: 7,
                maxBarThickness: 48
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' Stok: ' + context.parsed.y + ' unit';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush