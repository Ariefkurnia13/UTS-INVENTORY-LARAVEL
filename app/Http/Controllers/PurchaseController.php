<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    
public function index(Request $request)
{
    $search = $request->input('search');

    $purchases = Purchase::with(['supplier', 'user'])
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('purchase_number', 'like', '%' . $search . '%')
                  ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                      $supplierQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('purchases.index', compact('purchases', 'search'));
}


    public function create()
{
    $suppliers = Supplier::orderBy('name')->get();
    $products = Product::orderBy('name')->get();

    return view('purchases.create', compact('suppliers', 'products'));
}
    
public function store(Request $request)
{
    

$validated = $request->validate([
    'supplier_id' => ['required', 'exists:suppliers,id'],
    'items' => ['required', 'array', 'min:1'],
    'items.*.product_id' => ['nullable', 'distinct', 'exists:products,id'],
    'items.*.quantity' => ['nullable', 'integer', 'min:1'],
    'items.*.unit_cost' => ['nullable', 'numeric', 'min:0'],
    'purchased_at' => ['nullable', 'date'],
], [
    'supplier_id.required' => 'Supplier wajib dipilih.',
    'supplier_id.exists' => 'Supplier tidak ditemukan.',
]);


$items = collect($validated['items'])
    ->filter(fn ($item) => !empty($item['product_id']))
    ->values()
    ->all();

if (count($items) === 0) {
    return back()
        ->withInput()
        ->withErrors(['items' => 'Pilih minimal satu produk untuk pembelian.']);
}

foreach ($items as $item) {
    if (
        !isset($item['quantity']) ||
        !is_numeric($item['quantity']) ||
        (int) $item['quantity'] < 1 ||
        !isset($item['unit_cost']) ||
        !is_numeric($item['unit_cost']) ||
        (float) $item['unit_cost'] < 0
    ) {
        return back()
            ->withInput()
            ->withErrors(['items' => 'Setiap produk yang dipilih harus memiliki jumlah minimal 1 dan harga beli tidak boleh negatif.']);
    }
}

$validated['items'] = $items;


    DB::transaction(function () use ($validated) {
        $purchase = Purchase::create([
            'supplier_id' => $validated['supplier_id'],
            'user_id' => auth()->id(),
            'purchase_number' => 'PO-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5)),
            'total' => 0,
            'status' => 'completed',
            'purchased_at' => $validated['purchased_at'] ?? now(),
        ]);

        $total = 0;

        foreach ($validated['items'] as $item) {
            $product = Product::whereKey($item['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $item['quantity'];
            $unitCost = (float) $item['unit_cost'];
            $subtotal = round($quantity * $unitCost, 2);

            $purchase->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'subtotal' => $subtotal,
            ]);

            $product->increment('quantity', $quantity);

            $total += $subtotal;
        }

        $purchase->update(['total' => $total]);
    });

    return redirect()
        ->route('purchases.index')
        ->with('success', 'Pembelian berhasil disimpan dan stok produk telah ditambahkan.');
}


    
public function show(string $id)
{
    $purchase = Purchase::with([
        'supplier',
        'user',
        'items.product',
    ])->findOrFail($id);

    return view('purchases.show', compact('purchase'));
}


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    
public function cancel(string $id)
{
    DB::transaction(function () use ($id) {
        $purchase = Purchase::whereKey($id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($purchase->status === 'cancelled') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'purchase' => 'Transaksi pembelian ini sudah dibatalkan sebelumnya.',
            ]);
        }

        if ($purchase->status !== 'completed') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'purchase' => 'Hanya pembelian berstatus completed yang dapat dibatalkan.',
            ]);
        }

        $items = $purchase->items()
            ->orderBy('product_id')
            ->get();

        // Periksa seluruh stok terlebih dahulu sebelum mengubah apa pun.
        foreach ($items as $item) {
            $product = Product::whereKey($item->product_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->quantity < $item->quantity) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'purchase' => "Pembelian tidak dapat dibatalkan karena stok {$product->name} tidak mencukupi untuk dikurangi. Stok saat ini: {$product->quantity}, jumlah yang perlu dikurangi: {$item->quantity}.",
                ]);
            }
        }

        // Kurangi stok setelah semua produk lolos pemeriksaan.
        foreach ($items as $item) {
            $product = Product::whereKey($item->product_id)
                ->lockForUpdate()
                ->firstOrFail();

            $product->decrement('quantity', $item->quantity);
        }

        $purchase->update([
            'status' => 'cancelled',
        ]);
    });

    return redirect()
        ->route('purchases.show', $id)
        ->with('success', 'Pembelian berhasil dibatalkan dan stok telah disesuaikan.');
}

}
