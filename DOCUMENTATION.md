# Dokumentasi Sistem Manajemen Peminjaman Ruangan

## 📋 Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Fitur Utama](#fitur-utama)
3. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
4. [Instalasi](#instalasi)
5. [Konfigurasi](#konfigurasi)
6. [Struktur Proyek](#struktur-proyek)
7. [Database](#database)
8. [API Endpoints](#api-endpoints)
9. [User Roles & Permissions](#user-roles--permissions)
10. [Panduan Penggunaan](#panduan-penggunaan)
11. [Troubleshooting](#troubleshooting)

---

## Pendahuluan

Sistem Manajemen Peminjaman Ruangan adalah aplikasi web berbasis Laravel 12 yang dirancang untuk mengelola peminjaman ruangan di institusi pendidikan atau organisasi. Sistem ini memungkinkan pengguna untuk mengajukan peminjaman ruangan, mengelola jadwal reguler, dan menghasilkan laporan peminjaman.

**Versi:** 1.0  
**Tingkat Stabil:** Stabil  
**Framework:** Laravel 12  
**PHP Version:** 8.4+

---

## Fitur Utama

### 1. **Manajemen User**
- Registrasi dan login pengguna
- Manajemen role dan permission (Administrator, Petugas, Peminjam)
- Profil pengguna yang dapat diperbarui

### 2. **Manajemen Ruangan**
- Pendaftaran ruangan dengan detail lengkap (nama, kode, kapasitas, lokasi, foto)
- Status ketersediaan ruangan
- Pencarian dan filter ruangan

### 3. **Peminjaman Ruangan**
- Pengajuan peminjaman ruangan dengan detail keperluan
- Sistem persetujuan/penolakan peminjaman (untuk Admin/Petugas)
- Pengecekan konflik jadwal otomatis
- History peminjaman

### 4. **Jadwal Reguler**
- Penetapan jadwal ruangan yang terpakai secara reguler
- Pengelolaan per hari dan sesi
- Pencegahan konflik dengan peminjaman

### 5. **Jadwal Gabungan**
- Tampilan jadwal terpadu (reguler + peminjaman)
- Pengecekan ketersediaan real-time

### 6. **Laporan**
- Export laporan peminjaman
- Print laporan
- Filter berdasarkan tanggal dan ruangan

### 7. **Dashboard**
- Overview statistik peminjaman
- Status terkini peminjaman
- Akses cepat ke fitur utama

---

## Teknologi yang Digunakan

### Backend
- **Framework:** Laravel 12
- **PHP:** 8.4+
- **Database:** MySQL/PostgreSQL (dikonfigurasi di `.env`)
- **Authentication:** Laravel Sanctum
- **Queue:** Redis (optional)

### Frontend
- **Build Tool:** Vite 7
- **CSS Framework:** Tailwind CSS 4 + Bootstrap 5
- **Styling:** SASS
- **HTTP Client:** Axios

### Development Tools
- **Testing:** PHPUnit 11.5.3
- **IDE Helper:** Laravel IDE Helper
- **Code Quality:** Laravel Pint
- **Process Manager:** Concurrently

---

## Instalasi

### Prerequisite
- PHP 8.4 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL atau database yang didukung Laravel

### Langkah Instalasi

#### 1. Clone Repository
```bash
git clone <repository-url>
cd LastUKK
```

#### 2. Install Dependencies
```bash
composer install
npm install
```

#### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

#### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lastukk
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Run Migrations
```bash
php artisan migrate
```

#### 6. Seed Database (Optional)
```bash
php artisan db:seed
```

#### 7. Build Assets
```bash
npm run build
```

#### 8. Start Development Server
```bash
npm run dev
php artisan serve
php artisan queue:listen
```

Atau gunakan command semua dalam satu:
```bash
composer run dev
```

---

## Konfigurasi

### File Konfigurasi Penting

#### `.env`
```env
APP_NAME=UKK_Peminjaman
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:...
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ukk_peminjaman
DB_USERNAME=root
DB_PASSWORD=

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=...
MAIL_PASSWORD=...
```

#### `config/app.php`
Konfigurasi aplikasi utama seperti timezone, locale, dll.

#### `config/auth.php`
Konfigurasi authentication menggunakan Sanctum.

#### `config/database.php`
Konfigurasi koneksi database.

---

## Struktur Proyek

```
LastUKK/
├── app/
│   ├── Exports/              # Export handlers
│   │   └── PeminjamanExport.php
│   ├── Helpers/              # Helper functions
│   │   └── sesihelper.php
│   ├── Http/
│   │   ├── Controllers/      # Route controllers
│   │   ├── Middleware/       # HTTP middleware
│   │   ├── Resources/        # API resources
│   │   └── Responses/        # Response classes
│   ├── Models/               # Database models
│   │   ├── Peminjaman.php
│   │   ├── Ruangan.php
│   │   ├── JadwalReguler.php
│   │   └── User.php
│   ├── Services/             # Business logic
│   │   └── ConflictResolutionService.php
│   └── Providers/            # Service providers
├── bootstrap/
│   ├── app.php               # Bootstrap application
│   └── providers.php         # Providers configuration
├── config/                   # Configuration files
├── database/
│   ├── migrations/           # Database migrations
│   ├── factories/            # Model factories
│   └── seeders/              # Database seeders
├── resources/
│   ├── css/
│   ├── js/
│   ├── sass/
│   └── views/                # Blade templates
├── routes/
│   ├── api.php               # API routes
│   ├── web.php               # Web routes
│   └── console.php           # Artisan commands
├── storage/
│   ├── app/                  # File uploads
│   ├── framework/
│   └── logs/
├── tests/                    # Test files
├── vendor/                   # Composer dependencies
├── composer.json
├── package.json
├── vite.config.js
├── phpunit.xml
└── README.md
```

---

## Database

### Schema Utama

#### 1. **Users Table**
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('administrator', 'petugas', 'peminjam') DEFAULT 'peminjam',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### 2. **Ruangans Table**
```sql
CREATE TABLE ruangans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_ruangan VARCHAR(255) NOT NULL,
    kode_ruangan VARCHAR(50) UNIQUE NOT NULL,
    deskripsi TEXT,
    kapasitas INT,
    lokasi VARCHAR(255),
    status ENUM('tersedia', 'tidak_tersedia') DEFAULT 'tersedia',
    foto VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### 3. **Peminjamans Table**
```sql
CREATE TABLE peminjamans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    ruangan_id BIGINT NOT NULL,
    tanggal DATE NOT NULL,
    sesi INT NOT NULL,
    keperluan TEXT NOT NULL,
    status ENUM('menunggu', 'disetujui', 'ditolak', 'selesai') DEFAULT 'menunggu',
    catatan TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (ruangan_id) REFERENCES ruangans(id) ON DELETE CASCADE
);
```

#### 4. **Jadwal Regulers Table**
```sql
CREATE TABLE jadwal_regulers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    ruangan_id BIGINT NOT NULL,
    hari ENUM('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat') NOT NULL,
    sesi INT NOT NULL,
    kegiatan VARCHAR(255) NOT NULL,
    user_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (ruangan_id) REFERENCES ruangans(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### Migrasi Database

Semua migrasi disimpan di `database/migrations/`. Untuk menjalankan migrasi:

```bash
# Run all migrations
php artisan migrate

# Rollback last batch
php artisan migrate:rollback

# Rollback all
php artisan migrate:reset

# Refresh (reset + migrate)
php artisan migrate:refresh

# Refresh dan seed
php artisan migrate:refresh --seed
```

---

## API Endpoints

### Authentication
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/login` | Login pengguna |
| POST | `/register` | Register pengguna baru |
| POST | `/logout` | Logout pengguna |

### Dashboard
| Method | Endpoint | Deskripsi | Role |
|--------|----------|-----------|------|
| GET | `/dashboard` | Tampilkan dashboard | Auth |

### Users (Administrator Only)
| Method | Endpoint | Deskripsi | Role |
|--------|----------|-----------|------|
| GET | `/users` | Daftar semua user | Administrator |
| GET | `/users/create` | Form tambah user | Administrator |
| POST | `/users` | Simpan user baru | Administrator |
| GET | `/users/{id}` | Detail user | Administrator |
| GET | `/users/{id}/edit` | Form edit user | Administrator |
| PUT | `/users/{id}` | Update user | Administrator |
| DELETE | `/users/{id}` | Hapus user | Administrator |

### Ruangan
| Method | Endpoint | Deskripsi | Role |
|--------|----------|-----------|------|
| GET | `/ruangan` | Daftar ruangan | Admin, Petugas |
| GET | `/ruangan/create` | Form tambah ruangan | Administrator |
| POST | `/ruangan` | Simpan ruangan baru | Administrator |
| GET | `/ruangan/{id}` | Detail ruangan | Administrator |
| GET | `/ruangan/{id}/edit` | Form edit ruangan | Administrator |
| PUT | `/ruangan/{id}` | Update ruangan | Administrator |
| DELETE | `/ruangan/{id}` | Hapus ruangan | Administrator |

### Peminjaman
| Method | Endpoint | Deskripsi | Role |
|--------|----------|-----------|------|
| GET | `/peminjaman` | Daftar peminjaman | Auth |
| GET | `/peminjaman/{id}` | Detail peminjaman | Auth |
| GET | `/peminjaman/create` | Form pengajuan peminjaman | Peminjam |
| POST | `/peminjaman` | Ajukan peminjaman | Peminjam |
| GET | `/peminjaman/{id}/edit` | Form edit peminjaman | Admin, Petugas |
| PUT | `/peminjaman/{id}` | Update peminjaman | Admin, Petugas |
| DELETE | `/peminjaman/{id}` | Hapus peminjaman | Admin, Petugas |
| PUT | `/peminjaman/{id}/approve` | Setujui peminjaman | Admin, Petugas |
| PUT | `/peminjaman/{id}/reject` | Tolak peminjaman | Admin, Petugas |

### Jadwal Reguler
| Method | Endpoint | Deskripsi | Role |
|--------|----------|-----------|------|
| GET | `/jadwal-reguler` | Daftar jadwal reguler | Admin, Petugas |
| GET | `/jadwal-reguler/create` | Form tambah jadwal | Admin, Petugas |
| POST | `/jadwal-reguler` | Simpan jadwal baru | Admin, Petugas |
| GET | `/jadwal-reguler/{id}/edit` | Form edit jadwal | Admin, Petugas |
| PUT | `/jadwal-reguler/{id}` | Update jadwal | Admin, Petugas |
| DELETE | `/jadwal-reguler/{id}` | Hapus jadwal | Admin, Petugas |

### Jadwal Gabungan
| Method | Endpoint | Deskripsi | Role |
|--------|----------|-----------|------|
| GET | `/jadwal` | Tampilkan jadwal gabungan | Auth |
| GET | `/api/check-availability` | Cek ketersediaan ruangan | Auth |

### Laporan
| Method | Endpoint | Deskripsi | Role |
|--------|----------|-----------|------|
| GET | `/laporan` | Tampilkan laporan | Admin, Petugas |
| GET | `/laporan/export` | Export laporan (Excel) | Admin, Petugas |
| GET | `/laporan/print` | Print laporan (PDF) | Admin, Petugas |

---

## User Roles & Permissions

### 1. **Administrator**
Memiliki akses penuh ke seluruh sistem:
- ✅ Manajemen user (create, read, update, delete)
- ✅ Manajemen ruangan (create, read, update, delete)
- ✅ Persetujuan/penolakan peminjaman
- ✅ Manajemen jadwal reguler
- ✅ Akses laporan lengkap
- ✅ Dashboard admin

### 2. **Petugas**
Memiliki akses untuk mengelola peminjaman:
- ✅ View ruangan
- ✅ Persetujuan/penolakan peminjaman
- ✅ Manajemen jadwal reguler
- ✅ View laporan
- ❌ Manajemen user
- ❌ Manajemen ruangan (hanya view)

### 3. **Peminjam**
Pengguna standar yang dapat mengajukan peminjaman:
- ✅ Ajukan peminjaman ruangan
- ✅ View peminjaman sendiri
- ✅ View jadwal ketersediaan
- ❌ Manajemen ruangan
- ❌ Manajemen user
- ❌ Persetujuan peminjaman

---

## Panduan Penggunaan

### Untuk Peminjam

#### 1. Register & Login
```
1. Buka halaman login (/)
2. Pilih "Daftar" dan isi form registrasi
3. Login dengan email dan password
4. Akan diarahkan ke dashboard
```

#### 2. Mengajukan Peminjaman
```
1. Klik menu "Peminjaman"
2. Klik tombol "+ Ajukan Peminjaman"
3. Pilih ruangan, tanggal, dan sesi
4. Isi keperluan peminjaman
5. Klik "Ajukan"
6. Tunggu persetujuan dari admin/petugas
```

#### 3. Melihat Status Peminjaman
```
1. Klik menu "Peminjaman"
2. Lihat daftar peminjaman dengan status:
   - Menunggu: Sedang dalam review
   - Disetujui: Peminjaman disetujui
   - Ditolak: Peminjaman ditolak
   - Selesai: Peminjaman selesai
```

#### 4. Melihat Jadwal Ketersediaan
```
1. Klik menu "Jadwal"
2. Lihat jadwal gabungan ruangan
3. Ruangan hijau = tersedia
4. Ruangan merah = tidak tersedia
```

### Untuk Admin/Petugas

#### 1. Manajemen Ruangan
```
1. Klik menu "Ruangan"
2. Klik "+ Tambah Ruangan"
3. Isi detail ruangan:
   - Nama ruangan
   - Kode ruangan
   - Kapasitas
   - Lokasi
   - Upload foto
4. Klik "Simpan"
```

#### 2. Mengelola Peminjaman
```
1. Klik menu "Peminjaman"
2. Lihat daftar peminjaman dengan status "Menunggu"
3. Klik detail peminjaman untuk review
4. Pilih aksi:
   - Setujui: Peminjaman disetujui
   - Tolak: Peminjaman ditolak (isi alasan)
5. Klik "Simpan"
```

#### 3. Manajemen Jadwal Reguler
```
1. Klik menu "Jadwal Reguler"
2. Klik "+ Tambah Jadwal"
3. Pilih ruangan, hari, sesi, dan kegiatan
4. Klik "Simpan"
5. Jadwal akan otomatis mencegah peminjaman pada waktu tersebut
```

#### 4. Generate Laporan
```
1. Klik menu "Laporan"
2. Atur filter: tanggal, ruangan, status
3. Pilih aksi:
   - Export: Download sebagai Excel
   - Print: Cetak sebagai PDF
4. File akan terdownload/terbuka
```

### Untuk Administrator

#### 1. Manajemen User
```
1. Klik menu "Users"
2. Untuk tambah user:
   - Klik "+ Tambah User"
   - Isi nama, email, password
   - Pilih role (Administrator, Petugas, Peminjam)
   - Klik "Simpan"
3. Untuk edit user:
   - Klik user pada daftar
   - Klik "Edit"
   - Ubah data sesuai kebutuhan
   - Klik "Update"
4. Untuk hapus user:
   - Klik user pada daftar
   - Klik "Hapus"
   - Konfirmasi penghapusan
```

---

## Troubleshooting

### Error: "SQLSTATE[HY000]: General error: 1005 Can't create table"
**Solusi:**
```bash
php artisan migrate:reset
php artisan migrate
```

### Error: "No files matched the pattern"
**Solusi:**
```bash
npm install
npm run build
```

### Error: "Class not found"
**Solusi:**
```bash
composer dump-autoload
php artisan cache:clear
php artisan config:clear
```

### Error: "Unauthenticated"
**Solusi:**
- Pastikan sudah login
- Clear cookies browser
- Restart server

### Upload Foto Tidak Berhasil
**Solusi:**
```bash
php artisan storage:link
chmod -R 755 storage/app/public
```

### Database Connection Error
**Solusi:**
- Cek konfigurasi .env
- Pastikan MySQL berjalan
- Cek username dan password database

### Session Error
**Solusi:**
```bash
php artisan session:table
php artisan migrate
```

### Cache Error
**Solusi:**
```bash
php artisan cache:clear
php artisan cache:forget-all
```

---

## Development Commands

```bash
# Setup project
composer run setup

# Development server
composer run dev

# Run tests
composer run test

# Code formatting
php artisan pint

# Generate IDE helper
php artisan ide-helper:generate
php artisan ide-helper:models

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Create migration
php artisan make:migration create_table_name

# Create model
php artisan make:model ModelName -m

# Create controller
php artisan make:controller ControllerName

# Seed database
php artisan db:seed

# Create backup
php artisan backup:run
```

---

## Performance Tips

1. **Database Optimization:**
   ```php
   // Gunakan eager loading untuk relasi
   Peminjaman::with('user', 'ruangan')->get();
   ```

2. **Query Optimization:**
   - Gunakan pagination: `->paginate(15)`
   - Select hanya field yang diperlukan: `->select('id', 'name')`

3. **Caching:**
   ```php
   // Cache hasil query
   Cache::remember('key', 3600, function() {
       return Ruangan::all();
   });
   ```

4. **Assets:**
   - Gunakan CDN untuk assets besar
   - Minify CSS dan JS (auto dengan Vite)

---

## Security Best Practices

1. **Environment Variables:**
   - Jangan commit `.env` file
   - Gunakan `.env.example` sebagai template

2. **Authentication:**
   - Selalu gunakan middleware `auth` untuk protected routes
   - Implement CSRF protection (default di Laravel)

3. **Authorization:**
   - Gunakan middleware role checking
   - Validate user permissions di controller

4. **Input Validation:**
   ```php
   $validated = $request->validate([
       'name' => 'required|string|max:255',
       'email' => 'required|email|unique:users',
   ]);
   ```

5. **SQL Injection Prevention:**
   - Gunakan parameterized queries (ORM Laravel)
   - Hindari raw queries

---

## Support & Contact

Untuk pertanyaan atau dukungan teknis:
- **Email:** support@example.com
- **Issue Tracker:** GitHub Issues
- **Documentation:** /DOCUMENTATION.md

---

**Terakhir Diperbarui:** November 2025  
**Versi:** 1.0  
**Status:** Stabil ✅
