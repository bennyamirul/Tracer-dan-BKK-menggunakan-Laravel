# 🚀 Panduan Instalasi Detail - BKK & Tracer Study

## 📋 Prasyarat

Pastikan sistem Anda memiliki:

### Software Requirements

-   **PHP**: >= 8.2
    -   Extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo
-   **Composer**: Latest version
-   **Node.js**: >= 18.x
-   **NPM** atau **Yarn**
-   **Database**: SQLite (default) atau MySQL/PostgreSQL
-   **Git**: Untuk cloning repository

### Check PHP Version

```bash
php -v
# Output harus >= 8.2
```

### Check PHP Extensions

```bash
php -m | grep -E "pdo|mbstring|xml|tokenizer|openssl"
```

---

## 🔧 Instalasi Step-by-Step

### 1️⃣ Clone Repository

```bash
git clone <repository-url> tracerbkk
cd tracerbkk
```

### 2️⃣ Install PHP Dependencies

```bash
composer install
```

**Troubleshooting:**

-   Jika ada error memory limit: `php -d memory_limit=-1 $(which composer) install`
-   Jika composer belum terinstall: [Download Composer](https://getcomposer.org/download/)

### 3️⃣ Install Node Dependencies

```bash
npm install
# Atau jika pakai yarn:
yarn install
```

### 4️⃣ Setup Environment File

#### Untuk SQLite (Default - Recommended untuk Development)

```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Buat database SQLite
touch database/database.sqlite
```

#### Untuk MySQL

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tracerbkk
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database MySQL:

```bash
mysql -u root -p
CREATE DATABASE tracerbkk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 5️⃣ Run Migrations

```bash
php artisan migrate
```

**Output yang diharapkan:**

```
Migration table created successfully.
Migrating: 2025_10_11_112049_user
Migrated:  2025_10_11_112049_user (XX.XXms)
...
```

### 6️⃣ Seed Database (Opsional tapi Direkomendasikan)

```bash
php artisan db:seed
# Atau hanya UserSeeder:
php artisan db:seed --class=UserSeeder
```

### 7️⃣ Create Storage Symlink

```bash
php artisan storage:link
```

**Output:**

```
The [public/storage] link has been connected to [storage/app/public].
```

### 8️⃣ Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

**Untuk Production:**

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

### 9️⃣ Build Frontend Assets

**Development Mode:**

```bash
npm run dev
# Ini akan watch file changes
```

**Production Build:**

```bash
npm run build
```

### 🔟 Run Development Server

```bash
php artisan serve
```

**Output:**

```
Starting Laravel development server: http://127.0.0.1:8000
```

Buka browser: **http://localhost:8000**

---

## 🎯 Quick Setup (One Command)

Jika Anda sudah familiar, bisa pakai script composer:

```bash
composer setup
```

Script ini akan otomatis:

1. Install dependencies
2. Copy `.env.example`
3. Generate key
4. Run migrations
5. Build assets

---

## 👤 User Default (Setelah Seeding)

Jika sudah run `db:seed`, Anda bisa login dengan:

**Admin Sekolah:**

-   Email: `admin@smktp4.sch.id`
-   Password: `password123`

**Admin DU/DI:**

-   Email: `dudi@perusahaan.com`
-   Password: `password123`

**Pelamar:**

-   Email: `alumni@example.com`
-   Password: `password123`

> ⚠️ **PENTING:** Ganti password default ini di production!

---

## 🐛 Troubleshooting

### Error: "No application encryption key has been specified"

```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000]: General error: 1 no such table"

```bash
php artisan migrate:fresh
```

### Error: "The stream or file could not be opened"

```bash
chmod -R 775 storage
```

### Error: "Class 'PDO' not found"

```bash
# Install PHP PDO extension
# Ubuntu/Debian:
sudo apt-get install php8.2-sqlite3
# Mac (Homebrew):
brew install php@8.2
```

### Vite/Asset Error

```bash
# Clear cache
npm run build
php artisan config:clear
php artisan view:clear
```

### Port 8000 Already in Use

```bash
# Gunakan port lain
php artisan serve --port=8080
```

---

## 🔒 Security Setup (PRODUCTION ONLY)

### 1. Environment

```env
APP_ENV=production
APP_DEBUG=false
SESSION_SECURE_COOKIE=true
```

### 2. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### 3. Set Proper Permissions

```bash
chown -R www-data:www-data /path/to/tracerbkk
chmod -R 755 /path/to/tracerbkk
chmod -R 775 storage bootstrap/cache
```

---

## 📦 Update/Maintenance

### Update Dependencies

```bash
composer update
npm update
```

### Clear All Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Fresh Install (⚠️ Data akan hilang)

```bash
php artisan migrate:fresh --seed
```

---

## 🆘 Butuh Bantuan?

-   **Documentation:** `README.md`
-   **Security:** `SECURITY.md`
-   **Email:** support@smktp4.sch.id

---

**Happy Coding! 🎉**
