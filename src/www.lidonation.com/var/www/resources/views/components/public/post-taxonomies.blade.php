@props([
    'tax',
    'size' => 'xs',
    'bgColor' => 'bg-accent-700',
    'textColor' => 'text-gray-700',
    'borderColor' => 'border-transparent',
    'badge' => true
])
@if($tax)
    <a
        href="{{$tax->url}}"
        style="background-color:{{$bgColor}};"
        class="inline-flex items-center px-2 py-0.5 rounded-sm text-xs font-semibold {{$textColor}} border {{$borderColor}}">
      {{$tax->title}}
    </a>
@endif
