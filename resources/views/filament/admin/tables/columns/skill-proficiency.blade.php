@php
    $value = min((float) ($getState() ?? 0), 100);
@endphp

<div class="fi-hr-skill-proficiency">
    <div class="fi-hr-skill-proficiency__track">
        <div
            class="fi-hr-skill-proficiency__bar"
            style="width: {{ $value }}%"
        ></div>
        <span class="fi-hr-skill-proficiency__label">
            {{ number_format($value, 2) }}%
        </span>
    </div>
</div>
