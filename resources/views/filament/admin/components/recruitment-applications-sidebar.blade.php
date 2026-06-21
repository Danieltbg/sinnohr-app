@php
    use App\Filament\Admin\Navigation\RecruitmentApplicationsMenu;

    $items = RecruitmentApplicationsMenu::items();
@endphp

<aside class="fi-hr-recruitments__sidebar" aria-label="{{ __('filament.recruitments.applications.sidebar') }}">
    <nav class="fi-hr-recruitments__sidebar-nav">
        @foreach ($items as $item)
            <a
                href="{{ route($item['route']) }}"
                @class([
                    'fi-hr-recruitments__sidebar-link',
                    'fi-hr-recruitments__sidebar-link--active' => ($recruitmentApplicationsActive ?? '') === $item['key'],
                ])
            >
                <x-filament::icon
                    :icon="$item['icon']"
                    class="fi-hr-recruitments__sidebar-icon"
                />
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
