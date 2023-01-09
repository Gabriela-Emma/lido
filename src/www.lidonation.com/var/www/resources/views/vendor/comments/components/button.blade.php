<button
    type="{{ isset($submit) && $submit ? 'submit' : 'button' }}"
    @class([
        'comments-button bg-teal-600 rounded-sm',
        'is-small' => isset($small) && $small,
        'is-danger' => isset($danger) && $danger,
        'is-link' => isset($link) && $link,
    ])"
    {{ $attributes->except('type', 'size', 'submit') }}
>
    {{ $slot }}
</button>
