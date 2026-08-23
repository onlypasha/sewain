@props([
    'variant' => null,
    'size' => null,
    'shape' => null,
    'outline' => false,
    'dash' => false,
    'soft' => false,
    'glass' => false,
    'active' => false,
    'disabled' => false,
    'loading' => false,
    'noAnimation' => false,
    'tag' => 'button',
    'href' => null,
    'type' => 'button',
])

@php
    $tag = $href ? 'a' : $tag;

    $classes = collect(['btn']);

    // Variant: primary, secondary, accent, neutral, info, success, warning, error, ghost, link
    if ($variant) {
        $classes->push("btn-{$variant}");
    }

    // Size: lg, md, sm, xs
    if ($size) {
        $classes->push("btn-{$size}");
    }

    // Shape: wide, block, circle, square
    if ($shape) {
        $classes->push("btn-{$shape}");
    }

    // Style modifiers
    if ($outline) {
        $classes->push('btn-outline');
    }
    if ($dash) {
        $classes->push('btn-dash');
    }
    if ($soft) {
        $classes->push('btn-soft');
    }
    if ($glass) {
        $classes->push('glass');
    }

    // State modifiers
    if ($active) {
        $classes->push('btn-active');
    }
    if ($disabled) {
        $classes->push('btn-disabled');
    }
    if ($loading) {
        $classes->push('btn-loading');
    }
    if ($noAnimation) {
        $classes->push('no-animation');
    }
@endphp

<{{ $tag }}
    {{ $attributes->class($classes->toArray()) }}
    @if ($href) href="{{ $href }}" @endif
    @if ($tag === 'button') type="{{ $type }}" @endif
    @if ($disabled) aria-disabled="true" tabindex="-1" @endif
>
    {{ $slot }}
</{{ $tag }}>