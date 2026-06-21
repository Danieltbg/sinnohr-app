# Projects — ERD

| | |
|---|---|
| **Plugin** | `projects` |
| **Namespace** | `Sinno\Project` |
| **Tipe** | Installable |
| **Install** | `php artisan projects:install` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `projects_projects` | Proyek |
| `projects_project_stages` | Tahap proyek |
| `projects_milestones` | Milestone |
| `projects_tags` | Tag |
| `projects_project_tag` | Pivot proyek ↔ tag |
| `projects_user_project_favorites` | Favorit user |
| `projects_tasks` | Task |
| `projects_task_stages` | Tahap task (kanban) |
| `projects_task_users` | Assignee |
| `projects_task_tag` | Pivot task ↔ tag |

## Diagram

```mermaid
erDiagram
    projects_projects {
        bigint id PK
        string name
        bigint partner_id FK
        bigint user_id FK
    }
    projects_tasks {
        bigint id PK
        bigint project_id FK
        bigint stage_id FK
        bigint parent_id FK
        decimal allocated_hours
        decimal total_hours_spent
    }
    projects_milestones {
        bigint id PK
        bigint project_id FK
    }
    projects_projects ||--|{ projects_tasks : tasks
    projects_tasks ||--o{ projects_tasks : subtasks
    projects_projects ||--o{ projects_milestones : milestones
    partners_partners ||--o{ projects_projects : client
    analytic_records ||--o{ projects_tasks : timesheets
```

## Relasi ke Plugin Lain

| Modul | Relasi |
|-------|--------|
| analytics | `analytic_records` (timesheets) |
| timesheets | UI over analytic_records |
| partners | `partner_id` |

---

[← Indeks](./README.md)
