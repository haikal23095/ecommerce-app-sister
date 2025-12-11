# Database Master-Slave Replication Configuration

## ✅ Laravel Configuration Complete

Konfigurasi Laravel untuk read-write splitting sudah selesai dilakukan.

## 📝 Cara Menggunakan

### 1. Update File `.env`

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
# Database Default (fallback)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_transaksi
DB_USERNAME=root
DB_PASSWORD=your_password

# Database Write (Master) - Untuk operasi INSERT, UPDATE, DELETE
DB_WRITE_HOST=192.168.1.100
DB_WRITE_PORT=3306
DB_WRITE_DATABASE=db_transaksi
DB_WRITE_USERNAME=root
DB_WRITE_PASSWORD=your_master_password

# Database Read (Slave) - Untuk operasi SELECT
DB_READ_HOST=192.168.1.101
DB_READ_PORT=3306
DB_READ_DATABASE=db_transaksi
DB_READ_USERNAME=root
DB_READ_PASSWORD=your_slave_password
```

### 2. Ganti IP Address & Credentials

Sesuaikan nilai berikut dengan konfigurasi server database Anda:

-   **DB_WRITE_HOST**: IP address database master (write)
-   **DB_WRITE_PORT**: Port database master (default: 3306)
-   **DB_WRITE_USERNAME**: Username untuk database master
-   **DB_WRITE_PASSWORD**: Password untuk database master

-   **DB_READ_HOST**: IP address database slave (read)
-   **DB_READ_PORT**: Port database slave (default: 3306)
-   **DB_READ_USERNAME**: Username untuk database slave
-   **DB_READ_PASSWORD**: Password untuk database slave

### 3. Cara Kerja

Laravel akan otomatis:

-   **Mengirim operasi WRITE (INSERT, UPDATE, DELETE)** ke database master
-   **Mengirim operasi READ (SELECT)** ke database slave
-   **Sticky Session** enabled: Setelah write, read berikutnya akan ke master untuk menghindari replikasi lag

## 🔍 Testing Koneksi

### Test koneksi ke database master (write):

```bash
php artisan tinker
```

Di Tinker, jalankan:

```php
// Test Write to Master
DB::connection('mysql')->insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', ['Test', 'test@example.com', bcrypt('password')]);

// Cek koneksi write
DB::connection('mysql')->getPdo()->getAttribute(PDO::ATTR_SERVER_INFO);
```

### Test koneksi ke database slave (read):

```php
// Test Read from Slave
DB::connection('mysql')->select('SELECT * FROM users LIMIT 1');

// Check current connection
DB::connection()->getDatabaseName();
```

## 📊 Monitoring Query

Untuk memonitor query ke database mana yang dijalankan, tambahkan di `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

public function boot()
{
    DB::listen(function ($query) {
        Log::info('Query executed', [
            'sql' => $query->sql,
            'bindings' => $query->bindings,
            'time' => $query->time,
            'connection' => $query->connectionName
        ]);
    });
}
```

## 🔧 Manual Control

Jika ingin memaksa query tertentu menggunakan koneksi tertentu:

```php
// Force read from master
DB::connection('mysql')->useWritePdo()->select('SELECT * FROM users');

// Force read from slave (default untuk SELECT)
DB::connection('mysql')->select('SELECT * FROM users');
```

## ⚙️ Konfigurasi Sticky Session

Sticky session sudah diaktifkan (`'sticky' => true`). Ini berarti:

-   Setelah operasi WRITE dalam request
-   Semua READ query berikutnya dalam request yang sama akan menggunakan MASTER
-   Mencegah masalah replikasi lag

Untuk menonaktifkan, ubah di `config/database.php`:

```php
'mysql' => [
    // ...
    'sticky' => false,
    // ...
]
```

## 📋 Best Practices

1. **Gunakan Read Replica untuk Laporan**: Query yang berat/reporting sebaiknya explicit menggunakan read connection
2. **Monitor Replication Lag**: Pastikan replikasi tidak terlalu jauh tertinggal
3. **Health Check**: Implementasikan health check untuk kedua database
4. **Fallback**: Jika slave down, Laravel otomatis fallback ke master
5. **Connection Pooling**: Pertimbangkan menggunakan ProxySQL atau MySQL Router untuk production

## 🚨 Troubleshooting

### Error: SQLSTATE[HY000] [2002] Connection refused

-   Pastikan IP address dan port sudah benar
-   Cek firewall di server database
-   Pastikan MySQL bind-address di server tidak hanya 127.0.0.1

### Error: Access denied for user

-   Pastikan user memiliki permission dari IP Laravel server
-   Di MySQL server, jalankan:

```sql
GRANT ALL PRIVILEGES ON db_transaksi.* TO 'root'@'%' IDENTIFIED BY 'password';
FLUSH PRIVILEGES;
```

### Replication Lag

-   Monitor dengan: `SHOW SLAVE STATUS;` di slave server
-   Jika lag terlalu besar, pertimbangkan upgrade hardware atau optimasi query

## 📚 Referensi

-   [Laravel Database: Read & Write Connections](https://laravel.com/docs/master/database#read-and-write-connections)
-   [MySQL Replication](https://dev.mysql.com/doc/refman/8.0/en/replication.html)

---

**Status**: ✅ Configured
**Last Updated**: December 11, 2025
