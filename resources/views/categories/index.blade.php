@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #166534;">
                <i class="bi bi-tags me-2"></i>Data Kategori
            </h2>
            <p class="text-secondary mb-0">
                Kelola kategori produk InventoryPro.
            </p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('categories.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Kategori
            </a>
        @endif
    </div>

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

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $category->name }}
                                </td>

                                <td>
                                    {{ $category->description ?: '-' }}
                                </td>

                                <td>
                                    <span class="badge bg-success-subtle text-success">
                                        {{ $category->products_count }} Produk
                                    </span>
                                </td>

                                <td>
    <div class="d-flex align-items-center gap-2">

        {{-- Tombol Detail --}}
        <a href="{{ route('categories.show', $category) }}"
           class="action-btn"
           title="Detail Kategori"
           aria-label="Detail kategori">
            <i class="bi bi-eye"></i>
        </a>

        @if(auth()->user()->isAdmin())

            {{-- Tombol Edit --}}
            <a href="{{ route('categories.edit', $category) }}"
               class="action-btn"
               title="Edit Kategori"
               aria-label="Edit kategori">
                <i class="bi bi-pencil"></i>
            </a>

            {{-- Tombol Hapus --}}
            <form action="{{ route('categories.destroy', $category) }}"
                  method="POST"
                  class="form-hapus-kategori m-0">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="action-btn action-delete"
                        title="Hapus Kategori"
                        aria-label="Hapus kategori">
                    <i class="bi bi-trash"></i>
                </button>

            </form>

        @endif

    </div>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-4">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-hapus-kategori').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Hapus Kategori?',
                text: 'Kategori yang dihapus tidak dapat dikembalikan. Pastikan kategori tidak sedang digunakan oleh produk.',
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