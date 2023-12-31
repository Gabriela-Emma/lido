@props(['catalystUser', 'allTimeCaAverage', 'allTimeCaRatingCount', 'allTimeCaAverageGroups', 'allTimeFundedPerRound', 'allTimeAwardedPerRound', 'allTimeReceivedPerRound', 'allTimeFundingPerRound', 'allTimeProposedPerRound', 'allTimeCompletedPerRound', 'discussionData'])
<div class="relative" wire:key="{{ $catalystUser->id }}">
 <div wire:loading.class.remove="hidden" wire:loading.delay.shortest.class="absolute" wire:target="toggleOwnMetrics"
        class="sticky left-0 z-10 flex items-center justify-center hidden w-full h-0 p-0 overflow-visible top-1/2">
        <div
            class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full xl:w-40 xl:h-40 lg:h-32 lg:w-32 bg-opacity-80">
            <svg class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-primary-600"
                viewBox="0 0 24 24"></svg>
        </div>
    </div>

    @if($catalystUser instanceof \App\Models\CatalystExplorer\CatalystUser)
    <div class="flex flex-row justify-end font-semibold text-yellow-400 right-0top-0p-4">
        <div class="flex items-center" x-data="{ ownMetrics: @entangle('ownMetrics') }">
            <button type="button" :class="{ 'bg-teal-800': ownMetrics, 'bg-gray-200': !ownMetrics }"
                wire:click="toggleOwnMetrics({{ $catalystUser->id }})"
                class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                role="switch" aria-checked="false" aria-labelledby="annual-billing-label">
                <span aria-hidden="true" :class="{ 'translate-x-5': ownMetrics, 'translate-x-0': !ownMetrics }"
                    class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
            </button>
            <span class="ml-3 text-sm">
                @if ($ownMetrics)
                    <span class="font-bold">{{ $catalystUser->name }}</span> own proposals
                @else
                    <span class="font-bold">{{ $catalystUser->name }}</span> own + co-authored proposals
                @endif
            </span>
        </div>
    </div>
    @endif

    <div class="user-summary">
        <div>
            <h3 class="mb-4 text-sm capitalize">
                Community Reviews across funding rounds
            </h3>
        </div>

        <div class="flex w-full gap-8 md:gap-16 lg:gap-4 combined-ratings">
            @if ($allTimeCaRatingCount)
                <div class="flex flex-col justify-center px-16 all-time-combine-reviews">
                    <div class="text-sm text-right">
                        <div class="rating-count">
                        <span class="text-4xl font-semibold lg:text-5xl xl:text-6xl 2xl:text-7xl leading-2">
                            {{ $allTimeCaRatingCount }}
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

            @if ($allTimeCaAverageGroups)
                <div class="flex flex-1 pt-1 md:col-span-3lg:col-span-4 chart stacked-bar lg:pl-8 lg:mt-9">
                    <div class="w-full text-sm">
                        @foreach ($allTimeCaAverageGroups as $key => $data)
                            <div class="mb-3">
                                <div class="flex flex-row items-end justify-between gap-3">
                                    <div class="grid flex-1 h-6 bg-teal-300 rounded-sm grid-cols-100">
                                        <div
                                            class="h-6 p-1 text-xs font-semibold bg-teal-800 rounded-sm text-teal-light-500"
                                            style="grid-column: span {{ $data['percent'] }} / span {{ $data['percent'] }}">
                                            {{ $key }}</div>
                                    </div>
                                    <div>
                                        <span class="font-semibold capitalize text-md">{{ $data['rating'] }} Star</span>
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
                    Proposals Across Funding Rounds
                </h3>
                <div class="flex flex-row justify-start p-1 overflow-x-scroll flex-nowrap categories">
                    <div
                        class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-2 text-yellow-500 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{ $allTimeCompletedPerRound['data']->sum() }}
                            </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                Completed
                            </span>
                            </div>
                        </div>
                        <div class="flex w-full min-w-full overflow-hidden">
                            @if ($allTimeCompletedPerRound['data']->count() > 1)
                                <div class="relative w-full xl:w-48">
                                    <x-catalyst.users.chart-per-fund :labels="$allTimeCompletedPerRound['labels']"
                                                                     :data="$allTimeCompletedPerRound['data']"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[11rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium rounded-l-sm text-dark-blue-500 focus:outline-none">
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
                        class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div
                            class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start text-blue-dark-500">
                            <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{ $allTimeFundedPerRound['data']->sum() }}
                            </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                Approved
                            </span>
                            </div>
                        </div>
                        <div class="flex w-full min-w-full overflow-hidden">
                            @if ($allTimeFundedPerRound['data']->count() > 1)
                                <div class="relative w-full xl:w-48">
                                    <x-catalyst.users.chart-per-fund :labels="$allTimeFundedPerRound['labels']"
                                                                     :data="$allTimeFundedPerRound['data']"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[11rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium rounded-l-sm text-blue-dark-500 focus:outline-none">
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
                        class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                        <div class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start">
                            <div class="flex text-xl font-semibold flex-nowrap">
                            <span class="text-xl font-semibold text-blue-dark-500 xl:text-3xl">
                                {{ $allTimeProposedPerRound['data']?->sum() ?? '-' }}
                            </span>
                            </div>
                            <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                Proposed
                            </span>
                            </div>
                        </div>
                        <div class="flex w-full min-w-full overflow-hidden">
                            @if ($allTimeProposedPerRound['data']->count() > 0)
                                <div class="relative w-full xl:w-48">
                                    <x-catalyst.users.chart-per-fund :labels="$allTimeProposedPerRound['labels']"
                                                                     :data="$allTimeProposedPerRound['data']"></x-catalyst.users.chart-per-fund>
                                </div>
                            @else
                                <div class="inline-flex min-w-[11rem]">
                                    <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                        <div
                                            class="relative inline-flex items-center gap-1 text-xl italic font-medium rounded-l-sm text-blue-dark-500 focus:outline-none">
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
                    @if ($allTimeFundingPerRound['data']?->count() > 0)
                        <div
                            class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                            <div class="flex flex-row flex-no-wrap items-center justify-between gap-4 md:justify-start">
                                <div class="flex-col flex-wrap font-semibold leading-2" x-data>
                                    @if ($allTimeFundingPerRound['totalAda'])
                                        <div>
                                        <span class="font-semibold ">
                                            ₳{{ humanNumber($allTimeFundingPerRound['totalAda']->sum() ) }}
                                        </span>
                                        </div>
                                    @endif
                                    @if ($allTimeFundingPerRound['totalUsd'])
                                        <div>
                                        <span class="font-semibold">
                                            ${{ humanNumber($allTimeFundingPerRound['totalUsd']->sum()) }}
                                        </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex gap-1 text-sm font-normal flex-nowrap leading-2">
                                <span>
                                    Requested
                                </span>
                                </div>
                            </div>
                            <div class="w-full min-w-full overflow-hidden">
                                @if ($allTimeFundingPerRound['data']?->sum() > 0)
                                    <div class="relative w-full xl:w-48">
                                        <x-catalyst.users.chart-per-fund :dataType="$allTimeFundingPerRound['currency']"
                                                                         :labels="$allTimeFundingPerRound['labels']"
                                                                         :data="$allTimeFundingPerRound['data']"></x-catalyst.users.chart-per-fund>
                                    </div>
                                @else
                                    <div class="inline-flex min-w-[10rem]">
                                        <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                            <div
                                                class="relative inline-flex items-center gap-1 text-xl italic font-medium rounded-l-sm text-blue-dark-500 focus:outline-none">
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
                            class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start text-blue-dark-500">
                                <div class="flex-col flex-wrap font-semibold leading-2" x-data>
                                    @if ($allTimeAwardedPerRound['totalAda'])
                                        <div>
                                        <span class="font-semibold ">
                                            ₳{{ humanNumber($allTimeAwardedPerRound['totalAda']->sum()) }}
                                        </span>
                                        </div>
                                    @endif
                                    @if ($allTimeAwardedPerRound['totalUsd'])
                                        <div>
                                        <span class="font-semibold">
                                            ${{ humanNumber($allTimeAwardedPerRound['totalUsd']->sum()) }}
                                        </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex gap-1 text-sm font-normal flex-nowrap leading-2">
                                <span>
                                    Awarded
                                </span>
                                </div>
                            </div>
                            <div class="w-full min-w-full overflow-hidden">
                                @if ($allTimeAwardedPerRound['data']?->sum() > 0)
                                    <div class="relative w-full xl:w-48">
                                        <x-catalyst.users.chart-per-fund :dataType="$allTimeAwardedPerRound['currency']"
                                                                         :labels="$allTimeAwardedPerRound['labels']"
                                                                         :data="$allTimeAwardedPerRound['data']"></x-catalyst.users.chart-per-fund>
                                    </div>
                                @else
                                    <div class="inline-flex min-w-[10rem]">
                                        <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                            <div
                                                class="relative inline-flex items-center gap-1 text-xl italic font-medium rounded-l-sm text-blue-dark-500 focus:outline-none">
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
                            class="border border-teal-600 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 min-w-15 md:min-w-[13rem] xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 md:justify-start text-blue-dark-500">
                                <div class="flex-col flex-wrap font-semibold leading-2" x-data>
                                    @if ($allTimeReceivedPerRound['totalAda'])
                                        <div>
                                        <span class="font-semibold ">
                                            ₳{{ humanNumber($allTimeReceivedPerRound['totalAda']->sum()) }}
                                        </span>
                                        </div>
                                    @endif
                                    @if ($allTimeReceivedPerRound['totalUsd'])
                                        <div>
                                        <span class="font-semibold">
                                            ${{ humanNumber($allTimeReceivedPerRound['totalUsd']->sum()) }}
                                        </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex gap-1 text-sm font-normal flex-nowrap leading-2">
                                <span>
                                    Received
                                </span>
                                </div>
                            </div>
                            <div class="w-full min-w-full overflow-hidden">
                                @if ($allTimeReceivedPerRound['data']?->count() > 1)
                                    <div class="relative w-full xl:w-48">
                                        <x-catalyst.users.chart-per-fund
                                            :dataType="$allTimeReceivedPerRound['currency']"
                                            :labels="$allTimeReceivedPerRound['labels']"
                                            :data="$allTimeReceivedPerRound['data']"></x-catalyst.users.chart-per-fund>
                                    </div>
                                @else
                                    <div class="inline-flex min-w-[10rem]">
                                        <div class="relative z-0 inline-flex rounded-md shadow-sm">
                                            <div
                                                class="relative inline-flex items-center gap-1 text-xl italic font-medium rounded-l-sm text-blue-dark-500 focus:outline-none">
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
                    @endif
                </div>
            </div>
        </div>
        @if ($catalystUser->proposals?->first()?->funding_updated_at)
            <div class="flex flex-row justify-end mt-4 text-xs italic font-bold text-yellow-400">
                <p>
                    Funding data last updated
                    <x-carbon :date="$catalystUser->proposals->first()->funding_updated_at" human/>
                </p>
            </div>
        @endif
    </div>
</div>
