<div class="animate-pulse">
    <div class="flex flex-col w-full gap-2">
        <span class="h-4 w-24 bg-teal-50 rounded"></span>
        <span class="h-12 w-64 bg-teal-50 rounded"></span>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12 more-posts mt-12">
            @foreach (range(1, $postLoadCount) as $n)
                <div
                    wire:loading
                    wire:loading.target="loadMorePosts"
                    class="w-full xl:border-r xl:border-slate-600 pr-6 -mt-px -ml-px post">
                    <x-placeholder.more-posts-placeholder/>
                </div>
            @endforeach
    </div>
</div>