@props([
    'meetups',
    'dayOfWeek',
    'hourOfDay'
])
<div class="p-6 bg-teal-600">
    <h2 class="tracking-tight text-white">
        <span class="inline-block">
            {{ $snippets->monthlyMeeting }}
        </span>
    </h2>
    <p class="my-3 text-base text-gray-100 sm:text-lg">
        {{ $snippets->meetupIntro }}
    </p>
{{--    <hr class="border-b-0 border-white border-opacity-25" />--}}
    <div>
        @if($meetups['upcoming'])
            <div class="mt-4 text-white">
                <h4 class="tex">
                    <span class="inline-block text-sm">{{ $snippets->nextMeeting }}:</span>
                    @if($dayOfWeek == 5 && $hourOfDay == 17)
                        <span class="font-extrabold text-white">
                            {{ $snippets->InSession }}
                                                </span>
                    @else
                        <span class="text-base font-bold">
                                                    <x-carbon class="" :date="$meetups['upcoming']->start_time" local format="DD/MM HH (z)" />
                                                </span>
                    @endif
                </h4>
                @if(!($dayOfWeek == 5 && $hourOfDay == 17))
                    <div class="mt-2 text-base font-extrabold text-center text-accent-200">
                        <x-countdown :expires="$meetups['upcoming']->start_time">
                            <span x-text="timer.days">
                                {{ $component->days() }}
                            </span> {{ $snippets->days }}
                            <span class="ml-2" x-text="timer.hours">{{ $component->hours() }}</span> {{ $snippets->hrs }}
                            <span class="ml-2" x-text="timer.minutes">{{ $component->minutes() }}</span> {{ $snippets->mins }}
                            <span class="ml-2" x-text="timer.seconds">{{ $component->seconds() }}</span> {{ $snippets->secs }}
                        </x-countdown>
                    </div>
                @endif
                <div class="mx-auto mt-5 w-full sm:flex sm:justify-start md:mt-8">
                    <div class="w-full rounded-md shadow-xs">
                        <a href="//zoom.us/j/99090517299?pwd=cWlUYlMxcGxlSlFEdUtRQUFZVnlGZz09" target="_blank"
                           class="flex justify-center items-center py-3 w-full text-base font-medium bg-white rounded-sm border border-transparent md:px-4 xl:px-6 md:py-4 xl:text-lg text-teal-600 hover:bg-gray-100">
                            <span class="inline-block mr-2 text-4xl text-teal-600">@include('svg.zoom-logo')</span>
                            <span class="font-extrabold text-teal-600 mix-blend-unset">
                                {{ $snippets->joinZoomCall }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div>
                <a type="button"
                   target="_blank"
                   href="//www.meetup.com/lido-nation-cardano-pool-meetup/events/282047528/"
                   class="flex items-center gap-1 px-2 py-3 border border-white border-opacity-25 text-md font-medium rounded-xs text-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                    <span class="w-8 h-8">
                        @include('svg.meetup-logo')
                    </span>
                    <span>
                        LIDO Monthly Checkin
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </span>
                </a>
            </div>
        @endif
    </div>
</div>
