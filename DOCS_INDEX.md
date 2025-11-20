# 📚 Dokumentasi Index

Selamat datang di dokumentasi lengkap **Sistem Manajemen Peminjaman Ruangan**. Pilih topik yang Anda butuhkan di bawah ini.

---

## 🚀 Mulai Cepat

**Baru di sini?** Mulai dari sini:

- **[README.md](README.md)** - Gambaran umum proyek ✨
- **[QUICK_REFERENCE.md](QUICK_REFERENCE.md)** - Referensi cepat (5 menit) ⚡

---

## 📖 Panduan Lengkap

### 1. **[SETUP.md](SETUP.md)** - Instalasi & Konfigurasi
   - Syarat sistem
   - Langkah instalasi step-by-step
   - Troubleshooting setup
   - Deployment untuk production

### 2. **[DOCUMENTATION.md](DOCUMENTATION.md)** - Dokumentasi Utama
   - Fitur sistem lengkap
   - Panduan penggunaan untuk setiap user role
   - Database schema
   - API endpoints
   - Troubleshooting umum

### 3. **[DEVELOPER.md](DEVELOPER.md)** - Panduan Developer
   - Penjelasan Models (User, Ruangan, Peminjaman, JadwalReguler)
   - Penjelasan Controllers
   - Services & Helpers
   - Best practices
   - Kode examples

### 4. **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** - API Reference
   - Authentication
   - Endpoint details
   - Request/Response examples
   - Error handling

---

## 🎯 Berdasarkan Peran

### Untuk Peminjam (End User)
1. Baca: [DOCUMENTATION.md → Panduan Penggunaan → Untuk Peminjam](DOCUMENTATION.md#untuk-peminjam)
2. Tanya: Hubungi admin jika ada kendala

### Untuk Admin/Petugas (Staff)
1. Baca: [SETUP.md](SETUP.md) untuk setup awal
2. Baca: [DOCUMENTATION.md → Panduan Penggunaan → Untuk Admin/Petugas](DOCUMENTATION.md#untuk-adminpetugas)
3. Referensi: [QUICK_REFERENCE.md](QUICK_REFERENCE.md) untuk command cepat

### Untuk Developer
1. Baca: [SETUP.md](SETUP.md) untuk instalasi development
2. Baca: [DEVELOPER.md](DEVELOPER.md) untuk struktur kode
3. Referensi: [DOCUMENTATION.md → API Endpoints](DOCUMENTATION.md#api-endpoints)
4. Tips: [QUICK_REFERENCE.md](QUICK_REFERENCE.md) untuk command berguna

---

## 📋 Topik-Topik Penting

### Installation & Setup
- [SETUP.md](SETUP.md) - Panduan instalasi lengkap
- [SETUP.md → Troubleshooting](SETUP.md#troubleshooting-installation) - Solusi error umum

### Penggunaan Sistem
- [DOCUMENTATION.md → Panduan Penggunaan](DOCUMENTATION.md#panduan-penggunaan) - Cara menggunakan fitur
- [DOCUMENTATION.md → User Roles](DOCUMENTATION.md#user-roles--permissions) - Akses berdasarkan role

### Pengembangan & Integrasi
- [DEVELOPER.md → Models](DEVELOPER.md#models) - Penjelasan database models
- [DEVELOPER.md → Controllers](DEVELOPER.md#controllers) - Penjelasan controller
- [API_DOCUMENTATION.md](API_DOCUMENTATION.md) - Integrasi via API

### Troubleshooting
- [SETUP.md → Troubleshooting](SETUP.md#troubleshooting-installation)
- [DOCUMENTATION.md → Troubleshooting](DOCUMENTATION.md#troubleshooting)
- [QUICK_REFERENCE.md → Common Issues](QUICK_REFERENCE.md#-common-issues--solutions)

---

## 🔍 Pencarian Cepat

### Bagaimana cara...

#### Instalasi & Setup
- ...menginstall aplikasi? → [SETUP.md](SETUP.md)
- ...konfigurasi database? → [SETUP.md → Step 6](SETUP.md#step-6-configure-database)
- ...mendeploy ke production? → [SETUP.md → Production Deployment](SETUP.md#production-deployment)

#### Penggunaan
- ...mengajukan peminjaman? → [DOCUMENTATION.md → Untuk Peminjam → Mengajukan Peminjaman](DOCUMENTATION.md#2-mengajukan-peminjaman)
- ...menyetujui peminjaman? → [DOCUMENTATION.md → Untuk Admin/Petugas → Mengelola Peminjaman](DOCUMENTATION.md#2-mengelola-peminjaman)
- ...menambah ruangan? → [DOCUMENTATION.md → Untuk Admin/Petugas → Manajemen Ruangan](DOCUMENTATION.md#1-manajemen-ruangan)
- ...generate laporan? → [DOCUMENTATION.md → Untuk Admin/Petugas → Generate Laporan](DOCUMENTATION.md#4-generate-laporan)

#### Development
- ...membuat controller? → [QUICK_REFERENCE.md → Common Commands](QUICK_REFERENCE.md#-common-commands)
- ...menjalankan tests? → [QUICK_REFERENCE.md → Testing](QUICK_REFERENCE.md#-common-commands)
- ...membuat migration? → [QUICK_REFERENCE.md → Common Commands](QUICK_REFERENCE.md#-common-commands)
- ...menggunakan API? → [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

#### Troubleshooting
- ...database connection error? → [SETUP.md → Troubleshooting](SETUP.md#error-sqlstatehymysqli_sql_exception-access-denied)
- ...tidak bisa upload file? → [SETUP.md → Troubleshooting](SETUP.md#upload-foto-tidak-berhasil)
- ...server tidak bisa dijalankan? → [QUICK_REFERENCE.md → Common Issues](QUICK_REFERENCE.md#cant-access-localhost8000)

---

## 📞 File & Struktur

### Dokumentasi Files
```
├── README.md                 ← Mulai dari sini!
├── QUICK_REFERENCE.md        ← Referensi cepat
├── SETUP.md                  ← Instalasi & setup
├── DOCUMENTATION.md          ← Dokumentasi lengkap
├── DEVELOPER.md              ← Panduan developer
├── API_DOCUMENTATION.md      ← API reference
└── DOCS_INDEX.md             ← File ini
```

### Project Structure
```
LastUKK/
├── app/Models/               ← Database models
├── app/Http/Controllers/     ← Request handlers
├── app/Services/             ← Business logic
├── routes/                   ← API & web routes
├── resources/views/          ← Blade templates
├── database/migrations/      ← Database schemas
└── database/seeders/         ← Sample data
```

---

## 🎓 Learning Path

### Beginner (User/Admin)
1. **README.md** (5 min) - Mengerti project overview
2. **SETUP.md** (20 min) - Install & setup
3. **DOCUMENTATION.md → Panduan Penggunaan** (30 min) - Cara pakai
4. **QUICK_REFERENCE.md** (10 min) - Command berguna

**Total: ~65 menit**

### Intermediate (Staff)
1. Lakukan Beginner path
2. **QUICK_REFERENCE.md** (15 min) - Pahami command
3. **DOCUMENTATION.md → Database** (20 min) - Mengerti data structure
4. **DEVELOPER.md → Models** (30 min) - Pahami database models

**Total: ~130 menit**

### Advanced (Developer)
1. Lakukan Intermediate path
2. **DEVELOPER.md** (60 min) - Pahami semua controllers & services
3. **API_DOCUMENTATION.md** (30 min) - API integration
4. Eksplorasi source code

**Total: ~220 menit**

---

## 🆘 Need Help?

### Langkah-Langkah Mencari Bantuan

1. **Cek Dokumentasi**
   - Cari topik di file dokumentasi yang sesuai
   - Gunakan fungsi search (Ctrl+F)

2. **Cek FAQ & Troubleshooting**
   - [SETUP.md → Troubleshooting](SETUP.md#troubleshooting-installation)
   - [DOCUMENTATION.md → Troubleshooting](DOCUMENTATION.md#troubleshooting)
   - [QUICK_REFERENCE.md → Common Issues](QUICK_REFERENCE.md#-common-issues--solutions)

3. **Cek Log Files**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Use Tinker untuk Debug**
   ```bash
   php artisan tinker
   ```

5. **Buka Issue di GitHub**
   - Sertakan error message
   - Langkah untuk reproduce
   - Screenshot jika ada

---

## 📊 Dokumentasi Statistics

| File | Size | Topik |
|------|------|-------|
| README.md | ~5 KB | Overview & Quick Start |
| QUICK_REFERENCE.md | ~8 KB | Referensi Cepat |
| SETUP.md | ~15 KB | Instalasi & Setup |
| DOCUMENTATION.md | ~25 KB | Dokumentasi Lengkap |
| DEVELOPER.md | ~20 KB | Panduan Developer |
| API_DOCUMENTATION.md | ~8 KB | API Reference |
| **Total** | **~81 KB** | **Dokumentasi Komprehensif** |

---

## 🔄 Version History

- **v1.0** (Current) - Initial release dengan dokumentasi lengkap
- **Planned v1.1** - Mobile app, notifications, analytics

---

## 📅 Last Updated

**November 2025**
- Dokumentasi dibuat
- Semua fitur terdokumentasi
- Troubleshooting guide lengkap

---

## 📝 Catatan

- Dokumentasi ini dalam **Bahasa Indonesia**
- Semua contoh kode dalam **PHP/Laravel**
- Command examples untuk **Windows, macOS, dan Linux**
- Akses penuh ke kode sumber tersedia di GitHub

---

## 🎯 Next Steps

- Pilih file dokumentasi sesuai kebutuhan Anda
- Baca dengan cermat step-by-step
- Jangan ragu untuk referensi kembali
- Buka issue jika ada pertanyaan

---

**Selamat belajar! Happy coding! 🚀**

---

*Dokumentasi ini adalah bagian dari Sistem Manajemen Peminjaman Ruangan*  
*Repository: https://github.com/RepieAFK/comet*  
*License: MIT*
