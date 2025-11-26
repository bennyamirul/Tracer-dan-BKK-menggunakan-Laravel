# 📄 PDF Export Template Documentation

## File: `pdf-template.blade.php`

Template Blade yang reusable untuk export PDF dengan styling profesional.

---

## 🎯 Fitur

-   ✅ **Header Document** dengan judul, subtitle, dan info export
-   ✅ **Table** dengan styling profesional
-   ✅ **Warna Header** yang bisa disesuaikan
-   ✅ **Footer** dengan informasi pencetak
-   ✅ **Alternating Row Colors** untuk readability
-   ✅ **Responsive** untuk berbagai ukuran kertas
-   ✅ **Empty State** ketika tidak ada data

---

## 📋 Parameter Template

### Required Parameters:

| Parameter | Type  | Deskripsi                           |
| --------- | ----- | ----------------------------------- |
| `headers` | array | Array berisi nama-nama kolom header |
| `data`    | array | Array 2 dimensi berisi data tabel   |

### Optional Parameters:

| Parameter       | Type   | Default              | Deskripsi                       |
| --------------- | ------ | -------------------- | ------------------------------- |
| `title`         | string | 'Export Data'        | Title untuk HTML document       |
| `documentTitle` | string | null                 | Judul utama di header dokumen   |
| `subtitle`      | string | null                 | Subtitle di bawah judul         |
| `headerColor`   | string | '#4472C4'            | Warna background header (hex)   |
| `exportDate`    | string | date('d F Y, H:i:s') | Tanggal export                  |
| `total`         | string | null                 | Total data (misal: "50 alumni") |
| `printedBy`     | string | null                 | Nama user yang mencetak         |
| `footer`        | string | null                 | Text tambahan di footer         |

---

## 💻 Cara Penggunaan

### Contoh 1: Export Data Tracer Alumni

```php
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

public function exportPDF($data, $fileName)
{
    // Define headers
    $headers = ['No', 'Nama', 'Email', 'Jurusan', 'Angkatan'];

    // Transform data ke array
    $rows = [];
    foreach ($data as $index => $item) {
        $rows[] = [
            $index + 1,
            $item->nama,
            $item->email,
            $item->jurusan->nama,
            $item->angkatan->tahun
        ];
    }

    // Generate PDF
    $pdf = Pdf::loadView('exports.pdf-template', [
        'title' => 'Data Tracer Alumni',
        'documentTitle' => 'Data Tracer Alumni',
        'subtitle' => 'SMK Negeri 1 Kota',
        'headers' => $headers,
        'data' => $rows,
        'headerColor' => '#4472C4', // Biru
        'total' => count($data) . ' alumni',
        'printedBy' => Auth::user()->nama
    ]);

    $pdf->setPaper('a4', 'landscape');
    return $pdf->download($fileName . '.pdf');
}
```

### Contoh 2: Export Data Lowongan

```php
public function exportLowongan($data)
{
    $headers = ['No', 'Posisi', 'Perusahaan', 'Lokasi', 'Gaji', 'Status'];

    $rows = [];
    foreach ($data as $index => $lowongan) {
        $rows[] = [
            $index + 1,
            $lowongan->posisi,
            $lowongan->perusahaan->nama,
            $lowongan->lokasi,
            'Rp ' . number_format($lowongan->gaji),
            $lowongan->status
        ];
    }

    $pdf = Pdf::loadView('exports.pdf-template', [
        'documentTitle' => 'Daftar Lowongan Kerja',
        'subtitle' => 'Periode: ' . date('F Y'),
        'headers' => $headers,
        'data' => $rows,
        'headerColor' => '#28A745', // Hijau
        'total' => count($data) . ' lowongan aktif',
    ]);

    $pdf->setPaper('a4', 'portrait');
    return $pdf->download('lowongan.pdf');
}
```

### Contoh 3: Export Data User

```php
public function exportUsers($data)
{
    $headers = ['No', 'Nama', 'Email', 'Role', 'Tanggal Daftar'];

    $rows = [];
    foreach ($data as $index => $user) {
        $rows[] = [
            $index + 1,
            $user->nama,
            $user->email,
            ucfirst($user->role),
            $user->created_at->format('d-m-Y')
        ];
    }

    $pdf = Pdf::loadView('exports.pdf-template', [
        'documentTitle' => 'Data Pengguna Sistem',
        'headers' => $headers,
        'data' => $rows,
        'headerColor' => '#6C757D', // Abu-abu
        'total' => count($data) . ' users',
    ]);

    return $pdf->download('users.pdf');
}
```

---

## 🎨 Pilihan Warna Header

```php
'headerColor' => '#4472C4', // Biru (Default)
'headerColor' => '#28A745', // Hijau
'headerColor' => '#DC3545', // Merah
'headerColor' => '#FFC107', // Kuning/Orange
'headerColor' => '#6C757D', // Abu-abu
'headerColor' => '#17A2B8', // Cyan
'headerColor' => '#6610F2', // Purple
```

---

## 📐 Ukuran Kertas

### Portrait (Vertikal)

```php
$pdf->setPaper('a4', 'portrait');
```

**Cocok untuk:** Data dengan kolom sedikit (3-6 kolom)

### Landscape (Horizontal)

```php
$pdf->setPaper('a4', 'landscape');
```

**Cocok untuk:** Data dengan banyak kolom (7+ kolom)

### Custom Size

```php
$pdf->setPaper([0, 0, 612, 1008]); // Letter size
```

---

## 🛠️ Tips & Best Practices

### 1. **Jumlah Kolom**

-   **Portrait**: Maksimal 6-7 kolom
-   **Landscape**: Maksimal 10-12 kolom
-   Lebih dari itu akan membuat text terlalu kecil

### 2. **Format Data**

Pastikan data sudah di-transform ke array 2 dimensi:

```php
$rows = [
    [1, 'John Doe', 'john@example.com'],
    [2, 'Jane Smith', 'jane@example.com'],
];
```

### 3. **Handle Relasi**

```php
// ✅ Good: Load relasi di query
$data = Model::with('relasi')->get();

// ❌ Bad: N+1 problem
$data = Model::all(); // akan query relasi berkali-kali
```

### 4. **HTML Escape**

Data akan di-escape otomatis oleh Blade `{{ }}`.
Jika butuh HTML, gunakan `{!! !!}` (hati-hati dengan XSS!)

### 5. **Error Handling**

Selalu gunakan try-catch:

```php
try {
    $pdf = Pdf::loadView('exports.pdf-template', $data);
    return $pdf->download('file.pdf');
} catch (\Throwable $e) {
    // Fallback atau log error
    Log::error('PDF Export Error: ' . $e->getMessage());
    return back()->with('error', 'Gagal export PDF');
}
```

---

## 🎭 Customisasi Lanjutan

Jika butuh styling khusus, Anda bisa:

1. **Copy template** dan buat versi baru:

    ```
    pdf-template.blade.php → pdf-custom-template.blade.php
    ```

2. **Override CSS** dengan parameter tambahan
3. **Buat template spesifik** untuk kebutuhan tertentu

---

## 📚 Contoh Struktur Export

```
app/
├── Http/Controllers/
│   ├── TracerAlumniController.php
│   └── LowonganController.php
resources/
└── views/
    └── exports/
        ├── pdf-template.blade.php     ← Generic template
        ├── excel-template.blade.php   ← Generic template
        └── PDF-README.md             ← Dokumentasi ini
```

---

## ❓ Troubleshooting

### PDF tidak tergenerate?

-   Check apakah DomPDF terinstall: `composer show barryvdh/laravel-dompdf`
-   Check error log di `storage/logs/laravel.log`

### Text terpotong?

-   Kurangi jumlah kolom
-   Gunakan landscape orientation
-   Perkecil font size di CSS

### Gambar tidak muncul?

-   DomPDF butuh absolute path untuk gambar
-   Atau gunakan base64 encoded image

---

## 📝 License & Credits

Template ini dibuat untuk project TracerBKK dan dapat digunakan untuk export data lainnya.

**Author:** TracerBKK Team  
**Last Updated:** {{ date('F Y') }}
