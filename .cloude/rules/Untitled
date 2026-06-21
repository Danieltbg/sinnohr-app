# Pengujian

## Menjalankan tes

- `composer test` (membersihkan config cache lalu `php artisan test`).

## Konvensi

- **Feature:** alur HTTP, panel, API — letakkan di `tests/Feature/`.
- **Unit:** kelas murni, service tanpa HTTP — `tests/Unit/`.
- Gunakan **factories** di `database/factories/` dan migrasi yang ada; hindari basis data production.

## Filament / auth

- Untuk akses admin, ikuti pola tes yang ada (mis. `FilamentAdminAccessTest`) — jangan asumsi guard baru tanpa menyelaraskan dengan aplikasi.

## CI

- Periksa `.gitlab-ci.yml` bila menambah langkah build/test yang relevan.
