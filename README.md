# 🎓 Sistem BKK & Tracer Study

## SMK Teratai Putih Global 4

Sistem informasi terintegrasi untuk mengelola Bursa Kerja Khusus (BKK) dan penelusuran alumni (Tracer Study) di SMK Teratai Putih Global 4.

---

## 📋 Fitur Utama

### 🔹 **Untuk Alumni/Pelamar**

-   ✅ Registrasi dan manajemen profil
-   ✅ Browse lowongan kerja dari perusahaan mitra
-   ✅ Apply lamaran secara online
-   ✅ Upload berkas (CV, ijazah, sertifikat)
-   ✅ Tracking status lamaran
-   ✅ Isi data tracer study

### 🔹 **Untuk Perusahaan (DU/DI)**

-   ✅ Registrasi dan verifikasi perusahaan
-   ✅ Posting lowongan kerja
-   ✅ Manajemen lamaran masuk
-   ✅ Update status lamaran (proses/diterima/ditolak)
-   ✅ Lihat profil kandidat

### 🔹 **Untuk Admin Sekolah**

-   ✅ Dashboard statistik lengkap
-   ✅ Manajemen data master (jurusan, angkatan, kegiatan)
-   ✅ Manajemen pengguna (admin, perusahaan, pelamar)
-   ✅ Verifikasi perusahaan
-   ✅ Monitoring lamaran
-   ✅ Export data tracer study (Excel/PDF)
-   ✅ Analisis tracer alumni

---

## 🛠️ Teknologi yang Digunakan

-   **Framework:** Laravel 12.x
-   **PHP:** ^8.2
-   **Database:** SQLite (default) / MySQL
-   **Frontend:** Metronic Theme, Bootstrap 5, Vanilla JavaScript
-   **Libraries:**
    -   `maatwebsite/excel` - Export Excel
    -   `barryvdh/laravel-dompdf` - Export PDF
    -   Vite - Asset bundling

---

## 🚀 Instalasi

### Persyaratan

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   SQLite extension (atau MySQL)

### Langkah-langkah

1. **Clone Repository**

```bash
git clone <repository-url>
cd tracerbkk
```

2. **Install Dependencies**

```bash
composer install
npm install
```

3. **Setup Environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Setup Database**

```bash
# Untuk SQLite (default)
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate
```

5. **Seed Data (Opsional)**

```bash
php artisan db:seed
```

6. **Link Storage**

```bash
php artisan storage:link
```

7. **Build Assets**

```bash
npm run build
# Atau untuk development
npm run dev
```

8. **Jalankan Server**

```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

---

## 📂 Struktur Project

```
tracerbkk/
├── app/
│   ├── Http/Controllers/
│   │   ├── admin/              # Admin Sekolah
│   │   ├── admin_dudi/         # Admin Perusahaan
│   │   └── ...                 # Public Controllers
│   ├── Models/
│   ├── Exports/
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/              # Views Admin
│   │   ├── admin_dudi/         # Views Perusahaan
│   │   ├── auth/               # Login/Register
│   │   ├── lowongan/           # Lowongan Kerja
│   │   ├── perusahaan/         # Daftar Perusahaan
│   │   ├── tracer-alumni/      # Tracer Study
│   │   └── layouts/
│   └── js/ & css/
└── routes/
    └── web.php
```

---

## 👥 Role & Hak Akses

| Role               | Deskripsi              | Dashboard     |
| ------------------ | ---------------------- | ------------- |
| **admin_sekolah**  | Administrator sekolah  | `/admin`      |
| **admin_dudi**     | Admin perusahaan/DU-DI | `/admin_dudi` |
| **pelamar_alumni** | Alumni sekolah         | Landing page  |
| **pelamar_umum**   | Pelamar umum           | Landing page  |

---

## 🔐 Default Login

Silakan buat user melalui seeder atau registrasi:

```bash
php artisan db:seed --class=UserSeeder
```

---

## 📊 Database Schema

### Tables:

-   `users` - Data pengguna (semua role)
-   `jurusan` - Master jurusan
-   `tahun_angkatan` - Master angkatan
-   `kegiatan` - Master kegiatan alumni
-   `perusahaan` - Data perusahaan mitra
-   `lowongan` - Lowongan kerja
-   `lamaran` - Data lamaran
-   `berkas` - File upload (CV, ijazah, dll)
-   `tracer_alumni` - Data tracer study

---

## 🎨 Fitur UI/UX

-   ✅ Responsive design (mobile-friendly)
-   ✅ Modern card design
-   ✅ Real-time search (lowongan & perusahaan)
-   ✅ Clean & intuitive interface
-   ✅ Interactive charts & statistics
-   ✅ Metronic components integration

---

## 📦 Export Features

### Excel Export

-   Export data tracer alumni
-   Filter berdasarkan angkatan
-   Multiple sheets support

### PDF Export

-   Export laporan tracer study
-   Custom layout & branding
-   Print-ready format

---

## 🔄 Development Scripts

```bash
# Install & Setup
composer install
npm install

# Development
npm run dev              # Vite dev server
php artisan serve       # Laravel dev server

# Production Build
npm run build

# Database
php artisan migrate     # Run migrations
php artisan db:seed     # Seed database
php artisan migrate:fresh --seed  # Fresh start

# Code Quality
./vendor/bin/pint       # Format code
php artisan test        # Run tests
```

---

## 🐛 Troubleshooting

### Storage Permission Error

```bash
chmod -R 775 storage bootstrap/cache
```

### Symlink Error

```bash
php artisan storage:link
```

### Cache Issues

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 📝 TODO / Future Enhancements

-   [ ] Sistem notifikasi real-time untuk status lamaran
-   [ ] Email notifications
-   [ ] Advanced filtering & sorting
-   [ ] API untuk mobile app
-   [ ] Dashboard analytics lebih detail
-   [ ] Multi-language support

---

## 🤝 Contributing

Silakan buat pull request atau laporkan issue jika menemukan bug atau punya ide fitur baru.

---

## 📄 License

Hak cipta © SMK Teratai Putih Global 4

---

## 👨‍💻 Developer

Dikembangkan untuk SMK Teratai Putih Global 4

**Kontak:**

-   Website: [Coming Soon]
-   Email: bkk@smktp4.sch.id

---

## 📞 Support

Jika ada pertanyaan atau butuh bantuan, silakan hubungi:

-   **Email:** support@smktp4.sch.id
-   **Telp:** 021-12345678
