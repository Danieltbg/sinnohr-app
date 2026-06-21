# Chatter — ERD

| | |
|---|---|
| **Plugin** | `chatter` |
| **Namespace** | `Sinno\Chatter` |
| **Tipe** | Core |
| **Trait** | `HasChatter`, `HasLogActivity` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `chatter_messages` | Komentar/log pada record |
| `chatter_attachments` | Lampiran pesan |
| `chatter_followers` | Follower record |

## Diagram

```mermaid
erDiagram
    chatter_messages {
        bigint id PK
        string messageable_type
        bigint messageable_id
        text body
        string type
        bigint author_id FK
    }
    chatter_attachments {
        bigint id PK
        bigint message_id FK
        string path
        string name
    }
    chatter_followers {
        bigint id PK
        string followable_type
        bigint followable_id
        bigint partner_id FK
    }
    chatter_messages ||--o{ chatter_attachments : has
```

## Polymorphic Targets (contoh)

`sales_orders`, `accounts_account_moves`, `projects_tasks`, `employees_employees`, `inventories_operations`

---

[← Indeks](./README.md)
