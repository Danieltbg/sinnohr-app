# Maintenance — ERD

| | |
|---|---|
| **Plugin** | `maintenance` |
| **Namespace** | `Sinno\Maintenance` |
| **Tipe** | Installable |
| **Install** | `php artisan maintenance:install` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `maintenance_equipment_categories` | Kategori equipment |
| `maintenance_equipments` | Aset/equipment |
| `maintenance_stages` | Tahap kanban request |
| `maintenance_teams` | Tim maintenance |
| `maintenance_team_users` | Anggota tim |
| `maintenance_requests` | Permintaan maintenance |

## Diagram

```mermaid
erDiagram
    maintenance_equipment_categories ||--o{ maintenance_equipments : groups
    maintenance_equipments {
        bigint id PK
        string name
        bigint category_id FK
        bigint partner_id FK
    }
    maintenance_teams ||--o{ maintenance_team_users : members
    maintenance_stages ||--o{ maintenance_requests : kanban
    maintenance_equipments ||--o{ maintenance_requests : equipment
    users ||--o{ maintenance_requests : assigned
    maintenance_requests {
        bigint id PK
        string name
        string state
        date schedule_date
    }
```

## Relasi ke Plugin Lain

| Modul | Relasi |
|-------|--------|
| partners | `partner_id` on equipment (vendor) |
| full-calendar | Widget menampilkan `schedule_date` |

---

[← Indeks](./README.md)
