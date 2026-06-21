# Leave, Permission & Workforce Continuity

## Ringkasan
Modul cuti/izin terstruktur dengan dukungan availability planning dan kontinuitas operasional.

## Leave

- Tipe cuti: annual, sick, unpaid, other
- Half-day (`is_half_day_start`, `is_half_day_end`)
- Urgent leave (`is_urgent`)
- Perhitungan durasi (`requested_days`)
- Sick notice (`sick_notice_submitted_at`)

## Leave Balance

- Tabel: `leave_balances`
- Ledger: `leave_accrual_ledgers`
- Service: `LeaveBalanceService`
- Endpoint:
  - `GET /api/v1/leaves/balances`

## Permission

- Tipe izin: late, wfh, wfa
- Urgent permission
- Sick notice permission (`is_sick_notice`, `medical_reference`)

## Workforce Continuity

- Backup PIC (`backup_pic_employee_id`)
- Handover note (`handover_note`)
- Escalation mapping (`escalation_to_user_id`)
