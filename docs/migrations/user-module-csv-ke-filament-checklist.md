# Checklist migrasi bertahap: modul CSV → Filament (HRIS Admin)

Dokumen ini memetakan baris `user_module_structure.csv` ke pekerjaan **Laravel + Filament v5** di repo ini. Centang `- [ ]` → `- [x]` saat selesai.

**Prasyarat teknik:**

- Migrasi DB + factory/seed konsisten dengan pola existing (`employees`, `organization_units`, …).
- Resource Filament ikuti pola `app/Filament/Admin/Resources/<Nama>/<Nama>Resource.php`.
- Setelah setiap fase besar: `./vendor/bin/pint` dan `composer test`; tambahkan tes akses/policy bila sensitif.

**Urutan umum tiap fitur baru:** model + migrasi → relasi di `Employee` jika perlu → policy → Resource (form/table) → navigation group → (opsional) API v1.

---

## Fase 0 — Landasan & keputusan

- [ ] **Menyelaraskan CSV dengan domain** — rujuk `docs/08-core-domains/` (mis. identitas karyawan, growth passport) agar nama field tidak bentrok dengan visi produk.
- [ ] **Strategi path** — CSV memakai path REST (`/subscriber`, `/role`). Di Filament, path = resource slug di panel **`/admin`**, bukan copy 1:1 URL CSV kecuali API publik diputuskan sama.
- [ ] **RBAC:** putuskan apakah mengganti `User.role` string dengan `roles` + `permissions` (Spatie atau tabel sendiri); ini mempengaruhi fase Login & Role.
- [ ] **Dokumentasikan di** `context/project-memory.md` — tanggal keputusan + pilihan RBAC & penamaan modul.

---

## Fase 1 — Otentikasi (baris CSV: Login)

| Item | Checklist |
|------|-----------|
| Login web admin (sudah ada Filament) | - [x] *(existing)* |
| API mobile: token Sanctum | - [x] *(existing `POST /api/v1/auth/login`)* |
| Refresh token (jika wajib parity dengan CSV) | - [ ] Rancang alur (token rotation / refresh route) + migrasi `personal_access_tokens` atau tabel refresh |
| Logout / revoke | - [x] *(existing `POST /api/v1/auth/logout`)* |
| Lupa / reset / ganti password (user self-service) | - [ ] Samakan dengan kebijakan: email reset Filament atau API khusus mobile |

---

## Fase 2 — Organisasi & master minimal (CSV: Organization, Master position)

| Item | Checklist |
|------|-----------|
| Unit organisasi | - [x] *(`OrganizationUnitResource`)* |
| Master posisi / jabatan | - [x] *(`JobPositionResource`)* |
| Halaman/info “About organisasi” (jika diperlukan parity) | - [ ] Filament Page atau field extended di `OrganizationUnit` |

---

## Fase 3 — Pengguna & karyawan inti (CSV: subscriber/user ringkas tanpa device/FCM dulu)

Fokus: CRUD akun yang terhubung karyawan, tanpa langsung ticketing/subscriber kompleks.

| Item | Checklist |
|------|-----------|
| User + Employee satu alur onboarding | - [ ] Audit & rapikan `EmployeeResource` + pembuatan `User` (factory/seed sudah ada pola) |
| Aktivasi / nonaktif user | - [ ] Field + policy (mis. `is_active` atau gunakan `employment_status`) |
| Persetujuan struktur organisasi / ticketing (parity CSV “approval … organisasi”) | - [ ] Spesifikasi alur tiket atau gunakan Approval di Filament Actions + log |
| **Device / unlink / status / FCM** | - [ ] Tabel device + Resource atau relasi dari `User` + job notifikasi (fase bisa di-split) |

*Catatan CSV “subscriber” besar — pecah menjadi Fase 3a (profil akun), 3b (device/FCM), 3c (workflow approval struktur org).*

---

## Fase 4 — Approval manager (CSV: Approval manager)

| Item | Checklist |
|------|-----------|
| Approval cuti | - [x] *(`LeaveApprovalResource`)* |
| Approval izin | - [x] *(`PermissionApprovalResource`)* |
| Satu “dashboard approval” terpusat (opsional) | - [ ] `Filament\Pages\Page` dengan widget ringkasan + deep link ke resource |

---

## Fase 5 — Role, menu, serah terima (CSV: Role & menu, Serah terima role)

| Item | Checklist |
|------|-----------|
| CRUD Role (bukan hanya enum string) | - [ ] Model `Role` + pivot `user_role` atau paket Spatie |
| Assignment role ke User | - [ ] Form di `User` resource atau Resource `UserManagement` |
| Menu dinamis berdasarkan role | - [ ] `->navigationItems()` conditional / Filament Shield / policy per resource |
| Serah terima role (`/role-handover`) | - [ ] Model + workflow + Resource `RoleHandover` + notifikasi; extend `UserRoleAuditLog` jika perlu |

---

## Fase 6 — Profil karyawan lanjutan (CSV: information, type, dll.)

Kerja **per issue** — satu merge request utama per blok di bawah. Nomor `#F6-xxx` hanya untuk rujukan dokumen ini (samakan dengan ID tiket GitLab/GitHub Anda).

### Urutan dependensi (ringkas)

```text
F6-E01 (profil MBTI/tipe)
    → F6-M01–M03 (master pendidikan) [wajib sebelum RelationManager Pendidikan jika pakai FK]
    → F6-RM01 Pendidikan
F6-M04 Skill, F6-M05 Kompetensi
    → F6-RM04 Expertise   → bisa paralel RM02, RM03
    → F6-RM05 Kompetensi karyawan
F6-RM02, F6-RM03, F6-RM06, F6-RM07 → independen secara data (parallel antar tim jika pola sama)
```

### Blocker bersama tiap RelationManager issue

Tiap tiket **`F6-RMxx`** mencakup: migrasi model + FK `employee_id` + factory + policy + **`RelationManager`** terdaftar di `EmployeeResource` + baris tes akses Filament (opsional mengikuti `FilamentAdminAccessTest`). Centang kotak `- [ ]` di sub-checklist tiket Anda.

---

### Issue `#F6-E01` — Perluasan profil karyawan (bukan RelationManager): MBTI & tipe

**Judul tiket disarankan:** `[Fase 6] Employee: kolom MBTI + master & assignment tipe karyawan`

- [ ] Migrasi: kolom MBTI (`employee` atau `employee_profiles`).
- [ ] Migrasi: `employee_types` + `employees.employee_type_id` (nullable).
- [ ] Filament: field di form `EmployeeResource` atau tab “Profil”; Resource master **`EmployeeTypeResource`** (bisa satu MR dengan blok ini atau dipisah `F6-M00`).
- [ ] Factory + seed demo.

---

### Issue `#F6-M01` — Master jenjang pendidikan

**Judul tiket:** `[Fase 6][Master] CRUD Education Level (jenjang)`

- [ ] Model + migrasi `education_levels`.
- [ ] `EducationLevelResource` (disarankan `Admin/Resources/Masters/EducationLevels/`).

---

### Issue `#F6-M02` — Master jurusan

**Judul tiket:** `[Fase 6][Master] CRUD Education Major (jurusan)`

- [ ] Model + migrasi `education_majors` (+ FK opsional ke level jika perlu).
- [ ] `EducationMajorResource`.

---

### Issue `#F6-M03` — Master institusi

**Judul tiket:** `[Fase 6][Master] CRUD Education Institution (institusi)`

- [ ] Model + migrasi `education_institutions`.
- [ ] `EducationInstitutionResource`.

---

### Issue `#F6-RM01` — RelationManager: Riwayat pendidikan

**Judul tiket:** `[Fase 6][RM] Employee → Pendidikan (RelationManager)`

**Bergantung pada:** `#F6-M01`–`#F6-M03` jika dropdown memakai FK (boleh seeded minimal dulu).

- [ ] Model `EmployeeEducation` + migrasi (+ FK optional ke level/major/institution).
- [ ] `EmployeeEducationRelationManager` + daftar di `EmployeeResource`.
- [ ] Form: tanggal mulai/selesai, gelar, pakai Select relasi master.

---

### Issue `#F6-RM02` — RelationManager: Pengalaman kerja

**Judul tiket:** `[Fase 6][RM] Employee → Pengalaman kerja`

- [ ] Model `EmployeeWorkExperience` + migrasi.
- [ ] `EmployeeWorkExperienceRelationManager`.

---

### Issue `#F6-RM03` — RelationManager: Proyek

**Judul tiket:** `[Fase 6][RM] Employee → Proyek`

- [ ] Model `EmployeeProject` + migrasi.
- [ ] `EmployeeProjectRelationManager`.

---

### Issue `#F6-M04` — Master skill

**Judul tiket:** `[Fase 6][Master] CRUD Skill`

**Bergantung pada:** sebelum **`#F6-RM04`** jika expertise memakai FK ke skill.

- [ ] Model `skills` + migrasi.
- [ ] `SkillResource`.

---

### Issue `#F6-M05` — Master kompetensi

**Judul tiket:** `[Fase 6][Master] CRUD Kompetensi (referensi)`

**Bergantung pada:** sebelum **`#F6-RM05`**.

- [ ] Model `competencies` + migrasi.
- [ ] `CompetencyResource`.

---

### Issue `#F6-RM04` — RelationManager: Keahlian / expertise

**Judul tiket:** `[Fase 6][RM] Employee → Expertise (bulk + filter tipe)`

- [ ] Model pivot atau `EmployeeExpertise` + migrasi (+ `skill_id` atau `type` enum).
- [ ] RelationManager dengan table + filter kolom “tipe”; opsi AttachAction bulk kalau pola Filament mendukung.
- [ ] **Bergantung pada:** `#F6-M04` jika ada FK skill.

---

### Issue `#F6-RM05` — RelationManager: Kompetensi per karyawan

**Judul tiket:** `[Fase 6][RM] Employee → Mapping kompetensi`

- [ ] Model `EmployeeCompetency` (mis. competency_id, level, acquired_at).
- [ ] RelationManager (+ form simpan banyak baris atau repeater dalam Filament sesuai UX).
- [ ] **Bergantung pada:** `#F6-M05`.

---

### Issue `#F6-RM06` — RelationManager atau subset dokumen: Sertifikat

**Judul tiket:** `[Fase 6][RM] Employee → Sertifikat`

- [ ] Putuskan: `EmployeeCertificate` baru **atau** perluasan `EmployeeDocument` + enum `document_type = certificate`.
- [ ] Migrasi + RelationManager atau kategori filter pada dokumen yang ada.
- [ ] Kolom penting: nomor, penerbit, valid_from / valid_until, lampiran file.

---

### Issue `#F6-RM07` — RelationManager: Prestasi

**Judul tiket:** `[Fase 6][RM] Employee → Prestasi`

- [ ] Model `EmployeeAchievement` + migrasi.
- [ ] `EmployeeAchievementRelationManager`.

---

### Ringkasan judul tiket (copy-paste backlog)

| ID doc | Judul |
|--------|--------|
| F6-E01 | `[Fase 6] Employee: kolom MBTI + master & assignment tipe karyawan` |
| F6-M01 | `[Fase 6][Master] CRUD Education Level (jenjang)` |
| F6-M02 | `[Fase 6][Master] CRUD Education Major (jurusan)` |
| F6-M03 | `[Fase 6][Master] CRUD Education Institution (institusi)` |
| F6-RM01 | `[Fase 6][RM] Employee → Pendidikan (RelationManager)` |
| F6-RM02 | `[Fase 6][RM] Employee → Pengalaman kerja` |
| F6-RM03 | `[Fase 6][RM] Employee → Proyek` |
| F6-M04 | `[Fase 6][Master] CRUD Skill` |
| F6-RM04 | `[Fase 6][RM] Employee → Expertise (bulk + filter tipe)` |
| F6-M05 | `[Fase 6][Master] CRUD Kompetensi (referensi)` |
| F6-RM05 | `[Fase 6][RM] Employee → Mapping kompetensi` |
| F6-RM06 | `[Fase 6][RM] Employee → Sertifikat` |
| F6-RM07 | `[Fase 6][RM] Employee → Prestasi` |

**Definition of Done fase 6:** semua `F6-RMxx` tersemat di `EmployeeResource` dan tes/regresi lulus; master `F6-Mxx` tersedia untuk referensi dropdown.

---

## Fase 7 — Unggah berkas (CSV: Upload)

| Item | Checklist |
|------|-----------|
| Kebijakan storage (S3/local) + validasi mime/size | - [ ] `config/filesystems.php` + Form `FileUpload` |
| Resource atau action terpusat “upload” | - [ ] Jika parity `/upload`: Service + (opsional) API; di Filament cukup `FileUpload` per entitas |
| Versi `/upload/v2` (mis. chunked/presigned) | - [ ] Hanya jika ada requirement mobile/backward compatibility |

---

## Fase 8 — Dropdown agregat (CSV: Dropdown)

| Item | Checklist |
|------|-----------|
| Endpoint internal untuk form Filament | - [ ] Biasanya **tidak perlu** satu `/dropdown`; gunakan Select relationship |
| API mobile/public parity CSV | - [ ] `GET /api/v1/dropdown/...` atau satu controller dengan parameter `keys[]` |
| Mapping: roles, orgs, locations, positions, competencies, employee-types, wilayah (negara→kelurahan) | - [ ] Resource/API per kategori + caching ringan jika besar |

---

## Fase 9 — Uji regresi, data, go-live

- [ ] Script seed minimal untuk demo modul baru.
- [ ] Tes Feature: akses admin + (jika API baru) tes HTTP.
- [ ] Dokumentasi singkat di `context/api-standard.md` untuk route API baru.
- [ ] Cutover data dari sistem lama (mapping CSV export → impor artisan command).

---

## Quick reference: mapping baris CSV → artefak target

| Area CSV | Artefak utama Filament/ Laravel |
|----------|----------------------------------|
| Login | `MobileAuthController`, config Sanctum, (opsional) refresh route |
| Manajemen user | `User` Resource / `EmployeeResource` tabs, device tables |
| Approval manager | Resources approval + custom Page |
| Role & menu | `Role` model, policies, navigation groups |
| Serah terima role | `RoleHandover` model + Resource |
| Organisasi | `OrganizationUnitResource` (+ Page info) |
| Employee * | RelationManagers + models di bawah `Employee` |
| Master * | `*Resource` di `Admin/Resources/Masters/...` (disarankan subfolder) |
| Upload | Service + FileUpload / API |
| Dropdown | API controller atau Livewire-friendly JSON |

---

*File ini boleh dipecah per tiket: salin satu fase ke issue/merge request agar review tetap kecil.*
