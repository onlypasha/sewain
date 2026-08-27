@props([
    'variant' => null,
    'size' => null,
    'outline' => false,
    'dash' => false,
    'soft' => false,
])

@php
    $classes = collect(['badge']);

    // Variant: primary, secondary, accent, neutral, info, success, warning, error, ghost
    if ($variant) {
        $classes->push("badge-{$variant}");
    }

    // Size: lg, md, sm, xs
    if ($size) {
        $classes->push("badge-{$size}");
    }

    // Style modifiers
    if ($outline) {
        $classes->push('badge-outline');
    }
    if ($dash) {
        $classes->push('badge-dash');
    }
    if ($soft) {
        $classes->push('badge-soft');
    }
@endphp

<div {{ $attributes->class($classes->toArray()) }}>
    {{ $slot }}
</div>