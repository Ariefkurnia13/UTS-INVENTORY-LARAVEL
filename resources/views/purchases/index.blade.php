
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Pembelian</h2>

        <a href="{{ route('purchases.create') }}" class="btn btn-primary">
            + Tambah Pembelian
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Pembelian</th>
                            <th>Supplier</th>
                            <th>Petugas</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchases->firstItem() + $loop->index }}</td>
                                <td>{{ $purchase->purchase_number }}</td>
                                <td>{{ $purchase->supplier->name }}</td>
                                <td>{{ $purchase->user->name }}</td>
                                <td>Rp {{ number_format((float) $purchase->total, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($purchase->status) }}</td>
                                <td>{{ $purchase->purchased_at?->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('purchases.show', $purchase->id) }}"
                                       class="btn btn-sm btn-info">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Belum ada transaksi pembelian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $purchases->links() }}
        </div>
    </div>
</div>
@endsection
