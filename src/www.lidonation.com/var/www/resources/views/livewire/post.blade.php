@push('json-ld')
    <x-global.json-ld :post="$post"></x-global.json-ld>
@endpush

@push('openGraph')
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ $post->social_post }}" />
    <meta property="og:url" content="{{ $post->url }}" />
    <meta property="og:image" content="{{ $post->hero?->getUrl('large') }}" />
    <meta property="og:image:width" content="2048" />
    <meta property="og:image:height" content="2048" />
    <meta property="article:publisher" content="{{ config('app.name') }}" />
    <meta property="article:author" content="{{ $post->author?->name }}" />
    <meta property="article:published_time" content="{{ $post->published_at }}" />

    @if ($post->categories->isNotEmpty())
        <meta property="article:section" content="{{ $post->categories->first()->title }}" />
    @endif

    @foreach ($post->tags as $tax)
        <meta property="article:tag" content="{{ $tax->title }}" />
    @endforeach

    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ $post->title }}" />
    <meta property="twitter:description" content="{{ $post->social_post }}" />
    <meta property="twitter:image" content="{{ $post->hero?->getUrl('large') }}" />
    <meta property="twitter:url" content="{{ $post->url }}" />
    <meta property="twitter:site" content="@lidonation" />
@endpush

@push('tags')
    @foreach (config('laravellocalization.supportedLocales') as $key => $locale)
        @if ($key == app()->getLocale())
            @continue
        @endif
        @if (Lang::has($post->getTable() . '.' . $post->slug, $key))
            <link rel="alternate" hreflang="{{ $key }}"
                href="{{ LaravelLocalization::getLocalizedURL($key) }}" />
        @endif
    @endforeach
    @if (config('app.fallback_locale') != app()->getLocale())
        <link rel="alternate" hreflang="{{ config('app.fallback_locale') }}"
            href="{{ LaravelLocalization::getLocalizedURL(config('app.fallback_locale')) }}" />
    @endif
@endpush

@push('editLink')
    <a href="{{ url('voltaire/resources/articles/' . $post->id . '/edit') }}"
        class="editArticle bg-gray-400  text-white text-sm px-6 py-2 rounded-xl">
        Edit Article
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24"
            height="24" class="inline-block" role="presentation">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
            </path>
        </svg>
    </a>
@endpush
<div>
    <div>
        <header class="text-white bg-teal-500 relative">
            <div class="container">
                <div class="flex z-10 flex-col-reverse items-center lg:flex-row-reverse gap-8 py-10">
                    <div class="pt-4 flex flex-col gap-2">
                        <div class="flex flex-row">
                            @if ($post?->categories->isNotEmpty() || $post?->tags->isNotEmpty())
                                <div class="flex flex-row flex-wrap gap-2 justify-center sm:max-w-md">
                                    @if ($post?->categories->isNotEmpty())
                                        @foreach ($post->categories as $tax)
                                            <x-post.taxonomies bgColor="{{ $tax->color ?? '#3CCDCC' }}"
                                                textColor="text-white" :tax="$tax"></x-post.taxonomies>
                                        @endforeach
                                    @endif
                                    @if ($post->tags->isNotEmpty())
                                        @foreach ($post->tags as $tax)
                                            <x-post.taxonomies bgColor="{{ $tax->color ?? 'white' }}"
                                                :tax="$tax"></x-post.taxonomies>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        </div>

                        <h1 class='mb-0 text-4xl xl:text-5xl 2xl:text-6xl font-bold'>{{ $post?->title }}</h1>

                        @if ($post?->subtitle)
                            <h3 class='mb-0 text-xl xl:text-3xl 2xl:text-4xl subtitle relative xl:-top-2'>
                                {{ $post->subtitle }}
                            </h3>
                        @endif

                        <div class="flex justify-start pl-2">
                            <x-post.meta :post="$post" :badge="false" size="md"></x-post.meta>
                        </div>

                        {{--                    <div class="bg-teal-300 inline-flex p-3 lg:w-96"> --}}
                        {{--                        <x-post.audio :post="$post"></x-post.audio> --}}
                        {{--                    </div> --}}
                    </div>

                    @if ($post?->hero)
                        <div class="lg:w-1/2 flex-shrink-0">
                            <div class="mb-4 flex-shrink-0 hero-wrapper">
                                <a href="{{ $post->link }}">
                                    <x-post.drip-image :post="$post"></x-post.drip-image>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <section
            class="overflow-visible relative py-10 bg-white bg-opacity-90 bg-left-bottom bg-repeat-y bg-contain bg-blend-color-burn lg:py-20 bg-pool-bw-light">
            <div class="container">
                <div class="pb-8 bg-white relative">
                    <div class="relative px-4 py-8 mx-auto sm:px-6 lg:px-8">
                        <div class="max-w-6xl xl:mx-auto">
                            @if ($post->content)
                                @if ($post->prologue)
                                    <div class="mt-4">
                                        <x-ui.callout :content="$post->prologue" theme="secondary"></x-ui.callout>
                                    </div>
                                @endif

                                <livewire:library.post-content-component :post="$post" />

                                @if ($post?->epilogue)
                                    <x-ui.callout :content="$post->epilogue" theme="secondary"></x-ui.callout>
                                @endif
                            @endif
                        </div>

                        @if ($post?->links)
                            <x-global.links :links="$post->links" />
                        @endif

                        <div class="flex mt-8 max-w-6xl xl:mx-auto bg-primary-400">
                            <div class="p-1 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-28 h-28" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                </svg>
                            </div>
                            <x-global.newsletter :title="$snippets->getMoreArticlesLikeThisInYourInbox" bg="bg-primary-400"
                                classes="px-0 md:p-4 text-white rounded-sm flex-grow" />
                        </div>
                    </div>

                    <!-- Comments Prompt -->
                    <section class="px-8 py-8 mx-auto max-w-6xl bg-white lg:bg-gray-50">
                        <div class="grid gap-4 md:grid-col-2 lg:grid-cols-3 sm:gap-8">
                            <div class="border-b border-gray-300 lg:border-r lg:border-b-0 lg:col-span-2">
                                <div class="border-b border-gray-300 lg:border-r lg:border-b-0 lg:col-span-2">
                                    <div class="max-w-lg mx-auto">
                                        <p class="mt-2 text-xl xl:text-2xl 2xl:text-4xl text-slate-700">
                                            @if ($post->comment_prompt)
                                                <span>{{ $post->comment_prompt }}</span>
                                            @else
                                                <span>
                                                    Was the article useful?
                                                </span>
                                            @endif
                                        </p>
                                        <div>
                                            <livewire:components.global-reaction :post="$post" lazy="on-scroll"/>
                                        </div>

                                        <div class="relative">
                                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                <div class="w-full border-t border-slate-300"></div>
                                            </div>

                                            <div class="relative flex justify-center text-sm">
                                                <span class="bg-white px-2 text-slate-500">Or leave comment</span>
                                            </div>
                                        </div>

                                        <div class="mt-8">
                                            <a type="button"
                                                class="block mx-auto rounded-sm text-center w-full bg-white py-2.5 px-4 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                                href="#commentForm{{ $post->id }}">
                                                {{ $snippets->leaveAComment }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-global.social-share :post="$post" />
                    </div>
                </section>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50 border border-gray-100" id="commentForm{{$post->id}}">
        <div class="px-6 max-w-6xl xl:mx-auto">
        <livewire:comments :showNotificationOptions="Auth::check()" :hideNotificationOptions="!Auth::check()" :hideAvatars="false" :noReplies="false" :model="$post" />
</div>
    </section>

    <div class="my-16">
        <div class="container">
            <livewire:components.support-lido-component lazy="on-load" theme="teal"
                cta="You can support the work we do by delegating to the LIDO pool, pickup a ware in our bazaar, or sponsor a podcast episode." />
        </div>
    </div>
</div>
</section>


</div>
</div>
