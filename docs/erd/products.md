# Products — ERD

| | |
|---|---|
| **Plugin** | `products` |
| **Namespace** | `Sinno\Product` |
| **Tipe** | Installable |
| **Install** | `php artisan products:install` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `products_categories` | Kategori produk |
| `products_products` | Produk (goods/service, variants) |
| `products_tags` | Tag |
| `products_product_tag` | Pivot |
| `products_attributes` | Atribut (size, color) |
| `products_attribute_options` | Opsi atribut |
| `products_product_attributes` | Pivot produk ↔ atribut |
| `products_product_attribute_values` | Nilai atribut per produk |
| `products_packagings` | Kemasan |
| `products_price_rules` | Aturan harga |
| `products_price_rule_items` | Item aturan harga |
| `products_product_suppliers` | Supplier per produk |
| `products_product_price_lists` | Daftar harga |
| `products_product_combinations` | Kombinasi variant |

## Diagram

```mermaid
erDiagram
    products_categories {
        bigint id PK
        string name
        bigint parent_id FK
    }
    products_products {
        bigint id PK
        string name
        string type
        decimal price
        decimal cost
        bigint category_id FK
        bigint uom_id FK
        bigint parent_id FK
        boolean enable_sales
        boolean enable_purchase
    }
    products_attributes {
        bigint id PK
        string name
        string type
    }
    products_attribute_options {
        bigint id PK
        bigint attribute_id FK
        string name
    }
    products_categories ||--o{ products_products : categorizes
    products_products ||--o{ products_products : variants
    products_products }o--o{ products_attributes : has
    products_attributes ||--|{ products_attribute_options : options
```

## Relasi ke Plugin Lain

| Modul | FK |
|-------|-----|
| sales | `sales_order_lines.product_id` |
| purchases | `purchases_order_lines.product_id` |
| inventories | `inventories_moves.product_id` |
| accounts | `accounts_product_taxes` |
| manufacturing | `manufacturing_orders.product_id` |

---

[← Indeks](./README.md)
