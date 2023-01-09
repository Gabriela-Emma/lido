<x-public-layout class="review" :metaTitle="$review->title">
    @push('openGraph')
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="{{$review->title}}"/>
        <meta property="og:description" content="{{$review->social_post}}"/>
        <meta property="og:url" content="{{$review->url}}"/>
        <meta property="og:image" content="{{$review->generated_summary_pic}}"/>
        <meta property="og:image:width" content="580"/>
        <meta property="og:image:height" content="1200"/>
        <meta property="article:publisher" content="{{config('app.name')}}"/>
        <meta property="article:author" content="{{$review->author?->name}}"/>
        <meta property="article:published_time" content="{{$review->published_at}}"/>

        @if($review->categories->isNotEmpty())
            <meta property="article:section" content="{{$review->categories->first()->title}}"/>
        @endif

        @foreach($review->tags as $tax)
            <meta property="article:tag" content="{{$tax->title}}"/>
        @endforeach

        <meta property="twitter:card" content="summary_large_image"/>
        <meta property="twitter:title" content="{{$review->title}}"/>
        <meta property="twitter:description" content="{{$review->social_post}}"/>
        <meta property="twitter:image" content="{{$review->generated_summary_pic}}"/>
        <meta property="twitter:url" content="{{$review->url}}"/>
        <meta property="twitter:site" content="@lidonation"/>
    @endpush
    @push('tags')
        @foreach(config('laravellocalization.supportedLocales') as $key => $locale)
            @if($key == app()->getLocale())
                @continue
            @endif
            @if(Lang::has($review->getTable() . '.' . $review->slug, $key ))
                <link rel="alternate" hreflang="{{$key}}" href="{{LaravelLocalization::getLocalizedURL($key)}}"/>
            @endif
        @endforeach
        @if(config('app.fallback_locale') != app()->getLocale())
            <link rel="alternate" hreflang="{{config('app.fallback_locale')}}"
                  href="{{LaravelLocalization::getLocalizedURL(config('app.fallback_locale'))}}"/>
        @endif
    @endpush
    <header class="text-white bg-teal-600">
        <div class="container">
            <section class="overflow-visible relative z-0 py-10 lg:px-4">
                <h1 class='flex relative flex-row flex-wrap gap-0 items-end mb-6 text-3xl font-bold 2xl:text-5xl decorate'>
                    <span class="pr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </span>
                    <span class="font-semibold">{{$review->title}}:&nbsp;</span>
                    <span class="font-normal capitalize">
                        {{ $snippets->aReview }}
                    </span>
                </h1>
                <div class="summary">
                    <h2 class="relative">Summary</h2>
                    <div class="mt-4">
                        <x-markdown>{{$review->summary}}</x-markdown>
                    </div>
                </div>

                <x-public.review-rating-summary :review="$review"></x-public.review-rating-summary>
            </section>
        </div>
    </header>

    <section
        class="overflow-visible relative py-10 bg-white bg-opacity-90 bg-left-bottom bg-repeat-y bg-contain bg-blend-color-burn lg:py-20 bg-pool-bw-light">
        <div class="container">
            @if(Lang::hasAny($review->getTable() . '.' . $review->slug, collect(config('laravellocalization.supportedLocales'))->keys()))
                <div class="mb-8 max-w-6xl">
                    <div class="flex flex-row flex-wrap gap-4 justify-center items-end w-full text-sm">
                        <h3 class="text-sm text-center text-gray-600 capitalize">{{ $snippets->alsoAvailableIn }}</h3>
                        @foreach(config('laravellocalization.supportedLocales') as $key => $locale)
                            @if($key == app()->getLocale())
                                @continue
                            @endif
                            @if(Lang::has($review->getTable() . '.' . $review->slug, $key ))
                                <a href="{{LaravelLocalization::getLocalizedURL($key)}}"
                                   class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600 hover:text-gray-500">
                                    {{$locale['native']}}
                                </a>
                            @endif
                        @endforeach
                        @if(config('app.fallback_locale') != app()->getLocale())
                            <a href="{{LaravelLocalization::getLocalizedURL(config('app.fallback_locale'))}}"
                               class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600">
                                english
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <div class="pb-8 bg-white">
                <div class="relative px-4 py-8 sm:px-6 lg:px-8">
                    <div class="max-w-6xl">
                        @if($review->content)
                            <article class="mb-6 text-xl">
                                <div class="mt-3">
                                    <div class="mb-5 italic">
                                        {{ $snippets->ratingSystemExplain }}
                                    </div>

                                    @if(Lang::has($review->getTable() . '.' . $review->slug ))
                                        <x-markdown>{{__($review->getTable() . '.' . $review->slug)}}</x-markdown>
                                    @else
                                        <x-markdown>{{$review->content}}</x-markdown>
                                    @endif
                                </div>
                            </article>

                            <div>
                                <x-public.links :links="$review->links" />
                            </div>

                            <div>
                                <hr class="border-gray-300"/>
                                <x-public.social-share :post="$review"
                                                       text="New Cardano Community Review @lidonation"></x-public.social-share>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Discussions -->
    <section class="relative" id="comments">
        <div class="container py-12 lg:py-16">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-8">
                <div class="col-span-6">
                    @if($review->discussions->isNotEmpty())
                        <h2 class="mb-8 text-4xl decorate dark">
                            {{ $snippets->reviewsDiscussions }}
                        </h2>
                        <div class="mb-10">
                            {{ $snippets->ratingDiscussionIntro }}
                        </div>
                        <div class="">
                            <x-public.discussions :model="$review"></x-public.discussions>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar -->
                <div class="col-span-2">
                    <div class="hidden sticky top-10 gap-10 md:flex md:flex-col">
                        <x-public.widgets.author :author="$review->author"/>
                        <x-public.widgets.newsletter/>
                        <x-public.widgets.meetup :meetups="$meetups" :dayOfWeek="$dayOfWeek" :hourOfDay="$hourOfDay"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
