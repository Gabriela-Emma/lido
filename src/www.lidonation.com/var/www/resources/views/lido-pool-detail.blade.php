<x-public-layout class="pool-detail" :metaTitle="$post->title">
    <header class="z-20 text-white bg-teal-600">
        <div class="flex z-20 flex-col items-center px-6 py-16 max-w-4xl md:mx-auto">
            <div class="flex z-20 flex-col gap-3 pb-8 lg:hidden">
                <div class="py-0 my-0">
                    <h1 class='mb-0 text-3xl font-bold text-center'>
                        {{$post->title}}
                    </h1>
                </div>
            </div>
            <x-public.post-hero :post="$post"></x-public.post-hero>
        </div>
    </header>
    @if($post->snippets->get(0)?->content)
        <section class="py-12 bg-white">
            <div class="flex flex-col-reverse gap-4 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                {{--                <div class="mb-8 max-w-6xl xl:mx-auto">--}}
                {{--                    <div class="flex flex-row flex-wrap gap-4 justify-center items-end w-full text-sm">--}}
                {{--                        <h3 class="text-sm text-center text-gray-600">Also Available In</h3>--}}
                {{--                        @if(config('app.fallback_locale') != app()->getLocale())--}}
                {{--                            <a href="{{LaravelLocalization::getLocalizedURL(config('app.fallback_locale'))}}"--}}
                {{--                               class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600">--}}
                {{--                                english--}}
                {{--                            </a>--}}
                {{--                        @endif--}}
                {{--                        @if('es' != app()->getLocale())--}}
                {{--                            <a href="{{LaravelLocalization::getLocalizedURL('es')}}"--}}
                {{--                               class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600">--}}
                {{--                                spanish--}}
                {{--                            </a>--}}
                {{--                        @endif--}}

                {{--                        @if('zh' != app()->getLocale())--}}
                {{--                            <a href="{{LaravelLocalization::getLocalizedURL('zh')}}"--}}
                {{--                               class="inline-block px-2 py-1 font-semibold text-white rounded-sm bg-teal-600">--}}
                {{--                                简体中文--}}
                {{--                            </a>--}}
                {{--                        @endif--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="w-1/4 md:w-[28rem]">
                    <div class="w-full">
                        <img class="object-cover responsive"
                             src="{{asset('img/llogo-transparent.png')}}"
                             alt="{{$snippets->lIDONationWhiteLogo}}"/>
                    </div>
                </div>
                <div>
                    <div class="p-4 mb-8 w-full text-white bg-black rounded lg:hidden">
                        <x-public.post-audio :post="$post"></x-public.post-audio>
                    </div>

                    <x-markdown>{{$post->snippets->get(0)?->content}}</x-markdown>
                </div>
        </section>
    @endif

    @if($post->snippets->get(1)?->content)
        <section class="py-12 text-white bg-teal-600">
            <div class="flex flex-col gap-4 px-6 max-w-6xl xl:mx-auto md:flex-row items-top">
                <div>
                    <x-markdown>{{$post->snippets->get(1)?->content}}</x-markdown>
                </div>
                <div class="w-1/4 mx-auto md:w-[20rem]">
                    @include('svg.coins-stack')
                </div>
            </div>
        </section>
    @endif

    @if($post->snippets->get(2)?->content)
        <section class="py-12 bg-accent-200">
            <div class="flex flex-col-reverse gap-8 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div class="w-1/4 x-auto md:w-[16rem]">
                    @include('svg.work-charity-balancer')
                </div>
                <div>
                    <x-markdown>{{$post->snippets->get(2)?->content}}</x-markdown>
                </div>
            </div>
        </section>
    @endif

    @if($post->snippets->get(3)?->content)
        <section class="py-12 text-white bg-teal-600">
            <div class="flex flex-col gap-4 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div>
                    <x-markdown>{{$post->snippets->get(3)?->content}}</x-markdown>
                </div>
                <div class="w-1/4 x-auto md:w-[28rem]">
                    @include('svg.clockwise')
                </div>
            </div>
        </section>
    @endif

    @if($post->snippets->get(4)?->content)
        <section class="py-12 bg-white">
            <div class="px-6 max-w-6xl xl:mx-auto">
                <div class="flex flex-col-reverse gap-8 md:grid md:grid-cols-8">
                    <div class="col-span-2">
                        <div class="w-32 md:w-[16rem] mx-auto md:mt-8 md:w-full">
                            @include('svg.happy-cloud-monitoring')
                        </div>
                    </div>
                    <div class="col-span-6">
                        <h2 class="mb-8">
                            {{$snippets->forTheTechHeads}}
                        </h2>
                        <div class="grid gap-8 md:grid-cols-2">
                            {{--left --}}
                            <div class="flex flex-col gap-8">
                                <div>
                                    <x-markdown>{{$post->snippets->get(4)?->content}}</x-markdown>
                                </div>
                            </div>

                            {{--Right --}}
                            <div class="flex flex-col gap-8">
                                @if($post->snippets->get(5)?->content)
                                    <div>
                                        <x-markdown>{{$post->snippets->get(5)?->content}}</x-markdown>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="py-12 bg-gray-50 border border-gray-100">
        <div class="px-6 max-w-6xl xl:mx-auto">
            <h2 class="mb-4 text-3xl font-semibold text-gray-900">
                Comments
            </h2>

            <!-- Comments -->
            @if($post && $post->comments->isNotEmpty())
                <div class="">
                    <x-public.divider></x-public.divider>
                </div>

                <div class="py-16 pt-8 max-w-5xl">
                    <x-public.comments :model="$post"></x-public.comments>
                </div>
        @endif

        <!-- Comment Form -->
            <div class="">
                <x-public.divider></x-public.divider>
            </div>
            <div class="py-16 max-w-5xl">
                <livewire:comment-form-component
                    :modelId="$post->id"
                    :modelType="$post->type ?? 'App\Models\Post'"
                    :prompt="$post->comments->count() > 1 ? $post->comment_prompt : null"/>
            </div>
        </div>
    </section>

</x-public-layout>
