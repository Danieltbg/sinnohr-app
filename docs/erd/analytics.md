# Analytics — ERD

| | |
|---|---|
| **Plugin** | `analytics` |
| **Namespace** | `Sinno\Analytic` |
| **Tipe** | Core |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `analytic_records` | Baris biaya/jam (timesheet, cost allocation) |

## Diagram

```mermaid
erDiagram
    analytic_records {
        bigint id PK
        string name
        decimal unit_amount
        bigint project_id FK
        bigint task_id FK
        bigint user_id FK
        bigint company_id FK
        date date
    }
    projects_projects ||--o{ analytic_records : cost lines
    projects_tasks ||--o{ analytic_records : logged on
    users ||--o{ analytic_records : by user
```

## Relasi ke Plugin Lain

| FK | Ke |
|----|-----|
| `project_id` | [projects](./projects.md) |
| `task_id` | [projects](./projects.md) |
| `user_id` | [security](./security.md) |

Plugin **timesheets** menggunakan tabel ini via `Sinno\Project\Models\Timesheet`.

---

[← Indeks](./README.md)
