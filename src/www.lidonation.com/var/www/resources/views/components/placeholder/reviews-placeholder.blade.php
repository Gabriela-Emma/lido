<div class="animate-pulse">
    <h2 class="text-3xl text-gray-700 decorate dark xl:text-4xl">
        <span class="inline-block p-4 md:p-0">
            {{ $snippets->reviews }}
        </span>
    </h2>
    <div class="p-4 space-y-6 md:p-0 lg:mt-8">
        <x-placeholder.more-reviews-placeholder :count="$postLoadCount" />
    </div>
</div>