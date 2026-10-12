
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 35px auto; max-width: 1100px; padding: 0 18px; background: #f5f7fb; color: #222; }
        h1 { color: #203864; }
        a, button { cursor: pointer; }
        .btn { display: inline-block; padding: 9px 13px; border-radius: 5px; background: #2457a7; color: white; text-decoration: none; border: 0; }
        .danger { background: #c0392b; }
        .panel { background: white; padding: 20px; border-radius: 8px; margin: 18px 0; }
        input { padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { text-align: left; padding: 12px 9px; border-bottom: 1px solid #ddd; }
        th { background: #eaf0fa; }
        .message { padding: 12px; background: #dff4e5; margin-bottom: 15px; border-radius: 5px; }
        .actions { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
        .muted { color: #666; }
    </style>
</head>
<body>
    <h1>Inventory Management System</h1>
    <p class="muted">Kelola data produk dan persediaan barang.</p>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="message">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <a href="{{ route('products.create') }}" class="btn">+ Tambah Produk</a>

        <form method="GET" action="{{ route('products.index') }}" style="display:inline-block; margin-left:12px">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau SKU...">
            <button class="btn" type="submit">Cari</button>
            <a href="{{ route('products.index') }}">Reset</a>
        </form>
    </div>

    <div class="panel">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('products.show', $product) }}">Detail</a>
                                <a href="{{ route('products.edit', $product) }}">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada produk yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px">
            {{ $products->links() }}
        </div>
    </div>
</body>
</html>
