
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Penjualan</h2>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi Transaksi</strong>
        </div>

        <div class="card-body">
            <p><strong>No. Penjualan:</strong> {{ $sale->sale_number }}</p>
            <p><strong>Petugas:</strong> {{ $sale->user->name }}</p>
            <p><strong>Tanggal:</strong> {{ $sale->sold_at?->format('d-m-Y H:i') }}</p>
            
<p>
    <strong>Status:</strong>
    @if ($sale->status === 'cancelled')
        <span class="badge bg-danger">Dibatalkan</span>
    @else
        <span class="badge bg-success">{{ ucfirst($sale->status) }}</span>
    @endif
</p>


@if (auth()->user()->role === 'admin' && $sale->status === 'completed')
    <form
        action="{{ route('sales.cancel', $sale->id) }}"
        method="POST"
        class="form-konfirmasi-batal-penjualan mt-3"
    >
        @csrf
        @method('PATCH')

        <button type="submit" class="btn btn-danger">
            Batalkan Penjualan
        </button>
    </form>
@endif

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Barang yang Dijual</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sale->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total Penjualan</th>
                            <th>
                                Rp {{ number_format((float) $sale->total, 0, ',', '.') }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-konfirmasi-batal-penjualan').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Batalkan Penjualan?',
                text: 'Stok barang akan dikembalikan. Pastikan Anda ingin melanjutkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#16a34a',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak, Kembali',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

