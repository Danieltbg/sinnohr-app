# Workforce Availability & Coverage

## Ringkasan
Kontrol ketersediaan SDM dan kecukupan tenaga kerja untuk kebutuhan operasional HR.

## Data Kebutuhan Harian

- Tabel: `workforce_requirements`
- Resource admin:
  - `WorkforceRequirementResource`
- Input per:
  - tanggal
  - unit organisasi (opsional)
  - role/jabatan (opsional)
  - required headcount

## Coverage Control (Current)

- Widget: `WorkforceCoverageByDayWidget`
- Perhitungan:
  - available = active employee - approved leave - approved permission
  - gap = available - required
  - status:
    - Understaffed
    - Optimal
    - Overstaffed

## Coverage Forecast (Next Week)

- Widget: `CoverageForecastNextWeekWidget`
- Digunakan untuk:
  - hiring plan
  - shift adjustment
  - resource balancing

## Catatan

- Widget coverage sudah memiliki fallback aman bila tabel belum termigrasi (tidak crash, data kosong).
