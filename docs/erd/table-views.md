# Table Views — ERD

| | |
|---|---|
| **Plugin** | `table-views` |
| **Namespace** | `Sinno\TableViews` |
| **Tipe** | Core |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `table_view_favorites` | Filter & kolom tersimpan per user per resource |

## Diagram

```mermaid
erDiagram
    table_view_favorites {
        bigint id PK
        bigint user_id FK
        string resource
        json filters
        json columns
        string name
    }
    users ||--o{ table_view_favorites : saves
```

---

[← Indeks](./README.md)
