# Payments — ERD

| | |
|---|---|
| **Plugin** | `payments` |
| **Namespace** | `Sinno\Payment` |
| **Tipe** | Installable |
| **Install** | `php artisan payments:install` |
| **Dependensi** | accounts |

## Tabel

| Tabel | Keterangan |
|-------|------------|
| `payments_payment_methods` | Metode pembayaran gateway |
| `payments_payment_tokens` | Token kartu tersimpan |
| `payments_payment_transactions` | Transaksi pembayaran |

> Pembayaran invoice di jurnal menggunakan `accounts_account_payments` (lihat [accounts](./accounts.md)).

## Diagram

```mermaid
erDiagram
    payments_payment_methods {
        bigint id PK
        string name
        string code
    }
    payments_payment_tokens {
        bigint id PK
        bigint partner_id FK
        string provider_ref
    }
    payments_payment_transactions {
        bigint id PK
        bigint payment_method_id FK
        decimal amount
        string state
    }
    partners_partners ||--o{ payments_payment_tokens : stores
    payments_payment_methods ||--o{ payments_payment_transactions : uses
```

---

[← Indeks](./README.md)
