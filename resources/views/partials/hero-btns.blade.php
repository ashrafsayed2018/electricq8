{{--
    Deprecated include path — kept for backward compatibility.
    Prefer <x-cta-buttons /> directly in new views.
    Usage: @include('partials.hero-btns')
    Optional: $waLabel, $callLabel, $waUrl to override button text/link
--}}
<x-cta-buttons :wa-label="$waLabel ?? null" :call-label="$callLabel ?? null" :wa-url="$waUrl ?? null" size="lg" />
