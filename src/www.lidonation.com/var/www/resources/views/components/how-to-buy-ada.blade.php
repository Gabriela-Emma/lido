<div class="onboarding" :metaTitle="$post->title">
    @push('json-ld')
     <x-public.json-ld :post="$post"></x-public.json-ld>
    @endpush

    <header class="bg-teal-600 z-20 text-white">
        <div class="max-w-4xl px-6 md:mx-auto z-20 flex flex-col items-center py-16">
            <div class="z-20 pb-8 flex flex-col gap-3 lg:hidden">
                <div class="py-0 my-0">
                    <h1 class='font-bold text-3xl mb-0 text-center'>
                        {{$post->title}}
                    </h1>
                </div>
                <div class="text-center flex justify-center">
                    <x-public.post-meta :post="$post" :badge="false" size="xs"></x-public.post-meta>
                </div>

                @if( $post->categories->isNotEmpty() || $post->tags->isNotEmpty())
                    <div class="flex flex-row gap-2 flex-wrap justify-center sm:max-w-md">
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

        <section class="bg-white py-12 px-6">
            <div class="bg-black rounded text-white p-4 lg:hidden w-full mb-8">
                <x-public.post-audio :post="$post"></x-public.post-audio>
            </div>

            <div class="max-w-6xl xl:mx-auto flex flex-col md:flex-row gap-4 items-center">
                <div class="w-1/4 mr-auto md:mr-0 md:ml-auto md:w-[24rem]">
                    @include('svg.bridge')
                </div>
                <div class="max-w-6xl  xl:mx-auto z-20">
                    <x-markdown>{{ $snippets->decidedToOwnSomeAda }}</x-markdown>
                </div>
            </div>
        </section>

        <section class="bg-teal-600 text-white py-12">
            <div class="max-w-6xl px-6 xl:mx-auto flex md:flex-row md:justify-between gap-4 items-center">
                <div class="max-w-xl">
                    <x-markdown>{{$snippets->useCoinbaseOnDesktopComputer}}</x-markdown>
                </div>
                <div class="mr-auto md:mr-0 md:ml-auto">
                    <div class="flex flex-row gap-2">
                        <a class="inline-block relative -top-2" target="_blank"
                           href='https://play.google.com/store/apps/details?id=com.coinbase.android&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'>
                            <img class="w-44" alt='Get it on Google Play'
                                 src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/>
                        </a>
                        <a class="inline-block" target="_blank"
                           href="https://apps.apple.com/us/app/coinbase-buy-sell-bitcoin/id886427730?itsct=apps_box_badge&amp;itscg=30200">
                            <img class="w-36"
                                 src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/en-us?size=250x83&amp;releaseDate=1403395200&h=c91411ab2ec4bc36a80000af72887b4a"
                                 alt="Download on the App Store">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-accent-200 py-12">
            <div class="max-w-6xl px-6 xl:mx-auto flex flex-col md:flex-row gap-10 items-center">
                <div class="w-1/4 mr-auto md:mr-0 md:w-[7rem]">
                    <img src="/img/coinbase.png"/>
                </div>
                <div>
                    <b><x-markdown>{{$snippets->inCoinbase}}</x-markdown></b>
                    <x-markdown>{{$snippets->useEmailToRegister}}</x-markdown>
                </div>
            </div>
        </section>

        <section class="bg-teal-600 text-white py-12">
            <div class="max-w-6xl px-6 xl:mx-auto flex flex-col-reverse md:flex-row gap-10 md:justify-between">
                <div>
                    <b><x-markdown>{{$snippets->verifyYourIdentity}}</x-markdown></b>
                    <x-markdown>{{$snippets->coinbaseIdentityVerification}}</x-markdown>
                    <x-markdown>{{$snippets->clickSettingsPayment}}</x-markdown>
                </div>
                <div class="w-1/4 mr-auto md:mr-0 md:w-[9rem]">
                    @include('svg.id')
                </div>
            </div>
        </section>

        <section class="bg-accent-200 py-12">
            <div class="max-w-6xl px-6 xl:mx-auto flex flex-col md:flex-row gap-10 md:justify-between">
                <div class="w-1/4 mr-auto md:mx-auto md:w-[9rem]">
                    @include('svg.crypto-bank')
                </div>
                <div>
                    <b><x-markdown>{{$snippets->addFundingSource}}</x-markdown></b>
                    <x-markdown>{{$snippets->avoidFeesUsingBank}}</x-markdown>
                    <x-markdown>{{$snippets->clickSettings}}</x-markdown>
                    <x-markdown>{{$snippets->clickAddPaymentMethod}}</x-markdown>
                </div>
            </div>
        </section>

        <section class="bg-teal-600 text-white py-12">
            <div class="max-w-6xl px-6 xl:mx-auto flex flex-col-reverse md:flex-row gap-10 md:justify-between">
                <div>
                    <b><x-markdown>{{$snippets->purchaseAda}}</x-markdown></b>
                    <x-markdown>{{$snippets->clickTradeArrrow}}</x-markdown>
                    <x-markdown>{{$snippets->clickBuyCardanoAda}}</x-markdown>
                    <x-markdown>{{$snippets->confirmBankAmount}}</x-markdown>
                    <x-markdown>{{$snippets->onNextScreenClickBuyNow}}</x-markdown>
                </div>
                <div class="w-1/4 mr-auto md:mr-0 md:w-[11rem] text-white">
                    @include('svg.cardano')
                </div>
            </div>
        </section>

        <section class="bg-white py-12">
            <div class="max-w-6xl px-6 xl:mx-auto flex flex-col md:flex-row gap-10 justify-between">
                <div class="w-1/4 mr-auto md:x-auto md:w-[24rem] text-gray-700">
                    @include('svg.funfair')
                </div>
                <div>
                    <x-markdown>{{$snippets->custodialWallet}}</x-markdown>
                    <x-markdown>{{$snippets->takeControlMoveFunds}}</x-markdown>
                    <b><x-markdown>{{$snippets->takeControlEvenBetter}}</x-markdown></b>
                    <x-markdown>{{$snippets->bestSecurityLidoLife}}</x-markdown>
                </div>
            </div>
        </section>

        <section class="flex flex-row justify-between px-8 py-16 pt-8 max-w-6xl xl:px-0 xl:mx-auto">
            <x-next-previous :name="$snippets->previousInSeries" title="What is Staking" link="what-is-the-point-of-buying-ada-and-staking-in-cardano" />
            <x-next-previous :name="$snippets->nextInSeries" title="How to stake your Ada" link="how-to-stake-ada" />
        </section>

    <section class="py-12 bg-gray-50 border border-gray-100">
        <div class="px-6 max-w-6xl xl:mx-auto">
            <livewire:comments :showNotificationOptions="Auth::check()" :hideNotificationOptions="!Auth::check()" :hideAvatars="false" :noReplies="false" :model="$post" />
        </div>
    </section>

{{--    <section class="bg-gray-50 py-12 border border-gray-100">--}}
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

{{--                <div class="py-16 pt-8 max-w-5xl">--}}
{{--                    <x-public.comments :model="$post"></x-public.comments>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <!-- Comment Form -->--}}
{{--            <div class="">--}}
{{--                <x-public.divider></x-public.divider>--}}
{{--            </div>--}}
{{--            <div class="py-16 max-w-5xl">--}}
{{--                <livewire:comment-form-component--}}
{{--                    :modelId="$post->id"--}}
{{--                    :modelType="$post->type ?? 'App\Models\Post'"--}}
{{--                    :prompt="$post->comments->count() > 1 ? $post->comment_prompt : null"/>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}


<x-support-lido heading-leading='Support the' heading-span='Library'/>

</div>
