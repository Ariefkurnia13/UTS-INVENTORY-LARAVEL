
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Produk</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 35px auto; padding: 0 18px; background: #f5f7fb; }
        .panel { background: white; padding: 24px; border-radius: 8px; }
        label { display: block; margin-top: 14px; font-weight: bold; }
        input, select, textarea { box-sizing: border-box; width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #ccc; border-radius: 4px; }
        button, .btn { display: inline-block; padding: 10px 14px; margin-top: 18px; background: #2457a7; color: white; border: 0; border-radius: 5px; text-decoration: none; cursor: pointer; }
        .errors { color: #b42318; }
    </style>
</head>
<body>
    <h1>Edit Produk</h1>
    <div class="panel">
        @if($errors->any())
            <ul class="errors">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nama Produk</label>
            <input name="name" value="{{ old('name', $product->name) }}" required>

            <label>SKU / Kode Produk</label>
            <input name="sku" value="{{ old('sku', $product->sku) }}" required>

            <label>Kategori</label>
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <label>Jumlah Stok</label>
            <input type="number" name="quantity" min="0"
                value="{{ old('quantity', $product->quantity) }}" required>

            <label>Harga (Rp)</label>
            <input type="number" name="price" min="0" step="0.01"
                value="{{ old('price', $product->price) }}" required>

            <label>Deskripsi</label>
            <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>

            <button type="submit">Simpan Perubahan</button>
            <a class="btn" href="{{ route('products.index') }}">Kembali</a>
        </form>
    </div>
</body>
</html>
