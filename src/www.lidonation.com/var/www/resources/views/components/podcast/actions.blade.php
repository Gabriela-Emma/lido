<div @gvp-now-playing.window="handlePlaying($event)"
    class="flex flex-row items-center gap-2 pl-2 ml-auto border-l sm:pl-6 sm:pr-3 border-slate-100/50">
    @if ($podcast->is_scheduled)
        <div class="text-yellow-700 bg-yellow-500 rounded-full shadow-sm">
            <div class="flex flex-col gap-2 p-2 text-xs text-yellow-800 rounded-full sm:p-3" x-data x-tt="Coming Soon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-5 h-5 sm:w-6 sm:h-6">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    @else
        <div @click="togglePodcast()"
            class="text-yellow-700 bg-yellow-500 rounded-full shadow-sm hover:cursor-pointer hover:shadow-md hover:shadow-yellow-500">
            <div x-show="!playing" class="p-1.5 sm:p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                </svg>
            </div>

            <div x-show="!!playing"
                class="relative rounded-full py-1 px-1.5 sm:py-2 sm:px-2 flex justify-center items-center">
                <img class="w-6 h-6 rounded-full sm:w-10 sm:h-10 aspect-square"
                    src="{{ asset('img/circular-wave.gif') }}" alt="" />
                <div
                    class="absolute flex items-center justify-center w-5 h-5 rounded-full sm:w-10 sm:h-10 text-slate-800">
                    <div
                        class="w-4 h-4 sm:w-7 sm:h-7 bg-yellow-500 p-0.5 rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-3 h-3 sm:w-4 sm:h-4">
                            <path fill-rule="evenodd"
                                d="M6.75 5.25a.75.75 0 01.75-.75H9a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75V5.25zm7.5 0A.75.75 0 0115 4.5h1.5a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H15a.75.75 0 01-.75-.75V5.25z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <img class="w-5 h-5 rounded-full" src="{{ $podcast->author?->gravatar }}" title="{{ $podcast->author?->name }}"
        alt="{{ $podcast->author?->name }} Bio Pic" />
</div>
