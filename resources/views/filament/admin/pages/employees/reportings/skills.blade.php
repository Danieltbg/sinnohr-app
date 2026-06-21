<x-filament-panels::page>
    <div class="fi-hr-reportings">
        <aside class="fi-hr-reportings__sidebar" aria-label="{{ __('filament.employees.reportings.sidebar') }}">
            <a
                href="{{ \App\Filament\Admin\Resources\EmployeeSkills\EmployeeSkillResource::getUrl('index') }}"
                class="fi-hr-reportings__sidebar-link fi-hr-reportings__sidebar-link--active"
            >
                <x-filament::icon
                    icon="heroicon-o-academic-cap"
                    class="fi-hr-reportings__sidebar-icon"
                />
                {{ __('filament.employees.reportings.skills.navigation') }}
            </a>
        </aside>

        <div class="fi-hr-reportings__content">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
