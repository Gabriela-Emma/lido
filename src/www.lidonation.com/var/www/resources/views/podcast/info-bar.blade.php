<div
    class="absolute left-0 bottom-0 flex gap-2 items-center text-yellow-500 bg-gradient-to-t from-slate-800 h-auto w-full p-2.5 sm:p-2">
    <div class="flex w-full">
        <div class="w-3/4">
            <div class="flex gap-3 items-center">
                <div class="text-sm">
                    EP{{$post->episode}}
                </div>
                @if($post->length)
                    <div class="text-xs">
                        <span>
                            {{Carbon\CarbonInterval::seconds($post->length)->cascade()->forHumans(null, true)}}
                        </span>
                    </div>
                @endif
                <a href="{{localizeRoute('lido-minute')}}"
                   class="inline-flex items-center px-1 py-0.5 capitalize text-slate-700 hover:text-yellow-900 rounded-sm text-xs font-semibold bg-yellow-500 border border-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/>
                    </svg>
                    <span class="hidden md:inline mr-1">Lido Minute</span> Podcast
                </a>
            </div>
            <h2 class="text-xl xl:text-2xl 2xl:text-4xl font-medium text-white">
                {{$post->title}}
            </h2>
        </div>
        @if(!isset($disablePlayer) || !$disablePlayer)
            @include('podcast.actions')
        @endif
    </div>
</div>
