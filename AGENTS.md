# Panduan Agen AI untuk Repo Ini

## Tujuan

Membangun dan merawat **HRIS Backend Admin** berbasis **Laravel 13 + Filament 5 + Sanctum API** dengan perubahan minimal, konsisten dengan kode yang ada.

## Tech Stack

- PHP 8.4+ / Laravel 13 / Filament 5.x
- Database: PostgreSQL
- Auth API: Laravel Sanctum
- Queue: Redis
- Testing: PHPUnit 12

## Prinsip Kerja

1. **Baca dulu** — buka file sejenis (Resource, Page, Service, Model) sebelum menulis kode baru.
2. **Domain HR** dijelaskan di `docs/08-core-domains/` — rujuk file spesifik, jangan gandakan narasi.
3. **Konteks proyek** di `context/` — baca sesuai tugas.
4. **Template prompt** di `prompts/*.prompt.md` — untuk tugas berulang.
5. **Cuplikan perintah** di `snippets/*-snippet.md` — referensi cepat.
6. **Satu PR satu fokus** — hindari refactor menyamping.
7. **Jangan tambah abstraksi/package baru** tanpa instruksi eksplisit.

## Keputusan: Di Mana Menaruh Kode?

| Kebutuhan | Lokasi |
|-----------|--------|
| Logika bisnis | `app/Services/{Domain}/` |
| Validasi input | `app/Http/Requests/` |
| UI admin | `app/Filament/Admin/Resources/` |
| API endpoint | `app/Http/Controllers/Api/` |
| Konstanta/status | `app/Enums/` |
| Otorisasi | `app/Policies/` |

## Context Discovery

| Tugas | Baca dulu |
|-------|-----------|
| Fitur domain baru | `docs/08-core-domains/{domain}.md` |
| API endpoint baru | `routes/api.php` + controller sejenis |
| Filament Resource | Resource sejenis di `app/Filament/Admin/Resources/` |
| Alur bisnis | `context/business-flow.md` |
| Konvensi kode | `context/code-style.md` |

## Filament

- Panel: id `admin`, path `/admin` — lihat `AdminPanelProvider`.
- Auto-discover dari `app/Filament/Admin/`.
- Logika kompleks → delegasikan ke Service.

## API

- Rute di `routes/api.php`; middleware `employee.api` untuk konteks employee.
- Definisi middleware di `bootstrap/app.php`.
- Response selalu via JsonResponse atau API Resource class.

## Larangan

- ❌ Abstraksi baru tanpa instruksi (trait, base class, interface)
- ❌ Install package baru tanpa konfirmasi
- ❌ Modifikasi migration yang sudah jalan
- ❌ Ubah `AdminPanelProvider` tanpa diminta
- ❌ Logika bisnis di Filament action closure
- ❌ `env()` di luar file config

## Verifikasi

- Setelah perubahan perilaku: `composer test`
- Setelah perubahan PHP luas: `./vendor/bin/pint`
- Setelah migration baru: `php artisan migrate:fresh --seed` (lokal)

## Bahasa

- Kode, komentar, nama simbol: **English**
- Respons ke pengguna: ikuti preferensi tim (Indonesia)
