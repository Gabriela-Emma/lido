<div class="taxonomy" metaTitle="{{ (new ReflectionClass($taxonomy))->getShortName() }}: {{$taxonomy->title}}">
    <header>
        <div class="container py-4 ml-10">
            <div class="flex z-10 flex-col mb-2">
                <span class='z-10 font-semibold text-sm text-slate-700'>{{ (new ReflectionClass($taxonomy))->getShortName() }}</span>
                <span class='z-10 font-semibold text-teal-600'>{{ $taxonomy->title }}</span>
            </div>
            <p class="mt-3 mb-1 text-xl max-w-3xl font-normal text-gray-500 sm:mt-4">
                {{ $taxonomy->content }}
            </p>
        </div>
    </header>
    <section class="relative bg-pool-bw-light bg-cover bg-center bg-scroll bg-gray-50 bg-blend-hard-light"
             aria-labelledby="quick-links-title">
        <hr />

        <div class="container">
            <div class="sm:grid sm:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4 mt-8">
                <x-post.highlight :post="$featurePost" />
            </div>

            <div class="relative py-8">
                <hr class="border-slate-500 border-0 border-t" />
            </div>


            <livewire:components.taxonomy-component :offset="1" :taxonomy='$taxonomy' :per-page="$perPage" :show-title="false" />
        </div>
    </section>
    <section class="py-16">
        <div class="container">
            <livewire:components.support-lido-component theme="green" lazy="on-scroll" />
        </div>
    </section>
</div>
