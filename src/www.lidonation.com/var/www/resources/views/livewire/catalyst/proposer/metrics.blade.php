<div class="relative" wire:key="{{$catalystUser->id}}">
    <div
        wire:loading.class.remove="hidden" wire:loading.delay.shortest.class="absolute" wire:target="toggleOwnMetrics"
        class="sticky left-0 z-10 flex items-center justify-center hidden w-full h-0 p-0 overflow-visible top-1/2">
        <div
            class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full xl:w-40 xl:h-40 lg:h-32 lg:w-32 bg-opacity-80">
            <svg
                class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-primary-600"
                viewBox="0 0 24 24"></svg>
        </div>
    </div>

    <div class="flex flex-row justify-end font-semibold text-yellow-400 right-0top-0p-4">
        <div class="flex items-center" x-data="{ownMetrics: @entangle('ownMetrics')}">
            <button type="button"
                    :class="{'bg-teal-800': ownMetrics, 'bg-gray-200': !ownMetrics}"
                    wire:click="toggleOwnMetrics({{ $catalystUser->id }})"
                    class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    role="switch"
                    aria-checked="false"
                    aria-labelledby="annual-billing-label">
                        <span aria-hidden="true"
                              :class="{'translate-x-5': ownMetrics, 'translate-x-0': !ownMetrics}"
                              class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
            </button>
            <span class="ml-3 text-sm">
                @if($ownMetrics)
                    <span class="font-bold">{{$catalystUser->name}}</span> own proposals
                @else
                    <span class="font-bold">{{$catalystUser->name}}</span> own + co-authored proposals
                @endif
            </span>
        </div>
    </div>

    <div class="user-summary">
        <div>
            <h3 class="mb-4 text-sm capitalize">
                Community Reviews across funding rounds
            </h3>
        </div>

        <div class="flex w-full gap-8 gridgrid-cols-6 md:gap-16 lg:gap-4 combined-ratings">
            @if($discussionData)
            <div class="flex flex-col justify-center px-16 all-time-combine-reviews">
                <div class="text-sm text-right">
                    <div class="rating-count">
                        <span class="text-4xl font-semibold lg:text-5xl xl:text-6xl 2xl:text-7xl leading-2">
                            {{$this->getMetric('allTimeCaRatingCount')}}
                        </span>
                    </div>
                    <div>
                        <span class="text-sm font-semibold capitalize">
                            {{ $snippets->totalReviews }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            @if($this->getMetric('allTimeCaAverageGroups'))
            <div class="flex flex-1 pt-1 md:col-span-3lg:col-span-4 chart stacked-bar lg:pl-8 lg:mt-9">
                <div class="w-full text-sm">
                        @foreach($this->getMetric('allTimeCaAverageGroups') as $key => $data)
                            <div class="mb-3">
                                <div class="flex flex-row items-end justify-between gap-3">
                                    <div class="grid flex-1 h-6 bg-teal-300 rounded-sm grid-cols-100">
                                        <div
                                            class="h-6 p-1 text-xs font-semibold bg-teal-800 rounded-sm text-teal-light-500"
                                            style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}">{{$key}}</div>
                                    </div>
                                    <div class="w-16 text-right">
                                        <span class="font-semibold capitalize text-md">{{$data['rating']}} Star</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 proposal-summary">
        <div class="flex flex-row flex-wrap justify-between gap-4">
            <div class="overflow-hidden all-time-combined-rating">
                <h3 class="mb-1 text-sm capitalize">
                    Proposals Across Fund Rounds
                </h3>
                <div class="flex flex-row justify-start p-1 overflow-x-scroll md:flex-wrap categories">
                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-2 text-yellow-500 md:justify-start">
                            <div class="flex flex-wrap text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{$this->getMetric('allTimeCompletedPerRound')?->data->sum()}}
                            </span>
                            </div>
                            <div class="flex flex-wrap gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                Completed
                            </span>
                            </div>
                        </div>
                        <div class="flex w-full min-w-full overflow-hidden">
                            @if( $this->getMetric('allTimeCompletedPerRound')?->data->count() > 1 )
                                <div class="relative w-full xl:w-48" wire:ignore>
                                    <x-catalyst.users.chart-per-fund
                                        chartName="allTimeCompletedPerRound"
                                        :modelId="$catalystUser->id"
                                        :labels="$this->getMetric('allTimeCompletedPerRound')?->labels"
                                        :data="$this->getMetric('allTimeCompletedPerRound')?->data"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[11rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium text-gray-200 rounded-l-sm focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            <span class="hidden md:inline-block">New to Catalyst!</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start text-blue-dark-500">
                            <div class="flex flex-wrap text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{$this->getMetric('allTimeFundedPerRound')?->data->sum()}}
                            </span>
                            </div>
                            <div class="flex flex-wrap gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                Approved
                            </span>
                            </div>
                        </div>
                        <div class="flex w-full min-w-full overflow-hidden">
                            @if( $this->getMetric('allTimeFundedPerRound')?->data->count() > 1 )
                                <div class="relative w-full xl:w-48" wire:ignore>
                                    <x-catalyst.users.chart-per-fund
                                        chartName="allTimeFundedPerRound"
                                        :modelId="$catalystUser->id"
                                        :labels="$this->getMetric('allTimeFundedPerRound')?->labels"
                                        :data="$this->getMetric('allTimeFundedPerRound')?->data"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[11rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium text-gray-200 rounded-l-sm focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            <span class="hidden md:inline-block">New to Catalyst!</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start">
                            <div class="flex flex-wrap text-xl font-semibold flex-nowrap">
                            <span class="text-xl font-semibold text-blue-dark-500 xl:text-3xl">
                                {{$this->getMetric('allTimeProposedPerRound')?->data?->sum() ?? '-'}}
                            </span>
                            </div>
                            <div class="flex flex-wrap gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                Proposed
                            </span>
                            </div>
                        </div>
                        <div class="flex w-full min-w-full overflow-hidden">
                            @if( $this->getMetric('allTimeProposedPerRound')?->data->count() > 1 )
                                <div class="relative w-full xl:w-48" wire:ignore>
                                    <x-catalyst.users.chart-per-fund
                                        chartName="allTimeProposedPerRound"
                                        :modelId="$catalystUser->id"
                                        :labels="$this->getMetric('allTimeProposedPerRound')->labels"
                                        :data="$this->getMetric('allTimeProposedPerRound')->data"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[11rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium text-gray-200 rounded-l-sm focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            <span class="hidden md:inline-block">New to Catalyst!</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div class="flex flex-row flex-no-wrap items-center justify-between gap-4 md:justify-start">
                            <div class="flex flex-wrap font-semibold leading-2">
                            <span class="text-xl font-semibold xl:text-3xl leading-2 text-blue-dark-500">
                                ${{ humanNumber($this->getMetric('allTimeFundingPerRound')?->data->sum()) }}
                            </span>
                            </div>
                            <div class="flex flex-wrap gap-1 text-sm font-normal flex-nowrap leading-2">
                            <span>
                                Requested
                            </span>
                            </div>
                        </div>
                        <div class="w-full min-w-full overflow-hidden">
                            @if( $this->getMetric('allTimeFundingPerRound')?->data->count() > 1 )
                                <div class="relative w-full xl:w-48" wire:ignore>
                                    <x-catalyst.users.chart-per-fund
                                        dataType="currency"
                                        chartName="allTimeFundingPerRound"
                                        :modelId="$catalystUser->id"
                                        :labels="$this->getMetric('allTimeFundingPerRound')?->labels"
                                        :data="$this->getMetric('allTimeFundingPerRound')?->data"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[10rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium text-gray-200 rounded-l-sm focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            <span class="hidden md:inline-block">New to Catalyst!</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start text-blue-dark-500">
                            <div class="flex flex-wrap font-semibold flex-nowrap leading-2">
                            <span class="text-xl font-semibold xl:text-3xl leading-2">
                                ${{ humanNumber($this->getMetric('allTimeAwardedPerRound')?->data->sum()) }}
                            </span>
                            </div>
                            <div class="flex flex-wrap gap-1 text-sm font-normal flex-nowrap leading-2">
                            <span>
                                Awarded
                            </span>
                            </div>
                        </div>
                        <div class="w-full min-w-full overflow-hidden">
                            @if( $this->getMetric('allTimeAwardedPerRound')?->data->count() > 1 )
                                <div class="relative w-full xl:w-48" wire:ignore>
                                    <x-catalyst.users.chart-per-fund
                                        dataType="currency"
                                        chartName="allTimeAwardedPerRound"
                                        :modelId="$catalystUser->id"
                                        :labels="$this->getMetric('allTimeAwardedPerRound')?->labels"
                                        :data="$this->getMetric('allTimeAwardedPerRound')?->data"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[10rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium text-gray-200 rounded-l-sm focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            <span class="hidden md:inline-block">New to Catalyst!</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div
                        class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start text-blue-dark-500">
                            <div class="flex flex-wrap font-semibold flex-nowrap leading-2">
                                <span class="text-xl font-semibold xl:text-3xl leading-2">
                                    ${{humanNumber($this->getMetric('allTimeReceivedPerRound')?->data?->sum())}}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-1 text-sm font-normal flex-nowrap leading-2">
                                <span>
                                    Received
                                </span>
                            </div>
                        </div>
                        <div class="w-full min-w-full overflow-hidden">
                            @if( $this->getMetric('allTimeReceivedPerRound')?->data->count() > 1 )
                                <div class="relative w-full xl:w-48" wire:ignore>
                                    <x-catalyst.users.chart-per-fund
                                        dataType="currency"
                                        chartName="allTimeReceivedPerRound"
                                        :modelId="$catalystUser->id"
                                        :labels="$this->getMetric('allTimeReceivedPerRound')?->labels"
                                        :data="$this->getMetric('allTimeReceivedPerRound')?->data"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[10rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium text-gray-200 rounded-l-sm focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            <span class="hidden md:inline-block">New to Catalyst!</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{--        <div class="flex flex-col justify-between all-time-combine-reviews">--}}
            {{--            <h3 class="mb-1 text-sm capitalize md:text-right">--}}
            {{--                Funding Across Funds--}}
            {{--            </h3>--}}
            {{--            <div class="flex flex-row flex-wrap justify-center md:gap-0 categories">--}}

            {{--            </div>--}}
            {{--        </div>--}}
        </div>
        @if($catalystUser->proposals?->sortByDesc('funded_at')->first()?->funding_updated_at)
            <div class="flex flex-row justify-end mt-4 text-xs italic font-bold text-white text-yellow-400">
                <p>
                    Funding data last updated
                    <x-carbon :date="$catalystUser->proposals->sortByDesc('funded_at')->first()->funding_updated_at" human/>
                </p>
            </div>
        @endif
    </div>
</div>
