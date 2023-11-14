<div>
    <div class="mx-auto max-w-2xl text-center">
        @isset($title)
            <h2 class="text-3xl font-bold tracking-tight text-{{$theme}}-500 sm:text-4xl xl:text-5xl">
                <span class="block">
                    {{$title}}
                </span>
            </h2>
        @endisset

        @isset($subtitle)
            <h3 class="text-xl font-bold tracking-tight text-{{$theme}}-500 sm:text-2xl">
                <span class="block">
                    {{$subtitle}}
                </span>
            </h3>
        @endisset

        @isset($cta)
            <p class="mt-8 text-lg font-semibold leading-6 text-slate-400">
                {{$cta}}
            </p>
        @endisset

        @if($links && count($links) > 0)
            <div class="flex gap-2 justify-center mt-4">
                @if(in_array('delegate', $links))
                    <a type="button" href=""
                       class="inline-flex items-center rounded-sm border border-transparent bg-eggplant-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-eggplant-700 focus:outline-none focus:ring-2 focus:ring-eggplant-500 focus:ring-offset-2">
                        Delegate to LIDO
                    </a>
                @endif
                    @if(in_array('bazaar', $links))
                        <a type="button" href="{{localizeRoute('bazaar')}}"
                           class="inline-flex items-center rounded-sm border border-transparent bg-yellow-500 px-4 py-2 text-base font-medium text-slate-800 shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                            Shop
                        </a>
                    @endif
                @if(in_array('podcast', $links))
                    <a type="button" href="{{localizeRoute('lido-minute-nft')}}"
                       class="inline-flex items-center rounded-sm border border-transparent bg-green-500 px-4 py-2 text-base font-medium text-slate-800 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Sponsor a podcast episode
                    </a>
                @endif
            </div>
        @endif
    </div>

    <div class="mt-16 shadow-xs border-4 border-slate-800 rounded-sm">
        <livewire:components.lido-origin-story-and-stats theme="green" lazy="on-scroll" />
    </div>
</div>
