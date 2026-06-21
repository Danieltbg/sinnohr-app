# Gaya kode (PHP / Laravel / Filament)

## Umum

- Ikuti gaya Laravel: PSR-12, jalankan **Laravel Pint** sebelum commit bila banyak file tersentuh.
- Namespace `App\...`; autoload PSR-4 seperti di `composer.json`.

## Struktur aplikasi

- **Filament:** `App\Filament\Admin\Resources\*Resource`, halaman di `Pages/`, relation manager & table/schema sesuai pola folder yang sudah ada.
- **Layanan bisnis:** `app/Services/<Area>/` — taruh logika non-trivial di sini, bukan membesarkan Resource secara berlebihan.
- **Enum:** `app/Enums/` untuk status/tipe yang stabil.

## UI / Filament

- Reuse komponen schema/table yang sudah dipakai resource sejenis; ikuti naming file tetangga (`*Form.php`, `*Table.php`).
- Hindari hardcode string panjang di UI bila sudah ada pola translasi/konfigurasi di proyek.

## Keamanan

- Jangan expose data sensitif di log atau response API; hormati auth Filament dan Sanctum sesuai konteks.
