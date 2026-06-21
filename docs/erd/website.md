# Website — ERD

| | |
|---|---|
| **Plugin** | `website` |
| **Namespace** | `Sinno\Website` |
| **Tipe** | Installable |
| **Install** | `php artisan website:install` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `website_pages` | Halaman CMS customer portal |

## Diagram

```mermaid
erDiagram
    website_pages {
        bigint id PK
        string title
        string slug UK
        text content
        boolean is_published
        bigint website_id FK
    }
```

## Relasi ke Plugin Lain

| Modul | Relasi |
|-------|--------|
| security | Customer guard — `Website\Models\Partner` |
| blogs | Posts published on website |

## Panel

Mendaftarkan routes & pages di **customer** panel (`id: customer`).

---

[← Indeks](./README.md)
