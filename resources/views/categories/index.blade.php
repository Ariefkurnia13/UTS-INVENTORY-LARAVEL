@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-tags page-title-icon"></i>
            <h1 class="page-title mb-0">Data Kategori</h1>
        </div>

        <p class="page-subtitle mb-0">
            Kelola kategori produk InventorySI.
        </p>
    </div>

   <a href="{{ route('categories.create') }}" class="btn-green">
    <i class="bi bi-plus-circle"></i>
    Tambah Kategori
</a>
</div>

    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            
<form action="{{ route('categories.index') }}" method="GET" class="mb-4">
    <div class="input-group">
        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nama kategori..."
            value="{{ $search ?? request('search') }}"
        >
        <button type="submit" class="btn btn-success">Cari</button>
        @if(request('search'))
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                Reset
            </a>
        @endif
    </div>
</form>


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
      class="form-hapus-kategori form-konfirmasi-hapus m-0">


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