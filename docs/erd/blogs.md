# Blogs — ERD

| | |
|---|---|
| **Plugin** | `blogs` |
| **Namespace** | `Sinno\Blog` |
| **Tipe** | Installable |
| **Install** | `php artisan blogs:install` |
| **Dependensi** | website |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `blogs_categories` | Kategori artikel |
| `blogs_posts` | Posting blog |
| `blogs_tags` | Tag |
| `blogs_post_tags` | Pivot post ↔ tag |

## Diagram

```mermaid
erDiagram
    blogs_categories ||--o{ blogs_posts : categorizes
    blogs_posts {
        bigint id PK
        string title
        bigint category_id FK
        bigint author_id FK
        boolean is_published
        datetime published_at
    }
    blogs_posts }o--o{ blogs_tags : tagged
    users ||--o{ blogs_posts : author
```

## Relasi ke Plugin Lain

| Modul | Relasi |
|-------|--------|
| website | Customer panel display |
| security | `author_id` → users |

---

[← Indeks](./README.md)
