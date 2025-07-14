@props(['action' => 'javascript:void(0);', 'onclick' => null, 'icon' => null, 'hasComment' => false])

<a
    href="{{ $action }}"
    {{ $attributes->merge(['class' => 'btn-action' . ($hasComment ? ' btn-comment' : '')]) }}
    @if (!empty($onclick)) onclick="{{ $onclick }}" @endif
>
    @if (!empty($icon))
        <img src="{{ asset("images/icons/{$icon}.svg") }}" alt=""/>
    @endif
</a>
