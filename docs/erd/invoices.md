# Invoices — ERD

| | |
|---|---|
| **Plugin** | `invoices` |
| **Namespace** | `Sinno\Invoice` |
| **Tipe** | Installable (UI layer) |
| **Install** | `php artisan invoices:install` |
| **Dependensi** | accounts |

## Tabel

Tidak ada prefix `invoices_*` untuk transaksi utama — menggunakan tabel **accounts**:

| Tabel accounts | Dipakai sebagai |
|----------------|-----------------|
| `accounts_account_moves` | Customer invoice, vendor bill |
| `accounts_account_move_lines` | Line items |

Plugin invoices menyediakan Filament resources/clusters yang disederhanakan untuk customer & vendor invoicing.

## Diagram

Sama dengan [accounts.md](./accounts.md) — fokus `move_type` = `out_invoice`, `in_invoice`.

## Relasi ke Plugin Lain

| Modul | Pivot / FK |
|-------|------------|
| sales | `sales_order_invoices` |
| purchases | `purchases_order_account_moves` |

---

[← Indeks](./README.md)
