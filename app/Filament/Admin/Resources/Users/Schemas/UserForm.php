<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\EmployeeBadgeEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(3)
                    ->schema([
                        Group::make()
                            ->columnSpan(['lg' => 2])
                            ->schema(self::primaryFields()),
                        Group::make()
                            ->columnSpan(['lg' => 1])
                            ->schema(self::organizationFields()),
                    ])
                    ->columnSpanFull(),
                Tabs::make('employeeTabs')
                    ->tabs([
                        Tab::make('work_information')
                            ->label(__('filament.employees.create.tabs.work_information'))
                            ->icon(Heroicon::OutlinedBriefcase)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                Section::make(__('filament.employees.create.sections.location'))
                                                    ->schema([
                                                        TextInput::make('work_address')
                                                            ->label(__('filament.employees.create.fields.work_address')),
                                                        TextInput::make('work_location')
                                                            ->label(__('filament.employees.create.fields.work_location')),
                                                    ]),
                                                Section::make(__('filament.employees.create.sections.approver'))
                                                    ->schema([
                                                        self::employeeSelect('time_off_approver_id')
                                                            ->label(__('filament.employees.create.fields.time_off'))
                                                            ->hintIcon(Heroicon::OutlinedInformationCircle),
                                                        self::employeeSelect('attendance_manager_id')
                                                            ->label(__('filament.employees.create.fields.attendance_manager'))
                                                            ->hintIcon(Heroicon::OutlinedInformationCircle),
                                                    ]),
                                                Section::make(__('filament.employees.create.sections.schedule'))
                                                    ->schema([
                                                        Select::make('working_hours')
                                                            ->label(__('filament.employees.create.fields.working_hours'))
                                                            ->options(self::workingHoursOptions())
                                                            ->searchable()
                                                            ->hintIcon(Heroicon::OutlinedInformationCircle)
                                                            ->native(false),
                                                        Select::make('timezone')
                                                            ->label(__('filament.employees.create.fields.timezone'))
                                                            ->options(self::timezoneOptions())
                                                            ->default('UTC')
                                                            ->searchable()
                                                            ->hintIcon(Heroicon::OutlinedInformationCircle)
                                                            ->native(false),
                                                    ]),
                                            ]),
                                        Group::make()
                                            ->schema([
                                                Section::make(__('filament.employees.create.sections.organization_details'))
                                                    ->schema([
                                                        TextInput::make('company_name')
                                                            ->label(__('filament.employees.create.fields.company'))
                                                            ->prefixIcon(Heroicon::OutlinedBuildingOffice2),
                                                        TextInput::make('department_note')
                                                            ->label(__('filament.employees.create.fields.dept')),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                        Tab::make('private_information')
                            ->label(__('filament.employees.create.tabs.private_information'))
                            ->icon(Heroicon::OutlinedUser)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('private_email')
                                            ->label(__('filament.employees.create.fields.private_email'))
                                            ->email(),
                                        TextInput::make('private_phone')
                                            ->label(__('filament.employees.create.fields.private_phone'))
                                            ->tel(),
                                        DatePicker::make('birth_date')
                                            ->label(__('filament.employees.create.fields.birth_date'))
                                            ->native(false),
                                        Select::make('gender')
                                            ->label(__('filament.employees.create.fields.gender'))
                                            ->options([
                                                'male' => __('filament.employees.create.gender.male'),
                                                'female' => __('filament.employees.create.gender.female'),
                                                'other' => __('filament.employees.create.gender.other'),
                                            ])
                                            ->native(false),
                                        Textarea::make('home_address')
                                            ->label(__('filament.employees.create.fields.home_address'))
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('settings')
                            ->label(__('filament.employees.create.tabs.settings'))
                            ->icon(Heroicon::OutlinedCog6Tooth)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('password')
                                            ->label(__('filament.users.form.password'))
                                            ->password()
                                            ->revealable()
                                            ->required(fn ($livewire): bool => $livewire instanceof CreateRecord)
                                            ->dehydrated(fn (?string $state): bool => filled($state)),
                                        Select::make('employee_badge')
                                            ->label(__('filament.employees.form.badge'))
                                            ->options(collect(EmployeeBadgeEnum::cases())->mapWithKeys(
                                                fn (EmployeeBadgeEnum $case): array => [$case->value => $case->label()],
                                            ))
                                            ->default(EmployeeBadgeEnum::Employee->value)
                                            ->native(false),
                                        Select::make('role')
                                            ->label(__('filament.employees.create.fields.role'))
                                            ->options(collect(RoleEnum::cases())->mapWithKeys(
                                                fn (RoleEnum $case): array => [$case->value => $case->label()],
                                            ))
                                            ->default(RoleEnum::User->value)
                                            ->native(false),
                                        Toggle::make('is_active')
                                            ->label(__('filament.employees.create.fields.is_active'))
                                            ->default(true),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @return list<Component>
     */
    private static function primaryFields(): array
    {
        return [
            TextInput::make('name')
                ->label(__('filament.employees.create.fields.name'))
                ->required()
                ->autofocus()
                ->maxLength(255),
            TextInput::make('job_title')
                ->label(__('filament.employees.create.fields.job_title'))
                ->maxLength(255),
            TextInput::make('email')
                ->label(__('filament.employees.create.fields.work_email'))
                ->email()
                ->required()
                ->suffixIcon(Heroicon::OutlinedEnvelope),
            TextInput::make('phone')
                ->label(__('filament.employees.create.fields.work_mobile'))
                ->tel()
                ->maxLength(32)
                ->suffixIcon(Heroicon::OutlinedPhone),
            TextInput::make('work_phone')
                ->label(__('filament.employees.create.fields.work_phone'))
                ->tel()
                ->maxLength(32)
                ->suffixIcon(Heroicon::OutlinedPhone),
            TagsInput::make('employee_tags')
                ->label(__('filament.employees.create.fields.employee_tags'))
                ->placeholder(__('filament.employees.create.fields.employee_tags_placeholder')),
        ];
    }

    /**
     * @return list<Component>
     */
    private static function organizationFields(): array
    {
        return [
            FileUpload::make('profile_photo_path')
                ->label(__('filament.employees.create.fields.profile_picture'))
                ->image()
                ->avatar()
                ->directory('employees/avatars')
                ->disk('public')
                ->visibility('public'),
            Select::make('master_department_id')
                ->label(__('filament.employees.create.fields.department'))
                ->relationship('department', 'name')
                ->searchable()
                ->preload()
                ->native(false),
            Select::make('master_position_id')
                ->label(__('filament.employees.create.fields.job_position'))
                ->relationship('position', 'name')
                ->searchable()
                ->preload()
                ->native(false),
            self::employeeSelect('manager_id')
                ->label(__('filament.employees.create.fields.manager'))
                ->suffixIcon(Heroicon::OutlinedUser),
            self::employeeSelect('coach_id')
                ->label(__('filament.employees.create.fields.coach')),
        ];
    }

    private static function employeeSelect(string $name): Select
    {
        return Select::make($name)
            ->options(fn (): array => User::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->pluck('name', 'id')
                ->all())
            ->searchable()
            ->native(false);
    }

    /**
     * @return array<string, string>
     */
    private static function workingHoursOptions(): array
    {
        return [
            'standard_40' => __('filament.employees.create.working_hours.standard_40'),
            'flexible' => __('filament.employees.create.working_hours.flexible'),
            'shift' => __('filament.employees.create.working_hours.shift'),
            'part_time' => __('filament.employees.create.working_hours.part_time'),
        ];
    }

    /**
     * @return array<string, string>
     */
    private static function timezoneOptions(): array
    {
        return [
            'UTC' => 'UTC',
            'Asia/Jakarta' => 'Asia/Jakarta',
            'Asia/Singapore' => 'Asia/Singapore',
            'Asia/Tokyo' => 'Asia/Tokyo',
            'Europe/London' => 'Europe/London',
            'America/New_York' => 'America/New_York',
        ];
    }
}
