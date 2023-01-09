<x-public-layout class="onboarding" :metaTitle="$post->title">
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
    <header class="z-20 text-white bg-teal-600">
        <div class="flex z-20 flex-col items-center px-6 py-16 max-w-4xl md:mx-auto">
            <div class="flex z-20 flex-col gap-3 pb-8 lg:hidden">
                <div class="py-0 my-0">
                    <h1 class='mb-0 text-3xl font-bold text-center'>
                        {{$post->title}}
                    </h1>
                </div>
                <div class="flex justify-center text-center">
                    <x-public.post-meta :post="$post" :badge="false" size="xs"></x-public.post-meta>
                </div>
            </div>
            <x-public.post-hero :post="$post"></x-public.post-hero>
        </div>
    </header>

    @if($post->snippets->get(0)?->content)
        <section class="py-12 bg-white">
            <div class="z-20 px-6 max-w-6xl xl:mx-auto">
                <div class="mb-8 max-w-6xl xl:mx-auto">
                    <div class="flex flex-row flex-wrap gap-4 justify-center items-end w-full text-sm">
                        <h3 class="text-sm text-center text-gray-600">Also Available In</h3>
                        @if(config('app.fallback_locale') != app()->getLocale())
                            <a href="{{LaravelLocalization::getLocalizedURL(config('app.fallback_locale'))}}"
                               class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600">
                                english
                            </a>
                        @endif
                        @if('es' != app()->getLocale())
                            <a href="{{LaravelLocalization::getLocalizedURL('es')}}"
                               class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600">
                                spanish
                            </a>
                        @endif

                        @if('zh' != app()->getLocale())
                            <a href="{{LaravelLocalization::getLocalizedURL('zh')}}"
                               class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600">
                                简体中文
                            </a>
                        @endif
                    </div>
                </div>
                <div class="p-4 mb-8 w-full text-white bg-black rounded lg:hidden">
                    <x-public.post-audio :post="$post"></x-public.post-audio>
                </div>

                <x-markdown>{{$post->snippets->get(0)?->content}}</x-markdown>
            </div>
        </section>
    @endif

    @if($post->snippets->get(1)?->content)
        <section class="py-12 text-white bg-teal-600">
            <div class="flex flex-col-reverse gap-4 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div>
                    <x-markdown>{{$post->snippets->get(1)?->content}}</x-markdown>
                </div>
                <div class="w-1/4 mr-auto md:mx-auto md:w-[38rem]">
                    @include('svg.runner-silhouette-fast')
                </div>
            </div>
        </section>
    @endif

    @if($post->snippets->get(2)?->content)
        <section class="py-12 bg-accent-200">
            <div class="flex flex-col gap-8 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div class="w-1/4 mr-auto md:x-auto md:w-[18rem]">
                    @include('svg.signing-contract')
                </div>
                <div>

                    <x-markdown>{{$post->snippets->get(2)?->content}}</x-markdown>
                </div>
            </div>
        </section>
    @endif

    @if($post->snippets->get(3)?->content)
        <section class="py-12 text-white bg-teal-600">
            <div class="flex flex-col-reverse gap-4 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div>
                    <x-markdown>{{$post->snippets->get(3)?->content}}</x-markdown>
                </div>
                <div class="w-1/4 mr-auto md:x-auto md:w-[28rem]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                    </svg>
                </div>
            </div>
        </section>
    @endif

    @if($post->snippets->get(4)?->content)
        <section class="py-12 bg-accent-200">
            <div class="flex flex-col gap-8 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div class="w-1/4 mr-auto md:x-auto md:w-[32rem]">
                    @include('svg.vote')
                </div>
                <div>
                    <x-markdown>{{$post->snippets->get(4)?->content}}</x-markdown>
                </div>

            </div>
        </section>
    @endif

    @if($post->snippets->get(5)?->content)
        <section class="py-12 text-white bg-teal-600">
            <div class="flex flex-col-reverse gap-6 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div>
                    <x-markdown>{{$post->snippets->get(5)?->content}}</x-markdown>
                </div>
                <div class="w-1/4 mr-auto md:x-auto md:w-[32rem]">
                    @include('svg.earth')
                </div>
            </div>
        </section>
    @endif

    @if($post->snippets->get(6)?->content)
        <section class="py-12 bg-white">
            <div class="flex flex-col gap-6 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div class="w-1/4 mr-auto md:x-auto md:w-[32rem]">
                    @include('svg.cardano')
                </div>
                <div>
                    <x-markdown>{{$post->snippets->get(6)?->content}}</x-markdown>
                </div>
            </div>
        </section>
    @endif

    <section class="py-12 bg-gray-50 border border-gray-100">
        <div class="px-6 max-w-6xl xl:mx-auto">
            <livewire:comments :showNotificationOptions="Auth::check()" :hideNotificationOptions="!Auth::check()" :hideAvatars="false" :noReplies="false" :model="$post" />
        </div>
    </section>

{{--    <section class="py-12 bg-gray-50 border border-gray-100">--}}
{{--        <div class="px-6 max-w-6xl xl:mx-auto">--}}
{{--            <h2 class="mb-4 text-3xl font-semibold text-gray-900">--}}
{{--                Comments--}}
{{--            </h2>--}}

{{--            @if($post && $post->comments->isNotEmpty())--}}
{{--                <div class="">--}}
{{--                    <x-public.divider></x-public.divider>--}}
{{--                </div>--}}

{{--                <div class="py-16 pt-8 max-w-5xl">--}}
{{--                    <x-public.comments :model="$post"></x-public.comments>--}}
{{--                </div>--}}
{{--        @endif--}}

{{--            <div class="">--}}
{{--                <x-public.divider></x-public.divider>--}}
{{--            </div>--}}
{{--            <div class="py-16 max-w-5xl">--}}
{{--                <livewire:comment-form-component--}}
{{--                    :modelId="$post->id"--}}
{{--                    :modelType="$post->type ?? 'App\Models\Post'"--}}
{{--                    :prompt="$post->comments->count() > 1 ? $post->comment_prompt : null" />--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <x-public.join-lido-pool></x-public.join-lido-pool>
</x-public-layout>
