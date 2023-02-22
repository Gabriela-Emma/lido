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

                            @if($proposal->users)
                                <div class="p-4 border border-slate-300 rounded-sm">
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
                                <div class="p-4 border border-slate-300 rounded-sm">
                                    <h2>
                                        {{ $snippets->experience}}
                                    </h2>
                                    <x-markdown>{{$proposal->experience}}</x-markdown>
                                </div>
                            @endif

                            @if($proposal->solution)
                                <div
                                    class="p-4 font-semibold text-white border border-slate-300 rounded-sm bg-teal-700">
                                    <h2>
                                        {{ $snippets->solution}}
                                    </h2>
                                    <x-markdown>{{$proposal->solution}}</x-markdown>
                                </div>
                            @endif

                            <div class="flex flex-row justify-around gap-2 p-4 bg-slate-200" x-data="voterTool">
                                <button type="button"
                                        @click="bookmarkProposal( {
                                            id: {{$proposal->id}},
                                            title: @js($proposal->title),
                                            type: @js($proposal->type),
                                            amount: {{$proposal->amount_requested}},
                                            ideascale_link: '{{$proposal->ideascale_link}}',
                                            link: '{{$proposal->link}}',
                                            fundId: {{$proposal->fund->id}},
                                            fundTitle: @js($proposal->fund->label),
                                            fundAmount: {{$proposal->fund?->amount}},
                                            proposalsCount: {{$proposal->fund?->proposals_count}},
                                            fundHero: '{{$proposal->fund?->thumbnail_url}}'
                                        } )"
                                        class="inline-flex items-center gap-1 xl:gap-2 p-1 xl:p-2 w-1/2  text-xs xl:text-sm 2xl:text-lg font-medium text-gray-700 bg-white border border-slate-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                    <span x-show="!has({{$proposal->id}})">Bookmark&nbsp;&nbsp;&nbsp;</span>
                                    <span class="" x-show="has({{$proposal->id}})">Bookmarked</span>
                                    <svg x-show="has({{$proposal->id}})"
                                         class="w-4 h-4 2xl:w-5 2xl:h-5 mr-2 -ml-1 text-pink-600"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path x-show="proposalsStore.length > 0"
                                              d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                    </svg>
                                    <svg x-show="!has({{$proposal->id}})" xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5 mr-2 -ml-1 text-pink-600"
                                         fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                </button>
                                @if($proposal->fund?->status == 'governance')
                                    <button type="button"
                                            @click="up( {
                                                id: {{$proposal->id}},
                                                title: @js($proposal->title),
                                                type: @js($proposal->type),
                                                amount: {{$proposal->amount_requested}},
                                                ideascale_link: '{{$proposal->ideascale_link}}',
                                                link: '{{$proposal->link}}',
                                                fundId: {{$proposal->fund->id}},
                                                fundTitle: @js($proposal->fund->label),
                                                fundAmount: {{$proposal->fund?->amount}},
                                                proposalsCount: {{$proposal->fund?->proposals_count}},
                                                fundHero: '{{$proposal->fund?->thumbnail_url}}',
                                                labels: [@js($proposal->fund?->parent?->label) + ' Picklist']
                                            } )"
                                            class="inline-flex items-center gap-1 xl:gap-2 p-1 xl:p-2 text-xs xl:text-sm 2xl:text-lg font-medium text-gray-700 bg-white border border-slate-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                        <span x-show="!has({{$proposal->id}}, 'upvote')">Upvote</span>
                                        <span x-show="has({{$proposal->id}}, 'upvote')">Remove</span>
                                        <svg x-show="has({{$proposal->id}}, 'upvote')"
                                             xmlns="http://www.w3.org/2000/svg"
                                             class=" w-4 h-4 2xl:w-5 2xl:h-5 text-teal-700" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path
                                                d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                        </svg>
                                        <svg x-show="!has({{$proposal->id}}, 'upvote')"
                                             xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 2xl:w-6 2xl:h-6"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                    </button>
                                    <button type="button"
                                            @click="down( {
                                            id: {{$proposal->id}},
                                            title: @js($proposal->title),
                                            type: @js($proposal->type),
                                            amount: {{$proposal->amount_requested}},
                                            ideascale_link: '{{$proposal->ideascale_link}}',
                                            link: '{{$proposal->link}}',
                                            fundId: {{$proposal->fund->id}},
                                            fundTitle: @js($proposal->fund->label),
                                            fundAmount: {{$proposal->fund?->amount}},
                                            proposalsCount: {{$proposal->fund?->proposals_count}},
                                            fundHero: '{{$proposal->fund?->thumbnail_url}}',
                                            labels: [@js($proposal->fund?->parent?->label) + ' Picklist']
                                        })"
                                            class="inline-flex items-center gap-1 xl:gap-2 p-1 xl:p-2 py-2 text-xs xl:text-sm 2xl:text-lg font-medium text-gray-700 bg-white border border-slate-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                        <span x-show="!has({{$proposal->id}}, 'downvote')">Downvote</span>
                                        <span x-show="has({{$proposal->id}}, 'downvote')">Remove</span>

                                        <svg x-show="has({{$proposal->id}}, 'downvote')"
                                             xmlns="http://www.w3.org/2000/svg"
                                             class="w-4 h-4 2xl:w-5 2xl:h-5 text-black-700" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path
                                                d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                                        </svg>
                                        <svg x-show="!has({{$proposal->id}}, 'downvote')"
                                             xmlns="http://www.w3.org/2000/svg" class=" w-4 h-4 2xl:w-6 2xl:h-6"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <div>
                                <a href="{{localizeRoute('catalystExplorer.proposals')}}" type="button"
                                   class="flex items-center w-full px-6 py-3 text-2xl font-medium text-gray-700 bg-white border border-slate-300 rounded-sm hover:bg-primary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
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
                        <div class="p-4 font-semibold text-white border border-slate-300 rounded-sm bg-teal-700 mb-4">
                            <div class="md:flex md:items-center md:justify-between">
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-white p-4">
                                        This proposal was approved and funded by the Cardano Community via Project
                                        <strong>{{$proposal->fund?->title}}</strong> Catalyst funding round.
                                    </h4>

{{--                                    <div>--}}
{{--                                        <nav class="hidden sm:flex" aria-label="Breadcrumb">--}}
{{--                                            <ol role="list" class="flex items-center space-x-4">--}}
{{--                                                <li>--}}
{{--                                                    <div class="flex">--}}
{{--                                                        <a href="#"--}}
{{--                                                           class="text-sm font-medium text-gray-400 hover:text-gray-200">Jobs</a>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <div class="flex items-center">--}}
{{--                                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-500" viewBox="0 0 20 20"--}}
{{--                                                             fill="currentColor" aria-hidden="true">--}}
{{--                                                            <path fill-rule="evenodd"--}}
{{--                                                                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"--}}
{{--                                                                  clip-rule="evenodd"/>--}}
{{--                                                        </svg>--}}
{{--                                                        <a href="#"--}}
{{--                                                           class="ml-4 text-sm font-medium text-gray-400 hover:text-gray-200">Engineering</a>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <div class="flex items-center">--}}
{{--                                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-500" viewBox="0 0 20 20"--}}
{{--                                                             fill="currentColor" aria-hidden="true">--}}
{{--                                                            <path fill-rule="evenodd"--}}
{{--                                                                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"--}}
{{--                                                                  clip-rule="evenodd"/>--}}
{{--                                                        </svg>--}}
{{--                                                        <a href="#" aria-current="page"--}}
{{--                                                           class="ml-4 text-sm font-medium text-gray-400 hover:text-gray-200">Back--}}
{{--                                                            End Developer</a>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
{{--                                            </ol>--}}
{{--                                        </nav>--}}
{{--                                    </div>--}}
                                </div>
{{--                                <div class="mt-4 flex flex-shrink-0 md:mt-0 md:ml-4">--}}
{{--                                    <button type="button"--}}
{{--                                            class="inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">--}}
{{--                                        Edit--}}
{{--                                    </button>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    @endif

                    @if($proposal->videos->isNotEmpty() || $proposal->media->isNotEmpty())
                        <div class="mb-2 bg-teal-800 primary-slide">
                            <div class="splide round-sm" id="proposal-primary-slide" role="group">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @if($proposal->videos->isNotEmpty())
                                            @foreach($proposal->videos as $video)
                                                @if($video->key == 'youtube' || $video->key == 'quick_pitch')
                                                    <li class="splide__slide" data-splide-youtube="{{$video->content}}">
                                                        <img class="fluid h-auto"
                                                             src="{{$proposal->hero?->getUrl() ?? $settings->catalyst_proposal_default_video_cover}}"
                                                             alt="{{$proposal->hero?->name ?? 'Video cover image'}}"/>
                                                    </li>
                                                @elseif($video->key == 'vimeo')
                                                    <li class="splide__slide" data-splide-vimeo="{{$video->content}}">
                                                        <img class="fluid h-auto"
                                                             src="{{$proposal->hero?->getUrl() ?? $settings->catalyst_proposal_default_video_cover}}"
                                                             alt="{{$proposal->hero?->name ?? 'Video cover image'}}"/>
                                                    </li>
                                                @elseif($video->key == 'video')
                                                    <li class="splide__slide"
                                                        data-splide-html-video="{{$video->content}}">
                                                        <img class="fluid h-auto"
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
                                                    <li class="flex flex-col items-center justify-center splide__slide bg-teal-700 text-teal-400 relative">
                                                        @if($video->key === 'quick_pitch')
                                                            <span
                                                                class="absolute text-lg text-left h-full left-1 pointer-events-none quick-pitch-badge text-teal-300 opacity-30 z-0">
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

                    @if($proposal->content || $proposal->defination_of_success)
                        <div x-data="{heightClass: 'max-h-[50rem] overflow-clip', funded: @js($proposal->funded)}"
                             class="relative p-4 border border-slate-300 rounded-sm break-normal">
                            <article :class="heightClass" x-transition>
                                @if($proposal->content)
                                    <x-markdown>{{$proposal->content}}</x-markdown>
                                @endif

                                @if($proposal->definition_of_success)
                                    <h2>Definition of Success</h2>
                                    <x-markdown>{{$proposal->definition_of_success}}</x-markdown>
                                @endif
                            </article>

                            <div @click="heightClass = ''" x-show="!heightClass"
                                 class="absolute w-full p-4 text-center bg-white/95 hover:cursor-pointer group bottom-4">
                                <span class="font-bold text-teal-600 group-hover:text-slate-600">
                                    Expand
                                </span>
                            </div>
                        </div>
                    @endif

                    <section class="py-12 bg-gray-50 border border-slate-200 mt-8 shadow-sm">
                        <div class="px-6 max-w-6xl xl:mx-auto">
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
                            <div class="">
                                <x-public.discussions :model="$proposal" :editable="false"></x-public.discussions>
                            </div>
                        @endif
                    </section>
                </div>
            </section>

            @if($proposal->commits?->isNotEmpty())
                <section class="px-4 py-8 xl:py-16 mt-8 bg-slate-100 round-sm">
                    <h2 class="text-center my-2 text-teal-800 2xl:text-5xl">
                        Development Updates
                    </h2>

                    <div class="mt-6 columns-1 sm:columns-2 xl:columns-3 gap-4 monthly-reports">
                        @foreach($proposal->commits as $commit)
                            <x-catalyst.commits.drip wire:key="{{$commit->id}}" :commit="$commit"/>
                        @endforeach
                    </div>
                </section>
            @endif
            @if($proposal->funded && $proposal->monthly_reports)
                <section class="px-4 py-8 xl:py-16 mt-8 bg-slate-100 round-sm">
                    <h2 class="text-center my-2 text-teal-800 2xl:text-5xl">
                        Monthly Reports
                    </h2>

                    <div class="mt-6 flex justify-center gap-4 follow-reports w-full">
                        <div class="rounded-md">
                            <x-catalyst.follow-monthly-reports :model="$proposal"/>
                        </div>
                    </div>

                    <div class="mt-6 columns-1 sm:columns-2 xl:columns-3 gap-4 monthly-reports">
                        @foreach($proposal->monthly_reports->reverse() as $report)
                            <x-catalyst.reports.drip wire:key="{{$report->id}}" :report="$report"/>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>

</x-public-layout>
