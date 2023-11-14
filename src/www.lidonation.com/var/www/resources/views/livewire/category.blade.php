<div class="category" :metaTitle="'Cat: '.$category - > title">
    <header>
        <div class="container py-4 pb-4">
            <div class="flex flex-row gap-4 text-sm">
                <span class="font-bold text-gray-300">Today</span>
                <span>{{ now()->format('F d') }}</span>
                <div class="flex flex-row text-sm" "current price of ada according to Coin Market Cap">
                    <span class="font-bold text-gray-300">Price</span>
                    <span>
                        <livewire:components.ada-quote />
                    </span>
                </div>
            </div>
            <hr class="border-gray-200" />
            <div>
                <h1 class="py-8 text-3xl font-extrabold md:text-5xl lg:text-6xl 2xl:text-8xl lg:py-12 2xl:py-8">
                    {{ $category->title }}
                </h1>
            </div>
            <hr class="border-gray-300" />
        </div>
    </header>

    <section class="relative py-8 bg-scroll bg-center bg-cover bg-pool-bw-light bg-gray-50 bg-blend-hard-light"
        aria-labelledby="quick-links-title">
        <div class="container">
            <div class="sm:grid sm:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-4 my-8">
                @foreach ($postsByCategory->models as $post)
                    @if ($loop->first)
                        <div class="col-span-2 xl:col-span-3 2xl:col-span-4 my-4">
                            <x-post.highlight :post="$post" />
                        </div>
                    @endif
                @endforeach
            </div>
            <livewire:components.taxonomy-component :taxonomy='$taxonomy' :per-page="$perPage" />
        </div>
    </section>
    <section class="container py-16">
        <div class="container">
            <livewire:components.support-lido-component theme="green" lazy="on-scroll" />
        </div>
    </section>
</div>
