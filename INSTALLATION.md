# Panduan Instalasi — SchoolPay

## Prasyarat

Pastikan sistem Anda memiliki:

| Software | Versi Minimum |
|----------|--------------|
| PHP | 8.3 |
| Composer | 2.x |
| Node.js | 18.x |
| NPM | 9.x |

> **Database:** SQLite sudah tersedia bawaan PHP. Untuk MySQL, pastikan MySQL 8.x terinstal.

---

## Instalasi Lokal (Development)

### 1. Clone / Ekstrak Proyek

```bash
cd C:\xampp\htdocs
# atau direktori pilihan Anda
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi Node.js

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfigurasi Database

**Opsi A — SQLite (default, tanpa konfigurasi tambahan):**

File `.env` sudah dikonfigurasi untuk SQLite. Pastikan file database ada:

```bash
# Jika belum ada
type nul > database\database.sqlite   # Windows
touch database/database.sqlite        # Linux/Mac
```

**Opsi B — MySQL:**

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schoolpay
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL:
```sql
CREATE DATABASE schoolpay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Migrasi & Seed Database

```bash
php artisan migrate --seed
```

Perintah ini akan:
- Membuat semua tabel database
- Mengisi data awal (admin, petugas, kelas, siswa contoh, tarif SPP)

### 7. Build Assets Frontend

```bash
npm run build
```

### 8. Buat Storage Link

```bash
php artisan storage:link
```

> Diperlukan agar foto profil yang diupload dapat diakses publik.

### 9. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## Akun Default Setelah Seeding

| Role | Username / NIS | Password |
|------|---------------|----------|
| Admin | `admin` | `admin123` |
| Petugas | `petugas01` | `petugas123` |
| Siswa | NIS siswa (lihat tabel siswa) | NIS siswa |

---

## Instalasi Production (Server)

### Konfigurasi .env untuk Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=schoolpay_prod
DB_USERNAME=db_user
DB_PASSWORD=db_password_kuat
```

### Optimasi Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
npm run build
```

### Konfigurasi Web Server (Apache)

Pastikan `DocumentRoot` mengarah ke folder `public/`:

```apache
<VirtualHost *:80>
    ServerName schoolpay.smkn7baleendah.sch.id
    DocumentRoot /var/www/schoolpay/public

    <Directory /var/www/schoolpay/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Aktifkan `mod_rewrite`:
```bash
a2enmod rewrite
systemctl restart apache2
```

### Konfigurasi Web Server (Nginx)

```nginx
server {
    listen 80;
    server_name schoolpay.smkn7baleendah.sch.id;
    root /var/www/schoolpay/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Permission Folder (Linux)

```bash
chown -R www-data:www-data /var/www/schoolpay
chmod -R 755 /var/www/schoolpay
chmod -R 775 /var/www/schoolpay/storage
chmod -R 775 /var/www/schoolpay/bootstrap/cache
```

---

## Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "SQLSTATE: unable to open database file"
```bash
# Pastikan file SQLite ada dan writable
touch database/database.sqlite
chmod 664 database/database.sqlite
```

### Foto tidak muncul setelah upload
```bash
php artisan storage:link
```

### Error 500 setelah deploy
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Halaman blank / CSS tidak muncul
```bash
npm run build
php artisan view:clear
```

---

## Update Sistem

```bash
git pull origin main
composer install
php artisan migrate
npm run build
php artisan config:cache
php artisan route:cache
```

---

## Backup Database

**SQLite:**
```bash
# Cukup copy file database
copy database\database.sqlite database\backup_database_%date%.sqlite
```

**MySQL:**
```bash
mysqldump -u root -p schoolpay > backup_schoolpay_$(date +%Y%m%d).sql
```
