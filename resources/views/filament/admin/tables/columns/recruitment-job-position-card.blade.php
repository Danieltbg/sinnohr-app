@php
    use App\Filament\Admin\Resources\Recruitments\Applicants\RecruitmentApplicantResource;
    use App\Filament\Admin\Resources\Recruitments\JobPositions\RecruitmentJobPositionResource;

    /** @var \App\Models\RecruitmentJobPosition $record */
    $record = $getRecord();
@endphp

<article class="fi-hr-recruitments__card">
    <h3 class="fi-hr-recruitments__card-title">
        {{ $record->name }}
    </h3>

    <ul class="fi-hr-recruitments__card-meta">
        @if ($record->manager)
            <li class="fi-hr-recruitments__card-meta-item">
                <x-filament::icon icon="heroicon-m-user" class="fi-hr-recruitments__card-meta-icon" />
                <span>{{ $record->manager->name }}</span>
            </li>
        @endif

        @if (filled($record->company_name))
            <li class="fi-hr-recruitments__card-meta-item">
                <x-filament::icon icon="heroicon-m-building-office-2" class="fi-hr-recruitments__card-meta-icon" />
                <span>{{ $record->company_name }}</span>
            </li>
        @endif
    </ul>

    <footer class="fi-hr-recruitments__card-footer">
        <a
            href="{{ RecruitmentApplicantResource::getUrl('index') }}"
            class="fi-hr-recruitments__applications-btn"
        >
            {{ trans_choice('filament.recruitments.job_positions.new_applications', $record->new_applications_count, ['count' => $record->new_applications_count]) }}
        </a>

        <div class="fi-hr-recruitments__card-menu">
            <a
                href="{{ RecruitmentJobPositionResource::getUrl('edit', ['record' => $record]) }}"
                class="fi-hr-recruitments__card-menu-btn"
                title="{{ __('filament.recruitments.job_positions.actions.edit') }}"
            >
                <x-filament::icon icon="heroicon-m-ellipsis-vertical" class="fi-hr-recruitments__card-menu-icon" />
            </a>
        </div>
    </footer>
</article>
