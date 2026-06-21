# Prompt: backend (Laravel / API / Services)

**Cara pakai:** salin blok **Prompt pengguna** ke Cursor; ganti `[...]`; lampirkan (`@`) hanya file yang perlu, jangan seluruh repo.

---

## Prompt pengguna

```text
Konteks proyek: HRIS Admin — Laravel 13, Filament, Sanctum. Rujuk repo: CLAUDE.md, context/system-context.md, context/api-standard.md (jika API).

Tugas: [JELASKAN SATU KALIMAT: endpoint baru / service / model / migrasi / policy]

Batasan:
- Jangan refactor di luar scope tugas.
- Ikuti pola file yang sudah ada di path setara (sebutkan @path jika sudah tahu).
- Logika non-trivial taruh di app/Services/<Area>/ bila sudah ada pola serupa.

Lampirkan @ hanya: [FILE PENTING, mis. routes/api.php, controller target, model]

Yang saya harapkan sebagai output:
1. Ringkasan perubahan (bullet, singkat).
2. Diff / kode per file.
3. Perintah verifikasi: composer test (dan pint jika banyak PHP berubah).

Jangan tempel ulang isi panjang dari docs/08-core-domains/; baca file domain di repo bila perlu.
```

---

## Catatan hemat token

- Satu chat = satu tugas backend.
- Sebut **satu resource atau controller contoh** sebagai acuan gaya, bukan “baca semua Filament”.
