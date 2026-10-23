@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold" style="color: #166534;">
            <i class="bi bi-tags me-2"></i>
            Detail Kategori
        </h2>

        <p class="text-secondary">
            Informasi lengkap kategori produk InventoryPro.
        </p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Nama Kategori
                </label>
                <h4 class="fw-bold mt-2">
                    {{ $category->name }}
                </h4>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Deskripsi
                </label>
                <p class="mt-2">
                    {{ $category->description ?: 'Tidak ada deskripsi.' }}
                </p>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Jumlah Produk
                </label>
                <div class="mt-2">
                    <span class="badge bg-success-subtle text-success">
                        {{ $category->products_count }} Produk
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label class="fw-semibold text-secondary">
                    Tanggal Dibuat
                </label>
                <p class="mt-2">
                    {{ $category->created_at->format('d M Y H:i') }}
                </p>
            </div>

            <div class="d-flex gap-2 flex-wrap">

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('categories.edit', $category) }}"
                       class="btn btn-success">
                        <i class="bi bi-pencil me-1"></i>
                        Edit Kategori
                    </a>
                @endif

                <a href="{{ route('categories.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

            </div>

        </div>
    </div>

</div>
@endsection