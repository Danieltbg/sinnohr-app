# Prompt: perbaikan bug

**Cara pakai:** salin blok **Prompt pengguna**; isi gejala minimum yang mereproduksi; lampirkan stack trace **ringkas** + file terkait `@`.

---

## Prompt pengguna

```text
Konteks: HRIS Admin (Laravel 13 + Filament + API v1). Rujuk singkat: context/system-context.md bila perlu arsitektur.

Bug:
- Gejala (satu kalimat): [APA YANG USER LIHAT]
- Langkah repro (bullet, maksimal 5): […]
- Lingkungan: [lokal / staging], URL/path: [mis. /admin atau /api/v1/...], user role jika relevan: [admin|hr|api]

Error (tempel HANYA pesan + baris atas trace, bukan 200 baris):
[PASTE RINGKAS]

Hipotesis saya (opsional): […]

Lampirkan @: [controller / Resource / migration / test yang paling dekat]

Mintalah:
1. Diagnosis singkat (akar masalah yang probable).
2. Perbaikan minimal (diff).
3. Tes: tambah atau perbarui test jika ada pola di tests/; jalankan composer test.

Jangan ubah perilaku di luar perbaikan bug kecuali saya minta.
```

---

## Catatan hemat token

- Satu bug satu thread; hindari menggabungkan dua isu.
- Tanpa repro: minta model untuk **menyarankan** log/debug satu titik, bukan menebak seluruh codebase.
