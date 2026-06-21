# Partners — ERD

| | |
|---|---|
| **Plugin** | `partners` |
| **Namespace** | `Sinno\Partner` |
| **Tipe** | Core |
| **Install** | Core (selalu aktif) |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `partners_partners` | Customer, vendor, contact (hierarki parent/child) |
| `partners_titles` | Gelar (Mr, Mrs, ...) |
| `partners_industries` | Industri |
| `partners_tags` | Tag partner |
| `partners_partner_tag` | Pivot partner ↔ tag |
| `partners_bank_accounts` | Rekening bank partner |

## Diagram

```mermaid
erDiagram
    partners_partners {
        bigint id PK
        string name
        string email
        string account_type
        bigint parent_id FK
        bigint company_id FK
        bigint country_id FK
        bigint state_id FK
        int customer_rank
        int supplier_rank
    }
    partners_bank_accounts {
        bigint id PK
        bigint partner_id FK
        bigint bank_id FK
        string acc_number
    }
    partners_tags {
        bigint id PK
        string name
    }
    partners_partners ||--o{ partners_partners : parent_child
    partners_partners ||--o{ partners_bank_accounts : banks
    partners_partners }o--o{ partners_tags : tagged
    countries ||--o{ partners_partners : located
```

## Relasi ke Plugin Lain

| Modul | FK |
|-------|-----|
| sales | `sales_orders.partner_id` |
| purchases | `purchases_orders.partner_id` |
| accounts | `accounts_account_moves.partner_id` |
| employees | `employees_employees.partner_id` |
| projects | `projects_projects.partner_id` |
| security | `users.partner_id` |

---

[← Indeks](./README.md)
