<x-public-layout class="challenge" :metaTitle="$fund->label">
    @push('openGraph')
        <meta property="og:type" content="article"/>
        <meta property="og:title" content="{{$fund->label}}"/>
        <meta property="og:description" content="{{$fund->excerpt}}"/>
        <meta property="og:url" content="{{$fund->url}}"/>
        <meta property="og:image" content="{{$fund->hero_url}}"/>
        <meta property="og:image:width" content="2048"/>
        <meta property="og:image:height" content="2048"/>
        <meta property="article:publisher" content="{{config('app.name')}}"/>
{{--        <meta property="article:author" content="{{$fund->author?->name}}"/>--}}
        <meta property="article:published_time" content="{{$fund->launched_at}}"/>
        <meta property="twitter:card" content="summary_large_image"/>
        <meta property="twitter:title" content="{{$fund->label}}"/>
        <meta property="twitter:description" content="{{$fund->excerpt}}"/>
        <meta property="twitter:image" content="{{$fund->hero_url}}"/>
        <meta property="twitter:url" content="{{$fund->url}}"/>
        <meta property="twitter:site" content="@lidonation"/>
    @endpush

{{--    @livewire('catalyst.catalyst-sub-menu-component')--}}

    <header class="text-white bg-teal-600">
        <div class="container">
            <section class="overflow-visible relative z-0 py-10 min-h-[28rem]">
                <h1 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate'>
                    <img class="w-10 h-10 rounded-sm lg:w-16 lg:h-16"
                         src="{{$fund->hero_url}}"
                         alt="{{$fund->label}} gravatar"/>

                    <span class="font-semibold">
                        {{$fund->label}}
                    </span>
                </h1>

                <div class="my-4 summary">
                    <div class="max-w-4xl font-semibold">
                        {{$fund->excerpt}}
                    </div>
                </div>

                <div x-data="{expanded: false}"
                     x-transition
                     x-cloak
                     :class="{'max-h-52 overflow-clip': !expanded, 'max-h-[40vh] overflow-auto': expanded}"
                     class="relative mt-6 ">

                    <x-markdown>{{$fund->content}}</x-markdown>

                    <div  x-show="!expanded" class="absolute w-full h-20 text-center bg-teal-600 -bottom-8 bg-opacity-90">
                        <div class="flex items-center justify-center w-full h-full">
                            <div class="py-3 text-xl font-bold text-white hover:cursor-pointer hover:text-yellow-400" @click="expanded = !expanded">
                                <span>Expand</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="relative py-8 text-white bg-teal-600 text-md">
                <div class="flex flex-row flex-wrap justify-start">
                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                <span class="font-semibold">
                                    {{$totalProposalsCount ?? '-'}}
                                </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                <span>
                                    {{__('Total Proposals')}}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                <span class="font-semibold">
                                    {{$fundedProposalsCount ?? '-'}}
                                </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                <span>
                                    {{__('Funded Proposals')}}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                <span class="font-semibold">
                                    {{$completedProposalsCount ?? '-'}}
                                </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                <span>
                                    {{__('Completed Proposals')}}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                    class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                <span class="font-semibold">
                                    {{$fund->currency_symbol}} {{humanNumber($fund->amount)}}
                                </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                <span>
                                    {{__('Available')}}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                <span class="font-semibold">
                                    {{$fund->currency_symbol}}{{humanNumber($totalAmountRequested)}}
                                </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                <span>
                                    {{__('Requested')}}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                <span class="font-semibold">
                                    {{$fund->currency_symbol}}{{humanNumber($totalAmountAwarded)}}
                                </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                <span>
                                    {{__('Awarded')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </header>
    <section
        class="relative py-10 overflow-visible bg-white bg-left-bottom bg-repeat-y bg-contain bg-opacity-90 bg-blend-color-burn lg:py-20 bg-pool-bw-light">
        <div class="container">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
                @foreach($proposals as $proposal)
                    @if($proposal->type=='challenge')
                        <x-catalyst.challenges.drip :challenge="$proposal"/>
                    @else
                        <x-catalyst.proposals.drip :proposal="$proposal" />
                    @endif
                @endforeach
            </div>

            <div class="mt-8">
                {{ $proposals?->onEachSide(5)->links() }}
            </div>
        </div>
    </section>
</x-public-layout>
