# Approval Workflows (HR)

## Ringkasan
Alur approval HR untuk izin attendance dan cuti, lengkap dengan notifikasi dan kontrol role approver.

## Permission Approval

- Resource: `PermissionApprovalResource`
- Aksi: approve/reject
- Scope: late, wfh, wfa
- Notifikasi: `PermissionRequestReviewedNotification`

## Leave Approval

- Resource: `LeaveApprovalResource`
- Aksi: approve/reject
- Notifikasi: `LeaveRequestReviewedNotification`
- Aturan saldo annual leave dipotong saat **approve** (bukan saat submit)

## Role & Access

- Role: `admin`, `hr`, `user`
- Approval butuh:
  - role `admin` / `hr`
  - flag `is_hr_approver = true`

## Pengaturan Approver

- Resource: `UserApproverResource`
- Admin bisa set role + `is_hr_approver` via UI
- Auto-promote role user -> hr saat approver diaktifkan
- Audit log auto-promote:
  - tabel `user_role_audit_logs`
  - badge indikator di tabel approver
