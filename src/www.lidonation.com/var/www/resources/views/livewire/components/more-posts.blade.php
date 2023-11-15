<div class="posts w-full mt-12">
    @if($posts)
        <x-post.posts :posts="$posts" :theme="$theme"/>
    @endif

    <!-- lazy loaded posts template on loadMorePosts action trigger -->
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12 more-posts">
        @foreach (range(1, $perPage) as $n)
            <div
                wire:loading
                wire:loading.target="loadMorePosts"
                class="w-full xl:border-r xl:border-slate-600 pr-6 -mt-px -ml-px post">
                <x-placeholder.more-posts-placeholder />
            </div>
        @endforeach
    </div>

    @if ($hasMorePages)
        <div class="flex items-center justify-center w-full mt-16">
            <button
                class="px-3 py-3 text-lg font-semibold text-white rounded-sm bg-teal-600 hover:bg-teal-400"
                wire:click="loadMorePosts()">
                {{ $moreLabel }}
            </button>
        </div>
    @endif

</div>



