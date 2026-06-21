# Attendance Core & Mobile API

## Ringkasan
Engine persensi untuk check-in/check-out dengan mode kerja, geofence, dan evaluasi kepatuhan harian.

## Domain Data

- `attendance_policies`
- `attendance_sites`
- `attendance_days`
- `attendance_punches`

## Fitur Inti

- Mode kerja: WFO, WFH, WFA
- Deteksi telat, kurang jam, MIA
- Face match metadata dan geofence result
- Finalisasi hari absensi

## API Mobile (Sanctum)

- Auth: login/logout
- Attendance:
  - `GET /api/v1/attendance/today`
  - `POST /api/v1/attendance/punch`
- Profile:
  - `GET /api/v1/me`

## Command

- `attendance:finalize-days`
