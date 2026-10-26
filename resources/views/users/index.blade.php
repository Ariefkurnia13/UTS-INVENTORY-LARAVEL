
@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('heading', '')

@section('content')

@if(session('success'))
    <div class="alert alert-success bg-white border-success-subtle">
        <i class="bi bi-check-circle-fill text-success me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa kembali data yang dimasukkan:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="panel">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
    <div class="d-flex align-items-center gap-3">
        <i class="bi bi-people page-title-icon"></i>
        <h1 class="page-title mb-0">Data Pengguna</h1>
    </div>
    <p class="page-subtitle mb-0">
        Kelola akun Admin dan Staff sistem inventory.
    </p>
</div>

        <a href="{{ route('users.create') }}" class="btn-green">
            <i class="bi bi-plus-lg"></i>
            Tambah Pengguna
        </a>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-4">
        <div class="col-12 col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search text-secondary"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Cari nama atau email pengguna..."
                >
            </div>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn-green">Cari</button>
        </div>

        @if(request('search'))
            <div class="col-auto">
                <a href="{{ route('users.index') }}" class="btn btn-light border py-2">
                    Reset
                </a>
            </div>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Tindakan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-secondary">
                            {{ $users->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="product-name">{{ $user->name }}</div>
                            <small class="text-secondary">ID #{{ $user->id }}</small>
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>
                            @if($user->role === 'admin')
                                <span class="badge text-bg-primary">Admin</span>
                            @else
                                <span class="badge text-bg-secondary">Staff</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="action-btn"
                                   title="Edit"
                                   aria-label="Edit pengguna">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn action-delete"
                                                title="Hapus"
                                                aria-label="Hapus pengguna">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            <strong>Belum ada pengguna</strong>
                            <div class="mt-1">
                                Coba ubah kata pencarian.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
        <small class="text-secondary">
            Menampilkan {{ $users->count() }} dari {{ $users->total() }} pengguna
        </small>

        {{ $users->links() }}
    </div>
</div>

@endsection
