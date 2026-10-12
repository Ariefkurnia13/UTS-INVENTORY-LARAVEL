
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Produk</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 35px auto; padding: 0 18px; background: #f5f7fb; }
        .panel { background: white; padding: 24px; border-radius: 8px; }
        dt { font-weight: bold; margin-top: 16px; color: #203864; }
        dd { margin: 6px 0 0; }
        .btn { display: inline-block; padding: 10px 14px; margin-top: 20px; background: #2457a7; color: white; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Detail Produk</h1>
    <div class="panel">
        <dl>
            <dt>Nama Produk</dt>
            <dd>{{ $product->name }}</dd>

            <dt>SKU</dt>
            <dd>{{ $product->sku }}</dd>

            <dt>Kategori</dt>
            <dd>{{ $product->category->name }}</dd>

            <dt>Jumlah Stok</dt>
            <dd>{{ $product->quantity }}</dd>

            <dt>Harga</dt>
            <dd>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</dd>

            <dt>Deskripsi</dt>
            <dd>{{ $product->description ?: '-' }}</dd>

            <dt>Dibuat</dt>
            <dd>{{ $product->created_at->format('d-m-Y H:i') }}</dd>
        </dl>

        <a class="btn" href="{{ route('products.edit', $product) }}">Edit Produk</a>
        <a class="btn" href="{{ route('products.index') }}">Kembali ke Daftar</a>
    </div>
</body>
</html>
