# Prompt: generate Filament CRUD (Laravel 13 + PHP 8.4)

**Cara pakai:** salin blok **Prompt pengguna** ke AI; ganti `[...]`; lampirkan (`@`) hanya file yang perlu.

---

## Prompt pengguna

```text
Konteks proyek: HRIS Admin — Laravel 13 / PHP 8.4 / Filament 5.x / Sanctum.
Rujuk: CLAUDE.md, snippets/filament-snippet.md, snippets/laravel-snippet.md.

Tugas: Generate Filament CRUD untuk [Team / Project / Entity] dengan spesifikasi:

1. Model & Migration:
   - Model: [NamaModel] dengan table [nama_tabel]
   - Fields: [...]
   - Relasi: [detail relasi]

2. Filament Resource:
   - Letak: app/Filament/Admin/Resources/{Domain}/{Nama}Resource.php
   - Wajib pakai struktur folder: Schemas/, Tables/, Pages/
   - form() method: parameter Schema (BUKAN Form)
   - navigationGroup: 'Time Tracker' (atau sesuai domain)

3. Laravel 13 + PHP 8.4 WAJIB:
   - Semua properti model pakai tipe PHP (array, string, int, dll.)
   - Nullable fields: nullable type hint, contoh: `public ?string $startedAt = null`
   - Migration: foreign key ke tabel `user` (bukan `users`) via `constrained('user')`
   - `HasFactory` opsional (hanya jika factory dibutuhkan)
   - `$fillable` gunakan: `protected array $fillable = [...]`
   - `casts()` gunakan method, bukan properti
   - Jangan gunakan dynamic properties
   - Jangan gunakan `env()` di luar file config
   - Gunakan `list<type>` di phpDoc untuk array typed, contoh: `/** @var list<string> */`

4. Filament 5.x WAJIB:
   - Import: `Filament\Schemas\Schema` (BUKAN `Filament\Forms\Form`)
   - Import form components: `Filament\Forms\Components\TextInput|Select|...`
   - Import table: `Filament\Tables\Table`
   - Form components di `Schemas/*Form.php` method static `configure(Schema $schema)`
   - Table di `Tables/*Table.php` method static `configure(Table $table)`
   - Record actions: pakai `$table->recordActions([...])` BUKAN `$table->actions()`
   - Select relasi: pakai `->relationship('relasi', 'kolom')`
   - Select options: pakai `->options(fn(): array => Model::pluck(...)->toArray())`

Lampirkan @ hanya: [file sejenis di repo untuk acuan gaya kode]

Output:
1. Semua file code (Model, Migration, Resource, Schemas, Tables, Pages)
2. Perintah migrasi: php artisan migrate
3. Jangan buat test, factory, atau seeder kecuali diminta
```

---

## Catatan

- ❌ Jangan generate `php artisan make:model` output — tulis manual.
- ❌ Jangan generate language file — pakai string inline.
- ✅ Ikuti persis pola `app/Filament/Admin/Resources/Settings/Teams/` untuk Resource.
- ✅ Tabel user = `user` (singular), foreign key = `constrained('user')`.
- ✅ Semua kode PHP 8.4: tipe ketat, nullable eksplisit, `list<T>` array.
