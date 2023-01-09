<style>
    footer, #header, #mobile-menu, #top-blob {
        display: none !important;
    }
</style>
<x-public-layout class="review" :metaTitle="$review->title">
    <header class="text-white bg-teal-600">
        <div class="container">
            <section class="overflow-visible relative z-20 py-10 lg:px-4">
                <h1 class='flex relative flex-row flex-wrap gap-0 items-end mb-6 text-3xl font-bold 2xl:text-5xl decorate'>
                    <span class="pr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </span>
                    <span class="font-semibold">{{$review->title}}</span>
                    <span class="font-normal capitalize">
                        : {{ $snippets->aReview}}
                    </span>
                </h1>
                <div class="summary">
                    <h2 class="relative">Summary</h2>
                    <div class="mt-4">
                        <x-markdown>{{$review->summary}}</x-markdown>
                    </div>
                </div>

                <x-public.review-rating-summary :review="$review" ></x-public.review-rating-summary>
            </section>
        </div>
    </header>
</x-public-layout>
