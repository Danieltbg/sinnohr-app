@if (filled($getState()))
    <span class="fi-hr-skill-type">
        {{ $getState() }}
    </span>
@else
    <span class="fi-hr-skill-type fi-hr-skill-type--empty">—</span>
@endif
