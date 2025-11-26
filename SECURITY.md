# 🔐 Security Guidelines - BKK & Tracer Study

## Implemented Security Features

### ✅ Authentication & Authorization

-   **CSRF Protection**: Semua form menggunakan `@csrf` token
-   **Role-based Access Control**: 4 role (admin_sekolah, admin_dudi, pelamar_alumni, pelamar_umum)
-   **Middleware Protection**: Route terproteksi dengan `auth` dan custom middleware
-   **Password Hashing**: Menggunakan bcrypt (12 rounds)
-   **Session Security**: Session regeneration setelah login

### ✅ Rate Limiting (Throttling)

```php
// Login: Max 5 attempts per menit
Route::post('/login')->middleware('throttle:5,1');

// Register: Max 3 attempts per menit
Route::post('/register')->middleware('throttle:3,1');

// Apply Lamaran: Max 10 per menit
Route::post('/lowongan/{id}/apply')->middleware('throttle:10,1');
```

### ✅ Input Validation

-   Semua input user divalidasi dengan Laravel Validation Rules
-   Custom error messages dalam Bahasa Indonesia
-   File upload validation (type, size)
-   Email uniqueness check

### ✅ Mass Assignment Protection

-   Semua model menggunakan `$fillable` property
-   Tidak ada `$guarded = []` yang membahayakan

### ✅ XSS Protection

-   Laravel automatic escaping di Blade templates
-   Output encoding enabled by default

### ✅ SQL Injection Protection

-   Query builder & Eloquent ORM (parameterized queries)
-   Tidak ada raw SQL tanpa binding

### ✅ File Upload Security

-   Type validation (image/pdf only)
-   Size limit (max 2MB untuk avatar)
-   Files stored di storage dengan symlink
-   Old files cleanup setelah update

---

## 🚨 Security Recommendations

### 1. Environment Configuration

**PRODUCTION .env:**

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=[generate dengan php artisan key:generate]

# HTTPS Only
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict
```

### 2. Database Security

-   **Jangan** commit file `.env` ke repository
-   Gunakan strong password untuk database production
-   Backup database secara regular
-   Encrypt sensitive data di database

### 3. Server Configuration

-   Enable HTTPS/SSL certificate
-   Configure firewall rules
-   Disable directory listing
-   Keep PHP & Laravel up to date
-   Use `php artisan optimize` di production

### 4. File Permissions

```bash
chmod 755 -R storage
chmod 755 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. Headers Security

Tambahkan di `.htaccess` atau nginx config:

```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Strict-Transport-Security: max-age=31536000
```

---

## 🔍 Security Checklist

### Before Deployment

-   [ ] `APP_DEBUG=false` di production
-   [ ] `APP_ENV=production`
-   [ ] Strong `APP_KEY` generated
-   [ ] Database credentials aman
-   [ ] `.env` tidak ter-commit
-   [ ] `storage/` writable tapi tidak executable
-   [ ] HTTPS enabled
-   [ ] Rate limiting aktif
-   [ ] Error logging configured
-   [ ] Backup strategy ready

### Regular Maintenance

-   [ ] Update Laravel & dependencies (`composer update`)
-   [ ] Monitor `storage/logs/laravel.log`
-   [ ] Review suspicious login attempts
-   [ ] Check file uploads directory
-   [ ] Audit user permissions
-   [ ] Database backup verification

---

## 🐛 Reporting Security Issues

Jika menemukan vulnerability, **JANGAN** buat public issue. Hubungi:

-   **Email:** security@smktp4.sch.id
-   **Subject:** [SECURITY] Vulnerability Report

---

## 📚 Additional Resources

-   [Laravel Security Documentation](https://laravel.com/docs/security)
-   [OWASP Top 10](https://owasp.org/www-project-top-ten/)
-   [Laravel Security Best Practices](https://github.com/Wulfheart/laravel-security-best-practices)

---

**Last Updated:** 2025-10-27
