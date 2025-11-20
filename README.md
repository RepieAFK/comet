# Sistem Manajemen Peminjaman Ruangan 🏫

[![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.0-red)](https://laravel.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-brightgreen)](.)

Platform manajemen peminjaman ruangan yang komprehensif untuk institusi pendidikan. Sistem ini memudahkan pengguna mengajukan peminjaman ruangan, mengelola jadwal, dan menghasilkan laporan.

---

## 📋 Table of Contents

- [Features](#features)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Documentation](#documentation)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

### Core Features
- 🔐 **Authentication & Authorization** - Role-based access control (Admin, Staff, User)
- 🏢 **Room Management** - Create, read, update, delete rooms with details
- 📅 **Regular Schedule** - Set fixed schedules for recurring room usage
- 📝 **Booking System** - Request, approve, and manage room bookings
- 📊 **Reports** - Export and print booking reports
- 📱 **Responsive Design** - Works on desktop, tablet, and mobile
- 🎨 **Modern UI** - Built with Tailwind CSS and Bootstrap 5

### Advanced Features
- ⚠️ **Conflict Detection** - Automatic detection of booking conflicts
- ⏱️ **Session-based Scheduling** - Flexible 9-session day schedule
- 📤 **Data Export** - Export reports to Excel and PDF
- 🔔 **Status Tracking** - Real-time booking status updates
- 📍 **Room Availability** - Check room availability before booking

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.4 or higher
- Composer
- Node.js 16+ with NPM
- MySQL 5.7+ or PostgreSQL 10+

### Installation (3 Steps)

```bash
# 1. Clone and enter directory
git clone <repository-url> && cd LastUKK

# 2. Run setup script
composer run setup

# 3. Start development server
composer run dev
```

That's it! Open http://localhost:8000 in your browser.

**Default credentials:**
- Email: `admin@example.com`
- Password: `password123`

> For detailed setup instructions, see [SETUP.md](SETUP.md)

---

## 📖 Installation

### Detailed Steps

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd LastUKK
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup Database**
   ```bash
   # Create database first
   mysql -u root -p -e "CREATE DATABASE ukk_peminjaman;"
   
   # Run migrations
   php artisan migrate
   
   # Optional: seed with sample data
   php artisan db:seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Start Servers**
   ```bash
   # Terminal 1
   php artisan serve
   
   # Terminal 2
   npm run dev
   
   # Terminal 3 (Optional)
   php artisan queue:listen
   ```

Visit http://localhost:8000 to access the application.

---

## 📚 Documentation

Complete documentation is available in the following files:

| File | Purpose |
|------|---------|
| [DOCUMENTATION.md](DOCUMENTATION.md) | Full user & system documentation |
| [SETUP.md](SETUP.md) | Detailed installation & setup guide |
| [API_DOCUMENTATION.md](API_DOCUMENTATION.md) | API endpoints reference |
| [DEVELOPER.md](DEVELOPER.md) | Developer guide (models, controllers, services) |

### Quick Reference

- **User Roles:** [DOCUMENTATION.md#user-roles--permissions](DOCUMENTATION.md#user-roles--permissions)
- **API Endpoints:** [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- **Database Schema:** [DEVELOPER.md#database-schema](DEVELOPER.md#database-schema)
- **Troubleshooting:** [SETUP.md#troubleshooting-installation](SETUP.md#troubleshooting-installation)

---

## 🛠️ Technology Stack

### Backend
- **Framework:** Laravel 12.0
- **Language:** PHP 8.4+
- **Database:** MySQL / PostgreSQL
- **Authentication:** Laravel Sanctum
- **Testing:** PHPUnit 11.5.3

### Frontend
- **Build Tool:** Vite 7
- **CSS:** Tailwind CSS 4 + SASS
- **UI Components:** Bootstrap 5
- **HTTP Client:** Axios
- **JavaScript:** Vanilla JS + ES6

### DevOps & Tools
- **Package Manager:** Composer, NPM
- **Process Manager:** Concurrently
- **Code Quality:** Laravel Pint
- **IDE Helper:** Laravel IDE Helper
- **Container:** Docker (optional)

---

## 📁 Project Structure

```
LastUKK/
├── app/
│   ├── Http/Controllers/      # Request handlers
│   ├── Models/                # Database models
│   ├── Services/              # Business logic
│   └── Helpers/               # Utility functions
├── routes/                    # Application routes
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Stylesheets
│   └── js/                    # JavaScript
├── database/
│   ├── migrations/            # Schema definitions
│   └── seeders/               # Sample data
├── config/                    # Configuration files
├── tests/                     # Unit & feature tests
├── storage/                   # File uploads & logs
└── vendor/                    # Dependencies
```

---

## 🎯 Usage Examples

### For End Users (Peminjam)

1. **Create Account**
   - Visit registration page
   - Fill in details and submit
   - Login with your credentials

2. **Request Booking**
   - Navigate to Peminjaman menu
   - Click "Ajukan Peminjaman"
   - Select room, date, session
   - Submit request
   - Wait for approval

3. **Track Status**
   - View booking history
   - Check status (Menunggu, Disetujui, Ditolak)
   - Download confirmation if needed

### For Administrators

1. **Manage Rooms**
   ```
   Ruangan → Add/Edit/Delete rooms
   ```

2. **Approve Bookings**
   ```
   Peminjaman → Review pending requests → Approve/Reject
   ```

3. **Generate Reports**
   ```
   Laporan → Filter & Export/Print reports
   ```

---

## 🔌 API Usage

### Check Room Availability

```bash
curl -X GET "http://localhost:8000/api/check-availability" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d "ruangan_id=1&tanggal=2025-11-20&sesi=1"
```

Response:
```json
{
  "available": true,
  "ruangan": {
    "id": 1,
    "nama_ruangan": "Lab Komputer 1",
    "kode_ruangan": "LC-001"
  },
  "waktu_sesi": "07:00 - 07:45"
}
```

For more API endpoints, see [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## 🧪 Testing

Run tests with:

```bash
composer run test
```

Or specific test:
```bash
php artisan test tests/Feature/PeminjamanTest.php
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

Please ensure:
- Code follows PSR-12 coding standard
- Tests are written for new features
- Documentation is updated

---

## 🐛 Bug Reports & Support

Found a bug? Please create an issue:
- Include detailed description
- Steps to reproduce
- Expected vs actual behavior
- Screenshots if applicable

---

## 📝 License

This project is licensed under the MIT License - see [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**RepieAFK**
- GitHub: [@RepieAFK](https://github.com/RepieAFK)
- Email: your-email@example.com

---

## 📞 Support

For questions or support:
- 📖 Check [DOCUMENTATION.md](DOCUMENTATION.md)
- 🔍 Search [Issues](https://github.com/RepieAFK/comet/issues)
- 💬 Open a [Discussion](https://github.com/RepieAFK/comet/discussions)

---

## 🙏 Acknowledgments

- Laravel community for the excellent framework
- All contributors who have helped with this project
- Your institution for inspiring this solution

---

## 📅 Changelog

### v1.0 (Current)
- ✅ Initial release
- ✅ Core features implemented
- ✅ Full documentation

### Planned Features (v1.1)
- 📱 Mobile app
- 🔔 Email notifications
- 📈 Analytics dashboard
- 🌙 Dark mode

---

**Last Updated:** November 2025  
**Status:** Active & Maintained ✅  
**Version:** 1.0
