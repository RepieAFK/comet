# Quick Reference Guide

## 🚀 Getting Started (5 Minutes)

### Start Development
```bash
composer run dev
```

This runs:
- PHP Server: http://localhost:8000
- Vite Dev Server: http://localhost:5173
- Queue Worker
- Tail logs

### Stop Server
Press `Ctrl+C` in terminal

---

## 📊 Common Commands

### Database
```bash
# Create tables
php artisan migrate

# Reset database
php artisan migrate:reset

# Reset & seed
php artisan migrate:refresh --seed

# Seed specific seeder
php artisan db:seed --class=UserSeeder
```

### Cache
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimize for production
php artisan optimize
```

### Code
```bash
# Fix code style
php artisan pint

# Generate IDE helpers
php artisan ide-helper:generate
php artisan ide-helper:models
```

### Testing
```bash
# Run all tests
composer run test

# Run specific test
php artisan test tests/Feature/PeminjamanTest.php

# Run with coverage
php artisan test --coverage
```

### Tinker (REPL)
```bash
php artisan tinker

# Inside tinker:
>>> $user = User::first()
>>> $user->name
>>> $user->peminjamans()->count()
>>> exit
```

---

## 🔌 Routes Reference

### Web Routes (Protected by Auth)

#### Dashboard
- `GET /dashboard` - Dashboard

#### Users (Admin only)
- `GET /users` - List users
- `GET /users/create` - Create form
- `POST /users` - Store user
- `GET /users/{id}` - Show user
- `GET /users/{id}/edit` - Edit form
- `PUT /users/{id}` - Update user
- `DELETE /users/{id}` - Delete user

#### Rooms (Admin/Staff)
- `GET /ruangan` - List rooms
- `GET /ruangan/create` - Create form
- `POST /ruangan` - Store room
- `GET /ruangan/{id}` - Show room
- `GET /ruangan/{id}/edit` - Edit form
- `PUT /ruangan/{id}` - Update room
- `DELETE /ruangan/{id}` - Delete room

#### Bookings (All users)
- `GET /peminjaman` - List bookings
- `GET /peminjaman/{id}` - Show booking
- `GET /peminjaman/create` - Create form (Peminjam)
- `POST /peminjaman` - Store booking (Peminjam)
- `GET /peminjaman/{id}/edit` - Edit form
- `PUT /peminjaman/{id}` - Update booking
- `DELETE /peminjaman/{id}` - Delete booking
- `PUT /peminjaman/{id}/approve` - Approve booking (Admin/Staff)
- `PUT /peminjaman/{id}/reject` - Reject booking (Admin/Staff)

#### Regular Schedules (Admin/Staff)
- `GET /jadwal-reguler` - List schedules
- `GET /jadwal-reguler/create` - Create form
- `POST /jadwal-reguler` - Store schedule
- `GET /jadwal-reguler/{id}/edit` - Edit form
- `PUT /jadwal-reguler/{id}` - Update schedule
- `DELETE /jadwal-reguler/{id}` - Delete schedule

#### Schedule View (All users)
- `GET /jadwal` - Combined schedule view

#### Reports (Admin/Staff)
- `GET /laporan` - View reports
- `GET /laporan/export` - Export to Excel
- `GET /laporan/print` - Print to PDF

#### API
- `GET /api/check-availability` - Check room availability

### Authentication Routes (Guest)
- `GET /` - Login form
- `POST /login` - Process login
- `GET /register` - Register form
- `POST /register` - Process registration
- `POST /logout` - Logout

---

## 🎨 Database Sessions

Each day has 9 sessions:

| Sesi | Waktu |
|------|-------|
| 1 | 07:00 - 07:45 |
| 2 | 07:45 - 08:30 |
| 3 | 08:30 - 09:15 |
| 4 | 09:15 - 10:00 |
| 5 | 10:15 - 11:00 |
| 6 | 11:00 - 11:45 |
| 7 | 11:45 - 12:30 |
| 8 | 13:00 - 13:45 |
| 9 | 13:45 - 14:30 |

---

## 👥 User Roles

| Role | Permissions |
|------|-------------|
| **Administrator** | Full access - users, rooms, bookings, schedules, reports |
| **Petugas (Staff)** | Approve bookings, manage schedules, view reports |
| **Peminjam (User)** | Create bookings, view own bookings, view schedule |

---

## 📋 Booking Status

| Status | Meaning |
|--------|---------|
| **menunggu** | Waiting for approval |
| **disetujui** | Approved and confirmed |
| **ditolak** | Rejected by admin/staff |
| **selesai** | Completed |

---

## 🐞 Common Issues & Solutions

### Can't access localhost:8000
```bash
# Check if port is in use
netstat -ano | findstr :8000

# Use different port
php artisan serve --port=8001
```

### Database connection error
```bash
# Check .env database settings
# Make sure MySQL is running
# Test connection
php artisan tinker
>>> DB::connection()->getPdo()
>>> exit
```

### Uploads not working
```bash
php artisan storage:link
chmod -R 755 storage/app/public
```

### Permission denied errors (Linux/Mac)
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Composer memory error
```bash
php -d memory_limit=-1 composer install
```

---

## 🔐 Environment Setup

### Minimal .env
```env
APP_NAME=UKK_Peminjaman
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ukk_peminjaman
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=cookie
```

---

## 🎯 Useful Links

- [Full Documentation](./DOCUMENTATION.md)
- [Setup Guide](./SETUP.md)
- [API Reference](./API_DOCUMENTATION.md)
- [Developer Guide](./DEVELOPER.md)
- [Laravel Docs](https://laravel.com/docs/12)

---

## 💡 Tips & Tricks

### Create admin user quickly
```bash
php artisan tinker
>>> App\Models\User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password'), 'role' => 'administrator'])
>>> exit
```

### Create sample room
```bash
php artisan tinker
>>> App\Models\Ruangan::create(['nama_ruangan' => 'Lab 1', 'kode_ruangan' => 'LAB-001', 'kapasitas' => 30, 'lokasi' => 'Building A', 'status' => 'tersedia'])
>>> exit
```

### Refresh everything for fresh start
```bash
php artisan migrate:fresh --seed
php artisan cache:clear
php artisan config:clear
```

### Check available routes
```bash
php artisan route:list
```

### Monitor logs in real-time
```bash
php artisan pail
```

---

## 📈 Performance Tweaks

### For Development
```php
// .env
APP_DEBUG=true
CACHE_DRIVER=file
```

### For Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize
npm run build
```

---

## 🆘 Getting Help

1. **Check Documentation** → Read DOCUMENTATION.md
2. **Search Issues** → GitHub Issues
3. **Check Logs** → `storage/logs/laravel.log`
4. **Use Tinker** → `php artisan tinker`

---

**Last Updated:** November 2025  
**Version:** 1.0
