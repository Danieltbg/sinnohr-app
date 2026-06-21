@php
    use App\Filament\Admin\Navigation\AttendanceMyAttendanceMenu;

    $items = AttendanceMyAttendanceMenu::items();
@endphp

<aside class="fi-hr-attendance__sidebar" aria-label="{{ __('filament.attendance.my_attendance.sidebar') }}">
    <p class="fi-hr-attendance__sidebar-title">
        {{ __('filament.attendance.my_attendance.section') }}
    </p>

    <nav class="fi-hr-attendance__sidebar-nav">
        @foreach ($items as $item)
            <a
                href="{{ route($item['route']) }}"
                @class([
                    'fi-hr-attendance__sidebar-link',
                    'fi-hr-attendance__sidebar-link--active' => ($attendanceSidebarActive ?? '') === $item['key'],
                ])
            >
                <x-filament::icon
                    :icon="$item['icon']"
                    class="fi-hr-attendance__sidebar-icon"
                />
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
