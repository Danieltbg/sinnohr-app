# Security — ERD

| | |
|---|---|
| **Plugin** | `security` |
| **Namespace** | `Sinno\Security` |
| **Tipe** | Core |
| **Guard** | `web` (admin users) |

## Tabel Plugin

| Tabel | Keterangan |
|-------|------------|
| `users` | Admin users (auth produksi) |
| `teams` | Tim internal |
| `user_team` | Pivot user ↔ team |
| `user_invitations` | Undangan user baru |

## Tabel Spatie Permission (shared)

| Tabel | Keterangan |
|-------|------------|
| `roles` | Peran RBAC |
| `permissions` | Izin granular |
| `model_has_roles` | User ↔ Role |
| `model_has_permissions` | User ↔ Permission |
| `role_has_permissions` | Role ↔ Permission |

## Tabel Sanctum

| Tabel | Keterangan |
|-------|------------|
| `personal_access_tokens` | API Bearer tokens |

## Diagram

```mermaid
erDiagram
    users {
        bigint id PK
        string email UK
        bigint company_id FK
        bigint partner_id FK
        string language
    }
    teams {
        bigint id PK
        string name
        bigint company_id FK
    }
    roles {
        bigint id PK
        string name
        string guard_name
    }
    permissions {
        bigint id PK
        string name
    }
    companies ||--o{ users : employs
    companies ||--o{ teams : has
    users ||--o{ user_team : member
    teams ||--o{ user_team : has
    users ||--o{ model_has_roles : has
    roles ||--o{ model_has_roles : assigned
    roles ||--o{ role_has_permissions : grants
    permissions ||--o{ role_has_permissions : in
    users ||--o{ personal_access_tokens : API
```

## Relasi ke Plugin Lain

| FK | Ke |
|----|-----|
| `users.company_id` | `companies` (support) |
| `users.partner_id` | `partners_partners` (opsional) |

---

[← Indeks](./README.md)
