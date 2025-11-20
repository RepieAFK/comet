# API Documentation

## Overview

API Sistem Manajemen Peminjaman Ruangan menyediakan endpoints RESTful untuk integrasi dengan aplikasi pihak ketiga.

## Base URL
```
http://localhost:8000/api
```

## Authentication

Semua API endpoints memerlukan authentication menggunakan Sanctum tokens.

### Mendapatkan Token
```bash
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}

Response:
{
  "token": "1|VJbwhqTe...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "peminjam"
  }
}
```

### Menggunakan Token
```bash
Authorization: Bearer <token>
```

---

## Endpoints Detail

### 1. Check Availability

**Endpoint:** `GET /api/check-availability`

**Description:** Cek ketersediaan ruangan untuk tanggal dan sesi tertentu

**Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| ruangan_id | integer | Yes | ID ruangan |
| tanggal | date | Yes | Tanggal (YYYY-MM-DD) |
| sesi | integer | Yes | Nomor sesi (1-9) |

**Example Request:**
```bash
GET /api/check-availability?ruangan_id=1&tanggal=2025-11-20&sesi=1
Authorization: Bearer <token>
```

**Success Response (200):**
```json
{
  "available": true,
  "ruangan": {
    "id": 1,
    "nama_ruangan": "Lab Komputer 1",
    "kode_ruangan": "LC-001"
  },
  "tanggal": "2025-11-20",
  "sesi": 1,
  "waktu_sesi": "07:00 - 07:45"
}
```

**Error Response (404):**
```json
{
  "available": false,
  "message": "Ruangan tidak tersedia pada waktu tersebut"
}
```

---

## Status Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Unprocessable Entity |
| 500 | Server Error |

---

## Error Handling

**Standard Error Response:**
```json
{
  "message": "Error description",
  "errors": {
    "field": ["Error message"]
  }
}
```

---

## Rate Limiting

- **Limit:** 60 requests per minute per IP
- **Header:** `X-RateLimit-*`

---

## Pagination

Endpoints yang mengembalikan list menggunakan pagination:

```bash
GET /api/endpoint?page=1&per_page=15
```

**Response:**
```json
{
  "data": [...],
  "links": {
    "first": "...",
    "last": "...",
    "next": "...",
    "prev": "..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "per_page": 15,
    "to": 15,
    "total": 100
  }
}
```

---

## Response Format

Semua response dalam format JSON dengan struktur:

```json
{
  "success": true/false,
  "message": "Description",
  "data": {...}
}
```

---

## CORS

CORS diaktifkan untuk semua origin. Konfigurasi di `config/cors.php`.

---

## Versioning

API saat ini di versi `v1` (implicit). Future versions akan menggunakan prefix `/api/v2`, dll.

---

**Last Updated:** November 2025  
**Version:** 1.0
