# API Standard

## Base Configuration

| Item | Value |
|---|---|
| Base Path | `/api/v1` |
| Route File | `routes/api.php` |
| Format | JSON |
| Authentication | Laravel Sanctum |
| Protected Middleware | `auth:sanctum`, `employee.api` |

---

# Route Structure

## Public Routes

```txt
POST /api/v1/auth/login
POST /api/v1/auth/refresh-token