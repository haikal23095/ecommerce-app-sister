# Contoh Test API Endpoint menggunakan cURL

# 1. REGISTER USER BARU
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Response akan memberikan token, simpan token tersebut
# Example: "token": "1|abc123xyz..."

# 2. LOGIN
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'

# 3. GET ALL PRODUCTS (Public - tidak perlu token)
curl -X GET http://localhost:8000/api/produk

# 4. GET SINGLE PRODUCT (Public)
curl -X GET http://localhost:8000/api/produk/1

# 5. CREATE PRODUCT (Protected - butuh token)
curl -X POST http://localhost:8000/api/produk \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "nama_produk": "Laptop Gaming ROG",
    "harga": 25000000,
    "stok": 5,
    "deskripsi": "Laptop gaming terbaik dengan RTX 4090",
    "gambar": "laptop-rog.jpg"
  }'

# 6. UPDATE PRODUCT (Protected)
curl -X PUT http://localhost:8000/api/produk/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "harga": 26000000,
    "stok": 3
  }'

# 7. CREATE TRANSACTION (Protected)
curl -X POST http://localhost:8000/api/transaksi \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "user_id": 1,
    "total_harga": 25000000,
    "alamat_pengiriman": "Jl. Sudirman No. 123, Jakarta",
    "status": "pending",
    "details": [
      {
        "produk_id": 1,
        "jumlah": 1,
        "harga_satuan": 25000000,
        "subtotal": 25000000
      }
    ]
  }'

# 8. GET ALL TRANSACTIONS (Protected)
curl -X GET http://localhost:8000/api/transaksi \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 9. GET TRANSACTIONS BY USER (Protected)
curl -X GET "http://localhost:8000/api/transaksi?user_id=1" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 10. UPDATE TRANSACTION STATUS (Protected)
curl -X PUT http://localhost:8000/api/transaksi/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "status": "dibayar"
  }'

# 11. CREATE PAYMENT (Protected)
curl -X POST http://localhost:8000/api/pembayaran \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "transaksi_id": 1,
    "metode_pembayaran": "Transfer Bank BCA",
    "jumlah_bayar": 25000000,
    "status_pembayaran": "pending",
    "bukti_pembayaran": "bukti_transfer.jpg"
  }'

# 12. UPDATE PAYMENT STATUS (Protected)
curl -X PUT http://localhost:8000/api/pembayaran/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "status_pembayaran": "success"
  }'

# 13. GET PAYMENT BY TRANSACTION (Protected)
curl -X GET "http://localhost:8000/api/pembayaran?transaksi_id=1" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 14. GET DETAIL TRANSAKSI BY TRANSAKSI ID (Protected)
curl -X GET http://localhost:8000/api/transaksi/1/details \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 15. GET USER INFO (Protected)
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 16. LOGOUT (Protected)
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 17. DELETE PRODUCT (Protected)
curl -X DELETE http://localhost:8000/api/produk/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 18. DELETE TRANSACTION (Protected)
curl -X DELETE http://localhost:8000/api/transaksi/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# NOTES:
# - Ganti YOUR_TOKEN_HERE dengan token yang didapat dari login/register
# - Ganti ID (angka 1, 2, dst) sesuai dengan data yang ada di database
# - Untuk testing di Windows PowerShell, gunakan format berbeda:
#   Invoke-WebRequest -Uri "http://localhost:8000/api/produk" -Method GET
