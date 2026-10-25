<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class LowStockController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->whereColumn('quantity', '<=', 'minimum_stock')
            ->orderBy('quantity')
            ->paginate(10);

        return view('low-stock.index', compact('products'));
    }
}
