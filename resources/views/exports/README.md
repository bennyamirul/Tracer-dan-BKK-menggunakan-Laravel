# Excel Export Template

Template Blade yang reusable untuk export Excel di berbagai controller.

## File Template

`resources/views/exports/excel-template.blade.php`

## Parameter yang Diterima

| Parameter     | Type   | Required | Default       | Deskripsi                   |
| ------------- | ------ | -------- | ------------- | --------------------------- |
| `title`       | string | No       | 'Export Data' | Judul dokumen               |
| `headers`     | array  | Yes      | -             | Array header kolom          |
| `data`        | array  | Yes      | -             | Array of arrays (data rows) |
| `headerColor` | string | No       | '#4472C4'     | Warna background header     |

## Contoh Penggunaan

### 1. Export Tracer Alumni

```php
private function exportExcel($data, $fileName)
{
    $headers = ['No', 'Nama Alumni', 'Email', '...'];

    $rows = [];
    foreach ($data as $index => $tracer) {
        $rows[] = [
            $index + 1,
            $tracer->user->nama ?? '-',
            $tracer->user->email ?? '-',
            // ... kolom lainnya
        ];
    }

    $html = view('exports.excel-template', [
        'title' => 'Data Tracer Alumni',
        'headers' => $headers,
        'data' => $rows,
        'headerColor' => '#4472C4' // Biru
    ])->render();

    return response($html, 200, [
        'Content-Type' => 'application/vnd.ms-excel',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '.xls"',
    ]);
}
```

### 2. Export User

```php
private function exportExcel($users, $fileName)
{
    $headers = ['No', 'Nama', 'Email', 'Role', 'Status'];

    $rows = [];
    foreach ($users as $index => $user) {
        $rows[] = [
            $index + 1,
            $user->nama,
            $user->email,
            $user->role,
            $user->status
        ];
    }

    $html = view('exports.excel-template', [
        'title' => 'Data User',
        'headers' => $headers,
        'data' => $rows,
        'headerColor' => '#E74C3C' // Merah
    ])->render();

    return response($html, 200, [
        'Content-Type' => 'application/vnd.ms-excel',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '.xls"',
    ]);
}
```

### 3. Export Perusahaan

```php
private function exportExcel($perusahaan, $fileName)
{
    $headers = ['No', 'Nama Perusahaan', 'Alamat', 'Kontak', 'Email'];

    $rows = [];
    foreach ($perusahaan as $index => $item) {
        $rows[] = [
            $index + 1,
            $item->nama,
            $item->alamat,
            $item->no_telp,
            $item->email
        ];
    }

    $html = view('exports.excel-template', [
        'title' => 'Data Perusahaan',
        'headers' => $headers,
        'data' => $rows,
        'headerColor' => '#27AE60' // Hijau
    ])->render();

    return response($html, 200, [
        'Content-Type' => 'application/vnd.ms-excel',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '.xls"',
    ]);
}
```

## Kelebihan Template Ini

✅ **Reusable** - Satu template untuk banyak export
✅ **Clean Code** - Controller lebih bersih tanpa HTML string
✅ **Easy Maintenance** - Update 1 file = semua export terupdate
✅ **Consistent Design** - Semua export punya look yang sama
✅ **Flexible** - Bisa customize warna header per export
✅ **Zebra Striping** - Baris genap otomatis punya background abu-abu

## Tips

1. **Data harus array of arrays**

    ```php
    // ✅ Benar
    $rows = [
        [1, 'Budi', 'budi@email.com'],
        [2, 'Ani', 'ani@email.com']
    ];

    // ❌ Salah
    $rows = [
        ['id' => 1, 'nama' => 'Budi'],
        ['id' => 2, 'nama' => 'Ani']
    ];
    ```

2. **Jumlah kolom header harus sama dengan data**

    ```php
    // ✅ Benar
    $headers = ['No', 'Nama', 'Email']; // 3 kolom
    $rows = [[1, 'Budi', 'budi@email.com']]; // 3 kolom

    // ❌ Salah
    $headers = ['No', 'Nama']; // 2 kolom
    $rows = [[1, 'Budi', 'budi@email.com']]; // 3 kolom (mismatch!)
    ```

3. **Handle null values**
    ```php
    $tracer->user->nama ?? '-' // Gunakan null coalescing
    ```

## Color Palette Suggestions

-   **Blue** (#4472C4) - Default, professional
-   **Red** (#E74C3C) - Important data, alerts
-   **Green** (#27AE60) - Success, approved
-   **Orange** (#F39C12) - Warning, pending
-   **Purple** (#9B59B6) - Special, premium
-   **Teal** (#1ABC9C) - Info, neutral

## Format File Output

File akan terdownload dengan format `.xls` (Excel 97-2003) yang:

-   Bisa dibuka di Microsoft Excel
-   Bisa dibuka di Google Sheets
-   Bisa dibuka di LibreOffice Calc
-   Support styling (warna, bold, border)
-   File size kecil
