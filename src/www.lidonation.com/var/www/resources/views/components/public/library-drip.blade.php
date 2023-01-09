@props(['posts'])
<div class="pt-16 pb-20 bg-white lg:pt-24 lg:pb-28">
    <div class="container relative mx-auto divide-y-2 divide-gray-300">
        <div class="flex flex-row flex-wrap gap-4 justify-start mb-4 divide-y-2 divide-gray-300 md:flex-nowrap md:divide-y-0 md:divide-x-2">
            <div class="flex-shrink-1 md:max-w-md lg:max-w-lg xl:max-w-xl 2xl:max-w-3xl 2xl:w-[700px]">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    <a href="{{localizeRoute('library')}}" class="capitalize">
                        {{$snippets->fromOurLibrary}}
                    </a>
                </h2>
                <p class="mt-3 mb-1 text-xl text-gray-500 sm:mt-4">
                    {{$snippets->headlinesInsightsReviews}}
                </p>
            </div>
            <div class="min-w-full md:min-w-[360px]">
                <x-public.widgets.newsletter bg="" classes="px-0 md:p-4 md:px-8" />
            </div>
        </div>

        <div class="w-full">
            <div class="splide" id="news-drip">
                <div class="splide__track">
                    <div class="grid gap-y-4 pt-12 mt-12 lg:grid-cols-3 splide__list">
                        @foreach($posts as $post)
                            <div class="splide__slide">
                                <div class="pr-4 md:pr-8 article">
                                    <div class="block mt-4 font-medium text-gray-700 hover:text-gray-700">
                                        @if($post->hero)
                                            <div>
                                                <a href="{{$post->link}}">
                                                    @if($loop->first)
                                                        <img class="fluid" src="{{$post->hero?->getUrl('large')}}"
                                                            alt="{{$post->hero?->name}}"/>
                                                    @endif
                                                </a>
                                            </div>
                                        @endif

                                        <div class="block mt-3">
                                            @if($post->categories->isNotEmpty())
                                                <x-public.post-taxonomies
                                                    textColor="text-white"
                                                    :tax="$post->categories->first()"></x-public.post-taxonomies>
                                            @endif
                                        </div>

                                        <div class="block">
                                            <a href="{{$post->link}}"
                                                class="font-semibold text-gray-900 hover:text-teal-600 line-clamp-2 2xl:line-clamp-3 capitalize {{$loop->first ? 'text-3xl pt-1': 'text-xl'}}">
                                                {{$post->title}} @if($post->type === \App\Models\Review::class) {{$snippets->review}} @endif
                                            </a>
                                        </div>
                                        <div class="flex items-center pt-1">
                                            <div
                                                class="flex flex-nowrap gap-3 items-center text-sm text-gray-500 post-meta">
                                                <time class="inline-flex items-center"
                                                    datetime="{{$post->published_at}}">{{$post->published_at_formatted}}</time>
                                                @if($post->content)
                                                    {{--                                                <span aria-hidden="true">&middot;</span>--}}
                                                    <span class="inline-flex items-center">
                                                    {{read_time($post->content)}}
                                                </span>
                                                @endif
                                                {{--                                                <span aria-hidden="true">&middot;</span>--}}
                                                <span class="inline-flex gap-1 items-center rounded-sm author">
                                                    <span class="inline-block bio-pic">
                                                        <img class="w-4 h-4 rounded-full"
                                                            src="{{$post->author?->gravatar}}"
                                                            title="{{$post->author?->name}}"
                                                            alt="{{$post->author?->name}} Bio Pic"/>
                                                    </span>
                                                    <span class="author-name">
                                                        {{$post->author?->name}}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        @if($loop->first)
                                                <x-markdown>{{Str::words($post->content, $post->hero ? 60 : 140)}}</x-markdown>
                                        @else
                                            <div class="mt-3 text-base text-gray-500 line-clamp-4 2xl:line-clamp-5">
                                                <x-markdown>{{Str::words($post->summary, 22)}}</x-markdown>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-row justify-center mt-2 text-lg">
                <x-public.continue-reading text='Go to library' theme="primary" route='library' style='button'></x-public.continue-reading>
            </div>
        </div>
    </div>
</div>

