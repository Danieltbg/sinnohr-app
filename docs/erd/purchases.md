# Purchases — ERD

| | |
|---|---|
| **Plugin** | `purchases` |
| **Namespace** | `Sinno\Purchase` |
| **Tipe** | Installable |
| **Install** | `php artisan purchases:install` |
| **Dependensi** | invoices |
| **Manager** | `PurchaseOrder` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `purchases_orders` | Purchase Order |
| `purchases_order_lines` | Baris PO |
| `purchases_order_line_taxes` | Pajak per line |
| `purchases_order_groups` | Grup PO |
| `purchases_requisitions` | RFQ / Requisition |
| `purchases_requisition_lines` | Baris requisition |
| `purchases_order_account_moves` | Pivot PO ↔ vendor bill |
| `purchases_order_operations` | Pivot PO ↔ receipt operation |
| `purchases_order_line_moves` | Pivot line ↔ inventory move |

## Diagram

```mermaid
erDiagram
    purchases_requisitions ||--|{ purchases_requisition_lines : lines
    purchases_orders {
        bigint id PK
        string name
        string state
        bigint partner_id FK
        decimal amount_total
    }
    purchases_order_lines {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        decimal qty_received
    }
    purchases_orders ||--|{ purchases_order_lines : contains
    partners_partners ||--o{ purchases_orders : vendor
    products_products ||--o{ purchases_order_lines : product
    purchases_orders ||--o{ inventories_operations : receipts
```

## Relasi ke Plugin Lain

| Modul | Relasi |
|-------|--------|
| inventories | Receipt operations & moves |
| accounts | Vendor bills via pivot |

---

[← Indeks](./README.md)
