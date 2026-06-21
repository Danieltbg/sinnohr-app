# Sales — ERD

| | |
|---|---|
| **Plugin** | `sales` |
| **Namespace** | `Sinno\Sale` |
| **Tipe** | Installable |
| **Install** | `php artisan sales:install` |
| **Dependensi** | invoices, payments |
| **Manager** | `SaleManager` |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `sales_orders` | Quotation / Sales Order |
| `sales_order_lines` | Baris order |
| `sales_order_line_taxes` | Pajak per line |
| `sales_tags` | Tag |
| `sales_order_tags` | Pivot order ↔ tag |
| `sales_teams` | Tim penjualan |
| `sales_team_members` | Anggota tim |
| `sales_order_templates` | Template quotation |
| `sales_order_template_products` | Produk di template |
| `sales_order_options` | Opsi konfigurasi |
| `sales_order_invoices` | Pivot SO ↔ account move |
| `sales_order_line_invoices` | Pivot line ↔ move line |
| `sales_advance_payment_invoices` | Down payment |
| `sales_advance_payment_invoice_order_sales` | Pivot advance |

## Diagram

```mermaid
erDiagram
    sales_orders {
        bigint id PK
        string name
        string state
        string delivery_status
        string invoice_status
        bigint partner_id FK
        bigint warehouse_id FK
        bigint procurement_group_id FK
        decimal amount_total
    }
    sales_order_lines {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        decimal product_uom_qty
        decimal qty_delivered
        decimal qty_invoiced
        decimal price_unit
    }
    sales_orders ||--|{ sales_order_lines : contains
    partners_partners ||--o{ sales_orders : customer
    products_products ||--o{ sales_order_lines : product
    inventories_warehouses ||--o{ sales_orders : ships_from
    inventories_procurement_groups ||--o| sales_orders : procurement
```

## Relasi ke Plugin Lain

| Modul | Relasi |
|-------|--------|
| inventories | `sale_order_id` on operations; procurement on confirm |
| accounts | pivot invoices |
| partners | `partner_id`, `partner_shipping_id` |

---

[← Indeks](./README.md) · [Business Flow](../BUSINESS-FLOWS.md#1-sales-order--konfirmasi-ke-delivery)
