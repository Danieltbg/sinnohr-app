# Time-off — ERD

| | |
|---|---|
| **Plugin** | `time-off` |
| **Namespace** | `Sinno\TimeOff` |
| **Tipe** | Installable |
| **Install** | `php artisan time-off:install` |
| **Dependensi** | employees |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `time_off_leave_types` | Tipe cuti |
| `time_off_leaves` | Permintaan cuti |
| `time_off_user_leave_types` | Allocasi per user |
| `time_off_leave_mandatory_days` | Hari wajib libur |
| `time_off_leave_accrual_plans` | Rencana akrual |
| `time_off_leave_accrual_levels` | Level akrual |
| `time_off_leave_allocations` | Alokasi hari cuti |

## Diagram

```mermaid
erDiagram
    time_off_leave_types ||--o{ time_off_leaves : type
    employees_employees ||--o{ time_off_leaves : requests
    time_off_leave_accrual_plans ||--|{ time_off_leave_accrual_levels : levels
    time_off_leave_allocations {
        bigint id PK
        bigint employee_id FK
        bigint leave_type_id FK
        decimal number_of_days
    }
    time_off_leaves {
        bigint id PK
        date date_from
        date date_to
        string state
    }
```

## Relasi ke Plugin Lain

| Modul | Relasi |
|-------|--------|
| employees | `employee_id`, work calendars |
| support | `calendar_leaves` integration |

---

[← Indeks](./README.md)
