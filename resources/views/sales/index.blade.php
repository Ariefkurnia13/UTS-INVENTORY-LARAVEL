
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Penjualan</h2>

        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            + Tambah Penjualan
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            
<form action="{{ route('sales.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nomor penjualan..."
            value="{{ $search ?? request('search') }}"
        >

        <button type="submit" class="btn btn-primary">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
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
                            <th>No. Penjualan</th>
                            <th>Petugas</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <td>{{ $sales->firstItem() + $loop->index }}</td>
                                <td>{{ $sale->sale_number }}</td>
                                <td>{{ $sale->user->name }}</td>
                                <td>
                                    Rp {{ number_format((float) $sale->total, 0, ',', '.') }}
                                </td>
                                <td>{{ ucfirst($sale->status) }}</td>
                                <td>{{ $sale->sold_at?->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('sales.show', $sale->id) }}"
                                       class="btn btn-sm btn-info">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada transaksi penjualan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection
