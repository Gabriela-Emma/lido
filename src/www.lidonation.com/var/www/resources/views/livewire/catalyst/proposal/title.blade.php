<?php $row = (array)$row; ?>
<div class="w-full flex flex-col md:flex-row md:items-center md:justify-between p-6 gap-6">
    <div class="flex-1 md:DEPRECATEDmax-w-[80%]">
        <div class="flex items-top lg:items-center gap-x-3">
            <h2 class="font-medium">
                <a class="text-gray-900 md:leading-3 text-md md:text-sm" href="{{url('proposals/' . $row['slug'])}}">
                    <span>
                        {{$value}}
                    </span>
                </a>
            </h2>
            <div>
                <span
                    class="flex-shrink-0 inline-block px-2 py-0.5 text-gray-700 text-xs font-semibold bg-accent-500 rounded-sm">
                    ${{ number_format($row['amount_requested'], 2, '.', ',') }}
                </span>
            </div>
        </div>
        <div class="text-sm 2xl:DEPRECATEDh[80px]">
            <div class="font-normal">
                <x-markdown>{{$row['problem']}}</x-markdown>
            </div>
            <div class="my-4 flex flex-col gap-3">
                <div class="">
                    <span class="font-bold">Fund: </span>
                    <span>{{ $row['fund.title'] }}</span>
                </div>
                @if($row['team.name'])
                    <div class="">
                        <span class="font-bold">Team: </span>
                        <span>{{ $row['team.name'] }}</span>
                    </div>
                @endif

                @if($row['fund.amount'] && $row['amount_requested'])
                    <div class="italic space-x-1">
                        @if(!!$row['funded_at'])
                            <span class="bg-teal-600 rounded-sm px-2 py-1 inline-block text-white font-semibold">funded</span>
                        @endif
                        <span>{{$row['funded_at'] ? 'Awarded' : 'Requested'}} {{round((float)($row['amount_requested'] / $row['fund.amount']) * 100, 3 ) . '%'}} of the
                            fund.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div>
        {{--        @if($row['team.logo'])--}}
        {{--            <img class="h-20 w-20 rounded-full lg:w-28 lg:h-28"--}}
        {{--                 src="{{ $row['team.logo'] }}"--}}
        {{--                 alt="{{ $row['team.name'] }}'s logo">--}}
        {{--        @else--}}
        {{--            <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0"--}}
        {{--                 src="https://www.gravatar.com/avatar/{{md5($row['slug'])}}?d=retro&r=r"--}}
        {{--                 alt=""/>--}}
        {{--        @endif--}}
    </div>
</div>

<div class="mt-auto">
    <div class="-mt-px flex divide-x {{!!$row['funded_at'] ? 'divide-primary-200' : 'divide-gray-300'}}">
        <div class="w-0 flex-1 flex justify-start items-center">
            @if($row['ideascale_link'])
                <a href="{{$row['ideascale_link']}}" target="_blank"
                   x-data="{ tooltip: 'View proposal on cardano.ideascale.com' }"
                   class="p-3 hover:cursor-pointer">
                    <img x-tooltip.theme.primary="tooltip" class="rounded-sm w-7 h-7"
                         src="{{asset('img/ideascale-logo.png')}}"
                         alt="Ideascale logo">
                </a>
            @endif

            @if($row['website'])
                <a href="{{$row['website']}}" target="_blank"
                   x-data="{ tooltip: 'Open proposal website in a new tab.' }"
                   class="p-3 hover:cursor-pointer">
                    <svg x-tooltip.theme.primary="tooltip" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
            @endif
        </div>


        @if($row['id'])
            <div class="-ml-px w-0 flex-1 flex">
                <div
                    class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-sm hover:text-gray-500">
                    <div x-data="{ tooltip: 'Proposal Assessor Reviews' }">
                        <div x-tooltip.theme.primary="tooltip">
                            <livewire:ratings.model-average-rating-component
                                :modelId="$row['id']"
                                wire:key="{{$row['id']}}"
                                :modelType="\App\Models\Proposal::class"/>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

