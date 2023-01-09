<div class="relative z-10">
    @livewire('catalyst.catalyst-sub-menu-component')

    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-10 flex flex-col block gap-3 sm:flex-row">
                <span class='z-10 font-light'>{{ $snippets->cardano }}</span>
                <span class='z-10 font-black text-teal-600'>
                    {{ $snippets->projects }}
                </span>
            </span>
        </x-slot>
        <h2 class="font-medium">
            {{ $snippets->prePayingForFutureInnovations }}
        </h2>
    </x-public.page-header>

    {{--    <section class="relative py-8 text-white bg-teal-600 text-md">--}}
    {{--        <div class="container">--}}
    {{--            <div class="flex flex-row items-center justify-end gap-4">--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    <section class="bg-gray-100 relative">
        <div class="container py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 grid-rows-1 xl:grid-cols-5 xl:grid-rows-4 gap-4 h-full">
                <div class="bg-teal-600 relative px-3 py-5 col-span-1 row-span-1 round-sm">
                    <dl class="flex flex-col justify-between h-full relative">
                        <div class="px3 absolute right-0 top-0">
                            <a type="button"
                               href="{{$largestProposal?->link}}"
                               class="inline-flex items-center px-1.5 py-1 border border-white hover:border-accent-700 shadow-xs text-xs font-semibold rounded-sm text-white bg-transparent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-600 hover:bg-accent-600">
                                View
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                        <dd class="pointer-events-none">
                            <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white relative">
                                <div>
                                    ${{humanNumber($largestProposal?->amount_requested)}}
                                </div>
                            </div>
                        </dd>
                        <dt class="text-lg font-medium text-gray-200 truncate mt-3 pointer-events-none">
                            Largest Winning Proposal
                        </dt>
                    </dl>
                </div>

                <div class="bg-white relative px-3 py-5 col-span-1 row-span-1 round-sm">
                    <dl class="flex flex-col justify-between h-full">
                        <dd>
                            <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-blue-dark-500">
                                {{$fundedOver75K}}
                            </div>
                        </dd>
                        <dt class="text-lg font-medium text-blue-dark-500 truncate mt-3">
                            Funded >= 75K
                        </dt>
                    </dl>
                </div>

                <div class="bg-teal-600 relative px-3 py-5 col-span-1 row-span-1 round-sm">
                    <dl class="flex flex-col justify-between h-full">
                        <dd>
                            <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white">
                                {{$numberOfFundedBuilders}}
                            </div>
                        </dd>
                        <dt class="text-lg font-medium text-gray-200 truncate mt-3">
                            Members Awarded Funding
                        </dt>
                    </dl>
                </div>

                <div class="bg-blue-dark-500 col-span-1 md:col-span-3 xl:col-span-2 relative p-3 row-span-1 round-sm">
                    <div class="flex flex-row flex-wrap md:flex-nowrap justify-between items-start h-full">
                        <div>
                            <dl class="flex flex-col justify-between">
                                <dd>
                                    <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white">
                                        {{$fullyDisbursed}}
                                    </div>
                                </dd>
                                <dt class="text-lg font-medium text-gray-200 truncate mt-3">
                                    Proposals with Fully Disbursed Funds
                                </dt>
                            </dl>
                        </div>

                        <div class="ml-auto md:mt-auto">
                            <dl class="flex flex-col justify-between text-right">
                                <dd>
                                    <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white">
                                        {{$completedProposals}}
                                    </div>
                                </dd>
                                <dt class="text-lg font-medium text-gray-200 truncate mt-3">
                                    Completed Proposals
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-3 w-full relative bg-white p-3 row-span-4 round-sm">
                    <div class="text-blue-dark-500">
                        <h2 class="xl:text-3xl mb-0">
                            Proposal Details
                        </h2>
                        <p>most frequent words</p>
                    </div>
                    <div class="relative w-full">
                        @if($wordCloudSet)
                            <x-catalyst.reports.chart-wordcloud
                                :labels="$wordCloudSet?->pluck('word')->toArray()"
                                :data="$wordCloudSet?->pluck('occurrences')->map(fn($v)=>intval(intval($v)/160))->toArray()"
                                dataType="currency"></x-catalyst.reports.chart-wordcloud>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 md:col-span-3 xl:col-span-2 xl:row-span-4 bg-white p-3 w-full round-sm">
                    <div class="h-full flex flex-col justify-start relative">
                        <div class="text-teal-600">
                            <h2 class="xl:text-3xl mb-0">
                                Average WINNING
                            </h2>
                            <p>proposal size by Fund</p>
                        </div>

                        <div class="my-auto">
                            @isset($fundedAverageSet)
                            <x-catalyst.reports.chart
                                :labels="$fundedAverageSet->pluck('label')->toArray()"
                                :data="$fundedAverageSet->pluck('avg')->toArray()"
                                dataType="currency"></x-catalyst.reports.chart>
                            @endisset
                        </div>
                    </div>
                </div>

                <div
                    class="col-span-1 md:col-span-3 xl:col-span-2 xl:row-span-4 p-3 w-full round-sm bg-teal-600 text-white">
                    <div class="h-full flex flex-col justify-start relative">
                        <div class="">
                            <h2 class="xl:text-3xl mb-0">
                                {{ $snippets->catalystNumbers }}
                            </h2>
                            {{--                            <p>proposal size by Fund</p>--}}
                        </div>

                        <div class="my-auto flex flex-row flex-wrap bg-teal-600">
                            <div class="p-2">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32 2xl:w-40 2xl:h-40">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-3xl inline-block font-semibold">
                                            ${{humanNumber($fundedProposalsSum)}}
                                        </div>
                                        <div class="text-xs inline-block text-center">
                                            Total Awarded
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32 2xl:w-40 2xl:h-40">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-2xl 2xl:text-3xl inline-block font-semibold">
                                            ${{humanNumber($completedProposalsSum, 2)}}
                                        </div>
                                        <div class="text-xs inline-block text-center">
                                            {{ $snippets->completedProjects }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32 2xl:w-40 2xl:h-40">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-3xl 2xl:text-4xl inline-block font-semibold">
                                            ${{humanNumber($avgFundedProposals)}}
                                        </div>
                                        <div class="text-xs inline-block text-center">
                                            Average Funded Amount
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32 2xl:w-40 2xl:h-40">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-4xl inline-block font-semibold">
                                            {{humanNumber($proposalsSum)}}
                                        </div>
                                        <div class="text-sm inline-block text-center">
                                            Proposals Submitted
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32 2xl:w-40 2xl:h-40">
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-4xl inline-block font-semibold">
                                            {{humanNumber($numberOfBuilders)}}
                                        </div>
                                        <div class="text-sm inline-block text-center">
                                            Builders in Catalyst
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="flex justify-center p-4 rounded-full border border-white w-32 h-32 2xl:w-40 2xl:h-40">

                                    <div class="inline-flex flex-col items-center justify-center">
                                        <div class="text-4xl inline-block font-semibold">
                                            {{humanNumber($startups)}}
                                        </div>
                                        <div class="text-sm inline-block text-center">
                                            Startups & Companies
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-3 w-full relative bg-white p-3 row-span-4 round-sm">
                    <div class="text-gray-600">
                        <h2 class="xl:text-3xl mb-0">
                            Top Funded Proposals
                        </h2>
                        <p>
                            Across all funding rounds
                        </p>
                    </div>
                    <div class="relative w-full mt-auto">
                        @if($topFundedProposals)
                            <ul role="list" class="divide-y divide-gray-200 max-h-[28rem] overflow-y-auto">
                                @foreach($topFundedProposals as $proposal)
                                    <li>
                                        <a href="{{$proposal->link}}" class="block hover:bg-gray-50" target="_blank">
                                            <div class="flex items-center px-4 py-4 sm:px-6">
                                                <div class="min-w-0 flex-1 flex items-center">
                                                    <div class="flex-shrink-0"
                                                         x-data="{ tooltip: @js($proposal?->group?->name ?? $proposal?->author?->name) }">
                                                        <img
                                                            x-tooltip.theme.teal="tooltip"
                                                            class="h-10 w-10 relative inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                                            src="{{$proposal?->group?->thumbnail_url ?? $proposal?->author?->gravatar}}"
                                                            alt="{{$proposal->author?->name}} gravatar"/>
                                                    </div>
                                                    <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                                        <div>
                                                            <p class="text-xl font-medium truncate text-gray-600 ">
                                                                {{$proposal->title}}
                                                            </p>
                                                            <div class="mt-2 text-sm text-gray-500">
                                                                <div x-data="{ tooltip: 'Proposal Assessor Reviews' }">
                                                                    <div x-tooltip.theme.teal="tooltip">
                                                                        <livewire:ratings.model-average-rating-component
                                                                            :modelId="$proposal->id"
                                                                            wire:key="{{$proposal->id}}"
                                                                            theme="{{$proposal->funding_status == 'completed' ? 'pink': 'accent'}}"
                                                                            :modelType="\App\Models\Proposal::class"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="hidden md:block">
                                                            <div
                                                                x-data="{ tooltip: @js('Funded in ' . $proposal?->fund?->parent?->label) }">
                                                                <p class="text-lg md:text-xl 2xl:text-2xl text-gray-900">
                                                                    ${{humanNumber($proposal->amount_requested)}}
                                                                </p>
                                                                <p x-tooltip.theme.teal="tooltip"
                                                                   class="mt-2 flex items-center text-sm text-gray-500">
                                                                    {{$proposal->fund?->label}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <!-- Heroicon name: solid/chevron-right -->
                                                    <svg class="h-5 w-5 text-gray-400"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                         fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div></div>
</div>
