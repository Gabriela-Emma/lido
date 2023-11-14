@props([
    'amount',
    'over' => 5,
    'size' => 6,
    'mobileSize' => 3,
    'theme' => 'text-teal-600'
])
<span class="flex flex-row stars">
    <span class="block font-medium text-gray-400 star">
        <svg class="block w-{{$mobileSize}} h-{{$mobileSize}} md:w-{{$size}} md:h-{{$size}} @if($amount >= 1 ) {{$theme}} @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    </span>
    <span class="block font-medium text-gray-400">
        <svg class="block w-{{$mobileSize}} h-{{$mobileSize}} md:w-{{$size}} md:h-{{$size}} @if($amount >= 2 ) {{$theme}} @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    </span>
    <span class="block font-medium text-gray-400">
        <svg class="block w-{{$mobileSize}} h-{{$mobileSize}} md:w-{{$size}} md:h-{{$size}} @if($amount >= 3 ) {{$theme}} @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    </span>
    <span class="block font-medium text-gray-400">
        <svg class="block w-{{$mobileSize}} h-{{$mobileSize}} md:w-{{$size}} md:h-{{$size}} @if($amount >= 4 ) {{$theme}} @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    </span>
    <span class="block font-medium text-gray-400">
        <svg class="block w-{{$mobileSize}} h-{{$mobileSize}} md:w-{{$size}} md:h-{{$size}} @if($amount >= 5 ) {{$theme}} @else text-grey @endif " fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    </span>
</span>
