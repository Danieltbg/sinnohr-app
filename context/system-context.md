# System Context

## Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 |
| PHP Runtime | PHP 8.4 FPM Alpine |
| Admin Panel | Filament 5.5 |
| API Authentication | Laravel Sanctum |
| Frontend Build | Vite 7 + Tailwind 4 |
| Testing | PHPUnit 12 |
| Queue | Redis Queue |
| Cache | Redis |
| Database Dev | SQLite |
| Database Production | PostgreSQL |

---

# Entry Points

## Web Admin

- Route file: `routes/web.php`
- Panel path: `/admin`
- Provider: `AdminPanelProvider`
- Panel ID: `admin`

## API Mobile

- Route file: `routes/api.php`
- Prefix: `/api/v1`
- Middleware:
  - `auth:sanctum`
  - `employee.api`

## Health Check

- `/up`

---

# Core Architecture

Aligned with `docs/ARCHITECTURE.md` — thin `app/` shell + domain modules in `modules/`.

| Layer | Path |
|-------|------|
| Application core | `app/Providers`, `app/Http/Middleware`, Filament panel providers |
| Domain modules | `modules/{Dashboard,Identity}/` — ServiceProvider, Services, Repositories |
| Admin UI (Filament) | `app/Filament/Admin/` — delegates to module services |
| API V1 | `app/Http/Controllers/Api/V1/`, `routes/api/v1.php` |

Request flow:

```txt
Controller / Filament Resource
  ↓
Service (modules/*/Services)
  ↓
Repository (modules/*/Repositories)
  ↓
Model (app/Models)