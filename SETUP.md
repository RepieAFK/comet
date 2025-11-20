# Setup & Installation Guide

## System Requirements

### Minimum
- **PHP:** 8.4 atau lebih tinggi
- **Composer:** Latest version
- **Node.js:** 16.x atau lebih tinggi
- **NPM:** 8.x atau lebih tinggi
- **Database:** MySQL 5.7+ atau PostgreSQL 10+
- **RAM:** 2 GB
- **Disk Space:** 500 MB

### Recommended
- **PHP:** 8.4 LTS
- **Node.js:** 20.x LTS
- **MySQL:** 8.0+
- **RAM:** 4 GB+
- **SSD Storage:** 1 GB

---

## Pre-Installation Checklist

- [ ] PHP 8.4 atau lebih tinggi terinstall
- [ ] Composer terinstall
- [ ] Node.js & NPM terinstall
- [ ] Database server running (MySQL/PostgreSQL)
- [ ] Git terinstall (untuk clone repository)
- [ ] Text editor atau IDE (VS Code, PHPStorm, etc)

---

## Installation Steps

### Step 1: Clone Repository

**Windows (PowerShell):**
```powershell
git clone https://github.com/username/UKK-Peminjaman.git
cd LastUKK
```

**macOS/Linux:**
```bash
git clone https://github.com/username/UKK-Peminjaman.git
cd LastUKK
```

### Step 2: Install PHP Dependencies

**Windows (PowerShell):**
```powershell
composer install
```

**macOS/Linux:**
```bash
composer install
```

> **Note:** Jika mengalami error memory, jalankan:
> ```bash
> composer install --no-interaction --prefer-dist
> ```

### Step 3: Install Frontend Dependencies

**Windows (PowerShell):**
```powershell
npm install
```

**macOS/Linux:**
```bash
npm install
```

### Step 4: Configure Environment

**Windows (PowerShell):**
```powershell
Copy-Item .env.example .env
```

**macOS/Linux:**
```bash
cp .env.example .env
```

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

Output akan seperti:
```
Application key set successfully.
```

### Step 6: Configure Database

Buka file `.env` dan edit section database:

**MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ukk_peminjaman
DB_USERNAME=root
DB_PASSWORD=
```

**PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ukk_peminjaman
DB_USERNAME=postgres
DB_PASSWORD=
```

**SQLite:**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/full/path/to/database.sqlite
```

> **Tip:** Untuk development, gunakan SQLite untuk simplicity:
> ```bash
> touch database/database.sqlite
> ```

### Step 7: Create Database

**MySQL:**
```bash
mysql -u root -p
CREATE DATABASE ukk_peminjaman;
EXIT;
```

**PostgreSQL:**
```bash
psql -U postgres
CREATE DATABASE ukk_peminjaman;
\q
```

### Step 8: Run Migrations

```bash
php artisan migrate
```

Output akan menampilkan:
```
Migrated: 2025_01_01_000000_create_users_table
Migrated: 2025_01_01_000001_create_cache_table
...
```

### Step 9: Seed Database (Optional)

Untuk mengisi data dummy:

```bash
php artisan db:seed
```

Atau seed spesifik:
```bash
php artisan db:seed --class=UserSeeder
```

### Step 10: Build Frontend Assets

**Development:**
```bash
npm run dev
```

**Production:**
```bash
npm run build
```

### Step 11: Create Storage Symlink

```bash
php artisan storage:link
```

### Step 12: Set Permissions (Linux/macOS Only)

```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Step 13: Start Development Server

**Option 1 - Separate Terminals:**

Terminal 1 - PHP Server:
```bash
php artisan serve
```

Terminal 2 - Frontend (Vite):
```bash
npm run dev
```

Terminal 3 - Queue Worker:
```bash
php artisan queue:listen
```

**Option 2 - All in One:**
```bash
composer run dev
```

---

## Access Application

- **Web URL:** http://localhost:8000
- **Vite Preview:** http://localhost:5173

---

## Initial Setup After Installation

### 1. Create Admin User

```bash
php artisan tinker
>>> App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'administrator'
])
>>> exit
```

Atau gunakan seeder yang sudah disediakan.

### 2. Create Test Rooms

```bash
php artisan tinker
>>> App\Models\Ruangan::create([
    'nama_ruangan' => 'Lab Komputer 1',
    'kode_ruangan' => 'LC-001',
    'kapasitas' => 30,
    'lokasi' => 'Gedung A Lantai 1',
    'status' => 'tersedia'
])
>>> exit
```

### 3. Test Login

Buka browser dan navigasi ke http://localhost:8000

- **Email:** admin@example.com
- **Password:** password123

---

## Docker Setup (Optional)

Jika menggunakan Docker:

### 1. Build Docker Image

```bash
docker-compose build
```

### 2. Start Containers

```bash
docker-compose up -d
```

### 3. Run Commands Inside Container

```bash
docker-compose exec app php artisan migrate
docker-compose exec app npm run build
```

---

## Troubleshooting Installation

### Error: "Failed to parse composer.json"

**Solution:**
```bash
composer install --no-scripts
composer update --no-scripts
```

### Error: "php.exe is not recognized"

**Solution:** Tambahkan PHP ke PATH environment variable.

### Error: "npm command not found"

**Solution:** Install Node.js dari https://nodejs.org

### Error: "The key has already been generated"

**Solution:**
```bash
php artisan key:generate --force
```

### Error: "SQLSTATE[HY000]: General error"

**Solution:**
```bash
php artisan migrate:reset
php artisan migrate
```

### Error: "Composer memory exhausted"

**Solution:**
```bash
php -d memory_limit=-1 composer install
```

### Error: "NPM install hangs"

**Solution:**
```bash
npm cache clean --force
npm install
```

### Error: "Port 8000 already in use"

**Solution:**
```bash
php artisan serve --port=8001
```

### Error: "Permission denied" (Linux/macOS)

**Solution:**
```bash
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/
```

---

## Environment Variables

### Essential Variables

```env
# Application
APP_NAME=UKK_Peminjaman
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:...
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ukk_peminjaman
DB_USERNAME=root
DB_PASSWORD=

# Mail (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@example.com

# Cache
CACHE_DRIVER=file

# Session
SESSION_DRIVER=cookie
SESSION_LIFETIME=120

# Queue (Optional)
QUEUE_CONNECTION=database
```

---

## Production Deployment

### Before Deploying

1. **Environment:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimization:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   composer dump-autoload --optimize
   ```

3. **Build Assets:**
   ```bash
   npm run build
   ```

4. **Migrate Database:**
   ```bash
   php artisan migrate --force
   ```

### Deployment Checklist

- [ ] `.env` file configured for production
- [ ] Database backed up
- [ ] Assets built for production
- [ ] `APP_KEY` generated and stored securely
- [ ] HTTPS enabled
- [ ] File permissions set correctly
- [ ] Logs directory writable
- [ ] Storage linked
- [ ] Cache configured
- [ ] Queue worker running (if needed)

---

## Maintenance Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Health check
php artisan tinker
>>> DB::connection()->getPdo()
>>> exit

# Database cleanup
php artisan db:wipe
php artisan migrate --fresh --seed
```

---

## Getting Help

- **Documentation:** See `DOCUMENTATION.md`
- **API Docs:** See `API_DOCUMENTATION.md`
- **Laravel Docs:** https://laravel.com/docs/12
- **Issues:** GitHub Issues

---

**Last Updated:** November 2025  
**Version:** 1.0
