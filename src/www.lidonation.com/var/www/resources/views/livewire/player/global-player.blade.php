<section x-data="globalVideoPlayer" @toggle-podcast.window="queueOrPauseContent($event.detail)"
         x-init=" playlist = @js($podcasts ?? []);"
         class="p-2 bg-yellow-500 border-yellow-600 text-slate-800 drop-shadow-2xl"
         @click.outside="maximize = false" @mouseenter="maximize = true"
         @mouseleave="maximize = false">

    <div @click.prevent="maximize = true" class="flex items-center">
        <div x-show="!maximize" x-transition:enter="transition ease-in duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100 "
             class="text-slate-700 bg-yellow-500 rounded-full shadow-sm hover:cursor-pointer hover:shadow-md hover:shadow-yellow-500 ">
            <div x-show="!playing" class="p-1.5 sm:p-3 rounded-full" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z">
                    </path>
                </svg>
            </div>
            <div x-show="!!playing"
                 class="relative rounded-full py-1 px-1.5 sm:py-2 sm:px-2 flex justify-center items-center">
                <img class="w-6 h-6 rounded-full sm:w-10 sm:h-10 aspect-square"
                     src="https://www.lidonation.com/img/circular-wave.gif" alt="">
                <div
                    class="absolute flex items-center justify-center w-5 h-5 rounded-full sm:w-10 sm:h-10 text-slate-800">
                    <div
                        class="w-4 h-4 sm:w-7 sm:h-7 bg-yellow-500 p-0.5 rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-3 h-3 sm:w-4 sm:h-4">
                            <path fill-rule="evenodd"
                                  d="M6.75 5.25a.75.75 0 01.75-.75H9a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75V5.25zm7.5 0A.75.75 0 0115 4.5h1.5a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H15a.75.75 0 01-.75-.75V5.25z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex w-[24rem] h-[36rem]" x-show="!!maximize" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
        <div class="relative flex flex-col gap-3 w-full" x-transition>
            <div class="flex flex-row justify-between">
                <div class="flex items-center pl-1.5 pt-1.5 hover:text-white"
                     @click.prevent="maximize = false">
                    <button type="button"
                            class="rounded-sm text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <span class="ml-1 hover:cursor-pointer"> close</span>
                </div>

                <div class="flex flex-row items-center gap-1">
                    <button class="flex flex-row items-center gap-2"
                            @click.prevent="showPlayList = !showPlayList" type="button">
                        <span class="text-sm"> Playlist</span>

                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             fill="#000000" version="1.1" id="Layer_1" viewBox="0 0 321.95 321.95"
                             xml:space="preserve" class="w-8 h-8 hover:fill-white fill-slate-700">
                                <g transform="translate(0 -562.36)">
                                    <g>
                                        <g>
                                            <path
                                                d="M97.675,674.238v98.1c0,10.5,11,17.3,20.5,12.6l97.7-48.8c10.5-5.2,10.5-19.9,0-25.2l-97.7-48.8c-2.1-1-4.7-1.5-6.8-1.5     v0C103.475,660.638,97.675,666.938,97.675,674.238z M125.475,697.338l53.1,26.2l-53.1,26.2V697.338z"/>
                                            <path
                                                d="M14.175,639.138h293.6c18.9,0.5,18.9-28.3,0-27.8h-293.6C-4.725,610.838-4.725,639.638,14.175,639.138z"/>
                                            <path
                                                d="M307.775,807.038h-293.6c-18.9,0-18.9,28.3,0,28.3h293.6C326.675,835.338,326.675,807.038,307.775,807.038z"/>
                                            <path
                                                d="M14.175,688.438h48.9c18.9,0,18.9-28.3,0-28.3h-48.9C-4.725,660.138-4.725,688.438,14.175,688.438z"/>
                                            <path
                                                d="M14.175,737.238h48.9c18.9,0.5,18.9-28.3,0-27.8h-48.9C-4.725,708.938-4.725,737.738,14.175,737.238z"/>
                                            <path
                                                d="M14.175,786.038h48.9c18.9,0.5,18.9-28.3,0-27.8h-48.9C-4.725,757.738-4.725,786.538,14.175,786.038z"/>
                                            <path
                                                d="M307.775,660.138h-90.3c-18.9,0-18.9,28.3,0,28.3h90.3C326.675,688.438,326.675,660.138,307.775,660.138z"/>
                                            <path
                                                d="M307.775,709.438h-48.3c-18.9-0.5-18.9,28.3,0,27.8h48.3C326.675,737.738,326.675,708.938,307.775,709.438z"/>
                                            <path
                                                d="M307.775,758.238h-48.3c-18.9-0.5-18.9,28.3,0,27.8h48.3C326.675,786.538,326.675,757.738,307.775,758.238z"/>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                    </button>
                </div>
            </div>

            <div class="flex flex-1 flex-col items-center h-[25rem]">
                {{-- promo --}}
                @if($promo)
                    <div x-show="!showPlayList">
                        <div class="flex flex-col">
                            <a href="{{ $promo?->uri }}" target="_blank" title="{{ $promo?->content }}" class="block">
                                <img src="{{ $promo?->feature_url }}" :alt="{{ $promo->title . "'\\s promo'" }}"
                                     title="{{ $promo?->content }}">
                            </a>
                            <p class="w-full mx-auto text-xs text-center bg-yellow-500 text-slate-800">
                                Put your ad here:
                                <a title="Lido Advertisement NFTs" class="text-labs-red-light"
                                   href="{{ route('lido-minute-nft') }}">Lido
                                    Ad NFT</a>
                            </p>
                        </div>
                    </div>
                @endif

                <div class="hidden overflow-visible" x-ref="globalVideoWrapper" x-transition>
                    <div class="p-0" x-transition>
                        <video x-ref="globalVideo" id="globalVideo" playsinline
                               data-poster="{{ asset('img/llogo-transparent.png') }}">
                            <source src="https://www.youtube.com/watch?v=T37nO9uJNp0" type="video/mp4"/>
                        </video>
                    </div>
                </div>

                {{-- playlist --}}
                <div class="overflow-auto w-full" x-show="!!showPlayList">
                    <livewire:player.playlist/>
                </div>
            </div>

            {{-- controls --}}
            <div class="margin-t-auto flex flex-col items-center w-full py-2 border-t border-slate-700">
                <div class="flex w-full justify-center items-center overflow-hidden font-medium"
                     x-init="setCurrentPlaying">
                    <div class="p-0.5">
                        <span class="pr-2" x-text="`EP: ${playingPodcast?.episode}`"></span>
                    </div>
                    <div class="overflow-hidden">
                        <span x-text="playingPodcast?.title"></span>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-start">
                    <div class="flex gap-4 text-slate-900">
                        <button type="button" class="hover:text-slate-100" @click="changeSource('previous')">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                                 width="24" fill="currentColor"
                                 class="w-12 h-12 hover:fill-white fill-slate-700">
                                <path
                                    d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10c5.515 0 10-4.486 10-10S17.515 2 12 2zm4 14-6-4v4H8V8h2v4l6-4v8z">
                                </path>
                            </svg>
                        </button>
                        <button x-ref="globalVideoClicker" type="button" class="hover:text-white"
                                @click="toggle">
                            <svg x-show="!playing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 fill="currentColor" aria-hidden="true"
                                 class="w-12 h-12 text-slate-700 hover:text-white">
                                <path fill-rule="evenodd"
                                      d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <svg x-show="!!playing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                 fill="currentColor" aria-hidden="true"
                                 class="w-12 h-12 text-slate-700 hover:text-white">
                                <path fill-rule="evenodd"
                                      d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM9 8.25a.75.75 0 00-.75.75v6c0 .414.336.75.75.75h.75a.75.75 0 00.75-.75V9a.75.75 0 00-.75-.75H9zm5.25 0a.75.75 0 00-.75.75v6c0 .414.336.75.75.75H15a.75.75 0 00.75-.75V9a.75.75 0 00-.75-.75h-.75z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <button type="button" class="hover:text-white" @click="changeSource('next')">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 version="1.1" id="mdi-skip-next-circle" fill="currentColor"
                                 class="w-12 h-12 fill-slate-700 hover:fill-white" viewBox="0 0 24 24">
                                <path
                                    d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M8,8L13,12L8,16M14,8H16V16H14">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <div>
                                <button type="button" class="" @click="rewind">
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke-width="1.5"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="w-6 h-6 stroke-slate-800 group-hover:stroke-slate-400">
                                        <path
                                            d="M8 5L5 8M5 8L8 11M5 8H13.5C16.5376 8 19 10.4624 19 13.5C19 15.4826 18.148 17.2202 17 18.188">
                                        </path>
                                        <path d="M5 15V19"></path>
                                        <path
                                            d="M8 18V16C8 15.4477 8.44772 15 9 15H10C10.5523 15 11 15.4477 11 16V18C11 18.5523 10.5523 19 10 19H9C8.44772 19 8 18.5523 8 18Z">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" class="" @click="forward">
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none"
                                         class="w-6 h-6 stroke-slate-800 group-hover:stroke-slate-400">
                                        <path
                                            d="M16 5L19 8M19 8L16 11M19 8H10.5C7.46243 8 5 10.4624 5 13.5C5 15.4826 5.85204 17.2202 7 18.188"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                        <path d="M13 15V19" stroke-width="1.5" stroke-linecap="round"
                                              stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M16 18V16C16 15.4477 16.4477 15 17 15H18C18.5523 15 19 15.4477 19 16V18C19 18.5523 18.5523 19 18 19H17C16.4477 19 16 18.5523 16 18Z"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                    </svg>
                                </button>

                            </div>
                            <div class="inline-flex flex-1 gap-1 text-sm text-slate-800 ">
                                <label for="scrubber"
                                       class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-slate-600">Player
                                    Scrubber</label>
                                <input id="scrubber" type="range" min="0" max="60" value="0"
                                       x-ref="scrubber" x-transition class="w-full h-2 rounded-lg cursor-pointer ">
                            </div>
                            <div class="inline-flex items-center gap-1 text-sm text-slate-800">
                                <div><span x-ref="currentTime">0:00</span></div>
                                <div class="text-slate-400">/</div>
                                <div x-ref="videoDuration">~0:00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
