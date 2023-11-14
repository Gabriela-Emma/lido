<div class="relative py-16 bg-primary-10" id="new-to-library">
    <!-- header -->
    <div class="container relative">
        <h2 class="mb-6 text-5xl text-gray-900 decorate dark">
            <div class="w-3/4 mb-4 text-5xl">
                <span>
                    {{ $snippets->newToThe }}
                </span>
                <span class="text-teal-600 opacity-90">
                    {{ $snippets->library }}
                </span>
            </div>
        </h2>
    </div>

    <div class="container">
        <div class="flex flex-wrap gap-8 mb-12 xl:flex-nowrap posts">
            @if ($showPodcast)
                <div class="flex flex-col w-full shrink-0 snap-center xl:w-2/5">
                    @livewire('components.lido-minute', ['latestLidoMinute' => $latestLidoMinute])
                </div>
            @endif

            <div class="w-full xl:w-3/5">

                <div class="flex flex-row gap-6 flex-nowrap posts">
                    @foreach ($newToLibrary as $post)
                        <div class="w-full px-6 -mt-px -ml-px xl:border-r xl:border-slate-600 post">
                            <x-post.drip :post="$post" :showHero="true" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <livewire:components.more-posts-component :offset="2" :per-page="4" more-label="More Recent Posts" />
    </div>
</div>
