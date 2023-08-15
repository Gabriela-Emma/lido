<x-public-layout class="proposal" :metaTitle="$proposal->title">
    @push('openGraph')
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="{{$proposal->title}}"/>
        <meta property="og:description" content="{{$proposal->social_post}}"/>
        <meta property="og:url" content="{{$proposal->url}}"/>
        <meta property="og:image" content="{{$proposal->generated_summary_pic}}"/>
        <meta property="og:image:width" content="2048"/>
        <meta property="og:image:height" content="2048"/>
        <meta property="article:publisher" content="{{config('app.name')}}"/>
        <meta property="article:author" content="{{$proposal->author?->name}}"/>
        <meta property="article:published_time" content="{{$proposal->published_at}}"/>
        <meta property="twitter:card" content="summary_large_image"/>
        <meta property="twitter:title" content="{{$proposal->title}}"/>
        <meta property="twitter:description" content="{{$proposal->social_post}}"/>
        <meta property="twitter:image" content="{{$proposal->generated_summary_pic}}"/>
        <meta property="twitter:url" content="{{$proposal->url}}"/>
        <meta property="twitter:site" content="@lidonation"/>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{asset('css/splide-extension-video.min.css')}}">
    @endpush

    @livewire('catalyst.catalyst-sub-menu-component')

    <section class="relative py-10 bg-white lg:py-20">
        <div class="container">
            <section class="relative grid grid-cols-9 gap-6">
                <div class="col-span-9 lg:col-span-3">
                    <div class="lg:sticky lg:top-10">
                        <div class="flex flex-col gap-6">
                            <div class="rounded-sm bg-gradient-to-br from-teal-800 via-teal-600 to-accent-900">
                                <x-catalyst.proposals.social-card :proposal="$proposal" :embedded="true"/>
                            </div>

                            @if($proposal->solution)
                                <div
                                    class="p-4 font-semibold text-white bg-teal-700 border rounded-sm border-slate-300">
                                    <h2>
                                        {{ $snippets->solution}}
                                    </h2>
                                    <x-markdown>{{$proposal->solution}}</x-markdown>
                                </div>
                            @endif

                            @if($proposal->users)
                                <div class="p-4 border rounded-sm border-slate-300">
                                    <h2 class="mb-6">
                                        {{ $snippets->team}}
                                    </h2>
                                    <div>
                                        @if($proposal->users->isNotEmpty())
                                            <ul class="grid grid-cols-4 gap-4 mx-auto sm:grid-cols-3">
                                                @foreach($proposal->users as $catalystUser)
                                                    <li wire:key="{{$catalystUser->id}}">
                                                        <div class="flex flex-col items-center gap-4">
                                                            <a class="block" href="{{$catalystUser->link}}">
                                                                <img
                                                                    class="w-20 h-20 mx-auto rounded-full lg:w-24 lg:h-24"
                                                                    src="{{$catalystUser->thumbnail_url ?? $catalystUser->bio_pic?->getUrl('thumbnail') ?? $catalystUser->gravatar}}"
                                                                    alt="{{$catalystUser->name}} bio pic">
                                                            </a>
                                                            <div class="space-y-2">
                                                                <div class="text-sm font-medium text-center lg:text-xs">
                                                                    <h3 class="">
                                                                        <a class="block font-bold text-teal-600"
                                                                           href="{{$catalystUser->link}}">
                                                                            {{$catalystUser->name}}
                                                                        </a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($proposal->experience)
                                <div class="p-4 border rounded-sm border-slate-300">
                                    <h2>
                                        {{ $snippets->experience}}
                                    </h2>
                                    <x-markdown>{{$proposal->experience}}</x-markdown>
                                </div>
                            @endif

                            <div>
                                <a href="{{localizeRoute('catalystExplorer.proposals')}}" type="button"
                                   class="flex items-center w-full px-6 py-3 text-2xl font-medium text-gray-700 bg-white border rounded-sm border-slate-300 hover:bg-primary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <span class="mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                                        </svg>
                                    </span>
                                    <span class="tracking-wider uppercase">
                                        {{ $snippets->allProposals}}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-9 lg:col-span-6">
                    @if($proposal->funded)
                        <div class="p-4 mb-4 font-semibold text-white bg-teal-700 border rounded-sm border-slate-300">
                            <div class="md:flex md:items-center md:justify-between">
                                <div class="flex-1 min-w-0">
                                    <h4 class="p-4 text-white">
                                        This proposal was approved and funded by the Cardano Community via Project
                                        <strong>{{$proposal->fund?->title}}</strong> Catalyst funding round.
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($proposal->videos->isNotEmpty() || $proposal->media->isNotEmpty())
                        <div class="mb-2 bg-teal-900 primary-slide">
                            <div class="splide round-sm" id="proposal-primary-slide" role="group">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @if($proposal->videos->isNotEmpty())
                                            @foreach($proposal->videos as $video)
                                                @if($video->key == 'youtube' || $video->key == 'quick_pitch')
                                                    <li class="splide__slide" data-splide-youtube="{{$video->content}}">
                                                        <img class="h-auto fluid"
                                                             src="{{$proposal->hero?->getUrl() ?? $settings->catalyst_proposal_default_video_cover}}"
                                                             alt="{{$proposal->hero?->name ?? 'Video cover image'}}"/>
                                                    </li>
                                                @elseif($video->key == 'vimeo')
                                                    <li class="splide__slide" data-splide-vimeo="{{$video->content}}">
                                                        <img class="h-auto fluid"
                                                             src="{{$proposal->hero?->getUrl() ?? $settings->catalyst_proposal_default_video_cover}}"
                                                             alt="{{$proposal->hero?->name ?? 'Video cover image'}}"/>
                                                    </li>
                                                @elseif($video->key == 'video')
                                                    <li class="splide__slide"
                                                        data-splide-html-video="{{$video->content}}">
                                                        <img class="h-auto fluid"
                                                             src="{{$proposal->hero?->getUrl() ?? $settings->catalyst_proposal_default_video_cover}}"
                                                             alt="{{$proposal->hero?->name ?? 'Video cover image'}}"/>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if($proposal->media->isNotEmpty())
                                            @foreach($proposal->media as $media)
                                                <li class="splide__slide">
                                                    <img class="fluid" src="{{$proposal->hero_url}}"
                                                         alt="{{$media?->name}}"/>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if($proposal->videos->concat($proposal->media)->count() > 0)
                            <div class="mb-6 secondary-slide">
                                <div class="splide round-sm" id="proposal-secondary-slide">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @if($proposal->videos->isNotEmpty())
                                                @foreach($proposal->videos as $video)
                                                    <li class="relative flex flex-col items-center justify-center text-teal-400 bg-teal-700 splide__slide">
                                                        @if($video->key === 'quick_pitch')
                                                            <span
                                                                class="absolute z-0 h-full text-lg text-left text-teal-300 pointer-events-none left-1 quick-pitch-badge opacity-30">
                                                            Quick<br/> Pitch
                                                        </span>
                                                        @endif
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </li>
                                                @endforeach
                                            @endif
                                            @if($proposal->media->isNotEmpty())
                                                @foreach($proposal->media as $media)
                                                    <li class="splide__slide">
                                                        <img class="fluid" src="{{$proposal->hero_url}}"
                                                             alt="{{$media?->name}}"/>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="pb-4"></div>
                        @endif
                    @endif

                    @if($proposal->content)
                        <x-catalyst.proposals.proposal-content :proposal="$proposal" :pageLocale="(app()->getLocale())"  />
                    @endif

                    <section class="py-12 mt-8 border shadow-sm bg-gray-50 border-slate-200">
                        <div class="max-w-6xl px-6 xl:mx-auto">
                            <livewire:comments :showNotificationOptions="Auth::check()"
                                               :hideNotificationOptions="!Auth::check()" :hideAvatars="false"
                                               :noReplies="false" :model="$proposal"/>
                        </div>
                    </section>

                    <!-- Discussions -->
                    <section class="relative mt-10" id="discussions">
                        @if($proposal->discussions->isNotEmpty())
                            <h2 class="mb-8 text-4xl decorate dark">
                                {{ $snippets->communityAdvisorReviews }}
                            </h2>
                            <div class="proposal-discussions-wrapper">
                                <x-public.discussions :model="$proposal" :editable="false"></x-public.discussions>
                            </div>
                        @endif
                    </section>
                </div>
            </section>

            @if($proposal->commits?->isNotEmpty())
                <section class="px-4 py-8 mt-8 xl:py-16 bg-slate-100 round-sm">
                    <h2 class="my-2 text-center text-teal-800 2xl:text-5xl">
                        Development Updates
                    </h2>

                    <div class="gap-4 mt-6 columns-1 sm:columns-2 xl:columns-3 monthly-reports">
                        @foreach($proposal->commits as $commit)
                            <x-catalyst.commits.drip wire:key="{{$commit->id}}" :commit="$commit"/>
                        @endforeach
                    </div>
                </section>
            @endif
            @if($proposal->funded && $proposal->monthly_reports)
                <section class="px-4 py-8 mt-8 xl:py-16 bg-slate-100 round-sm">
                    <h2 class="my-2 text-center text-teal-800 2xl:text-5xl">
                        Monthly Reports
                    </h2>

                    <div class="flex justify-center w-full gap-4 mt-6 follow-reports">
                        <div class="rounded-md">
                            <x-catalyst.follow-monthly-reports :model="$proposal"/>
                        </div>
                    </div>

                    <div class="gap-4 mt-6 columns-1 sm:columns-2 xl:columns-3 monthly-reports">
                        @foreach($proposal->monthly_reports->reverse() as $report)
                            <x-catalyst.reports.drip wire:key="{{$report->id}}" :report="$report"/>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>

</x-public-layout>
