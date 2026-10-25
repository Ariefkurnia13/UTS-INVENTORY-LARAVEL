
@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('heading', 'Edit Pengguna')

@section('content')

<div class="panel">
    <div class="mb-4">
        <h5 class="panel-heading">Form Edit Pengguna</h5>
        <div class="panel-description">
            Perbarui informasi akun dan peran pengguna.
        </div>
    </div>

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

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="{{ old('name', $user->name) }}"
                required
                maxlength="255"
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                value="{{ old('email', $user->email) }}"
                required
                maxlength="255"
            >
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Peran Pengguna</label>
            <select name="role" id="role" class="form-select" required>
                <option value="admin" @selected(old('role', $user->role) === 'admin')>
                    Admin
                </option>
                <option value="staff" @selected(old('role', $user->role) === 'staff')>
                    Staff
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                Password Baru (Opsional)
            </label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                minlength="8"
                autocomplete="new-password"
            >
            <small class="text-secondary">
                Kosongkan jika tidak ingin mengubah password.
            </small>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                Konfirmasi Password Baru
            </label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                minlength="8"
                autocomplete="new-password"
            >
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-green">
                <i class="bi bi-save me-1"></i>
                Simpan Perubahan
            </button>

            <a href="{{ route('users.index') }}"
               class="btn btn-light border py-2">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
