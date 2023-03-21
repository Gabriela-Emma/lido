<x-public-layout class="post" :metaTitle="$post->title">
    @push('json-ld')
     <x-public.json-ld :post="$post"></x-public.json-ld>
    @endpush

    @push('openGraph')
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="{{$post->title}}"/>
        <meta property="og:description" content="{{$post->social_post}}"/>
        <meta property="og:url" content="{{$post->url}}"/>
        <meta property="og:image" content="{{$post->hero?->getUrl('large')}}"/>
        <meta property="og:image:width" content="2048"/>
        <meta property="og:image:height" content="2048"/>
        <meta property="article:publisher" content="{{config('app.name')}}"/>
        <meta property="article:author" content="{{$post->author?->name}}"/>
        <meta property="article:published_time" content="{{$post->published_at}}"/>

        @if($post->categories->isNotEmpty())
            <meta property="article:section" content="{{$post->categories->first()->title}}"/>
        @endif

        @foreach($post->tags as $tax)
            <meta property="article:tag" content="{{$tax->title}}"/>
        @endforeach

        <meta property="twitter:card" content="summary_large_image"/>
        <meta property="twitter:title" content="{{$post->title}}"/>
        <meta property="twitter:description" content="{{$post->social_post}}"/>
        <meta property="twitter:image" content="{{$post->hero?->getUrl('large')}}"/>
        <meta property="twitter:url" content="{{$post->url}}"/>
        <meta property="twitter:site" content="@lidonation"/>
    @endpush

    @push('tags')
        @foreach(config('laravellocalization.supportedLocales') as $key => $locale)
            @if($key == app()->getLocale())
                @continue
            @endif
            @if(Lang::has($post->getTable() . '.' . $post->slug, $key ))
                <link rel="alternate" hreflang="{{$key}}" href="{{LaravelLocalization::getLocalizedURL($key)}}"/>
            @endif
        @endforeach
        @if(config('app.fallback_locale') != app()->getLocale())
            <link rel="alternate" hreflang="{{config('app.fallback_locale')}}"
                  href="{{LaravelLocalization::getLocalizedURL(config('app.fallback_locale'))}}"/>
        @endif
    @endpush

    @push('editLink')
            <a
            href="{{ url('voltaire/resources/articles/' .$post->id. '/edit') }}"
            class="editArticle bg-gray-400  text-white text-sm px-6 py-2 rounded-xl" >
                    Edit Article
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24" class="inline-block" role="presentation">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
            </a>  
    @endpush

    <header class="text-white bg-teal-500 relative">
        <div class="container">
            <div class="flex z-10 flex-col-reverse items-center lg:flex-row-reverse gap-8 py-10">
                <div class="pt-4 flex flex-col gap-2">
                    <div class="flex flex-row">
                        @if( $post->categories->isNotEmpty() || $post->tags->isNotEmpty())
                            <div class="flex flex-row flex-wrap gap-2 justify-center sm:max-w-md">
                                @if($post->categories->isNotEmpty())
                                    @foreach($post->categories as $tax)
                                        <!-- <x-public.post-taxonomies textColor="text-white" :tax="$tax"></x-public.post-taxonomies> -->
                                        <x-public.post-taxonomies bgColor="{{ $tax->color ?? '#3CCDCC' }}" textColor="text-white" :tax="$tax"></x-public.post-taxonomies>
                                    @endforeach
                                @endif
                                @if($post->tags->isNotEmpty())
                                    @foreach($post->tags as $tax)
                                        <!-- <x-public.post-taxonomies bgColor="bg-white" :tax="$tax"></x-public.post-taxonomies> -->
                                        <x-public.post-taxonomies bgColor="{{ $tax->color ?? 'white' }}" :tax="$tax"></x-public.post-taxonomies>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>

                    <h1 class='mb-0 text-4xl xl:text-5xl 2xl:text-6xl font-bold'>{{$post->title}}</h1>

                    @if($post->subtitle)
                    <h3 class='mb-0 text-xl xl:text-3xl 2xl:text-4xl subtitle relative xl:-top-2'>
                        {{ $post->subtitle }}
                    </h3>
                    @endif

                    <div class="flex justify-start pl-2">
                        <x-public.post-meta :post="$post" :badge="false" size="md"></x-public.post-meta>
                    </div>

                    <div class="bg-teal-300 inline-flex p-3 lg:w-96">
                        <x-public.post-audio :post="$post"></x-public.post-audio>
                    </div>
                </div>

                @if($post->hero)
                    <div class="lg:w-1/2 flex-shrink-0">
                        @include('post.drip-image')
                    </div>
                @endif
            </div>
        </div>
    </header>

    <section
        class="overflow-visible relative py-10 bg-white bg-opacity-90 bg-left-bottom bg-repeat-y bg-contain bg-blend-color-burn lg:py-20 bg-pool-bw-light">
        <div class="container">
            @if(Lang::hasAny($post->getTable() . '.' . $post->slug, collect(config('laravellocalization.supportedLocales'))->keys()))
                <div class="mb-8 max-w-6xl xl:mx-auto">
                    <div class="flex flex-row flex-wrap gap-4 justify-center items-end w-full text-sm">
                        <h3 class="text-sm text-center text-gray-600 capitalize">
                            {{ $snippets->alsoAvailableIn }}
                        </h3>
                        @foreach(config('laravellocalization.supportedLocales') as $key => $locale)
                            @if($key == app()->getLocale())
                                @continue
                            @endif
                            @if(Lang::has($post->getTable() . '.' . $post->slug, $key ))
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
                <div class="relative px-4 py-8 mx-auto sm:px-6 lg:px-8">
                    <div class="max-w-6xl xl:mx-auto">
                        @if($post->content)
                            @if($post->prologue)
                                <div class="mt-4">
                                    <x-public.callout :content="$post->prologue"
                                                      theme="secondary"></x-public.callout>
                                </div>
                            @endif
                            <article class="mb-6 text-xl text-justify">
                                <div class="mt-3">
                                    @if(Lang::has($post->getTable() . '.' . $post->slug ))
                                        <x-markdown>{{__($post->getTable() . '.' . $post->slug)}}</x-markdown>
                                    @else
                                        <x-markdown>{{$post->content}}</x-markdown>
                                    @endif
                                </div>
                            </article>
                            @if($post->epilogue)
                                <x-public.callout :content="$post->epilogue"
                                                  theme="secondary"></x-public.callout>
                            @endif
                        @endif
                    </div>

                    @if($post->links)
                        <x-public.links :links="$post->links" />
                    @endif

                    <div class="flex mt-8 max-w-6xl xl:mx-auto bg-primary-400">
                        <div class="p-1 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-28 h-28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </div>
                        <x-public.widgets.newsletter
                            :title="$snippets->getMoreArticlesLikeThisInYourInbox"
                            bg="bg-primary-400" classes="px-0 md:p-4 text-white rounded-sm flex-grow" />
                    </div>
                </div>



            @if(! $post?->children?->isEmpty() || !!$post->parent)
                <!-- Series -->
                    <section
                        class="flex flex-row justify-between px-8 py-16 pt-8 max-w-6xl xl:px-0 xl:mx-auto">
                        <!-- Prev in Series -->
                        <div class="inline-block">
                            @if($post->parent)
                                <div class="p-4 max-w-xl rounded-sm border min-w-25">
                                    <p class="text-sm text-gray-400">
                                        {{ $snippets->previousInSeries}}
                                    </p>
                                    <a href="/posts/{{$post->parent->slug}}/"
                                       class="text-base font-semibold hover:text-teal-600">
                                        {{$post->parent->title}}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <!-- Next in Series -->
                        <?php $nextInSeries = $post->children?->first(); ?>
                        <div class="inline-block">
                            @if($nextInSeries)
                                <div class="p-4 max-w-xl rounded-sm border min-w-25">
                                    <p class="text-sm text-gray-400">
                                        {{ $snippets->nextInSeries}}
                                    </p>
                                    <a href="/posts/{{$nextInSeries->slug}}/"
                                       class="text-base font-semibold hover:text-teal-600">
                                        {{$nextInSeries->title}}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </section>
            @endif

            <!-- Comments Prompt -->
                <section class="px-8 py-12 mx-auto max-w-6xl bg-white lg:bg-gray-50">
                    <div class="grid gap-4 md:grid-col-2 lg:grid-cols-3 sm:gap-8">
                        <div class="border-b border-gray-300 lg:border-r lg:border-b-0 lg:col-span-2">
                            @if($post->comments->isNotEmpty())
                                <h2>
                                    <span>
                                        {{$post->comments()->count()}} {{ $snippets->comments }}
                                    </span>
                                    <a href="#comments" class="text-xs subcopy text-teal-600 hover:text-teal-700">
                                        {{ $snippets->viewComments}}</a>
                                </h2>
                            @endif

                            <div class="max-w-xl">
                                <p class="mt-2">
                                    @if($post->comment_prompt)
                                        <span>{{$post->comment_prompt}}</span>
                                    @else
                                        <span>
                                            {{ $snippets->atartAConversation }}
                                        </span>
                                    @endif
                                </p>
                                <p class="text-sm">Was the article useful?</p>
                                <div x-data="globalReactions({{ json_encode($post) }})">
                                    <div class="py-4 border-t border-slate-400">
                                        <ul class="flex flex-row gap-3 justify-end">
                                            <template x-for="[reaction, count] of Object.entries(reactionsCount)">
                                                    <li class="border flex flex-row gap-1 border-slate-600 hover:border-green-500 p-1 rounded-sm text-xs cursor-pointer">
                                                        <button @click.prevent="addReaction(reaction, {{$post->id}})" x-text="reaction"></button>
                                                        <span x-text="count"></span>
                                                    </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                            <div class="w-full border-t border-slate-400"></div>
                                        </div>
                                        <div class="relative flex justify-center text-sm">
                                            <span class="bg-white px-2 text-slate-500">Or leave comment</span>
                                        </div>
                                    </div>
                                    <a class="block text-xl text-end" href="#commentForm{{$post->id}}">
                                        {{ $snippets->leaveAComment}}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <x-public.social-share :post="$post"></x-public.social-share>
                    </div>
                </section>

            @if($post->related_posts->isNotEmpty())
                <!-- Related Posts -->
                <section class="px-4 py-12 mx-auto max-w-6xl bg-white sm:px-8 xl:px-0">
                    <x-public.divider></x-public.divider>

                    <div>
                        <h2 class="my-6">Related {{$post->type_name}}</h2>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 sm:gap-8">
                            @foreach($post->related_posts as $relatedPost)
                                <div class="md:last:hidden lg:last:block post related">
                                    @include('post.related')
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50 border border-gray-100" id="commentForm{{$post->id}}">
        <div class="px-6 max-w-6xl xl:mx-auto">
            <livewire:comments :showNotificationOptions="Auth::check()" :hideNotificationOptions="!Auth::check()" :hideAvatars="false" :noReplies="false" :model="$post" />
        </div>
    </section>

    <!-- Comments -->
{{--    <section class="relative" id="comments">--}}
{{--        <div class="container py-12 lg:py-16">--}}
{{--            <div class="grid grid-cols-1 gap-10 lg:grid-cols-8">--}}
{{--                <div class="col-span-6">--}}
{{--                    @if($post->comments->isNotEmpty())--}}
{{--                        <div class="">--}}
{{--                            <h2 class="mb-8 text-4xl">--}}
{{--                                @markdownLang('Comments')--}}
{{--                            </h2>--}}
{{--                            <x-public.comments :model="$post"></x-public.comments>--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <div class="pt-16" id="articleCommentForm">--}}
{{--                        <livewire:comment-form-component--}}
{{--                            :modelId="$post->id"--}}
{{--                            :modelType="$post->type ?? 'App\Models\Post'"--}}
{{--                            :prompt="$post->comments->count() > 1 ? $post->comment_prompt : null" />--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Right Sidebar -->--}}
{{--                <div class="col-span-2">--}}
{{--                    <div class="hidden sticky top-10 gap-10 md:flex md:flex-col">--}}
{{--                        <x-public.widgets.author :author="$post->author" :editor="$post->editor" />--}}
{{--                        <x-public.widgets.newsletter/>--}}
{{--                        <x-public.widgets.meetup :meetups="$meetups" :dayOfWeek="$dayOfWeek" :hourOfDay="$hourOfDay"/>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
<script>
    function globalReactions(post) {
        return {
            loggedIn: false,
            reactionsCount: {
                "❤️": post.hearts_count,
                "👍": post.thumbs_up_count,
                "🎉": post.party_popper_count,
                "🚀": post.rocket_count,
                "👎": post.thumbs_down_count,
                "👀": post.eyes_count
            },

            checkLogin() {
                axios.get('/api/user').then(res => {
                 this.loggedIn = true;
                }).catch(error => {
                    window.location.href = "/catalyst-explorer/login";
                });
            },


            async addReaction(reaction, id){
                 this.checkLogin();
                let data = {
                    comment: reaction
                }
                if (this.loggedIn) {
                    const res = await window.axios.post(`/react/post/${id}`, data);
                    this.reactionsCount = {
                        "❤️": res.data.hearts_count,
                        "👍": res.data.thumbs_up_count,
                        "🎉": res.data.party_popper_count,
                        "🚀": res.data.rocket_count,
                        "👎": res.data.thumbs_down_count,
                        "👀": res.data.eyes_count
                    };
                }
            },
        }
    }
</script>