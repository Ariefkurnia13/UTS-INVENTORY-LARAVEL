<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Menampilkan daftar supplier
    
public function index(Request $request)
{
    $search = $request->input('search');

    $suppliers = Supplier::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('suppliers.index', compact('suppliers', 'search'));
}


    // Menampilkan form tambah supplier
    public function create()
    {
        return view('suppliers.create');
    }

    // Menyimpan supplier baru
    public function store(Request $request)
    {
        $validated = $request->validate([
    'name' => ['required', 'string', 'max:150'],
    'contact_person' => ['nullable', 'string', 'max:100'],
    'phone' => ['nullable', 'string', 'max:30'],
    'email' => ['nullable', 'email', 'max:150'],
    'address' => ['nullable', 'string'],
], [
    'name.required' => 'Nama supplier wajib diisi.',
    'name.max' => 'Nama supplier maksimal 150 karakter.',
    'contact_person.max' => 'Nama kontak maksimal 100 karakter.',
    'phone.max' => 'Nomor telepon maksimal 30 karakter.',
    'email.email' => 'Format email tidak valid.',
    'email.max' => 'Email maksimal 150 karakter.',
]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    // Menampilkan detail supplier
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    // Menampilkan form edit supplier
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    // Memperbarui supplier
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
    'name' => ['required', 'string', 'max:150'],
    'contact_person' => ['nullable', 'string', 'max:100'],
    'phone' => ['nullable', 'string', 'max:30'],
    'email' => ['nullable', 'email', 'max:150'],
    'address' => ['nullable', 'string'],
], [
    'name.required' => 'Nama supplier wajib diisi.',
    'name.max' => 'Nama supplier maksimal 150 karakter.',
    'contact_person.max' => 'Nama kontak maksimal 100 karakter.',
    'phone.max' => 'Nomor telepon maksimal 30 karakter.',
    'email.email' => 'Format email tidak valid.',
    'email.max' => 'Email maksimal 150 karakter.',
]);

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

       // Menghapus supplier
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}