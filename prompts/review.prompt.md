# Prompt: review kode / PR

**Cara pakai:** lampirkan diff atau `@` file yang direview; sebut branch/PR jika ada. Jangan lampirkan vendor.

---

## Prompt pengguna

```text
Lakukan code review untuk HRIS Admin (Laravel + Filament + Sanctum).

Lingkup perubahan: [RINGKAS / tautkan PR / sebut commit]

Fokus review (urutkan prioritas):
1. Keamanan: mass assignment, SQL, auth API (employee.api), exposure data.
2. Konsistensi dengan pola repo: app/Filament/Admin, app/Services, routes/api.php.
3. Tes: apakah perilaku baru/kritis punya cakupan tests/?
4. Maintainability: ukuran method, duplikasi, naming.

Lampirkan @: [daftar file atau diff; maksimal file yang wajar untuk satu review]

Format output:
- **Ringkasan** (2–4 bullet).
- **Must-fix** (jika ada) + lokasi file:baris jika memungkinkan.
- **Should-fix** / **Nit**.
- **Pertanyaan** ke pengembang (jika ambigu).

Jangan tulis ulang seluruh file tanpa diminta; jangan usulkan rewrite besar tanpa bukti risiko.
```

---

## Catatan hemat token

- Review besar: pecah per area (`@app/Filament/...` lalu `@app/Services/...`) dalam chat terpisah.
- Rujuk `context/coding-style.md` dan `.cursor/rules/security-rules.mdc` sebagai acuan internal tim.
