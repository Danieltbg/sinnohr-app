# Accounting — ERD

| | |
|---|---|
| **Plugin** | `accounting` |
| **Namespace** | `Sinno\Accounting` |
| **Tipe** | Installable (UI layer) |
| **Install** | `php artisan accounting:install` |
| **Dependensi** | accounts |

## Tabel

Plugin **accounting** tidak memiliki migrasi tabel sendiri. Menggunakan seluruh skema [accounts](./accounts.md) dengan Filament Clusters untuk:

- Reporting (Aged Receivable/Payable)
- Dashboard overview
- Vendor/Customer simplified views

## Model Alias

Beberapa model di `Sinno\Accounting\Models\` mem-extend atau wrap model accounts untuk keperluan UI.

## Diagram

Lihat [accounts.md](./accounts.md) dan [cross-plugin.md](./cross-plugin.md).

---

[← Indeks](./README.md)
