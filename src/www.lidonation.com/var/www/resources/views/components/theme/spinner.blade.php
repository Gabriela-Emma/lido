@props([
    'theme' => 'primary',
    'square' => 8,
    'squareXl' => 8
])
<span
class="flex items-center justify-center w-full p-2 bg-white rounded-full bg-opacity-90">
    <svg
        class="relative w-{{$square}} h-{{$square}} lg:h-{{$squareXl ?? $square}} lg:w-{{$squareXl ?? $square}} border-t-2 border-b-2 rounded-full animate-spin border-{{$theme}}-600"
        viewBox="0 0 24 24"></svg>
</span>
