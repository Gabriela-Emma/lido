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
        <div class="z-20 flex flex-col items-center max-w-4xl px-6 py-16 md:mx-auto">
            <div class="z-20 flex flex-col gap-3 pb-8 lg:hidden">
                <div class="py-0 my-0">
                    <h1 class='mb-0 text-3xl font-bold text-center'>
                        {{$post->title}}
                    </h1>
                </div>
                <div class="flex justify-center text-center">
                    <x-public.post-meta :post="$post" :badge="false" size="xs"></x-public.post-meta>
                </div>

                @if( $post->categories->isNotEmpty() || $post->tags->isNotEmpty())
                    <div class="flex flex-row flex-wrap justify-center gap-2 sm:max-w-md">
                        @if($post->categories->isNotEmpty())
                            @foreach($post->categories as $tax)
                                <x-public.post-taxonomies textColor="text-white" :tax="$tax"></x-public.post-taxonomies>
                            @endforeach
                        @endif
                        @if($post->tags->isNotEmpty())
                            @foreach($post->tags as $tax)
                                <x-public.post-taxonomies bgColor="bg-white" :tax="$tax"></x-public.post-taxonomies>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
            <x-public.post-hero :post="$post"></x-public.post-hero>
        </div>
    </header>

    @if($post->snippets->get(0)?->content)
        <section class="py-12 bg-white">
            <div class="z-20 max-w-6xl px-6 xl:mx-auto">

                <div class="w-full p-4 mb-8 text-white bg-black rounded lg:hidden">
                    <x-public.post-audio :post="$post"></x-public.post-audio>
                </div>
                <x-markdown>{{$post->snippets->get(0)?->content}}</x-markdown>
            </div>
        </section>
    @endif

    @if($post->snippets->get(1)?->content)
        <section class="py-12 text-white bg-teal-600">
            <div class="flex flex-col-reverse items-center max-w-6xl gap-4 px-6 xl:mx-auto md:flex-row">
                <div>
                    <x-markdown>{{$post->snippets->get(1)?->content}}</x-markdown>
                </div>
                <div class="w-1/4 mr-auto md:x-auto md:w-[44rem]">
                    @include('svg.social')
                </div>
            </div>
        </section>
    @endif

    <section class="py-12 bg-accent-200">
        <div class="flex flex-col items-center max-w-6xl gap-8 px-6 xl:mx-auto md:flex-row">
            <div class="w-1/4 mr-auto md:x-auto md:w-[22rem]">
                @include('svg.group')
            </div>
            <div>
                <x-markdown>{{$post->snippets->get(2)?->content}}</x-markdown>
            </div>
        </div>
    </section>

    <section class="py-12 text-white bg-teal-600">
        <div class="flex flex-col-reverse items-center max-w-6xl gap-4 px-6 xl:mx-auto md:flex-row">
            <div>
                <x-markdown>{{$post->snippets->get(3)?->content}}</x-markdown>
            </div>
            <div class="w-1/4 mr-auto md:x-auto md:w-[42rem]">
                @include('svg.cpu')
            </div>
        </div>
    </section>

    <section class="py-12 bg-accent-200">
        <div class="flex flex-col items-center max-w-6xl gap-2 px-6 xl:mx-auto md:flex-row">
            <div class="md:-ml-6 w-1/4 mx-auto md:w-[16rem]">
                @include('svg.growth-investment')
            </div>
            <div class="text-3xl font-bold text-center md:text-left">
                <x-markdown>{{$post->snippets->get(4)?->content}}</x-markdown>
            </div>

        </div>
    </section>

    <section class="py-12 text-white bg-teal-600">
        <div class="flex flex-col-reverse items-center max-w-6xl gap-6 px-6 xl:mx-auto md:flex-row">
            <div class="text-2xl font-semibold">
                <x-markdown>{{$post->snippets->get(5)?->content}}</x-markdown>
            </div>
            <div class="w-1/4 mr-auto md:x-auto md:w-[28rem] text-white">
                @include('svg.brain-light-bulb')
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="flex flex-row items-center max-w-6xl gap-6 px-6 xl:mx-auto">
            <div class="w-1/4 mr-auto md:x-auto md:w-[28rem] text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                </svg>
            </div>
            <div>
                <x-markdown>{{$post->snippets->get(6)?->content}}</x-markdown>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50 border border-gray-100">
        <div class="px-6 max-w-6xl xl:mx-auto">
            <livewire:comments :showNotificationOptions="Auth::check()" :hideNotificationOptions="!Auth::check()" :hideAvatars="false" :noReplies="false" :model="$post" />
        </div>
    </section>

{{--    <section class="py-12 border border-gray-100 bg-gray-50">--}}
{{--        <div class="max-w-6xl px-6 xl:mx-auto">--}}
{{--            <h2 class="mb-4 text-3xl font-semibold text-gray-900">--}}
{{--                {{ $snippets->comments }}--}}
{{--            </h2>--}}

{{--            <!-- Comments -->--}}
{{--            @if($post && $post->comments->isNotEmpty())--}}
{{--                <div class="">--}}
{{--                    <x-public.divider></x-public.divider>--}}
{{--                </div>--}}

{{--                <div class="max-w-5xl py-16 pt-8">--}}
{{--                    <x-public.comments :model="$post"></x-public.comments>--}}
{{--                </div>--}}
{{--        @endif--}}

{{--        <!-- Comment Form -->--}}
{{--            <div class="">--}}
{{--                <x-public.divider></x-public.divider>--}}
{{--            </div>--}}
{{--            <div class="max-w-5xl py-16">--}}
{{--                <livewire:comment-form-component--}}
{{--                    :modelId="$post->id"--}}
{{--                    :modelType="$post->type ?? 'App\Models\Post'"--}}
{{--                    :prompt="$post->comments->count() > 1 ? $post->comment_prompt : null"/>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}


    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
