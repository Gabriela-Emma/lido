<div class="posts w-full">
    @if($moreReviews?->isNotEmpty())
        @foreach($moreReviews as $post)
            <x-post.reviews-drip :post="$post" :loop="$loop" />
        @endforeach
    @endif

    <!-- lazy loaded headlines template on loadMorePosts action trigger -->
    <div wire:loading
        wire:loading.target="loadMorePosts"
        class="w-full">
        <x-placeholder.more-reviews-placeholder :count="$perPage"></x-placeholder.more-reviews-placeholder>
    </div>

    @if ($hasMorePages)
    <div class="flex items-center justify-center mt-8 w-full">
        <button class="px-3 py-3 text-lg font-semibold text-white rounded-sm bg-teal-600 hover:bg-teal-400" wire:click="loadMorePosts()">
            {{ $moreLabel }}
        </button>
    </div>
    @endif

</div>