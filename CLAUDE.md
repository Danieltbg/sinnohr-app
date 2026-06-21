# HRIS Admin — konteks proyek (ringkas)

**Stack:** Laravel 13 · PHP ≥8.4 · Filament 5.5 · Sanctum · PHPUnit 12.

## Peta direktori (mulai dari sini)

| Area | Path |
|------|------|
| Panel admin Filament | `app/Filament/Admin/` (`Resources`, `Pages`, `Widgets`, exports) |
| Registrasi panel | `app/Providers/Filament/AdminPanelProvider.php` |
| API (mobile/employee) | `app/Http/Controllers/Api/`, `routes/api.php`, middleware `employee.api` |
| Domain logic | `app/Services/` |
| Model & enum | `app/Models/`, `app/Enums/` |
| Test | `tests/Feature/`, `tests/Unit/` |
| Migrasi & seed | `database/migrations/`, `database/seeders/`, `database/factories/` |
| Dokumen domain bisnis | `docs/08-core-domains/` (14 domain HR) |
| Konteks agen (sistem, API, bisnis ringkas) | `context/` — mulai dari `context/system-context.md` |
| Template prompt (hemat token) | `prompts/*.prompt.md` — salin blok “Prompt pengguna” ke chat |
| Cuplikan perintah / pola | `snippets/` — `laravel`, `filament`, `docker`, `sql` (berkas `*-snippet.md`) |

## Aturan hemat token

1. Jangan menyerukan ulang isi panjang domain — **buka file di `docs/08-core-domains/`** bila perlu.
2. Tanpa narasi panjang: **`context/*.md`** untuk konteks proyek; **`prompts/*.prompt.md`** untuk tugas berulang (salin blok “Prompt pengguna”, lampiran `@` terarah).
3. Untuk fitur Filament: cari `*Resource.php` dan halaman terkait di folder resource yang sama sebelum menambah pola baru.
4. Standar kode & tes: lihat `.claude/rules/code-style.md` dan `.claude/rules/testing.md`.

## Perintah umum

- `composer test` — tes PHPUnit (via `php artisan test`).
- `./vendor/bin/pint` — format PHP (Laravel Pint).
