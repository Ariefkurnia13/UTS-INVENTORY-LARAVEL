@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold" style="color: #166534;">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Supplier
        </h2>
        <p class="text-secondary">
            Perbarui informasi pemasok barang InventoryPro.
        </p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" novalidate>
    @csrf
    @method('PUT')

                {{-- Nama Supplier --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        Nama Supplier <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $supplier->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Kontak --}}
                <div class="mb-3">
                    <label for="contact_person" class="form-label fw-semibold">
                        Nama Kontak
                    </label>

                    <input type="text"
                           name="contact_person"
                           id="contact_person"
                           value="{{ old('contact_person', $supplier->contact_person) }}"
                           class="form-control @error('contact_person') is-invalid @enderror">

                    @error('contact_person')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">
                        Nomor Telepon
                    </label>

                    <input type="text"
                           name="phone"
                           id="phone"
                           value="{{ old('phone', $supplier->phone) }}"
                           class="form-control @error('phone') is-invalid @enderror">

                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        Email Supplier
                    </label>

                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email', $supplier->email) }}"
                           class="form-control @error('email') is-invalid @enderror">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <label for="address" class="form-label fw-semibold">
                        Alamat Supplier
                    </label>

                    <textarea name="address"
                              id="address"
                              rows="3"
                              class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier->address) }}</textarea>

                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('suppliers.index') }}"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection