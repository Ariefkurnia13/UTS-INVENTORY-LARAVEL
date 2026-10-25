@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #166534;">
                <i class="bi bi-truck me-2"></i>Data Supplier
            </h2>
            <p class="text-secondary mb-0">
                Kelola data pemasok barang InventoryPro.
            </p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('suppliers.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Supplier
            </a>
        @endif
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Supplier --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            
{{-- Pencarian Supplier --}}
<form action="{{ route('suppliers.index') }}" method="GET" class="mb-4">
    <div class="row g-2">
        <div class="col-md-6">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari nama, kontak, telepon, atau email supplier..."
                value="{{ $search ?? '' }}"
            >
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-search me-1"></i>
                Cari
            </button>
        </div>

        <div class="col-auto">
            <a href="{{ route('suppliers.index') }}"
               class="btn btn-outline-secondary">
                Reset
            </a>
        </div>
    </div>
</form>
    

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Supplier</th>
                            <th>Kontak</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>
                                    {{ $suppliers->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $supplier->name }}
                                </td>

                                <td>
                                    {{ $supplier->contact_person ?: '-' }}
                                </td>

                                <td>
                                    {{ $supplier->phone ?: '-' }}
                                </td>

                                <td>
                                    {{ $supplier->email ?: '-' }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">

                                        {{-- Detail --}}
                                        <a href="{{ route('suppliers.show', $supplier) }}"
                                           class="action-btn"
                                           title="Detail Supplier"
                                           aria-label="Detail supplier">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if(auth()->user()->isAdmin())

                                            {{-- Edit --}}
                                            <a href="{{ route('suppliers.edit', $supplier) }}"
                                               class="action-btn"
                                               title="Edit Supplier"
                                               aria-label="Edit supplier">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('suppliers.destroy', $supplier) }}"
                                                  method="POST"
                                                  class="form-hapus-supplier m-0">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="action-btn action-delete"
                                                        title="Hapus Supplier"
                                                        aria-label="Hapus supplier">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">
                                    Belum ada supplier.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $suppliers->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-hapus-supplier').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Hapus Supplier?',
                text: 'Data supplier yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#16a34a',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
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