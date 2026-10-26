
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Pembelian</h2>

        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Informasi Transaksi</strong>
        </div>

        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Nomor Pembelian</div>
                <div class="col-md-9">{{ $purchase->purchase_number }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Supplier</div>
                <div class="col-md-9">{{ $purchase->supplier->name }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Petugas</div>
                <div class="col-md-9">{{ $purchase->user->name }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Tanggal Pembelian</div>
                <div class="col-md-9">
                    {{ $purchase->purchased_at?->format('d-m-Y H:i') }}
                </div>
            </div>

            
<div class="row mb-2">
    <div class="col-md-3 fw-bold">Status</div>
    <div class="col-md-9">
        @if ($purchase->status === 'cancelled')
            <span class="badge bg-danger">Dibatalkan</span>
        @else
            <span class="badge bg-success">{{ ucfirst($purchase->status) }}</span>
        @endif
    </div>
</div>


@if (auth()->user()->role === 'admin' && $purchase->status === 'completed')
    <div class="mt-3">
        <form
            action="{{ route('purchases.cancel', $purchase->id) }}"
            method="POST"
            class="form-konfirmasi-batal-pembelian m-0"
        >
            @csrf
            @method('PATCH')

            <button type="submit" class="btn btn-danger">
                Batalkan Pembelian
            </button>
        </form>
    </div>
@endif



    <div class="card">
        <div class="card-header">
            <strong>Rincian Barang</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($purchase->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    Rp {{ number_format((float) $item->unit_cost, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total Pembelian</th>
                            <th>
                                Rp {{ number_format((float) $purchase->total, 0, ',', '.') }}
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
    document.querySelectorAll('.form-konfirmasi-batal-pembelian').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Batalkan Pembelian?',
                text: 'Stok akan dikurangi sesuai jumlah pembelian jika stok mencukupi.',
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

