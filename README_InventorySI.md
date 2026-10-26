# Inventory Laravel UTS

Aplikasi inventaris berbasis Laravel untuk mengelola data kategori,
produk, supplier, pembelian (stok masuk), penjualan (stok keluar), serta
ringkasan persediaan.

> **Catatan status:** README ini disusun berdasarkan informasi proyek
> dan perubahan yang telah dibahas. Hasil pengujian fitur di bawah
> merupakan hasil pengujian yang dilaporkan pengguna; belum berarti
> seluruh pengujian telah dijalankan ulang secara otomatis pada kondisi
> proyek saat ini.

## Teknologi dan persyaratan

-   PHP: `^8.3`
-   Laravel Framework: `^13.17`
-   PHPUnit: `^12.5.12` (dependensi pengujian)
-   Database: MySQL, sesuai konfigurasi lingkungan proyek
-   Dependensi PHP dikunci melalui `composer.lock`

Pastikan versi PHP, ekstensi PHP, Composer, dan layanan database di
komputer tujuan memenuhi kebutuhan proyek sebelum menjalankan aplikasi.

## Fitur aplikasi

Fitur yang telah dilaporkan diuji: - Login, validasi login, akses
halaman internal setelah login, dan logout. - Pembatasan akses Staff dan
Admin, termasuk pengujian akses URL langsung. - Pengelolaan kategori,
produk, dan supplier. - Validasi SKU unik dan penolakan nilai formulir
yang tidak valid. - Transaksi pembelian dan penjualan beserta detail
item. - Perubahan stok setelah transaksi, perhitungan total di sisi
server, pembatalan transaksi yang mengembalikan stok, dan penanganan
transaksi gagal. - Ringkasan Dashboard, daftar stok minimum,
pencarian/filter, pagination, dan detail transaksi.

**Penting:** Dashboard dipertahankan sesuai tampilan dan perilaku yang
sudah dikerjakan. Penyeragaman tampilan halaman lain tidak dimaksudkan
untuk mengubah Dashboard atau logika bisnis transaksi.

## Persiapan instalasi

1.  Siapkan PHP sesuai persyaratan proyek, Composer, dan MySQL.

2.  Salin atau clone proyek ke komputer.

3.  Di terminal, masuk ke direktori proyek.

4.  Pasang dependensi dari lock file:

    ``` bash
    composer install
    ```

5.  Buat file `.env` dari template:

    ``` bash
    # Windows PowerShell
    Copy-Item .env.example .env
    ```

    Jika `.env` sudah ada, jangan menimpanya. Periksa dan sesuaikan
    konfigurasi yang diperlukan.

6.  Atur konfigurasi aplikasi dan database pada `.env`, terutama:

    ``` dotenv
    APP_NAME="Inventory Laravel UTS"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://127.0.0.1:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=username_database
    DB_PASSWORD=password_database
    ```

    Ganti nilai database dengan konfigurasi lokal yang benar. Jangan
    mengunggah `.env` atau membagikan kata sandi.

7.  Buat application key jika belum tersedia:

    ``` bash
    php artisan key:generate
    ```

8.  Jalankan migrasi dan seeder **hanya pada database yang memang
    disiapkan untuk instalasi/pengujian**:

    ``` bash
    php artisan migrate --seed
    ```

    Perintah ini mengubah skema database dan dapat menambahkan data
    awal. Jangan jalankan pada database yang berisi data penting tanpa
    backup dan persetujuan pemilik database.

9.  Jika proyek memiliki aset frontend yang perlu dibangun dan
    Node.js/npm tersedia:

    ``` bash
    npm install
    npm run build
    ```

10. Jalankan server lokal:

    ``` bash
    php artisan serve
    ```

11. Buka URL lokal yang ditampilkan oleh Artisan, biasanya
    `http://127.0.0.1:8000`.

### Menjalankan dengan PHP tertentu di Windows

Jika PHP tidak terdaftar di `PATH`, gunakan lokasi executable PHP yang
terpasang. Contoh yang pernah digunakan pada lingkungan pengembangan
proyek ini:

``` powershell
& "C:\php84\php.exe" artisan view:clear
& "C:\php84\php.exe" artisan optimize:clear
& "C:\php84\php.exe" artisan route:list
```

Perintah tersebut adalah contoh untuk membersihkan cache view/optimasi
dan menampilkan daftar route. `route:list` bersifat pemeriksaan;
perintah pembersihan cache mengubah cache aplikasi, bukan data transaksi
database.

## Akun demo

Materi UTS mensyaratkan seeder menyiapkan kategori, produk, supplier,
dan akun demo. Pastikan implementasi `database/seeders` benar-benar
membuat data tersebut sebelum demo.

**Kredensial akun tidak dicantumkan di README ini karena nilai akun dan
kata sandi yang aktif belum dikonfirmasi dari kode seeder terbaru.**
Setelah diverifikasi, dokumentasikan akun demo yang aman untuk
penilaian. Jangan gunakan kata sandi produksi.

## Aturan bisnis yang harus dipertahankan

-   Kuantitas transaksi harus lebih besar dari nol.
-   Penjualan tidak boleh melebihi stok yang tersedia.
-   Total transaksi harus dihitung oleh aplikasi di sisi server, bukan
    dipercaya dari input browser.
-   Pembelian yang berhasil menambah stok; penjualan yang berhasil
    mengurangi stok.
-   Pembatalan transaksi harus mengikuti izin dan status yang ditetapkan
    serta menjaga konsistensi stok.
-   Kegagalan transaksi tidak boleh meninggalkan header, detail, dan
    perubahan stok dalam kondisi parsial.
-   Nomor transaksi harus unik.
-   Produk yang memiliki riwayat transaksi tidak boleh dihapus permanen
    jika penghapusan akan merusak riwayat atau relasi.
-   Pembatasan Admin/Staff harus diterapkan di server, bukan hanya
    dengan menyembunyikan tombol pada tampilan.

## Status pengujian yang dilaporkan

Pengujian manual berikut dilaporkan **lulus oleh pengguna**. Daftar ini
bukan laporan hasil test otomatis dan belum dijalankan ulang sebagai
bagian penyusunan README ini.

  Area                                     Jumlah yang dilaporkan lulus Status
  -------------------------------------- ------------------------------ --------------------------------------------
  Hak akses Staff dan aturan transaksi                               25 Dilaporkan lulus
  Login dan keamanan umum                                             4 Dilaporkan lulus
  Master data Admin                                                   7 Dilaporkan lulus
  Pembelian dan penjualan                                             8 Dilaporkan lulus
  Dashboard, laporan, pencarian                                       6 Dilaporkan lulus
  **Total**                                                      **50** **Berdasarkan laporan pengujian pengguna**

Hal-hal yang masih dilaporkan **belum diuji**: - Relasi dan foreign key
antar tabel berfungsi. - Migrasi dapat dijalankan pada database yang
disiapkan. - Seeder membuat data awal yang diperlukan. - README dan
prosedur instalasi dapat diikuti dari lingkungan bersih. - Aplikasi
dapat dijalankan kembali setelah konfigurasi database benar.

Status ini harus diperbarui setelah pemeriksaan dilakukan. Jangan
menandai item belum diuji sebagai lulus hanya karena file atau
konfigurasi terlihat tersedia.

## Pemecahan masalah

### Koneksi database ditolak

Jika muncul pesan seperti `SQLSTATE[HY000] [2002]` atau koneksi ke
`127.0.0.1:3306` ditolak:

1.  Pastikan layanan MySQL berjalan.
2.  Pastikan `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan
    `DB_PASSWORD` di `.env` sesuai dengan lingkungan lokal.
3.  Pastikan database sudah dibuat.
4.  Jangan menjalankan migrasi atau seeder sampai target database sudah
    dipastikan benar.

Contoh pesan koneksi yang pernah muncul pada lingkungan pengembangan
menyebut database `inventory_db`. Nama database pada komputer lain dapat
berbeda; gunakan nilai yang benar-benar dikonfigurasi pada `.env` lokal.

### Route atau tampilan belum mencerminkan perubahan

Untuk memeriksa route:

``` bash
php artisan route:list
```

Jika memang diperlukan untuk menyegarkan cache tampilan, perintah
berikut dapat digunakan:

``` bash
php artisan view:clear
php artisan optimize:clear
```

Jalankan dari direktori proyek dan pastikan konfigurasi lingkungan sudah
benar. Perintah tersebut tidak menggantikan pengujian fungsional.

## Struktur direktori penting

``` text
app/                 # Kode aplikasi, model, controller, middleware/policy
database/
  migrations/        # Struktur database
  seeders/           # Data awal dan akun demo
resources/views/     # Blade views
routes/              # Definisi route
.env.example         # Template konfigurasi lingkungan
composer.json        # Persyaratan dan dependensi PHP
composer.lock        # Versi dependensi yang dikunci
```

## Catatan keamanan dan pengumpulan

-   Jangan commit `.env`, kredensial database, atau kata sandi.
-   Pastikan `.env.example` hanya berisi nilai contoh, bukan rahasia.
-   Verifikasi seeder akun demo sebelum menyerahkan proyek.
-   Lakukan backup sebelum pengujian yang mengubah database.
-   Sertakan ERD dan informasi instalasi pada laporan/pengumpulan
    apabila diwajibkan dosen.
-   Pastikan setiap fitur yang ditampilkan saat demo sudah diuji pada
    database yang benar.
