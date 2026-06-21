# Prompt: frontend (Vite / Tailwind / Blade / aset)

**Cara pakai:** salin blok **Prompt pengguna**; isi `[...]`; lampirkan `@vite.config.js` atau `@resources/...` hanya jika relevan.

---

## Prompt pengguna

```text
Konteks proyek: HRIS Admin — Vite 7, Tailwind 4, entry resources/css/app.css & resources/js/app.js. Admin utama: Filament (bukan Blade custom besar). Rujuk: CLAUDE.md, context/system-context.md.

Tugas: [JELASKAN: ubah aset / styling global / perilaku JS ringan / view Blade tertentu]

Batasan:
- Jangan menambah dependency npm tanpa persetujuan eksplisit.
- UI panel admin: utamakan pola Filament; hindari duplikasi besar dengan Blade kecuali file itu sudah dipakai proyek.

Lampirkan @ hanya: [resources/... atau vite.config.js]

Output:
1. Ringkasan singkat.
2. Perubahan file.
3. npm run build atau npm run dev sesuai kebutuhan verifikasi lokal.
```

---

## Catatan hemat token

- Jangan lampirkan `node_modules` atau `public/build`.
- Untuk tema Filament, sebutkan apakah perubahan di PHP panel provider vs CSS global.
