<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')
            ->latest()
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('products'));
    }

    
public function store(Request $request)
{
    $validated = $request->validate([
        'items' => ['required', 'array', 'min:1'],
        'items.*.product_id' => ['nullable', 'distinct', 'exists:products,id'],
        'items.*.quantity' => ['nullable', 'integer', 'min:1'],
        'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
        'sold_at' => ['nullable', 'date'],
    ]);

    $items = collect($validated['items'])
        ->filter(fn ($item) => !empty($item['product_id']))
        ->values()
        ->all();

    if (count($items) === 0) {
        return back()
            ->withInput()
            ->withErrors(['items' => 'Pilih minimal satu produk untuk penjualan.']);
    }

    foreach ($items as $item) {
        if (
            !isset($item['quantity']) ||
            !is_numeric($item['quantity']) ||
            (int) $item['quantity'] < 1 ||
            !isset($item['unit_price']) ||
            !is_numeric($item['unit_price']) ||
            (float) $item['unit_price'] < 0
        ) {
            return back()
                ->withInput()
                ->withErrors(['items' => 'Setiap produk yang dipilih harus memiliki jumlah minimal 1 dan harga jual tidak boleh negatif.']);
        }
    }

    $validated['items'] = $items;

    try {
        \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            $sale = \App\Models\Sale::create([
                'user_id' => auth()->id(),
                'sale_number' => 'SO-' . now()->format('YmdHis') . '-' .
                    \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(5)),
                'total' => 0,
                'status' => 'completed',
                'sold_at' => $validated['sold_at'] ?? now(),
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = \App\Models\Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];
                $unitPrice = (float) $product->selling_price;

                if ($product->quantity < $quantity) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'items' => "Stok produk {$product->name} tidak mencukupi. Stok tersedia: {$product->quantity}.",
                    ]);
                }

                $subtotal = round($quantity * $unitPrice, 2);

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('quantity', $quantity);

                $total += $subtotal;
            }

            $sale->update(['total' => $total]);
        });
    } catch (\Illuminate\Validation\ValidationException $exception) {
        throw $exception;
    }

    return redirect()
        ->route('sales.index')
        ->with('success', 'Penjualan berhasil disimpan dan stok produk telah dikurangi.');
}


    public function show(string $id)
    {
        $sale = Sale::with([
            'user',
            'items.product',
        ])->findOrFail($id);

        return view('sales.show', compact('sale'));
    }

    public function edit(string $id)
    {
        abort(404);
    }

    public function update(Request $request, string $id)
    {
        abort(404);
    }

    public function destroy(string $id)
    {
        abort(404);
    }

    
public function cancel(string $id)
{
    \Illuminate\Support\Facades\DB::transaction(function () use ($id) {
        $sale = \App\Models\Sale::whereKey($id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($sale->status === 'cancelled') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'sale' => 'Transaksi ini sudah dibatalkan sebelumnya.',
            ]);
        }

        if ($sale->status !== 'completed') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'sale' => 'Hanya penjualan berstatus completed yang dapat dibatalkan.',
            ]);
        }

        $items = $sale->items()->get();

        foreach ($items as $item) {
            $product = \App\Models\Product::whereKey($item->product_id)
                ->lockForUpdate()
                ->firstOrFail();

            $product->increment('quantity', $item->quantity);
        }

        $sale->update([
            'status' => 'cancelled',
        ]);
    });

    return redirect()
        ->route('sales.show', $id)
        ->with('success', 'Penjualan berhasil dibatalkan dan stok telah dikembalikan.');
}

}
