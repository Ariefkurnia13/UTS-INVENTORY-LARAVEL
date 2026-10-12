# Inventory Management System

Aplikasi manajemen inventaris berbasis Laravel untuk mengelola produk, kategori, jumlah stok, dan harga.

## Fitur
- Melihat daftar produk dan detail produk
- Menambahkan, mengedit, dan menghapus produk (CRUD)
- Mencari produk berdasarkan nama atau SKU
- Ringkasan jumlah produk, kategori, dan stok
- Grafik jumlah stok berdasarkan kategori
- Peringatan stok menipis untuk produk dengan stok 5 unit atau kurang

## Teknologi
- PHP
- Laravel
- MySQL
- Blade
- Bootstrap 5
- Chart.js

## Persyaratan
- PHP yang sesuai dengan versi Laravel pada `composer.json`
- Composer
- MySQL/MariaDB (contohnya melalui XAMPP)
- Git (opsional, untuk GitHub)

Pastikan ekstensi PHP yang dibutuhkan Laravel aktif, termasuk `mbstring` dan `pdo_mysql`.

## Instalasi dari awal

1. Clone repository atau buka folder source code proyek:
   ```bash
   git clone <URL_REPOSITORY>
   cd inventory-laravel
   ```

2. Pasang dependency:
   ```bash
   composer install
   ```

3. Buat file `.env` dari contoh.

   Windows PowerShell:
   ```powershell
   Copy-Item .env.example .env
   ```

   macOS/Linux:
   ```bash
   cp .env.example .env
   ```

   Jika `.env` sudah ada, jangan menimpanya.

4. Buat application key:
   ```bash
   php artisan key:generate
   ```

5. Buat database MySQL bernama `inventory_db` melalui phpMyAdmin atau MySQL.

6. Sesuaikan konfigurasi database di `.env`:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Sesuaikan username dan password dengan konfigurasi MySQL lokal. Jangan unggah `.env` ke GitHub.

7. Jalankan migration dan seeder:
   ```bash
   php artisan migrate --seed
   ```

8. Jalankan server:
   ```bash
   php artisan serve
   ```

9. Buka `http://127.0.0.1:8000`.

### Jika PHP Windows berada di `C:\php84`
Jika PHP tidak tersedia melalui PATH, jalankan:
```powershell
& "C:\php84\php.exe" -v
& "C:\php84\php.exe" artisan key:generate
& "C:\php84\php.exe" artisan migrate --seed
& "C:\php84\php.exe" artisan serve
```
Composer harus sudah terpasang dan dapat dipanggil dari terminal.

## Migration dan seeder
Migration mendefinisikan struktur database:
- `categories`: `id`, `name`, `description` (nullable), timestamps.
- `products`: `id`, `category_id`, `name`, `sku`, `quantity`, `price`, `description` (nullable), timestamps.
- `products.category_id` adalah foreign key ke `categories.id`.
- `products.sku` harus unik.
- Relasi foreign key mengikuti aturan `cascadeOnDelete` yang digunakan pada migration proyek.

Seeder membuat kategori contoh seperti Elektronik, Alat Tulis, dan Aksesori, serta produk contoh seperti Mouse Wireless dan Buku Tulis. Seeder menggunakan `firstOrCreate` agar data contoh tidak diduplikasi saat dijalankan ulang dengan data yang sama.

## Arsitektur MVC
- **Model** — `app/Models/Category.php` dan `app/Models/Product.php` mewakili data dan relasi database. Category memiliki banyak produk; Product berelasi ke satu kategori.
- **View** — Blade di `resources/views/products/` menampilkan dashboard, form tambah/edit, dan detail. `resources/views/layouts/app.blade.php` menyediakan layout bersama.
- **Controller** — `app/Http/Controllers/ProductController.php` memproses request, memvalidasi input, berinteraksi dengan model, lalu mengembalikan view atau redirect.
- **Route** — `routes/web.php` menghubungkan URL dengan controller melalui `Route::resource('products', ProductController::class)`.

## Demonstrasi satu alur lengkap: tambah produk
1. **Membuka form:** pengguna membuka `/products/create`. Route resource memanggil `ProductController::create()`, mengambil daftar kategori, lalu menampilkan `products.create`.
2. **Mengirim form:** pengguna mengisi nama, SKU, kategori, stok, harga, dan deskripsi, lalu menekan Simpan. Form mengirim request `POST` ke `products.store` beserta token CSRF.
3. **Validasi:** `ProductController::store()` memvalidasi data, termasuk field wajib, stok/harga, kategori, dan SKU unik. Jika gagal, Laravel kembali ke form dengan pesan error dan input lama.
4. **Simpan:** jika validasi berhasil, controller menyimpan record Product ke database.
5. **Redirect:** controller mengarahkan pengguna ke halaman tujuan dan dapat menyertakan pesan sukses. Pada implementasi yang umum untuk proyek ini, tujuan redirect adalah daftar produk (`products.index`); pastikan sesuai dengan kode `store()` aktual.
6. **Tampilkan data:** dashboard membaca produk dari database dan menampilkannya di tabel. Pengguna bisa membuka Detail untuk memeriksa produk.

Untuk demonstrasi, kirim form dengan field wajib kosong agar pesan validasi terlihat. Setelah itu, isi data yang benar dengan SKU yang belum dipakai, simpan, lalu tunjukkan pesan sukses dan produk di dashboard.

## Screenshot yang harus disertakan
Ambil screenshot asli dari aplikasi dan source code yang benar-benar berjalan. Simpan dalam `docs/screenshots/`:
1. `01-routes.png` — `routes/web.php` dengan route resource.
2. `02-crud-controller.png` — method CRUD pada `ProductController.php` (gunakan beberapa screenshot jika tidak muat).
3. `03-blade-view.png` — file Blade seperti `products/create.blade.php` atau `products/index.blade.php`.
4. `04-dashboard.png` — dashboard pada browser.
5. `05-form-validation.png` — form tambah produk dengan pesan validasi.
6. `06-product-saved.png` — pesan sukses dan produk yang baru disimpan di dashboard.

Gunakan screenshot dari proyek sendiri, bukan gambar contoh yang tidak menunjukkan aplikasi aktual.

## Struktur berkas relevan
```text
app/
  Http/Controllers/ProductController.php
  Models/Category.php
  Models/Product.php
database/
  migrations/
  seeders/CategorySeeder.php
  seeders/ProductSeeder.php
  seeders/DatabaseSeeder.php
resources/
  views/
    layouts/app.blade.php
    products/
      index.blade.php
      create.blade.php
      edit.blade.php
      show.blade.php
routes/
  web.php
docs/
  screenshots/
```

## Catatan keamanan dan pengumpulan
- Jangan commit `.env`, `vendor/`, atau data rahasia.
- Sertakan `.env.example` tanpa password asli.
- Sertakan seluruh migration dan seeder.
- Sertakan screenshot asli di `docs/screenshots/`.
- Pastikan README sesuai dengan versi PHP/Laravel, nama database, dan perintah yang benar-benar berhasil di proyek.
