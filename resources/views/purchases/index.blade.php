@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Judul halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-cart-check page-title-icon"></i>
                <h1 class="page-title mb-0">Daftar Pembelian</h1>
            </div>
            <p class="page-subtitle mb-0">
                Kelola transaksi pembelian barang dan informasi supplier InventorySI.
            </p>
        </div>

       <a href="{{ route('purchases.create') }}" class="btn-green">
    <i class="bi bi-plus-circle me-2"></i>
    Tambah Pembelian
</a>
    </div>


    <div class="card">
        <div class="card-body">

            <form action="{{ route('purchases.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari nomor pembelian atau nama supplier..."
                        value="{{ $search ?? request('search') }}"
                    >

                    <button type="submit" class="btn btn-success">
    <i class="bi bi-search me-1"></i>
    Cari
</button>

                    @if(request('search'))
                        <a href="{{ route('purchases.index') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

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
                                <td>{{ $purchase->user?->role === 'admin' ? 'Admin' : ($purchase->user?->role === 'staff' ? 'Staff' : '-') }}</td>
                                <td>
                                    Rp {{ number_format((float) $purchase->total, 0, ',', '.') }}
                                </td>
                                <td>{{ ucfirst($purchase->status) }}</td>
                                <td>{{ $purchase->purchased_at?->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('purchases.show', $purchase->id) }}"
   class="btn btn-sm btn-outline-success">
    <i class="bi bi-eye me-1"></i>
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