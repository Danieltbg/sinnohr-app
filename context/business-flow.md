# Business Flow

## System Overview

This project separates:

1. HR operational management via Filament admin panel
2. Employee self-service via mobile API

Architecture:

```txt
Admin (Filament)
    ↓
Service Layer
    ↓
Repository Layer
    ↓
Database

Mobile API
    ↓
Sanctum Authentication
    ↓
employee.api Middleware
    ↓
Service Layer