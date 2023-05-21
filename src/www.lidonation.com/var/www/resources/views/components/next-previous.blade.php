@props(['name', 'title', 'link'])
<div class="inline-block">
    <div class="p-4 max-w-xl rounded-sm border min-w-25">
        <p class="text-sm text-gray-400">
            {{ $name }}
        </p>
        <a href="/{{ $link }}" class="text-base font-semibold hover:text-teal-600">
            {{ $title }}
        </a>
    </div>
</div>
