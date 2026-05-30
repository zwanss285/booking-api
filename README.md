# 📅 Booking API

Aplikasi booking jadwal berbasis web yang dibangun dengan **Laravel** menggunakan **Sanctum** untuk autentikasi, **Form Request** untuk validasi, dan **API Resource** untuk response yang terstruktur. Proyek ini dibuat sebagai bagian dari **PKL (Praktik Kerja Lapangan)**.

---

## ✨ Fitur

- 🔐 Autentikasi dengan Laravel Sanctum (register, login, logout)
- 📋 Daftar jadwal tersedia (guest & authenticated)
- 🔖 Booking jadwal oleh pengguna yang sudah login
- ❌ Pembatalan booking
- ✅ Validasi kapasitas slot & double booking
- 🌐 Mode dual: **REST API** + **Web (Blade)**

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11 |
| Auth | Laravel Sanctum |
| Frontend | Bootstrap 5, Font Awesome 6, Blade |
| Validasi | Form Request |
| Response | API Resource |

---

## 📁 Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── AuthController.php       # Register, Login, Logout (API)
│   │   │   ├── BookingController.php    # Booking via API
│   │   │   └── ScheduleController.php  # Jadwal via API
│   │   └── Web/
│   │       ├── AuthController.php      # Login/Register/Logout (Web)
│   │       ├── BookingController.php   # Booking via Web
│   │       ├── DashboardController.php
│   │       └── HomeController.php
│   ├── Requests/
│   │   ├── LoginRequest.php
│   │   ├── RegisterRequest.php
│   │   └── StoreBookingRequest.php
│   └── Resources/
│       ├── BookingResource.php
│       ├── ScheduleResource.php
│       └── UserResource.php
├── Models/
│   ├── Booking.php
│   ├── Schedule.php
│   └── User.php
routes/
├── api.php
└── web.php
resources/views/
├── layouts/app.blade.php
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── dashboard.blade.php
├── home.blade.php
├── my-bookings.blade.php
└── schedule-detail.blade.php
```

---

## 🚀 Instalasi

### 1. Clone repositori

```bash
git clone https://github.com/username/booking-api.git
cd booking-api
```

### 2. Install dependensi

```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_api
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & seeder

```bash
php artisan migrate
php artisan db:seed   # opsional, jika tersedia seeder jadwal
```

### 5. Jalankan aplikasi

```bash
php artisan serve
```

Aplikasi berjalan di `http://localhost:8000`

---

## 🗺️ API Endpoints

### Auth (Guest)

| Method | Endpoint | Deskripsi |
|---|---|---|
| POST | `/api/register` | Daftarkan akun baru |
| POST | `/api/login` | Login & dapatkan token |

### Jadwal (Guest)

| Method | Endpoint | Deskripsi |
|---|---|---|
| GET | `/api/schedules` | Daftar semua jadwal |
| GET | `/api/schedules?available_only=1` | Hanya jadwal tersedia |
| GET | `/api/schedules/{id}` | Detail jadwal |

### Booking (Auth — Bearer Token)

| Method | Endpoint | Deskripsi |
|---|---|---|
| POST | `/api/bookings` | Buat booking baru |
| GET | `/api/bookings/me` | Riwayat booking user |
| DELETE | `/api/bookings/{id}` | Batalkan booking |
| POST | `/api/logout` | Logout & hapus token |

---

## 📬 Contoh Request & Response

### Register

**Request:**
```json
POST /api/register
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Registrasi berhasil",
  "data": {
    "user": {
      "id": 1,
      "name": "Budi Santoso",
      "email": "budi@example.com"
    },
    "token": "1|xxxxxxxxxxxxxxxx"
  }
}
```

### Buat Booking

**Request:**
```json
POST /api/bookings
Authorization: Bearer {token}

{
  "schedule_id": 3
}
```

**Response:**
```json
{
  "success": true,
  "message": "Booking berhasil",
  "data": {
    "id": 7,
    "schedule": {
      "id": 3,
      "title": "Kelas Laravel Dasar",
      "start_time": "2026-06-01T09:00:00",
      "end_time": "2026-06-01T11:00:00",
      "slot_capacity": 20,
      "available_slots": 14,
      "is_available": true
    },
    "status": "booked",
    "booked_at": "2026-05-30 10:00:00"
  }
}
```

---

## ✅ Validasi Booking

`StoreBookingRequest` secara otomatis menolak permintaan jika:

- `schedule_id` tidak ditemukan di database
- Waktu mulai jadwal sudah lewat
- `start_time >= end_time` pada jadwal
- User sudah pernah booking jadwal yang sama (double booking)
- Kapasitas slot sudah penuh

---

## 🌐 Halaman Web

| URL | Deskripsi |
|---|---|
| `/` | Daftar jadwal |
| `/schedules/{id}` | Detail & tombol booking |
| `/login` | Halaman login |
| `/register` | Halaman registrasi |
| `/dashboard` | Dashboard user (auth) |
| `/my-bookings` | Riwayat booking user (auth) |

---

## 🔑 Status Booking

| Status | Warna | Keterangan |
|---|---|---|
| `booked` | 🟡 Kuning | Booking aktif |
| `cancelled` | ⚫ Abu-abu | Booking dibatalkan |

---

## 👨‍💻 Author

Dibuat untuk keperluan **PKL** — Laravel dengan Sanctum, Form Request, dan Resource.

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](LICENSE).
