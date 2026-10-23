<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
   
public function index(Request $request): View
{
    $search = $request->query('search');
    $categoryId = $request->query('category_id');

    $products = Product::with('category')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        })
        ->when($categoryId, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->latest()
        ->paginate(5)
        ->withQueryString();

    $categories = Category::orderBy('name')->get();

    $totalProducts = Product::count();
    $totalCategories = Category::count();
    $totalStock = (int) Product::sum('quantity');
    $lowStock = Product::whereColumn('quantity', '<=', 'minimum_stock')->count();

    $categoryStock = Category::withSum('products', 'quantity')
        ->orderBy('name')
        ->get();

    $chartLabels = $categoryStock->pluck('name')->values();
    $chartValues = $categoryStock
        ->map(fn ($category) => (int) ($category->products_sum_quantity ?? 0))
        ->values();

    return view('products.index', compact(
        'products',
        'categories',
        'search',
        'categoryId',
        'totalProducts',
        'totalCategories',
        'totalStock',
        'lowStock',
        'chartLabels',
        'chartValues'
    ));
}

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    
public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'name' => ['required', 'string', 'max:255'],
        'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
        'quantity' => ['required', 'integer', 'min:0'],
        'minimum_stock' => ['required', 'integer', 'min:0'],
        'purchase_price' => ['required', 'numeric', 'min:0'],
        'selling_price' => ['required', 'numeric', 'min:0'],
        'description' => ['nullable', 'string'],
    ]);

    Product::create($validated);

    return redirect()->route('products.index')
        ->with('success', 'Produk berhasil ditambahkan.');
}


    public function show(Product $product): View
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    
public function update(Request $request, Product $product): RedirectResponse
{
    $validated = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'name' => ['required', 'string', 'max:255'],
        'sku' => [
            'required',
            'string',
            'max:255',
            Rule::unique('products', 'sku')->ignore($product->id),
        ],
        'quantity' => ['required', 'integer', 'min:0'],
        'minimum_stock' => ['required', 'integer', 'min:0'],
        'purchase_price' => ['required', 'numeric', 'min:0'],
        'selling_price' => ['required', 'numeric', 'min:0'],
        'description' => ['nullable', 'string'],
    ]);

    $product->update($validated);

    return redirect()->route('products.index')
        ->with('success', 'Produk berhasil diperbarui.');
}


    
public function destroy(Product $product): RedirectResponse
{
    $hasSales = \App\Models\SaleItem::where('product_id', $product->id)->exists();
    $hasPurchases = \App\Models\PurchaseItem::where('product_id', $product->id)->exists();

    if ($hasSales || $hasPurchases) {
        return redirect()->route('products.index')
            ->with('error', 'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi.');
    }

    $product->delete();

    return redirect()->route('products.index')
        ->with('success', 'Produk berhasil dihapus.');
}

}
