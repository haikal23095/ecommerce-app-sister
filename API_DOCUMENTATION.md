# API Documentation - E-Commerce App

Base URL: `http://localhost:8000/api`

## Authentication

API ini menggunakan Laravel Sanctum untuk autentikasi. Setelah login/register, Anda akan mendapatkan token yang harus disertakan di header setiap request.

```
Authorization: Bearer {your-token-here}
```

---

## 1. AUTH ENDPOINTS

### Register

**POST** `/register`

Request Body:

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

Response:

```json
{
    "success": true,
    "message": "Registrasi berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "1|xxxxxxxxxxxxxxxxxxxxx"
    }
}
```

### Login

**POST** `/login`

Request Body:

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

Response:

```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "token": "2|xxxxxxxxxxxxxxxxxxxxx"
    }
}
```

### Logout

**POST** `/logout` (Protected)

Headers:

```
Authorization: Bearer {token}
```

Response:

```json
{
    "success": true,
    "message": "Logout berhasil"
}
```

---

## 2. PRODUK ENDPOINTS

### Get All Products

**GET** `/produk` (Public)

Response:

```json
{
    "success": true,
    "message": "Data produk berhasil diambil",
    "data": [
        {
            "id": 1,
            "nama_produk": "Laptop Gaming",
            "harga": 15000000,
            "stok": 10,
            "deskripsi": "Laptop gaming terbaik",
            "gambar": "laptop.jpg"
        }
    ]
}
```

### Get Single Product

**GET** `/produk/{id}` (Public)

Response:

```json
{
    "success": true,
    "message": "Detail produk berhasil diambil",
    "data": {
        "id": 1,
        "nama_produk": "Laptop Gaming",
        "harga": 15000000,
        "stok": 10,
        "deskripsi": "Laptop gaming terbaik",
        "gambar": "laptop.jpg"
    }
}
```

### Create Product

**POST** `/produk` (Protected)

Request Body:

```json
{
    "nama_produk": "Laptop Gaming",
    "harga": 15000000,
    "stok": 10,
    "deskripsi": "Laptop gaming terbaik",
    "gambar": "laptop.jpg"
}
```

### Update Product

**PUT** `/produk/{id}` (Protected)

Request Body:

```json
{
    "nama_produk": "Laptop Gaming Updated",
    "harga": 16000000,
    "stok": 8
}
```

### Delete Product

**DELETE** `/produk/{id}` (Protected)

Response:

```json
{
    "success": true,
    "message": "Produk berhasil dihapus"
}
```

---

## 3. USERS ENDPOINTS

### Get All Users

**GET** `/users` (Protected)

### Get Single User

**GET** `/users/{id}` (Protected)

### Update User

**PUT** `/users/{id}` (Protected)

Request Body:

```json
{
    "name": "John Updated",
    "email": "john.new@example.com",
    "password": "newpassword123"
}
```

### Delete User

**DELETE** `/users/{id}` (Protected)

---

## 4. TRANSAKSI ENDPOINTS

### Get All Transactions

**GET** `/transaksi` (Protected)

Query Parameters:

-   `user_id`: Filter by user
-   `status`: Filter by status (pending, dibayar, dikirim)

Response:

```json
{
    "success": true,
    "message": "Data transaksi berhasil diambil",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "total_harga": 15000000,
            "alamat_pengiriman": "Jl. Contoh No. 123",
            "status": "pending",
            "tanggal_transaksi": "2025-12-11 10:00:00",
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            },
            "details": [
                {
                    "id": 1,
                    "transaksi_id": 1,
                    "produk_id": 1,
                    "jumlah": 1,
                    "harga_satuan": 15000000,
                    "subtotal": 15000000,
                    "produk": {
                        "id": 1,
                        "nama_produk": "Laptop Gaming"
                    }
                }
            ]
        }
    ]
}
```

### Get Single Transaction

**GET** `/transaksi/{id}` (Protected)

### Create Transaction

**POST** `/transaksi` (Protected)

Request Body:

```json
{
    "user_id": 1,
    "total_harga": 15000000,
    "alamat_pengiriman": "Jl. Contoh No. 123",
    "status": "pending",
    "details": [
        {
            "produk_id": 1,
            "jumlah": 1,
            "harga_satuan": 15000000,
            "subtotal": 15000000
        }
    ]
}
```

### Update Transaction

**PUT** `/transaksi/{id}` (Protected)

Request Body:

```json
{
    "status": "dibayar",
    "alamat_pengiriman": "Jl. Baru No. 456"
}
```

### Delete Transaction

**DELETE** `/transaksi/{id}` (Protected)

---

## 5. DETAIL TRANSAKSI ENDPOINTS

### Get All Detail Transactions

**GET** `/detail-transaksi` (Protected)

### Get Details by Transaction ID

**GET** `/transaksi/{transaksi_id}/details` (Protected)

### Get Single Detail

**GET** `/detail-transaksi/{id}` (Protected)

### Create Detail Transaction

**POST** `/detail-transaksi` (Protected)

Request Body:

```json
{
    "transaksi_id": 1,
    "produk_id": 1,
    "jumlah": 2,
    "harga_satuan": 15000000,
    "subtotal": 30000000
}
```

### Update Detail Transaction

**PUT** `/detail-transaksi/{id}` (Protected)

### Delete Detail Transaction

**DELETE** `/detail-transaksi/{id}` (Protected)

---

## 6. PEMBAYARAN ENDPOINTS

### Get All Payments

**GET** `/pembayaran` (Protected)

Query Parameters:

-   `transaksi_id`: Filter by transaction
-   `status_pembayaran`: Filter by status (pending, success, failed)

Response:

```json
{
    "success": true,
    "message": "Data pembayaran berhasil diambil",
    "data": [
        {
            "id": 1,
            "transaksi_id": 1,
            "metode_pembayaran": "Transfer Bank",
            "jumlah_bayar": 15000000,
            "status_pembayaran": "pending",
            "tanggal_pembayaran": "2025-12-11 10:30:00",
            "bukti_pembayaran": "bukti_tf.jpg",
            "transaksi": {
                "id": 1,
                "total_harga": 15000000,
                "status": "pending"
            }
        }
    ]
}
```

### Get Single Payment

**GET** `/pembayaran/{id}` (Protected)

### Create Payment

**POST** `/pembayaran` (Protected)

Request Body:

```json
{
    "transaksi_id": 1,
    "metode_pembayaran": "Transfer Bank",
    "jumlah_bayar": 15000000,
    "status_pembayaran": "pending",
    "bukti_pembayaran": "bukti_tf.jpg"
}
```

### Update Payment

**PUT** `/pembayaran/{id}` (Protected)

Request Body:

```json
{
    "status_pembayaran": "success"
}
```

### Delete Payment

**DELETE** `/pembayaran/{id}` (Protected)

---

## Error Responses

### Validation Error (422)

```json
{
    "success": false,
    "message": "Validasi gagal",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

### Not Found (404)

```json
{
    "success": false,
    "message": "Data tidak ditemukan"
}
```

### Unauthorized (401)

```json
{
    "success": false,
    "message": "Unauthenticated"
}
```

### Server Error (500)

```json
{
    "success": false,
    "message": "Gagal memproses request",
    "error": "Error message details"
}
```

---

## Testing dengan Postman/Insomnia

1. **Register/Login** terlebih dahulu untuk mendapatkan token
2. Simpan token yang diterima
3. Untuk endpoint yang Protected, tambahkan header:
    - Key: `Authorization`
    - Value: `Bearer {your-token}`
4. Set Content-Type ke `application/json` untuk request body

---

## CORS Configuration

CORS sudah dikonfigurasi untuk menerima request dari semua origin (`*`).
Jika ingin membatasi hanya dari frontend tertentu, edit `config/cors.php`:

```php
'allowed_origins' => ['http://localhost:3000', 'http://localhost:5173'],
```
