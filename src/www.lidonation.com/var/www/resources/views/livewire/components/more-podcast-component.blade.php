<div>
    <div class="flex flex-wrap gap-8 mb-12 xl:flex-nowrap posts">
        @foreach($podcasts as $podcast)
            <x-podcast.drip :podcast="$podcast" />
        @endforeach
    </div>

    <!-- lazy loaded posts template on loadMorePosts action trigger -->
    @if ($hasMorePages === null || $hasMorePages === true)
        <div class="flex items-center justify-center w-full mt-16">
            <button
                class="px-3 py-3 text-lg font-semibold text-white rounded-sm bg-teal-600 hover:bg-teal-400"
                wire:click="loadPodcast()">
                {{ $moreLabel }}
            </button>
        </div>
    @endif
</div>
