<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="podcast w-full mt-12">
        @if ($podcast)
            <x-podcast.drip :podcast="$podcast" />
        @endif
    </div>

    <!-- lazy loaded posts template on loadMorePosts action trigger -->
    @if ($hasMorePages)
        <div class="flex items-center justify-center w-full mt-16">
            <button
                class="px-3 py-3 text-lg font-semibold text-white rounded-sm bg-teal-600 hover:bg-teal-400"
                wire:click="loadMorePodcast()">
                {{ $moreLabel }}
            </button>
        </div>
    @endif
</div>
