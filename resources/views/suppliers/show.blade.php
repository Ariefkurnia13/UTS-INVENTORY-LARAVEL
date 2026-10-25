@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold" style="color: #166534;">
            <i class="bi bi-truck me-2"></i>
            Detail Supplier
        </h2>
        <p class="text-secondary">
            Informasi lengkap pemasok barang InventoryPro.
        </p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Nama Supplier
                </label>
                <h4 class="fw-bold mt-2">
                    {{ $supplier->name }}
                </h4>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Nama Kontak
                </label>
                <p class="mt-2">
                    {{ $supplier->contact_person ?: '-' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Nomor Telepon
                </label>
                <p class="mt-2">
                    {{ $supplier->phone ?: '-' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Email Supplier
                </label>
                <p class="mt-2">
                    {{ $supplier->email ?: '-' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Alamat Supplier
                </label>
                <p class="mt-2">
                    {{ $supplier->address ?: '-' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Tanggal Ditambahkan
                </label>
                <p class="mt-2">
                    {{ $supplier->created_at->format('d M Y H:i') }}
                </p>
            </div>

            <div class="d-flex gap-2 flex-wrap">

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('suppliers.edit', $supplier) }}"
                       class="btn btn-success">
                        <i class="bi bi-pencil me-1"></i>
                        Edit Supplier
                    </a>
                @endif

                <a href="{{ route('suppliers.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

            </div>

        </div>
    </div>
</div>
@endsection