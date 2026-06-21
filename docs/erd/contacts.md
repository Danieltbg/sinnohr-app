# Contacts — ERD

| | |
|---|---|
| **Plugin** | `contacts` |
| **Namespace** | `Sinno\Contact` |
| **Tipe** | Installable |
| **Install** | `php artisan contacts:install` |

## Tabel

Plugin **contacts** tidak memiliki tabel migrasi terpisah. Memperluas [partners](./partners.md):

- Filter `partners_partners` by `account_type` (customer/vendor/contact)
- Child contacts via `parent_id` hierarchy
- Filament resources khusus untuk manajemen kontak

## Diagram

Lihat [partners.md](./partners.md).

## Fungsi

| Fitur | Implementasi |
|-------|--------------|
| Customer contacts | `parent_id` → company partner |
| Tags | `partners_tags` |
| Addresses | `partners` address fields / related |

---

[← Indeks](./README.md)
