# Plugin Manager — ERD

| | |
|---|---|
| **Plugin** | `plugin-manager` |
| **Namespace** | `Sinno\PluginManager` |
| **Tipe** | Core |
| **Model utama** | `Sinno\PluginManager\Models\Plugin` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `plugins` | Metadata & status instalasi setiap modul |
| `plugin_dependencies` | Pivot dependensi antar plugin |

## Diagram

```mermaid
erDiagram
    plugins {
        bigint id PK
        string name UK
        string author
        text summary
        boolean is_active
        boolean is_installed
        int sort
    }
    plugin_dependencies {
        bigint id PK
        bigint plugin_id FK
        bigint dependency_id FK
    }
    plugins ||--o{ plugin_dependencies : depends_on
```

## Relasi ke Plugin Lain

Tidak ada FK ke tabel bisnis — hanya metadata plugin.

---

[← Indeks](./README.md)
