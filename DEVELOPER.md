# Developer Documentation

## Table of Contents
1. [Models](#models)
2. [Controllers](#controllers)
3. [Services](#services)
4. [Helpers](#helpers)
5. [Middleware](#middleware)
6. [Database Schema](#database-schema)

---

## Models

### User Model

**File:** `app/Models/User.php`

**Purpose:** Represents a user in the system

**Properties:**
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'status'
];

protected $hidden = ['password'];
protected $casts = [
    'email_verified_at' => 'datetime',
];
```

**Relationships:**
```php
public function peminjamans()    // One-to-many with Peminjaman
public function jadwalRegulers() // One-to-many with JadwalReguler
```

**Methods:**
```php
// Check if user has role
public function isAdmin()
public function isPetugas()
public function isPeminjam()

// Get user's peminjamans
$user->peminjamans()->get()

// Get user's jadwal reguler
$user->jadwalRegulers()->get()
```

**Example Usage:**
```php
// Create user
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password123'),
    'role' => 'peminjam'
]);

// Get user peminjamans
$peminjamans = $user->peminjamans()->approved()->get();

// Update user
$user->update(['role' => 'petugas']);

// Delete user
$user->delete();
```

---

### Ruangan Model

**File:** `app/Models/Ruangan.php`

**Purpose:** Represents a room/space

**Properties:**
```php
protected $fillable = [
    'nama_ruangan',
    'kode_ruangan',
    'deskripsi',
    'kapasitas',
    'lokasi',
    'status',
    'foto'
];
```

**Relationships:**
```php
public function peminjamans()    // One-to-many
public function jadwalRegulers() // One-to-many
```

**Methods:**
```php
// Check availability for regular schedule
public function isAvailableForRegular($hari, $sesi)

// Check availability for booking
public function isAvailableForBooking($tanggal, $sesi)
```

**Example Usage:**
```php
// Get all available rooms
$rooms = Ruangan::where('status', 'tersedia')->get();

// Check availability
$ruangan = Ruangan::find(1);
$available = $ruangan->isAvailableForBooking('2025-11-20', 1);

// Get room peminjamans
$peminjamans = $ruangan->peminjamans()->approved()->get();

// Get room jadwal reguler
$jadwal = $ruangan->jadwalRegulers()->where('hari', 'Senin')->get();
```

---

### Peminjaman Model

**File:** `app/Models/Peminjaman.php`

**Purpose:** Represents a room booking/request

**Properties:**
```php
protected $fillable = [
    'user_id',
    'ruangan_id',
    'tanggal',
    'sesi',
    'keperluan',
    'status',
    'catatan'
];

protected $casts = [
    'tanggal' => 'date',
];
```

**Relationships:**
```php
public function user()    // Belongs to User
public function ruangan() // Belongs to Ruangan
```

**Attributes:**
```php
$peminjaman->getSesiNameAttribute() // Returns formatted session time like "07:00 - 07:45"
```

**Example Usage:**
```php
// Create peminjaman
$peminjaman = Peminjaman::create([
    'user_id' => auth()->id(),
    'ruangan_id' => 1,
    'tanggal' => '2025-11-20',
    'sesi' => 1,
    'keperluan' => 'Kelas Tambahan',
    'status' => 'menunggu'
]);

// Get session name
echo $peminjaman->sesi_name; // "07:00 - 07:45"

// Filter by status
$approved = Peminjaman::where('status', 'disetujui')->get();
$pending = Peminjaman::where('status', 'menunggu')->get();

// Get user peminjamans
$peminjamans = auth()->user()->peminjamans()->get();
```

---

### JadwalReguler Model

**File:** `app/Models/JadwalReguler.php`

**Purpose:** Represents regular/recurring schedule

**Properties:**
```php
protected $fillable = [
    'ruangan_id',
    'hari',
    'sesi',
    'kegiatan',
    'user_id'
];
```

**Relationships:**
```php
public function ruangan() // Belongs to Ruangan
public function user()    // Belongs to User
```

**Example Usage:**
```php
// Create regular schedule
$jadwal = JadwalReguler::create([
    'ruangan_id' => 1,
    'hari' => 'Senin',
    'sesi' => 1,
    'kegiatan' => 'Kelas Matematika'
]);

// Get all schedules for a room
$jadwal = JadwalReguler::where('ruangan_id', 1)->get();

// Check conflict
$conflict = JadwalReguler::where('ruangan_id', 1)
    ->where('hari', 'Senin')
    ->where('sesi', 1)
    ->exists();
```

---

## Controllers

### AuthController

**File:** `app/Http/Controllers/AuthController.php`

**Methods:**

```php
// Show login form
public function showLoginForm()

// Handle login
public function login(Request $request)

// Show register form
public function showRegisterForm()

// Handle registration
public function register(Request $request)

// Logout user
public function logout(Request $request)
```

**Example Usage:**
```php
// Login
POST /login
{
    "email": "user@example.com",
    "password": "password123"
}

// Register
POST /register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}

// Logout
POST /logout
```

---

### DashboardController

**File:** `app/Http/Controllers/DashboardController.php`

**Methods:**

```php
// Show dashboard
public function index()
```

**Functionality:**
- Display statistics
- Show recent peminjamans
- Display system status

---

### PeminjamanController

**File:** `app/Http/Controllers/PeminjamanController.php`

**Methods:**

```php
// List all peminjamans
public function index()

// Show peminjaman detail
public function show(Peminjaman $peminjaman)

// Show create form
public function create()

// Store new peminjaman
public function store(Request $request)

// Show edit form
public function edit(Peminjaman $peminjaman)

// Update peminjaman
public function update(Request $request, Peminjaman $peminjaman)

// Delete peminjaman
public function destroy(Peminjaman $peminjaman)

// Approve peminjaman
public function approve(Peminjaman $peminjaman)

// Reject peminjaman
public function reject(Request $request, Peminjaman $peminjaman)
```

**Validation Rules:**
```php
// Store/Update
$request->validate([
    'ruangan_id' => 'required|exists:ruangans,id',
    'tanggal' => 'required|date|after_or_equal:today',
    'sesi' => 'required|integer|between:1,9',
    'keperluan' => 'required|string|max:500',
]);
```

---

### RuanganController

**File:** `app/Http/Controllers/RuanganController.php`

**Methods:**

```php
// List all rooms
public function index()

// Show room detail
public function show(Ruangan $ruangan)

// Show create form
public function create()

// Store new room
public function store(Request $request)

// Show edit form
public function edit(Ruangan $ruangan)

// Update room
public function update(Request $request, Ruangan $ruangan)

// Delete room
public function destroy(Ruangan $ruangan)
```

**Validation Rules:**
```php
$request->validate([
    'nama_ruangan' => 'required|string|max:255',
    'kode_ruangan' => 'required|string|unique:ruangans,kode_ruangan',
    'kapasitas' => 'required|integer|min:1',
    'lokasi' => 'required|string|max:255',
    'status' => 'required|in:tersedia,tidak_tersedia',
    'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
]);
```

---

### JadwalRegulerController

**File:** `app/Http/Controllers/JadwalRegulerController.php`

**Methods:**

```php
// List all schedules
public function index()

// Show create form
public function create()

// Store new schedule
public function store(Request $request)

// Show edit form
public function edit(JadwalReguler $jadwalReguler)

// Update schedule
public function update(Request $request, JadwalReguler $jadwalReguler)

// Delete schedule
public function destroy(JadwalReguler $jadwalReguler)
```

---

### JadwalController

**File:** `app/Http/Controllers/JadwalController.php`

**Methods:**

```php
// Show combined schedule
public function index()

// Check availability (API)
public function checkAvailability(Request $request)
```

**Example Usage:**
```php
// Get combined schedule
GET /jadwal

// Check availability
GET /api/check-availability?ruangan_id=1&tanggal=2025-11-20&sesi=1
```

---

### LaporanController

**File:** `app/Http/Controllers/LaporanController.php`

**Methods:**

```php
// Show reports
public function index()

// Export to Excel
public function export(Request $request)

// Print to PDF
public function print(Request $request)
```

---

### UserController

**File:** `app/Http/Controllers/UserController.php`

**Methods:**

```php
// List all users
public function index()

// Show user detail
public function show(User $user)

// Show create form
public function create()

// Store new user
public function store(Request $request)

// Show edit form
public function edit(User $user)

// Update user
public function update(Request $request, User $user)

// Delete user
public function destroy(User $user)
```

---

## Services

### ConflictResolutionService

**File:** `app/Services/ConflictResolutionService.php`

**Purpose:** Handle conflict detection and resolution for bookings

**Methods:**

```php
// Resolve conflicts
public function resolve(Peminjaman $peminjaman)

// Check for conflicts
public function hasConflict(Ruangan $ruangan, $tanggal, $sesi)

// Get conflicting bookings
public function getConflicts(Ruangan $ruangan, $tanggal, $sesi)
```

**Example Usage:**
```php
$service = app(ConflictResolutionService::class);

if ($service->hasConflict($ruangan, '2025-11-20', 1)) {
    // Handle conflict
}
```

---

## Helpers

### SesiHelper

**File:** `app/Helpers/sesihelper.php`

**Purpose:** Helper functions for session management

**Functions:**

```php
// Get session name/time
getSesiName($sesiNumber)

// Get all sessions
getAllSesi()

// Convert session number to time
getSesiTime($sesiNumber)
```

---

## Middleware

### Role Middleware

**File:** `app/Http/Middleware/CheckRole.php`

**Purpose:** Check user role authorization

**Usage:**
```php
Route::get('/admin', function() {
    //
})->middleware('role:administrator');

Route::get('/staff', function() {
    //
})->middleware('role:administrator,petugas');
```

---

## Database Schema

### Session System

Setiap hari dibagi menjadi 9 sesi:
- Sesi 1: 07:00 - 07:45
- Sesi 2: 07:45 - 08:30
- Sesi 3: 08:30 - 09:15
- Sesi 4: 09:15 - 10:00
- Sesi 5: 10:15 - 11:00 (break 07:00)
- Sesi 6: 11:00 - 11:45
- Sesi 7: 11:45 - 12:30
- Sesi 8: 13:00 - 13:45 (lunch 12:30 - 13:00)
- Sesi 9: 13:45 - 14:30

### Status Values

**Peminjaman Status:**
- `menunggu` - Waiting for approval
- `disetujui` - Approved
- `ditolak` - Rejected
- `selesai` - Completed

**Ruangan Status:**
- `tersedia` - Available
- `tidak_tersedia` - Not available

**User Role:**
- `administrator` - Full access
- `petugas` - Manage bookings
- `peminjam` - Create bookings

---

## Best Practices

### 1. Model Usage
```php
// ❌ Bad
$peminjamans = Peminjaman::all();

// ✅ Good
$peminjamans = Peminjaman::with('user', 'ruangan')
    ->paginate(15);
```

### 2. Query Optimization
```php
// ❌ Bad
foreach ($ruangans as $ruangan) {
    $count = $ruangan->peminjamans()->count();
}

// ✅ Good
$ruangans = Ruangan::withCount('peminjamans')->get();
foreach ($ruangans as $ruangan) {
    echo $ruangan->peminjamans_count;
}
```

### 3. Validation
```php
// ✅ Good
$validated = $request->validate([
    'email' => 'required|email|unique:users,email,' . $user->id,
]);
```

### 4. Authorization
```php
// ✅ Good
if (auth()->user()->cannot('approve', $peminjaman)) {
    abort(403);
}
```

---

**Last Updated:** November 2025  
**Version:** 1.0
