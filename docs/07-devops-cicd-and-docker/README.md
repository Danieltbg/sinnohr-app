# DevOps, CI/CD & Docker

## GitLab CI

File: `.gitlab-ci.yml`

## Pipeline Ringkas

- Stage: `build`
- Build image Docker
- Push image ke Docker Hub:
  - `popyfebrian/sinnohr-admin-dev:latest`

## Docker

- File: `Dockerfile` (multi-stage)
  - Composer dependencies
  - Node assets build
  - Runtime PHP
- File: `.dockerignore`

## Environment Variables

Saran production:

- simpan secret di GitLab CI/CD Variables, bukan commit `.env`
- contoh penting:
  - `APP_KEY`, `APP_ENV`, `APP_DEBUG`, `APP_URL`
  - `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

## Queue Worker

- Jalankan: `php artisan queue:work`
- Diperlukan untuk job async (mis. export Filament, notifikasi queue jika diaktifkan).
