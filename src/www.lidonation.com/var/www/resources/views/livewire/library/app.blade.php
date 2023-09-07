<section class="relative py-8 bg-white md:py-16">
    <div class="container flex flex-row items-center justify-between">
        <div class="flex flex-col gap-1">
            <h1 class="text-4xl font-semibold leading-8 tracking-tight text-slate-800 lg:text-5xl xl:text-6xl 2xl:text-7xl md:pr-8 xl:pr-20 2xl:max-w-7xl">
                Lido Nation <span class="text-teal-500">Library</span>
            </h1>
            <p class="xl:text-2xl 2xl:text-3xl">
                Blockchain Education in Plain <br/>
                <span class="font-semibold text-yellow-500">English</span>,
                <span class="font-semibold text-slate-800">Kiswahili</span>, &
                <span class="font-semibold text-green-500">Español</span>.
            </p>

            <div>
                <x-public.mailchimp-form layout="row"/>
            </div>
        </div>

        <div class="hidden lg:block">
            <div class="">
                <span class="text-2xl lg:text-4xl xl:text-7xl 2xl:text-10xl text-slate-200 font-display">
                    {{$postsCount}}
                </span>
            </div>
        </div>
    </div>
</section>

<x-new-to-library :newToLibrary="$newToLibrary"
                  :latestLidoMinute="$latestLidoMinute" />

@if($categories && $categories->isNotEmpty())
    <section id="browse-by-categorys" class="relative py-16 bg-eggplant-500">
        <div class="container">
            <h2 class="mb-4 text-2xl font-extrabold xl:text-4xl 2xl:text-6xl text-slate-50">
                Browse by Category
            </h2>

            <div class="p-2 splide slider-splide" aria-label="Basic Structure Example">
                <div class="splide__track">
                    <div class="gap-2 splide__list">
                        @foreach($categories as $cat)
                            <div class="splide__slide">
                                <div class="bg-white rounded-sm">
                                    <a href="{{$cat->url}}" class="block">
                                        <img class="aspect-w-1aspect-h-2" alt="{{$cat->title}}'s hero"
                                             src="{{ $cat->thumbnail_url }}"/>
                                    </a>
                                    <div class="flex flex-row items-center justify-between p-4 border-t border-slate-400">
                                        <a href="{{$cat->url}}" class="font-semibold text-slate-700">
                                            {{$cat->title}}
                                        </a>
                                        <div class="rounded-sm bg-slate-100">
                                            <div class="px-4 py-3 font-semibold rounded-sm bg-slate-300 aspect-square">
                                                {{$cat->posts_count}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<section id="bite-size-lido-minutes" class="py-16 bg-primary-10">
    <header class="py-16">
        <div class="container">
            <h1 class="pr-8 text-3xl font-light leading-8 tracking-tight text-slate-800 sm:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl xl:pr-20 2xl:max-w-7xl">
                <span class="font-extrabold text-yellow-500">LIDO Minute.</span>
                <span>Bite size podcast for Blockchain & Cardano education.</span>
            </h1>
        </div>
    </header>

    <div class="container">
        @if($latestLidoMinutes)
        <section class="relative mb-16 splide minute-splide bg-primary-10" id="new-lido-minutes">
            <div class="splide__track">
                <div class="gap-2 splide__list episodes">
                    @foreach($latestLidoMinutes as $post)
                        <div class="splide__slide">
                            @include('podcast.drip')
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    </div>
</section>

@if($categories && !empty($categories))
    @foreach(collect($categories)->take(2) as $cat)
        @if($cat->models && $cat->models->isNotEmpty())
            <section class="relative py-16 bg-white border-t border-slate-300"
            x-data='scrollSection()'
            >
                <div class="container">
                    <h2 class="mb-6 text-2xl font-extrabold xl:text-4xl 2xl:text-6xl text-slate-700">
                        <span class="block text-sm text-slate-500">Category</span> <span class="block">{{$cat->title}}</span>
                    </h2>

                    <x-left-arrow :category="$cat->id"/>
                    <x-right-arrow :category="$cat->id"/>

                    <div>
                        <div class="flex flex-row gap-6 overflow-x-auto md:flex-nowrap no-scrollbar" id="{{$cat->id}}">
                            @foreach($cat->models as $post)
                                <div class="w-full h-full">
                                    <div class="w-64 bg-white rounded-sm md:w-72 lg:w-80">
                                        <a href="{{$post->url}}" class="block">
                                            <img class="rounded-sm aspect-w-1aspect-h-2" alt="{{$post->title}}'s hero"
                                                 src="{{ $post->thumbnail_url }}"/>
                                        </a>

                                        <div class="py-4 border-t border-slate-400">
                                            <x-public.post-type :post="$post"></x-public.post-type>

                                            <div
                                                class="flex flex-row items-center justify-between">

                                                <a href="{{$post->url}}" class="font-semibold text-slate-700">
                                                    {{$post->title}}
                                                </a>
                                                <div
                                                    class="items-center flex-shrink-0 gap-1 rounded-sm rounded-full sm:inline-flex author">
                                                    <div class="inline-block bio-pic">
                                                        <img
                                                            class="w-8 h-8 rounded-full"
                                                            src="{{$post->author?->gravatar}}"
                                                            title="{{$post->author?->name}}"
                                                            alt="{{$post->author?->name}} Bio Pic"/>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($post->subtitle)
                                                <p class='relative text-lg font-medium subtitle'>
                                                    {{ $post->subtitle }}
                                                </p>
                                            @endif

                                            <div class="py-2 mb-4">
                                                <x-public.post-meta :post="$post"></x-public.post-meta>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endif

@if($reviews?->isNotEmpty())
    <section class="relative bg-gray-50 reviews" id="reviews-section">
        <div class="container px-4 py-12 mx-auto sm:px-6 lg:px-8 lg:py-24">
            <h2 class="pt-0 mt-0 mb-2 text-3xl font-extrabold text-pink-500 xl:text-4xl 2xl:text-3xl">
                {{$snippets->reviews}}
            </h2>

            <p class="mb-8 text-2xl text-gray-500">
                {{$snippets->promisingConsumerFacingProjectsInTheCardanoEcosystem}}
            </p>

            <div class="">
                @foreach($reviews->take(9)->chunk(3) as $group)
                    <div class="grid grid-cols-2 gap-8 mb-8 lg:grid-cols-5 lg:grid-rows-4"
                         style="{{$loop->even ? 'direction:rtl;' : ''}}">
                        @foreach($group as $post)
                            <div
                                style="direction: initial"
                                class="{{$loop->first ? 'lg:row-span-4 col-span-2 lg:col-span-3' : 'lg:row-span-2 lg:col-span-2'}}">
                                <div
                                    class="flex flex-col justify-start h-full article review">
                                    @if($post->hero)
                                        <div class="flex-shrink-0 mb-4">
                                            <a href="{{$post->link}}">
                                                @if($loop->first)
                                                    <img
                                                        class="object-cover w-full bg-teal-600 filter hover:contrast-200"
                                                        srcset="{{$post->hero?->getSrcset('large')}}"
                                                        src="{{$post->hero?->getUrl('large')}}"
                                                        alt="{{$post->hero?->name}}"/>
                                                @else
                                                    <img
                                                        class="object-cover w-full bg-teal-600 filter hover:contrast-200"
                                                        srcset="{{$post->hero?->getSrcset('thumbnail')}}"
                                                        src="{{$post->hero?->getUrl('thumbnail')}}"
                                                        alt="{{$post->hero?->name}}"/>
                                                @endif
                                            </a>
                                        </div>
                                    @endif

                                    <div class="flex flex-row mb-1">
                                        @if($post?->categories?->isNotEmpty())
                                            <x-public.post-taxonomies
                                                :tax="$post->categories->first()"></x-public.post-taxonomies>
                                        @endif
                                    </div>
                                    <h3 class="text-2xl font-semibold text-gray-900 capitalize">
                                        <a href="{{$post->link}}"
                                           class="space-x-1 hover:text-teal-600 line-clamp-4 lg:line-clamp-2">
                                                <span>
                                                    {{$post->title}}
                                                </span>
                                            <span class="capitalize">
                                                {{$snippets->review}}
                                                </span>
                                        </a>
                                    </h3>

                                    @if(!$loop->first)
                                        <div class="py-1 mb-4">
                                            <span class="hidden md:w-5 md:h-5"></span>
                                            <x-public.stars :amount="$post?->ratings_average" :size="5"/>
                                        </div>
                                    @endif

                                    <div
                                        class="text-base text-gray-500 overflow-x-hidden {{!$loop->first ? 'lg:line-clamp-4' : 'lg:line-clamp-9'}}">
                                        <x-markdown>{{$post->summary}}</x-markdown>
                                    </div>

                                    <div>
                                        @if($loop->first)
                                            <div>
                                                <x-public.review-rating-summary
                                                    :review="$post"></x-public.review-rating-summary>
                                            </div>
                                        @endif
                                    </div>
                                    @if($loop->first)
                                        <div class="mt-4 text-sm capitalize">
                                            <x-public.continue-reading
                                                :link="$post->url"
                                                :text="$snippets->readFullReview"></x-public.continue-reading>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<x-lido-tag :tags="$tags"/>

<x-support-lido heading-leading='Support the' heading-span='Library'/>

@if($categories && !empty($categories))
    @foreach(collect($categories)->skip(2)->take(2) as $cat)
        @if($cat->models && $cat->models->isNotEmpty())
            <section class="relative py-16 bg-primary-10 border-y" id="new-to-library"
            x-data='scrollSection()'
            >
                <div class="container">
                    <h2 class="mb-6 text-2xl font-extrabold xl:text-4xl 2xl:text-6xl text-slate-700">
                        <span class="block text-sm text-slate-500">Category</span> <span class="block">{{$cat->title}}</span>
                    </h2>
                </div>
                <div class="container">
                    <div class="flex gap-8 overflow-x-auto flex-nowrap posts" id="{{$cat->id}}">
                        <div class="flex flex-col flex-1">
                            <div
                                class="flex flex-row gap-6 flex-nowrap xl:gridxl:grid-cols-22xl:grid-cols-3 posts">
                                @foreach($cat->models as $post)
                                    <div
                                        class="w-[380px] xl:w[420px] 2xl:w-[420px] md:border-r md:border-gray-300 px-5 -mt-px -ml-px post">
                                            <?php $showHero = true; ?>
                                        @include("post.drip")
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <x-left-arrow :category="$cat->id"/>
                    <x-right-arrow :category="$cat->id"/>
                </div>
            </section>
        @endif
    @endforeach
@endif

<section id="new-to-cardano" class="relative bg-white">
    <div class="container px-4 py-12 mx-auto text-center sm:px-6 lg:px-8 lg:py-20">
        <h2 class="mb-4 text-2xl font-extrabold text-teal-600 xl:text-4xl 2xl:text-6xl">
            {{$snippets->newToCardano}}
        </h2>
        <p>
            {{$snippets->resourcesToGetYouStarted}}
        </p>
        <div>
            <ul class="grid items-end justify-center grid-cols-2 gap-20 mt-12 lg:grid-cols-4 xl:text-xl 3xl:text-2xl">
                <li class="flow-root">
                    <a href="{{route('what-is-cardano')}}"
                       class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                        <div class="w-20 icon">
                            @include('svg.cardano')
                        </div>
                        <span>
                                {{$snippets->whatIsCardano}}
                            </span>
                    </a>
                </li>

                <li class="flow-root">
                    <a href="{{route('what-is-staking')}}"
                       class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                        <div class="w-20 icon">
                            @include('svg.pool-network')
                        </div>
                        <span>
                            {{$snippets->whatIsStaking}}
                        </span>
                    </a>
                </li>

                <li class="flow-root">
                    <a href="{{route('how-to-buy-ada')}}"
                       class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                        <div class="w-20 icon">
                            @include('svg.crypto-bank')
                        </div>
                        <span>
                            {{$snippets->howToBuyADA}}
                        </span>
                    </a>
                </li>

                <li class="flow-root">
                    <a href="{{route('how-to-stake-ada')}}"
                       class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                        <div class="w-20 icon">
                            @include('svg.funfair')
                        </div>
                        <span>
                                {{$snippets->howToStakeYourADA}}
                            </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>


@if($categories && !empty($categories))
    @foreach(collect($categories)->skip(4)->take(2) as $cat)
        @if($cat->models && $cat->models->isNotEmpty())
            <section class="relative py-16 bg-primary-10 border-y" id="new-to-library"
            x-data='scrollSection()'
            >
                <div class="container">
                    <h2 class="mb-6 text-2xl font-extrabold xl:text-4xl 2xl:text-6xl text-slate-700">
                        <span class="block text-sm text-slate-500">Category</span> <span class="block">{{$cat->title}}</span>
                    </h2>
                </div>
                <div class="container">
                    <div class="flex gap-8 overflow-x-auto flex-nowrap posts" id="{{$cat->id}}">
                        <div class="flex flex-col flex-1">
                            <div
                                class="flex flex-row gap-6 flex-nowrap xl:gridxl:grid-cols-22xl:grid-cols-3 posts">
                                @foreach($cat->models as $post)
                                    <div
                                        class="w-[380px] xl:w[420px] 2xl:w-[420px] md:border-r md:border-gray-300 px-5 -mt-px -ml-px post">
                                            <?php $showHero = true; ?>
                                        @include("post.drip")
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <x-left-arrow :category="$cat->id"/>
                    <x-right-arrow :category="$cat->id"/>
                </div>
            </section>
        @endif
    @endforeach
@endif
