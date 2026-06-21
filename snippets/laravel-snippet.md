# Snippet — Laravel (HRIS Admin) — Laravel 13 + PHP 8.4

Purpose:

- Quick Laravel reference for Cursor AI
- Reduce repetitive command explanation
- Preserve Laravel project conventions
- Standardize development workflow

---

# Project Stack

Framework:

```txt
Laravel 13 + PHP 8.4+
Filament 5.x (Filament v3)
PostgreSQL (via pgsql)
Sanctum (API auth)
Redis (queue/cache)
```

---

# Laravel 13 — Perubahan Penting

| Area | Detail |
|------|--------|
| PHP minimal | **PHP 8.4** → semua properti wajib tipe, nullable eksplisit, `#[\Override]` attribute tersedia |
| Model `casts()` | Gunakan metode `casts()` return array → **jangan** properti `$casts` |
| Migration | Sama seperti Laravel 11 → `foreignId()->constrained('table')` standar |
| Schedule | Laravel 13 masih pakai `schedule()` di `bootstrap/app.php` |
| SQLite | Mode WAL aktif default untuk testing |
| `make:model` | `php artisan make:model Nama -m` masih berlaku |
| `HasFactory` | Tetap di `Database\Factories\NamaFactory` secara konvensi |
| Eloquent | API 100% backward-compatible dengan Laravel 11 |
| SoftDeletes | Import: `use Illuminate\Database\Eloquent\SoftDeletes` |
| `$fillable` | Gunakan `list<string>` type hint: `protected array $fillable = ['field']` |
| Pivot table | `Schema::create('team_user', ...)` konvensi alphabetical |
| Enum | `app/Enums/` — gunakan PHP 8.4 native backed enums |

---

# Migrasi — Foreign Key ke Tabel `user`

⚠️ Tabel User di proyek ini adalah `user` (bukan `users`):

```php
$table->foreignId('leader_id')->constrained('user');
$table->foreignId('user_id')->constrained('user');
```

Pivot `team_user`:

```php
Schema::create('team_user', function (Blueprint $table) {
    $table->foreignId('team_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained('user')->cascadeOnDelete();
    $table->timestamps();
    $table->primary(['team_id', 'user_id']);
});
```

---

# Model Conventions

```php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    protected array $fillable = ['name', 'leader_id'];

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user')->withTimestamps();
    }
}
```

---

# Routes

| Prefix | Middleware | File |
|--------|-----------|------|
| `/admin` | `web`, `auth:admin` | Auto oleh Filament |
| `/api` | `api`, `employee.api` | `routes/api.php` |

Gunakan route **Filament Resource** untuk CRUD admin. Jangan tambah route manual.
