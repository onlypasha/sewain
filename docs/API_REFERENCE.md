# Sewain API Reference — v1 (Android)

Base URL: `http://<host>/api/v1`
Autentikasi: Laravel Sanctum, header `Authorization: Bearer <token>`.
Format: JSON. Error validasi: `422` + objek `errors`. Error JSON otomatis untuk path `api/*`.

> API hanya aktif kalau `SEWAIN_API_ENABLED=true` di `.env` server.
> Default `false` — route tidak didaftarkan sama sekali.

## Auth

### POST /auth/register
Daftar sebagai customer, langsung dapat token.

Body (JSON):
```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "password": "Rahasia123",
  "password_confirmation": "Rahasia123",
  "phone": "08123456789"
}
```

Aturan:
- `name`: wajib, maks 255
- `email`: wajib, email valid, unik
- `password`: wajib, min 8, huruf besar-kecil + angka, wajib `password_confirmation`
- `phone`: opsional, maks 20

Response `201`:
```json
{
  "token": "<plain-text-token>",
  "user": { "id": 1, "name": "Budi Santoso", "email": "budi@example.com", "role": "customer" }
}
```

### POST /auth/login
Body: `email`, `password` (wajib). Kredensial salah → `422` dengan pesan `Kredensial tidak valid.`
Response `200`: sama seperti register (`token` + `user`).

### GET /auth/me 🔒
Response `200`:
```json
{ "data": { "id": 1, "name": "Budi", "email": "budi@example.com", "role": "customer", "phone": "0812..." } }
```

### POST /auth/logout 🔒
Menghapus token saat ini. Response `200`: `{ "message": "Logout berhasil." }`

## Katalog (publik)

### GET /vendors
Hanya vendor berprofil aktif. Paginasi 12/halaman (`?page=2`).
Item data: `id`, `slug`, `name`, `business_name`, `address`.
Meta: `current_page`, `last_page`, `total`.

### GET /vendors/{slug}
Detail vendor + daftar item available (12/halaman).
Item ringkas: `id`, `name`, `price_per_day`, `status`.

### GET /items
Hanya `status = available`. Paginasi 12/halaman.
Item data: `id`, `name`, `description`, `price_per_day`, `status`, `vendor {id, slug, name}`, `category {id, name} | null`.

### GET /items/{id}
Detail satu item (status apa pun). Struktur sama seperti list, tunggal di `data`.

### GET /categories
Semua kategori: `{ "data": [{ "id": 1, "name": "Kamera" }] }`.

## Booking 🔒 (customer)

### GET /bookings
Booking milik sendiri, terbaru dulu, 10/halaman.
Item data: `id`, `booking_code` (format `SWN-YYYYMMDD-NNNN`), `status`, `rental_start`, `rental_end`, `total_price`, `item {id, name} | null`.

Status: `pending` → `confirmed` → `active` → `completed`. Bisa `cancelled` dari `pending`/`confirmed`.

### POST /items/{id}/booking
Buat booking. Harga = jumlah hari inklusif × `price_per_day`, dicek overlap tanggal.

Body:
```json
{
  "rental_start": "2026-11-20",
  "rental_end": "2026-11-22",
  "customer_name": "Budi",
  "customer_phone": "08123456789",
  "notes": "Butuh lensa kit"
}
```

Aturan:
- `rental_start`: wajib, tanggal, tidak boleh lampau (`after_or_equal:today`)
- `rental_end`: wajib, tanggal, ≥ `rental_start`
- `customer_name`/`customer_phone`: opsional (default dari profil)
- `notes`: opsional, maks 500

Response `201`: `data {id, booking_code, status, rental_start, rental_end, total_price}`.
Error: `403` sewa barang sendiri · `422` item tidak available / tanggal overlap.

### GET /bookings/{id}
Detail booking milik sendiri (403 kalau bukan miliknya).
Data: `id`, `booking_code`, `status`, `rental_start`, `rental_end`, `total_price`, `customer_name`, `item {id, name}`, `payments [{id, status, amount}]`.

### POST /bookings/{id}/payment
Upload bukti transfer (multipart). Field: `payment_proof` — gambar `jpeg/png/jpg/webp`, maks 2 MB. Nominal otomatis = `total_price`, status awal `pending`.
Response `201`: `data {id, status}` + `message: Bukti pembayaran berhasil diunggah.`
