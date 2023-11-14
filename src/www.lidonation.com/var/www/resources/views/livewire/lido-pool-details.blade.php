<div>
    <header class="z-20 text-white bg-teal-600">
        <div class="flex z-20 flex-col items-center px-6 py-16 max-w-4xl md:mx-auto">
            <div class="flex z-20 flex-col gap-3 pb-8 lg:hidden">
                <div class="py-0 my-0">
                    <h1 class='mb-0 text-3xl font-bold text-center'>
                        {{$post->title}}
                    </h1>
                </div>
            </div>

            <section class="hero-image overflow-visible z-10 relative py-0 lg:px-8 xl:px-0">
                <div class="relative">
                    @if($post->hero)
                        <img
                            class="img-fluid rounded-tl-[16rem] lg:rounded-tl-[20rem] rounded-tr-[12rem] rounded-br-[24rem] rounded-bl-[6rem]"
                            width='2048' height="2048" src="{{$post->heroUrl}}"
                            srcset="{{$post->hero?->getSrcset('large')}}"
                            alt="{{$post->hero?->name}}"/>
                    @endif

                    <div class="-left-1 h-auto hidden lg:block absolute bottom-12">
                        <div
                            class="bg-black py-8 rounded-sm rounded-bl-[2rem] rounded-br-[5rem] lg:rounded-br-[0rem] ml-2 mix-blend-revert max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl">
                            <div class="p-2 xl:px-4 pb-0">
                                <h1 class='font-bold text-2xl lg:text-4xl xl:text-5xl z-20 mb-0'>
                                    {{$post->title}}
                                </h1>
                            </div>

                            <div class="mb-4 px-2 xl:px-4">
                                <x-public.post-meta :post="$post" :badge="false" size="xs"></x-public.post-meta>
                            </div>

                            {{--                            <div class="">--}}
                            {{--                                <hr class="border-b border-white border-opacity-25 " />--}}
                            {{--                            </div>--}}

                            {{--                            <div class="p-4">--}}
                            {{--                                <x-public.post-audio :post="$post"></x-public.post-audio>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </header>

    @if($post->snippets->get(0)?->content)
        <section class="py-12 bg-white">
            <div class="flex flex-col-reverse gap-4 items-center px-6 max-w-6xl xl:mx-auto md:flex-row">
                <div class="w-1/4 md:w-[28rem]">
                    <div class="w-full">
                        <img class="object-cover responsive"
                             src="{{asset('img/llogo-transparent.png')}}"
                             alt="{{$snippets->lIDONationWhiteLogo}}"/>
                    </div>
                </div>
                <div>
                    <x-markdown>{{$post->snippets->get(0)?->content}}</x-markdown>
                </div>
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
                        <div class="w-32 mx-auto md:mt-8 md:w-full">
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
</div>
