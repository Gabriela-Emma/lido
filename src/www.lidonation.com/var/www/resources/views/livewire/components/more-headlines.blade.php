<div class="posts w-full">
    @if($newHeadlines?->isNotEmpty())
        @foreach($newHeadlines as $post)
            <x-post.headline-drip :post="$post" />
            <hr class="border-b border-b-black" />
        @endforeach
    @endif

    <!-- lazy loaded headlines template on loadMorePosts action trigger -->
    <div wire:loading
        wire:loading.target="loadMoreHeadlines"
        class="w-full">
        <x-placeholder.more-headlines-placeholder :count="$perPage"></x-placeholder.more-headlines-placeholder>
    </div>

    @if ($hasMorePages)
    <div class="flex items-center justify-center mt-8 w-full">
        <button class="px-3 py-3 text-lg font-semibold text-white rounded-sm bg-teal-600 hover:bg-teal-400" wire:click="loadMoreHeadlines()">
            More Recent Headlines
        </button>
    </div>
    @endif

</div>