@php
    $level = $getState();
    $variant = match ($level) {
        'Expert' => 'expert',
        'C2' => 'outlined',
        'Professional' => 'outlined',
        default => 'outlined',
    };
@endphp

@if (filled($level))
    <span class="fi-hr-skill-level fi-hr-skill-level--{{ $variant }}">
        {{ $level }}
    </span>
@else
    <span class="fi-hr-skill-level fi-hr-skill-level--empty">—</span>
@endif
