<x-public-layout class="onboarding" :metaTitle="$post?->title">
    @push('json-ld')
     <x-public.json-ld :post="$post"></x-public.json-ld>
    @endpush

    <header class="z-20 text-white bg-teal-600">
        <div class="z-20 flex flex-col items-center max-w-4xl px-6 py-16 md:mx-auto">
            <div class="z-20 flex flex-col gap-3 pb-8 lg:hidden">
                <div class="py-0 my-0">
                    <h1 class='mb-0 text-3xl font-bold text-center'>
                        {{$snippets->stakeTitle}}
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

    @if($snippets->stakeContent)
    <section class="py-12 bg-white">
        <div class="flex flex-col-reverse items-center max-w-4xl gap-4 px-6 xl:mx-auto md:flex-row">
            <div class="w-full p-4 mb-8 text-white bg-black rounded lg:hidden">
                <x-public.post-audio :post="$post"></x-public.post-audio>
            </div>

            <x-markdown>{{$snippets->stakeContent}}</x-markdown>
        </div>
    </section>
    @endif

    <section class="py-12 text-white bg-teal-600">
        <div class="grid max-w-4xl grid-cols-3 gap-1 px-6 text-gray-700 xl:mx-auto">
            <div class="flex flex-col items-center gap-6 p-4 bg-accent-100">
                <h2 class="text-4xl">1</h2>
                <p>
                    {{$snippets->createYoroiWallet}}
                </p>
                <div class="w-20">
                    @include('svg.wallet')
                </div>
            </div>
            <div class="flex flex-col items-center gap-6 p-4 bg-white">
                <h2 class="text-4xl">2</h2>
                <p>
                    {{$snippets->sendAdaToYourWallet}}
                </p>
                <div class="w-20">
                    @include('svg.paperairplane')
                </div>
            </div>
            <div class="flex flex-col items-center gap-6 p-4 bg-accent-100">
                <h2 class="text-4xl">3</h2>
                <p>
                    {{$snippets->deledateToLidoNation}}
                </p>
                <div class="w-20">
                    @include('svg.arrowclick')
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="flex flex-col max-w-4xl gap-4 px-6 xl:mx-auto">
            <div class="flex flex-row justify-between gap-4">
                <div>
                    {{$snippets->howToCreateYoroiWallet}}
                </div>
                <div class="w-1/4 mr-auto md:mr-0 md:w-[17rem]">
                    @include('svg.mobile')
                </div>
            </div>
            <div>
                <h3 class="mt-4 text-xl font-bold">
                    {{$snippets->onYourPhone}}
                </h3>
                <ul class="list-disc list-outside list">
                    <li>
                        <span class="block">
                            {{$snippets->installYoroiApp}}
                        </span>
                        <a  class="inline-block w-24 rounded-sm" href="https://apps.apple.com/us/app/emurgos-yoroi-cardano-wallet/id1447326389?itsct=apps_box_badge&amp;itscg=30200">
                            <img class="rounded-sm" src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/en-us?size=250x83&amp;releaseDate=1551052800&h=0b6a65df479c9a2d4ed92fc8880f6371"
                                alt="Download on the App Store">
                        </a>
                        <a class="relative inline-block w-32 rounded-sm top-2" href='https://play.google.com/store/apps/details?id=com.emurgo&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'>
                            <img class="rounded-sm" alt='Get it on Google Play' src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/>
                        </a>
                    </li>
                </ul>

                <x-markdown>{{$snippets->howToLaunchApp}}</x-markdown>
            </div>
        </div>
    </section>

    <section class="py-12 text-white bg-teal-600">
        <div class="flex flex-col max-w-4xl gap-4 px-6 xl:mx-auto">
            <div class="flex flex-row gap-6">
                <div class="w-1/4 md:mt-10 md:w-[9rem]">
                    @include('svg.envelopesend')
                </div>
                <div>
                    <x-markdown>{{$snippets->howToSendAda}}</x-markdown>
                </div>
            </div>
            <div>
                <x-markdown>{{$snippets->howToCoinbase}}</x-markdown>
            </div>
        </div>
    </section>

    <section class="py-12 bg-accent-200">
        <div class="flex flex-col-reverse justify-between max-w-4xl gap-10 px-6 xl:mx-auto md:flex-row">
            <div>
                <x-markdown>{{$snippets->howToDelegate}}</x-markdown>
            </div>
            <div class="mr-auto w-1/4 md:mx-auto md:w-[9rem]">
                @include('svg.fingerclick')
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50 border border-gray-100">
        <div class="px-6 max-w-6xl xl:mx-auto">
            <livewire:comments :showNotificationOptions="Auth::check()" :hideNotificationOptions="!Auth::check()" :hideAvatars="false" :noReplies="false" :model="$post" />
        </div>
    </section>


{{--    <section class="py-12 border border-gray-100 bg-gray-50">--}}
{{--        <div class="max-w-6xl px-6 xl:mx-auto ">--}}
{{--            <div class="">--}}
{{--                <p class="mt-2">--}}
{{--                    @if($post->comment_prompt)--}}
{{--                        <span>{{$post->comment_prompt}}</span>--}}
{{--                    @else--}}
{{--                        <span>--}}
{{--                            {{ $snippets->atartAConversation }}--}}
{{--                        </span>--}}
{{--                    @endif--}}
{{--                </p>--}}
{{--                <a class="block text-xl" href="#commentForm{{$post->id}}">--}}
{{--                    {{ $snippets->leaveAComment}}--}}
{{--                </a>--}}
{{--            </div>--}}

{{--            <!-- Comments -->--}}
{{--            @if($post && $post->comments->isNotEmpty())--}}
{{--                <div class="">--}}
{{--                    <x-public.divider></x-public.divider>--}}
{{--                </div>--}}

{{--                <div class="max-w-5xl py-16 pt-8">--}}
{{--                    <x-public.comments :model="$post"></x-public.comments>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <!-- Comment Form -->--}}
{{--            <div class="">--}}
{{--                <x-public.divider></x-public.divider>--}}
{{--            </div>--}}

{{--            <div class="max-w-5xl py-16">--}}
{{--                <livewire:comment-form-component--}}
{{--                    :modelId="$post->id"--}}
{{--                    :modelType="$post->type ?? 'App\Models\Post'"--}}
{{--                    :prompt="$post->comments->count() > 1 ? $post->comment_prompt : null" />--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}


<x-support-lido heading-leading='Support the' heading-span='Library'/>

</x-public-layout>
