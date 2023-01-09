@props([
    'post'
])
<div x-data="articleRecorder('{{$post->slug}}', '{{$locale}}')">
    <div class="flex flex-col justify-center w-full h-full px-6 py-4 bg-pink-600" x-show="errors.length > 0" x-transition>
        <ul class="flex flex-row flex-wrap items-end gap-1">
            <template x-for="error in errors">
                <li class="text-sm font-semibold text-white" x-html="error"></li>
            </template>
        </ul>
    </div>
    <div x-show="errors.length == 0" x-transition
        class="bg-gray-400 px-6 py-4 w-full text-sm font-medium text-white rounded-sm rounded-br-[2rem] lg:rounded-br-[0rem] relative flex flex-row gap-3">
        <div class="container">
            <div class="absolute top-0 left-0 z-20 w-full h-full bg-white bg-opacity-50" x-show="working">
                <div class="flex flex-row items-center justify-center w-full h-full">
                    <svg class="w-6 h-6 mr-3 animate-spin text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
            <button
                @click="startOrStopRecording()"
                type="button"
                class="inline-flex items-center justify-center h-10 py-2 bg-pink-400 border border-transparent rounded-sm op w-28 hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                <span x-show="!recording" x-transition class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentsColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                    </svg>
                </span>
                <span x-show="recording" x-transition class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z"
                        clip-rule="evenodd"/>
                </svg>
                </span>
                <span x-show="!recording">
                    Record
                </span>
                <span x-show="recording">
                    Stop
                </span>
            </button>
            <button
                @click="playback($event)"
                :disabled="!downloadLink"
                type="button"
                class="inline-flex items-center justify-center h-10 py-2 border border-transparent rounded-sm w-28 bg-accent-400 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-400 disabled:bg-gray-500 disabled:cursor-default">
                <span x-show="!playing" x-transition class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span x-show="playing" x-transition class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span>
                    <template x-if="downloadLink">
                        <audio id="article-recorded-draft" class="hidden"
                            :src="downloadLink"></audio>
                    </template>
                    <span x-show="!playing">
                        Play
                    </span>
                    <span x-show="playing">
                        Pause
                    </span>
                </span>
            </button>
            <div class="relative inline-flex flex-col items-center gap-0 ml-auto">
            <button
                @click="send()"
                :disabled="!downloadLink"
                type="button"
                class="inline-flex items-center h-10 p-2 ml-auto text-white border border-transparent rounded-sm bg-primary-400 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:bg-gray-500 disabled:cursor-default">
            <span class="mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                </svg>
            </span>
                <span>
                Send
            </span>
            </button>
            <a id="download-article-recorded-draft" x-show="downloadLink" x-transition href="#"
                class="absolute right-0 py-2 mt-1 mt-auto text-xs font-extrabold text-pink-500 -bottom-6 hover:text-white">
                Download
            </a>
        </div>
        </div>
    </div>
</div>
