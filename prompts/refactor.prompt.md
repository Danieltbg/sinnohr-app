# Prompt: refactor

**Cara pakai:** definisikan **tujuan bisnis/teknis** dan **batas file**; refactor tanpa mengubah perilaku memerlukan tes sebagai jaring pengaman.

---

## Prompt pengguna

```text
Refactor terbatas untuk HRIS Admin (Laravel 13 + Filament).

Tujuan refactor: [mis. ekstrak service, kurangi duplikasi, rename untuk kejelasan]
Lingkup WAJIB: [daftar folder/file dengan @path]
Lingkup DILARANG: [apa yang tidak boleh disentuh]

Syarat:
- Perilaku luaran tetap sama kecuali saya sebutkan perubahan eksplisit.
- Ikuti pola existing; jangan introduksi pola arsitektur baru tanpa alasan.
- Setelah selesai: composer test harus hijau; ./vendor/bin/pint jika banyak PHP.

Sebelum mengubah kode, berikan rencana singkat (bullet, maksimal 8 baris), laku setelah saya konfirmasi dengan "lanjut" ATAU langsung lanjut jika risiko rendah.

Lampirkan @: [file inti yang akan direfactor + test terkait jika ada]
```

---

## Catatan hemat token

- Hindari “refactor seluruh modul” dalam satu prompt; pecah per layanan atau per resource.
- Catat keputusan di `context/project-memory.md` jika refactor mengubah konvensi tim.

---

## Varian cepat (tanpa rencana dua tahap)

Ganti paragraf “Sebelum mengubah…” dengan: `Lanjut langsung; risiko rendah; diff minimal.`
