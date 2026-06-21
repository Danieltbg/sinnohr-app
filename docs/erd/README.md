# SinnoERP — ERD per Plugin

Entity-Relationship Diagram dipisah **satu file per modul/plugin**.

## Konvensi

| Item | Keterangan |
|------|------------|
| Prefix tabel | `{plugin}_{entity}` — contoh `sales_orders` |
| Core plugin | Migrasi selalu dimuat (`isCore()`) |
| Installable | Migrasi dimuat setelah `php artisan {plugin}:install` |
| Polymorphic | `*_type` + `*_id` (Chatter, Custom Fields) |

## Indeks Plugin

### Core

| Plugin | File | Tabel |
|--------|------|-------|
| Plugin Manager | [plugin-manager.md](./plugin-manager.md) | 2 |
| Security | [security.md](./security.md) | users, teams, RBAC |
| Support | [support.md](./support.md) | companies, currencies, UOM, UTM, activity |
| Fields | [fields.md](./fields.md) | 1 |
| Chatter | [chatter.md](./chatter.md) | 3 |
| Analytics | [analytics.md](./analytics.md) | 1 |
| Partners | [partners.md](./partners.md) | 6 |
| Table Views | [table-views.md](./table-views.md) | 1 |
| Full Calendar | [full-calendar.md](./full-calendar.md) | — (widget) |

### Financial

| Plugin | File | Dependensi |
|--------|------|------------|
| Products | [products.md](./products.md) | — |
| Accounts | [accounts.md](./accounts.md) | products |
| Accounting | [accounting.md](./accounting.md) | accounts (UI) |
| Invoices | [invoices.md](./invoices.md) | accounts (UI) |
| Payments | [payments.md](./payments.md) | accounts |

### Operations

| Plugin | File | Dependensi |
|--------|------|------------|
| Sales | [sales.md](./sales.md) | invoices, payments |
| Purchases | [purchases.md](./purchases.md) | invoices |
| Inventories | [inventories.md](./inventories.md) | products |
| Manufacturing | [manufacturing.md](./manufacturing.md) | products, inventories |

### Human Resources

| Plugin | File | Dependensi |
|--------|------|------------|
| Employees | [employees.md](./employees.md) | — |
| Recruitments | [recruitments.md](./recruitments.md) | employees |
| Time-off | [time-off.md](./time-off.md) | employees |
| Timesheets | [timesheets.md](./timesheets.md) | projects |

### Other

| Plugin | File | Dependensi |
|--------|------|------------|
| Projects | [projects.md](./projects.md) | — |
| Contacts | [contacts.md](./contacts.md) | partners |
| Website | [website.md](./website.md) | — |
| Blogs | [blogs.md](./blogs.md) | website |
| Maintenance | [maintenance.md](./maintenance.md) | — |

### Integrasi

| Dokumen | Isi |
|---------|-----|
| [cross-plugin.md](./cross-plugin.md) | Relasi FK lintas modul + dependency graph |

---

[Lihat Business Flows →](../BUSINESS-FLOWS.md) · [Architecture →](../ARCHITECTURE.md)
