# Snippet — Filament 5.x (HRIS Admin) — Laravel 13 + PHP 8.4

Purpose:

- Quick Filament reference for Cursor AI
- Standardize admin panel implementation
- Reduce repeated Filament explanation
- Preserve existing admin structure

---

# Admin Panel Information

Panel ID: `admin`
Panel path: `/admin`
Panel provider: `App\Providers\Filament\AdminPanelProvider`

---

# Resource Convention

Setiap Resource **wajib** mengikuti struktur folder berikut:

```
app/Filament/Admin/Resources/{Domain}/
├── {Nama}Resource.php
├── Schemas/
│   └── {Nama}Form.php
├── Tables/
│   └── {Nama}Table.php
└── Pages/
    ├── List{Nama}.php
    ├── Create{Nama}.php
    └── Edit{Nama}.php
```

Contoh lihat `app/Filament/Admin/Resources/Settings/Teams/`.

---

# Resource Base (`*Resource.php`)

Gunakan `Filament\Schemas\Schema` (BUKAN `Filament\Forms\Form`) di method `form()`:

```php
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $slug = 'time-tracker/projects';
    protected static ?string $navigationIcon = Heroicon::OutlinedFolder;
    protected static ?string $navigationGroup = 'Time Tracker';

    public static function form(Schema $schema): Schema { ... }
    public static function table(Table $table): Table { ... }
    public static function getPages(): array { ... }
}
```

---

# Form (`Schemas/*Form.php`)

```php
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('name')->required()->maxLength(255),
                Select::make('leader_id')
                    ->label('Leader')
                    ->required()
                    ->options(fn (): array => User::pluck('name', 'id')->toArray())
                    ->searchable(),
                Select::make('members')
                    ->multiple()
                    ->relationship('members', 'name')
                    ->preload()
                    ->searchable(),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
```

---

# Table (`Tables/*Table.php`)

```php
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()
                    ->url(fn ($record): string => TeamResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),
                TextColumn::make('members_count')->label('Members')->counts('members'),
                TextColumn::make('created_at')->dateTime('M j, Y')->sortable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make()->link()->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()->link()->color('danger')->icon(Heroicon::OutlinedTrash),
            ]);
    }
}
```

---

# Pages (`Pages/*.php`)

```php
// List
class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;
    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->icon(Heroicon::OutlinedPlus)];
    }
}

// Create
class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;
}

// Edit
class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;
    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
```

---

# Livewire Component — DB Query

Untuk Livewire Component (bukan Resource page), fetch data langsung di `render()`:

```php
use App\Models\Project;

public function render(): View
{
    $projectNames = Project::pluck('name')->toArray();
    // ...
    return view('livewire.live-time-tracker', [
        'filteredProjects' => $projectNames,
    ]);
}
```

⚠️ Jangan gunakan properti publik array untuk data dari DB — fetch di `render()` agar selalu sinkron.

---

# Navigator

Untuk navigasi group:

```php
protected static ?string $navigationGroup = 'Time Tracker';
```

Ini akan mengelompokkan resource di sidebar admin.

---

# Larangan Filament

- ❌ Jangan pakai `Filament\Forms\Form` — pakai `Filament\Schemas\Schema`
- ❌ Jangan inline form/table di Resource — ekstrak ke `Schemas/*` dan `Tables/*`
- ❌ Jangan override `mount()` di Resource pages tanpa perlu
- ❌ Jangan pakai `$table->actions()` — pakai `$table->recordActions()`
