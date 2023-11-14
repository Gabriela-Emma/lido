<div class="py-16 relative bg-primary-10 animate-pulse" id="new-to-library">
    <div class="container relative">
        <h2 class="mb-6 text-5xl text-gray-900 decorate dark">
            <div class="mb-4 text-5xl w-3/4">
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
        <div class="flex flex-nowrap gap-8 posts mb-12">
            <!-- podcast -->
            <div class="flex flex-col shrink-0 snap-center w-2/5">
                <div class="flex shrink-0 snap-start flex-col gap-2 items-start justify-center podcast-inner h-full">
                    <div class="relative w-full h-full">
                        <div class="h-110 bg-teal-50 rounded"></div>
                        <div class="flex h-12 flex-row gap-4 pt-4">
                            <div class="h-full w-3/4 bg-teal-50 rounded"></div>
                            <div class="rounded-full bg-teal-50 h-10 w-10"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-3/5">
                <?php $showHero = true; ?>
                <div
                    class="flex flex-row flex-nowrap gap-6 posts">
                    @foreach(range(1, 2) as $post)
                        <div
                            class="w-full md:border-r md:border-slate-600 px-6 -mt-px -ml-px post">
                            <x-placeholder.more-posts-placeholder />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
