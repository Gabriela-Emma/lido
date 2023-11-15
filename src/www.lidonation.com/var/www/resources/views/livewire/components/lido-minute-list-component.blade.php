<div>
    <header class="py-16">
        <div class="container">
            <h1 class="text-3xl font-light leading-8 tracking-tight text-slate-800 sm:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl pr-8 xl:pr-20 2xl:max-w-7xl">
                <span class="font-extrabold text-yellow-500">LIDO Minute.</span>
                <span>Bite size podcast for Blockchain & Cardano education.</span>
            </h1>
        </div>
    </header>

    <div class="container">
        <div class="flex flex-wrap gap-8 mb-12 xl:flex-nowrap posts">
            @if ($newEpisodes)
                @foreach($newEpisodes as $podcast)
                    <div class="w-full -mt-px">
                         <x-podcast.drip :podcast="$podcast" />
                    </div>
                 @endforeach
            @endif
        </div>

        <livewire:components.more-podcast-component :offset="3" :per-page="3" :show-initial="false" more-label="More Lido Minutes" />
    </div>
</div>
