@php
    use App\Filament\Admin\Resources\Departments\DepartmentResource;

    /** @var \App\Models\MasterDepartment $record */
    $record = $getRecord();
@endphp

<article class="fi-hr-departments__card">
    <div class="fi-hr-departments__card-top">
        <img
            src="{{ $record->avatar_url }}"
            alt=""
            class="fi-hr-departments__avatar"
            loading="lazy"
        />
    </div>

    <h3 class="fi-hr-departments__name">
        {{ $record->name }}
    </h3>

    <ul class="fi-hr-departments__meta">
        @if ($record->manager)
            <li class="fi-hr-departments__meta-item">
                <x-filament::icon icon="heroicon-m-user" class="fi-hr-departments__meta-icon" />
                <span>{{ $record->manager->name }}</span>
            </li>
        @endif

        @if (filled($record->company_name))
            <li class="fi-hr-departments__meta-item">
                <x-filament::icon icon="heroicon-m-building-office-2" class="fi-hr-departments__meta-icon" />
                <span>{{ $record->company_name }}</span>
            </li>
        @endif
    </ul>

    <footer class="fi-hr-departments__actions">
        <a
            href="{{ DepartmentResource::getUrl('edit', ['record' => $record]) }}"
            class="fi-hr-departments__action fi-hr-departments__action--text"
        >
            <x-filament::icon icon="heroicon-m-eye" class="fi-hr-departments__action-icon" />
            {{ __('filament.employees.departments.actions.view') }}
        </a>

        <a
            href="{{ DepartmentResource::getUrl('edit', ['record' => $record]) }}"
            class="fi-hr-departments__action fi-hr-departments__action--text"
        >
            <x-filament::icon icon="heroicon-m-pencil-square" class="fi-hr-departments__action-icon" />
            {{ __('filament.employees.departments.actions.edit') }}
        </a>

        <button
            type="button"
            class="fi-hr-departments__action fi-hr-departments__action--text fi-hr-departments__action--danger"
            wire:click="mountTableAction('delete', '{{ $record->getKey() }}')"
            wire:loading.attr="disabled"
        >
            <x-filament::icon icon="heroicon-m-trash" class="fi-hr-departments__action-icon" />
            {{ __('filament.employees.departments.actions.delete') }}
        </button>
    </footer>
</article>
