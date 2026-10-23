# Inventory & Sales Management System

Aplikasi web berbasis Laravel untuk mengelola data kategori, produk, pemasok, pembelian stok, penjualan, dan informasi persediaan.

## 1. Deskripsi Proyek

Proyek ini dibuat untuk memenuhi tugas UTS Web Programming 2 dengan menerapkan Laravel MVC, database relasional, Eloquent ORM, autentikasi, otorisasi, validasi, serta pengelolaan transaksi dan stok barang.

Aplikasi dirancang untuk membantu pencatatan persediaan dan transaksi agar lebih terstruktur serta mengurangi kesalahan dalam pengelolaan stok.

## 2. Fitur Aplikasi

### Autentikasi dan Hak Akses
- Login dan logout.
- Pembatasan akses berdasarkan role pengguna.
- Perlindungan halaman yang memerlukan autentikasi.

### Master Data
- Pengelolaan kategori produk.
- Pengelolaan produk.
- Pengelolaan data pemasok.
- Validasi data produk, termasuk SKU dan harga.

### Pembelian
- Pencatatan transaksi pembelian atau penambahan stok.
- Pencatatan item pembelian.
- Penambahan stok berdasarkan transaksi yang berhasil.

### Penjualan
- Pencatatan transaksi penjualan.
- Pencatatan beberapa item dalam transaksi.
- Pengurangan stok setelah transaksi berhasil.
- Penolakan penjualan apabila stok tidak mencukupi.

### Pencarian dan Informasi
- Pencarian serta filter data produk.
- Filter kategori pada daftar produk.
- Pagination pada daftar data.
- Informasi stok produk.

## 3. Teknologi

- PHP
- Laravel
- MySQL atau database yang didukung oleh konfigurasi Laravel
- Blade Template Engine
- Eloquent ORM
- Composer
- Node.js dan npm untuk pengelolaan aset frontend, jika diperlukan oleh proyek

Versi perangkat lunak yang diperlukan mengikuti versi pada `composer.json`, `composer.lock`, dan konfigurasi proyek.

## 4. Persyaratan Instalasi

Pastikan perangkat sudah memiliki:
- PHP dengan ekstensi yang dibutuhkan Laravel.
- Composer.
- Database yang didukung proyek.
- Git.
- Node.js dan npm jika proses build aset frontend diperlukan.

## 5. Cara Instalasi

### Langkah 1 — Clone Repository

Ganti URL berikut dengan URL repository GitHub proyek ini.

```bash
git clone <URL_REPOSITORY_GITHUB>
cd inventory-laravel
```

### Langkah 2 — Instal Dependensi PHP

```bash
composer install
```

### Langkah 3 — Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

Pada Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Sesuaikan konfigurasi database di file `.env`, misalnya:

```dotenv
APP_NAME="Inventory Management"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Nilai di atas adalah contoh konfigurasi. Sesuaikan nama database, username, password, dan driver dengan lingkungan yang digunakan.

Buat database kosong terlebih dahulu melalui MySQL atau alat pengelolaan database yang digunakan.

### Langkah 4 — Generate Application Key

```bash
php artisan key:generate
```

### Langkah 5 — Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

Perintah tersebut digunakan untuk membuat tabel dan menjalankan data awal yang disediakan oleh seeder proyek.

Jika proses ini gagal, periksa konfigurasi database dan isi migration serta seeder yang tersedia sebelum melanjutkan.

### Langkah 6 — Instal dan Build Aset Frontend

Jika proyek menggunakan Vite atau aset frontend berbasis npm:

```bash
npm install
npm run build
```

### Langkah 7 — Jalankan Aplikasi

```bash
php artisan serve
```

Buka alamat berikut di browser:

http://127.0.0.1:8000

## 6. Akun Demo

Akun demo mengikuti data yang disediakan oleh seeder proyek.

Periksa file seeder untuk mengetahui apakah akun Admin dan Staff telah dibuat beserta kredensial demo yang disediakan.

Jangan menggunakan password pribadi atau kredensial produksi sebagai akun demo.

## 7. Struktur Aplikasi

Struktur utama aplikasi Laravel meliputi:

```text
app/
  Http/
    Controllers/
  Models/

database/
  migrations/
  seeders/

resources/
  views/

routes/
  web.php

tests/
  Feature/
  Unit/
```

Struktur aktual dapat berbeda sesuai implementasi proyek.

## 8. Aturan Bisnis

Aplikasi inventory perlu menjaga konsistensi data melalui aturan berikut:

- SKU produk harus unik.
- Harga dan jumlah barang harus memenuhi validasi.
- Penjualan tidak boleh melebihi stok yang tersedia.
- Stok hanya berubah ketika transaksi berhasil diproses.
- Total transaksi dihitung berdasarkan data item di sisi server.
- Header transaksi, detail item, dan perubahan stok harus dikelola secara konsisten.
- Kegagalan penyimpanan salah satu item tidak boleh meninggalkan transaksi parsial.

## 9. Pengujian

Jalankan pengujian otomatis menggunakan:

```bash
php artisan test
```

Pengujian manual juga perlu dilakukan untuk memeriksa login, hak akses, penambahan stok melalui pembelian, pengurangan stok melalui penjualan, validasi stok tidak mencukupi, dan konsistensi transaksi.

## 10. Keamanan

- Password pengguna harus disimpan menggunakan hashing.
- Form yang mengubah data harus dilindungi CSRF.
- Validasi input dilakukan di server.
- Hak akses harus diperiksa di sisi server, bukan hanya dengan menyembunyikan tombol pada antarmuka.
- File `.env` yang berisi kredensial tidak boleh dimasukkan ke repository.
- Repository hanya menyediakan `.env.example` tanpa rahasia.
- Pada lingkungan produksi, gunakan `APP_DEBUG=false`.

## 11. Catatan Pengembangan

Proyek ini dikembangkan sebagai aplikasi pengelolaan persediaan dan transaksi penjualan menggunakan Laravel. Implementasi akhir perlu diuji kembali setelah instalasi dari repository baru untuk memastikan migration, seeder, konfigurasi database, autentikasi, dan alur transaksi berjalan dengan benar.

## 12. Pengembang

**Project:** Inventory & Sales Management System  
**Framework:** Laravel  
**Course:** Web Programming 2 — UTS Integrated Laravel Project
