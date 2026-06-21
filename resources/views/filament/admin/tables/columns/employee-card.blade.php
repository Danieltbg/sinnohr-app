@php
    use App\Filament\Admin\Resources\Users\UserResource;

    /** @var \App\Models\User $record */
    $record = $getRecord();
    $badge = $record->employee_badge;
@endphp

<article class="fi-hr-employees__card">
    <div class="fi-hr-employees__card-top">
        <img
            src="{{ $record->avatar_url }}"
            alt=""
            class="fi-hr-employees__avatar"
            loading="lazy"
        />
    </div>

    <h3 class="fi-hr-employees__name">
        {{ $record->name }}
    </h3>

    <ul class="fi-hr-employees__meta">
        @if (filled($record->job_title))
            <li class="fi-hr-employees__meta-item">
                <x-filament::icon icon="heroicon-m-briefcase" class="fi-hr-employees__meta-icon" />
                <span>{{ $record->job_title }}</span>
            </li>
        @endif

        <li class="fi-hr-employees__meta-item">
            <x-filament::icon icon="heroicon-m-envelope" class="fi-hr-employees__meta-icon" />
            <span>{{ $record->email }}</span>
        </li>

        @if (filled($record->phone))
            <li class="fi-hr-employees__meta-item">
                <x-filament::icon icon="heroicon-m-phone" class="fi-hr-employees__meta-icon" />
                <span>{{ $record->phone }}</span>
            </li>
        @endif
    </ul>

    @if ($badge)
        <span class="fi-hr-employees__badge fi-hr-employees__badge--{{ $badge->color() }}">
            {{ $badge->label() }}
        </span>
    @endif

    <footer class="fi-hr-employees__actions">
        <a
            href="{{ UserResource::getUrl('edit', ['record' => $record]) }}"
            class="fi-hr-employees__action"
            title="{{ __('filament.employees.actions.history') }}"
        >
            <x-filament::icon icon="heroicon-m-clock" class="fi-hr-employees__action-icon" />
        </a>

        <a
            href="{{ UserResource::getUrl('edit', ['record' => $record]) }}"
            class="fi-hr-employees__action fi-hr-employees__action--text"
        >
            {{ __('filament.employees.actions.view') }}
        </a>

        <a
            href="{{ UserResource::getUrl('edit', ['record' => $record]) }}"
            class="fi-hr-employees__action fi-hr-employees__action--text"
        >
            <x-filament::icon icon="heroicon-m-pencil-square" class="fi-hr-employees__action-icon" />
            {{ __('filament.employees.actions.edit') }}
        </a>

        <button
            type="button"
            class="fi-hr-employees__action fi-hr-employees__action--text fi-hr-employees__action--danger"
            wire:click="mountTableAction('delete', '{{ $record->getKey() }}')"
            wire:loading.attr="disabled"
        >
            <x-filament::icon icon="heroicon-m-trash" class="fi-hr-employees__action-icon" />
            {{ __('filament.employees.actions.delete') }}
        </button>
    </footer>
</article>
