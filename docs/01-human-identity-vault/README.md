# Human Identity Vault

## Ringkasan
Modul master data identitas karyawan untuk kebutuhan administrasi HR dan relasi lintas modul.

## Cakupan

- Data profil karyawan (`employees`)
- Struktur organisasi (`organization_units`)
- Jabatan (`job_positions`)
- Relasi turunan (keluarga, dokumen, eligibility, kontrak, tanggal penting)

## Admin (Filament)

- Resource utama:
  - `EmployeeResource`
  - `OrganizationUnitResource`
  - `JobPositionResource`
- Navigation group: `Human Identity Vault`

## Dampak ke Modul Lain

- Menjadi sumber data untuk:
  - Absensi/persensi
  - Cuti/izin
  - Workforce planning
  - Approval workflow
