@props([
    'catalystUser',
    'allTimeCaAverage',
    'allTimeCaRatingCount',
    'allTimeCaAverageGroups',
    'allTimeFundedPerRound',
    'allTimeAwardedPerRound',
    'allTimeReceivedPerRound',
    'allTimeFundingPerRound',
    'allTimeProposedPerRound',
    'allTimeCompletedPerRound'
])
<div class="user-summary">
    <div class="grid grid-cols-6 gap-8 md:gap-16 lg:gap-4 combined-ratings">
        <div class="col-span-6 md:col-span-3 lg:col-span-2">
            <div class="flex flex-row gap-4 justify-between">
                <div class="all-time-combined-rating">
                    <h3 class="mb-4 text-sm capitalize">
                        Combined CA Review Across Funds
                    </h3>
                    <div class="">
                        <div class="flex flex-col items-start">
                            <span class="hidden md:w-6 md:h-6"></span>
                            <x-public.stars :amount="round($allTimeCaAverage)" :size="6" theme="text-yellow-600"></x-public.stars>
                            <div class="mt-2 rating-average">
                                <span
                                    class="inline-block text-3xl font-semibold xl:text-5xl leading-2">
                                   {{humanNumber($allTimeCaAverage)}} / 5
                                </span>
                            </div>
                            <div>
                                <span
                                    class="inline-block text-sm font-semibold capitalize xl:text-md">
                                    {{ $snippets->averageRating }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between all-time-combine-reviews">
                    <h3 class="mb-4 text-sm text-right capitalize">
                        Total PA Reviews across funds
                    </h3>
                    <div class="text-sm text-right">
                        <div class="rating-count">
                            <span class="text-4xl font-semibold xl:text-5xl leading-2">
                                {{$allTimeCaRatingCount}}
                            </span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold capitalize">
                                {{ $snippets->totalReviews }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($allTimeCaAverageGroups)
        <div class="col-span-6 pt-1 md:col-span-3 lg:col-span-4 chart stacked-bar lg:pl-8 lg:mt-9">
            <div class="w-full text-sm">
                @foreach($allTimeCaAverageGroups as $key => $data)
                    <div class="mb-3">
                        <div class="flex flex-row gap-3 justify-between items-end">
                            <div class="grid flex-1 h-6 bg-teal-300 rounded-sm grid-cols-100">
                                <div class="h-6 bg-teal-800 rounded-sm p-1 text-xs text-teal-light-500 font-semibold"
                                     style="grid-column: span {{$data['percent']}} / span {{$data['percent']}}">{{$key}}</div>
                            </div>
                            <div>
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

<div class="proposal-summary mt-8">
    <div class="flex flex-row gap-4 justify-between flex-wrap">
        <div class="all-time-combined-rating overflow-hidden">
            <h3 class="mb-1 text-sm capitalize">
                Proposals Across Fund Rounds
            </h3>
            <div class="flex flex-row overflow-x-scroll md:flex-wrap p-1 justify-start categories">
                <div class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                    <div
                        class="flex flex-row gap-2 justify-between items-center flex-no-wrap md:justify-start text-yellow-500">
                        <div class="flex flex-wrap flex-nowrap font-semibold text-xl xl:text-3xl">
                            <span class="font-semibold">
                                {{$allTimeCompletedPerRound->data->sum()}}
                            </span>
                        </div>
                        <div class="flex flex-wrap flex-nowrap gap-1 font-normal leading-2 text-base">
                            <span>
                                Completed
                            </span>
                        </div>
                    </div>
                    <div class="flex w-full min-w-full overflow-hidden">
                        @if( $allTimeCompletedPerRound->data->count() > 1 )
                            <div class="w-full xl:w-48 relative">
                                <x-catalyst.users.chart-per-fund
                                    :labels="$allTimeCompletedPerRound->labels"
                                    :data="$allTimeCompletedPerRound->data"></x-catalyst.users.chart-per-fund>
                            </div>
                        @else
                            <div class="inline-flex min-w-[11rem]">
                                <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                    <div class="relative inline-flex items-center text-xl italic gap-1 font-medium text-dark-blue-500 rounded-l-sm focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                        <span class="hidden md:inline-block">New to Catalyst!</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                    <div class="flex flex-row gap-5 justify-between items-center flex-no-wrap md:justify-start text-blue-dark-500">
                        <div class="flex flex-wrap flex-nowrap font-semibold text-xl xl:text-3xl">
                            <span class="font-semibold">
                                {{$allTimeFundedPerRound->data->sum()}}
                            </span>
                        </div>
                        <div class="flex flex-wrap flex-nowrap gap-1 font-normal leading-2 text-base">
                            <span>
                                Approved
                            </span>
                        </div>
                    </div>
                    <div class="flex w-full min-w-full overflow-hidden">
                        @if( $allTimeFundedPerRound->data->count() > 1 )
                            <div class="w-full xl:w-48 relative">
                                <x-catalyst.users.chart-per-fund
                                    :labels="$allTimeFundedPerRound->labels"
                                    :data="$allTimeFundedPerRound->data"></x-catalyst.users.chart-per-fund>
                            </div>
                        @else
                            <div class="inline-flex min-w-[11rem]">
                                <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                    <div class="relative inline-flex items-center text-xl italic gap-1 font-medium text-blue-dark-500 rounded-l-sm focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                        <span class="hidden md:inline-block">New to Catalyst!</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                    <div
                        class="flex flex-row gap-5 justify-between items-center flex-no-wrap md:justify-start">
                        <div class="flex flex-wrap flex-nowrap font-semibold text-xl">
                            <span class="font-semibold text-blue-dark-500 text-xl xl:text-3xl">
                                {{$allTimeProposedPerRound->data?->sum() ?? '-'}}
                            </span>
                        </div>
                        <div class="flex flex-wrap flex-nowrap gap-1 font-normal leading-2 text-base">
                            <span>
                                Proposed
                            </span>
                        </div>
                    </div>
                    <div class="flex w-full min-w-full overflow-hidden">
                        @if( $allTimeProposedPerRound->data->count() > 1 )
                            <div class="w-full xl:w-48 relative">
                                <x-catalyst.users.chart-per-fund
                                    :labels="$allTimeProposedPerRound->labels"
                                    :data="$allTimeProposedPerRound->data"></x-catalyst.users.chart-per-fund>
                            </div>
                        @else
                            <div class="inline-flex min-w-[11rem]">
                                <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                    <div class="relative inline-flex items-center text-xl italic gap-1 font-medium text-blue-dark-500 rounded-l-sm focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                        <span class="hidden md:inline-block">New to Catalyst!</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                    <div class="flex flex-row gap-4 justify-between items-center flex-no-wrap md:justify-start">
                        <div class="flex flex-wrap font-semibold leading-2">
                            <span class="text-xl xl:text-3xl font-semibold leading-2 text-blue-dark-500">
                                ${{ humanNumber($allTimeFundingPerRound->data->sum()) }}
                            </span>
                        </div>
                        <div class="flex flex-wrap flex-nowrap gap-1 font-normal leading-2 text-sm">
                            <span>
                                Requested
                            </span>
                        </div>
                    </div>
                    <div class="w-full min-w-full overflow-hidden">
                        @if( $allTimeFundingPerRound->data->count() > 1 )
                            <div class="w-full xl:w-48 relative">
                                <x-catalyst.users.chart-per-fund
                                    dataType="currency"
                                    :labels="$allTimeFundingPerRound->labels"
                                    :data="$allTimeFundingPerRound->data"></x-catalyst.users.chart-per-fund>
                            </div>
                        @else
                            <div class="inline-flex min-w-[10rem]">
                                <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                    <div class="relative inline-flex items-center text-xl italic gap-1 font-medium text-blue-dark-500 rounded-l-sm focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                        <span class="hidden md:inline-block">New to Catalyst!</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                    <div class="flex flex-row gap-5 justify-between items-center flex-no-wrap md:justify-start text-blue-dark-500">
                        <div class="flex flex-wrap flex-nowrap font-semibold leading-2">
                            <span class="text-xl xl:text-3xl font-semibold leading-2">
                                ${{ humanNumber($allTimeAwardedPerRound->data->sum()) }}
                            </span>
                        </div>
                        <div class="flex flex-wrap flex-nowrap gap-1 font-normal leading-2 text-sm">
                            <span>
                                Awarded
                            </span>
                        </div>
                    </div>
                    <div class="w-full min-w-full overflow-hidden">
                        @if( $allTimeAwardedPerRound->data->count() > 1 )
                            <div class="w-full xl:w-48 relative">
                                <x-catalyst.users.chart-per-fund
                                    dataType="currency"
                                    :labels="$allTimeAwardedPerRound->labels"
                                    :data="$allTimeAwardedPerRound->data"></x-catalyst.users.chart-per-fund>
                            </div>
                        @else
                            <div class="inline-flex min-w-[10rem]">
                                <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                    <div class="relative inline-flex items-center text-xl italic gap-1 font-medium text-blue-dark-500 rounded-l-sm focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                        <span class="hidden md:inline-block">New to Catalyst!</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                    <div
                        class="flex flex-row gap-5 justify-between items-center flex-no-wrap md:justify-start text-blue-dark-500">
                        <div class="flex flex-wrap flex-nowrap font-semibold leading-2">
                            <span class="text-xl xl:text-3xl font-semibold leading-2">
                                ${{humanNumber($allTimeReceivedPerRound->data?->sum())}}
                            </span>
                        </div>
                        <div class="flex flex-wrap flex-nowrap gap-1 font-normal leading-2 text-sm">
                            <span>
                                Received
                            </span>
                        </div>
                    </div>
                    <div class="w-full min-w-full overflow-hidden">
                        @if( $allTimeReceivedPerRound->data->count() > 1 )
                            <div class="w-full xl:w-48 relative">
                                <x-catalyst.users.chart-per-fund
                                    dataType="currency"
                                    :labels="$allTimeReceivedPerRound->labels"
                                    :data="$allTimeReceivedPerRound->data"></x-catalyst.users.chart-per-fund>
                            </div>
                        @else
                            <div class="inline-flex min-w-[10rem]">
                                <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                    <div class="relative inline-flex items-center text-xl italic gap-1 font-medium text-blue-dark-500 rounded-l-sm focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
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
{{--            <h3 class="mb-1 text-sm md:text-right capitalize">--}}
{{--                Funding Across Funds--}}
{{--            </h3>--}}
{{--            <div class="flex flex-row flex-wrap justify-center md:gap-0 categories">--}}

{{--            </div>--}}
{{--        </div>--}}
    </div>
    @if($catalystUser->proposals?->first()?->funding_updated_at)
        <div class="flex flex-row justify-end text-white font-bold text-xs mt-4 italic text-yellow-400">
            <p>
                Funding data last updated
                <x-carbon :date="$catalystUser->proposals->first()->funding_updated_at" human/>
            </p>
        </div>
    @endif
</div>
