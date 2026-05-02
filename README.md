# SchoolPay 🏫💳
### Sistem Informasi Manajemen Pembayaran SPP — SMKN 7 Baleendah

> Aplikasi web berbasis Laravel untuk digitalisasi pencatatan dan pelaporan pembayaran SPP sekolah.

---

## ✨ Fitur Utama

### 👤 Admin
- Dashboard statistik real-time dengan grafik pendapatan
- Manajemen siswa (CRUD, import Excel, reset password, generate ID Card PDF)
- Manajemen petugas, kelas, dan tarif SPP
- History transaksi dengan filter bulan/tahun dan export PDF
- Laporan keuangan (PDF & Excel) per periode

### 🧑‍💼 Petugas
- Input transaksi pembayaran dengan pencarian siswa cepat
- Cetak kwitansi PDF per transaksi
- History transaksi pribadi

### 🎓 Siswa
- Portal mandiri untuk cek status pembayaran
- Download kwitansi PDF
- Update profil dan foto

---

## 🛠️ Teknologi

| Layer | Teknologi |
|-------|-----------|
| Backend | PHP 8.3, Laravel 13 |
| Database | SQLite (default) / MySQL |
| PDF | barryvdh/laravel-dompdf |
| Excel | maatwebsite/excel |
| Frontend | Blade, CSS Custom, Chart.js, Vanilla JS |
| Build | Vite, Composer, NPM |

---

## 🚀 Quick Start

```bash
# Clone & masuk ke direktori
cd website-spp

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Migrasi & seed database
php artisan migrate --seed

# Build assets
npm run build

# Storage link
php artisan storage:link

# Jalankan server
php artisan serve
```

Akses di: **http://localhost:8000**

---

## 🔑 Akun Default

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Petugas | `petugas01` | `petugas123` |
| Siswa | NIS siswa | NIS siswa |

---

## 📁 Struktur Direktori

```
website-spp/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller admin
│   │   ├── Petugas/        # Controller petugas
│   │   └── Siswa/          # Controller siswa
│   ├── Models/             # Eloquent models
│   └── Exports/            # Excel export classes
├── database/
│   └── migrations/         # Skema database
├── resources/
│   └── views/
│       ├── admin/          # Views admin
│       ├── petugas/        # Views petugas
│       ├── siswa/          # Views siswa
│       ├── pdf/            # Template PDF
│       └── layouts/        # Layout utama
├── routes/
│   └── web.php             # Semua route
└── public/
    └── storage/            # Symlink ke storage/app/public
```

---

## 📄 Dokumentasi

Dokumentasi lengkap tersedia di [sini](https://github.com/AndreasSirulRizki/dokumentasi-SchoolPay) :

| File | Isi |
|------|-----|
| `script-presentasi.md` | Script presentasi proyek |
| `SRS.md` | Software Requirements Specification |
| `uml-erd.puml` | Entity Relationship Diagram |
| `uml-usecase.puml` | Use Case Diagram |
| `uml-activity.puml` | Activity Diagram |
| `uml-sequence.puml` | Sequence Diagram |
| `uml-class.puml` | Class Diagram |

> File `.puml` dapat dibuka dengan [PlantUML](https://plantuml.com/) atau ekstensi PlantUML di VS Code.

---

## 👥 Tim

**Team PayFlow** — SMKN 7 Baleendah

---

## 📝 Lisensi

Proyek ini dibuat untuk keperluan akademik.
