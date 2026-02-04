# Sales Project API

Aplikasi Laravel untuk sistem penjualan dengan API RESTful lengkap.

## Fitur

- **API CRUD Barang** - Kelola data barang dengan validasi lengkap
- **API CRUD Pelanggan** - Kelola data pelanggan dengan informasi lengkap
- **API CRUD Penjualan** - Kelola transaksi penjualan dengan relasi ke pelanggan
- **API Item Penjualan** - Kelola detail item penjualan dengan composite key
- **Resource Formatting** - Response JSON yang konsisten dan terstruktur
- **Validasi Data** - Validasi input yang komprehensif untuk semua endpoint

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Database (SQLite/MySQL/PostgreSQL)
- Node.js & NPM (untuk assets)

## Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi:

### 1. Clone Repository

```bash
git clone <repository-url>
cd sales-project
```

### 2. Install Dependencies

Install PHP dependencies dengan Composer:

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file environment dan generate application key:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Buka file `.env` dan sesuaikan konfigurasi database:

**Untuk SQLite (default):**
```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_project
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration

Buat tabel-tabel database yang diperlukan:

```bash
php artisan migrate
```

### 6. Install Frontend Dependencies (Opsional)

```bash
npm install
npm run build
```

### 7. Jalankan Server

Start development server:

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## API Endpoints

### Barang
- `GET /api/barang` - List semua barang
- `GET /api/barang/{kode}` - Detail barang
- `POST /api/barang` - Tambah barang baru
- `PUT /api/barang/{kode}` - Update barang
- `DELETE /api/barang/{kode}` - Hapus barang

### Pelanggan
- `GET /api/pelanggan` - List semua pelanggan
- `GET /api/pelanggan/{id}` - Detail pelanggan
- `POST /api/pelanggan` - Tambah pelanggan baru
- `PUT /api/pelanggan/{id}` - Update pelanggan
- `DELETE /api/pelanggan/{id}` - Hapus pelanggan

### Penjualan
- `GET /api/penjualan` - List semua penjualan
- `GET /api/penjualan/{id_nota}` - Detail penjualan
- `POST /api/penjualan` - Tambah penjualan baru
- `PUT /api/penjualan/{id_nota}` - Update penjualan
- `DELETE /api/penjualan/{id_nota}` - Hapus penjualan

### Item Penjualan
- `GET /api/item_penjualan` - List semua item penjualan
- `GET /api/item_penjualan/{nota}/{kode_barang}` - Detail item penjualan
- `POST /api/item_penjualan` - Tambah item penjualan baru
- `PUT /api/item_penjualan/{nota}/{kode_barang}` - Update item penjualan
- `DELETE /api/item_penjualan/{nota}/{kode_barang}` - Hapus item penjualan

## Quick Setup (Script Otomatis)

Gunakan script setup yang tersedia:

```bash
composer run setup
```

Script ini akan menjalankan:
- `composer install`
- Copy `.env.example` ke `.env`
- `php artisan key:generate`
- `php artisan migrate`
- `npm install`
- `npm run build`

## Development Mode

Untuk development dengan hot reload:

```bash
composer run dev
```

## Testing

Jalankan test suite:

```bash
composer run test
```

## Struktur Database

- **barang** - Data barang (kode, nama, kategori, harga)
- **pelanggan** - Data pelanggan (id_pelanggan, nama, domisili, jenis_kelamin)
- **penjualan** - Data transaksi penjualan (id_nota, tgl, kode_pelanggan, subtotal)
- **item_penjualan** - Detail item penjualan (nota, kode_barang, qty, harga)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
