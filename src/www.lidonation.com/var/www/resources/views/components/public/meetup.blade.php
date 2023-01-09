@props([
    'upcoming',
    'dayOfWeek',
    'hourOfDay',
    'bg' => 'teal',
    'theme' => 'primary',
   ])
<div class="relative bg-{{$bg}}-400 overflow-hidden mix-blend-normal">
    <div class="hidden sm:block sm:absolute sm:inset-y-0 sm:h-full sm:w-full" aria-hidden="true">
        <div class="relative mx-auto max-w-7xl h-full text-blue-dark-500">
            <svg class="absolute right-full z-20 transform translate-x-1/4 translate-y-1/4 lg:translate-x-1/2"
                 width="404" height="784" fill="none" viewBox="0 0 404 784">
                <defs>
                    <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20"
                             patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-{{$bg}}-800" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)"/>
            </svg>
            <svg
                class="absolute left-full z-20 transform -translate-x-1/4 -translate-y-3/4 md:-translate-y-1/2 lg:-translate-x-1/2"
                width="404" height="784" fill="currentColor" viewBox="0 0 404 784">
                <defs>
                    <pattern id="5d0dd344-b041-4d26-bec4-8d33ea57ec9b" x="0" y="0" width="20" height="20"
                             patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-{{$bg}}-800" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#5d0dd344-b041-4d26-bec4-8d33ea57ec9b)"/>
            </svg>
        </div>
    </div>

    <div
        class="relative pt-6 pb-16 bg-scroll bg-center bg-cover bg-blend-color-burn sm:pb-24 bg-pool-bw-light bg-teal-light-500">
        <main class="px-4 mx-auto mt-16 max-w-7xl sm:mt-12">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-blue-dark-500 sm:text-5xl md:text-6xl">
                    <span class="block xl:inline">
                        {{ $snippets->monthlyMeeting }}
                    </span>
                </h1>
                <p class="mx-auto mt-3 max-w-md text-base text-blue-dark-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    {{ $snippets->meetupIntro }}
                </p>
{{--                @if($upcoming)--}}
{{--                <div class="mt-12">--}}
{{--                    <h2>--}}
{{--                        <span>--}}
{{--                            {{ $snippets->nextMeeting }}:</span>--}}
{{--                        @if($inSession)--}}
{{--                            <span class="font-extrabold text-white">--}}
{{--                                {{ $snippets->inSession }}--}}
{{--                            </span>--}}
{{--                        @else--}}
{{--                            <span class="opacity-50">--}}
{{--                                <x-carbon class="" :date="$upcoming->start_time" local format="DD/MM HH:mm (z)" />--}}
{{--                            </span>--}}
{{--                        @endif--}}
{{--                    </h2>--}}
{{--                    @if(!$inSession)--}}
{{--                    <div>--}}
{{--                        <x-countdown :expires="$upcoming->start_time">--}}
{{--                            <span x-text="timer.days">{{ $component->days() }}</span> {{ $snippets->days }}--}}
{{--                            <span class="ml-2" x-text="timer.hours">{{ $component->hours() }}</span> {{ $snippets->hours }}--}}
{{--                            <span class="ml-2" x-text="timer.minutes">{{ $component->minutes() }}</span> {{ $snippets->minutes }}--}}
{{--                            <span class="ml-2" x-text="timer.seconds">{{ $component->seconds() }}</span> {{ $snippets->seconds }}--}}
{{--                        </x-countdown>--}}
{{--                    </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                @endif--}}
                <div class="mx-auto mt-5 max-w-md sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow-xs">
                        <a href="//zoom.us/j/99090517299?pwd=cWlUYlMxcGxlSlFEdUtRQUFZVnlGZz09" target="_blank"
                           class="flex justify-center items-center px-6 py-3 w-full text-base font-medium text-white bg-blue-dark-500 rounded-sm border border-transparent hover:bg-indigo-700 md:py-4 md:text-lg md:px-8">
                            <span class="inline-block mr-2 text-4xl text-white">@include('svg.zoom-logo')</span>
                            <span class="font-extrabold text-white mix-blend-unset">
                                {{ $snippets->joinZoomCall }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
