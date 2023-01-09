@props([
    'challenge',
    'view' => 'detail'
])
<div
    x-data="proposalDrip" data-view="{{$view}}" data-proposal='@json($challenge->toJs())' x-ref="proposalDrip"
    class="flex flex-col border bg-gray-100 relative rounded-sm divide-y w-full h-full proposal-drip overflow-clip
        {{ !!$challenge->funded_at ? 'border-teal-600' : '' }}
        {{ $challenge->funding_status == 'completed' ? 'border-pink-400' : 'not-completed' }}
        {{ !!$challenge->funded_at ? 'divide-teal-300' : 'divide-gray-300'}}">
    @if($challenge->quick_pitch_id)
        <div :class="{'hidden': !pitching}"
             class="absolute w-full h-full z-10 flex flex-col justify-start gap-8 bg-white/[.98]">
            <x-catalyst.proposals.quickpitch :proposal="$challenge" />
        </div>
    @endif
    <div class="flex flex-col w-full gap-6 p-6 md:flex-row md:items-center md:justify-between z-0">
        <div class="flex-1">
            <!-- Header -->
            <header class="flex flex-col gap-y-1 justify-center">
                <h2 class="flex items-start justify-between">
                    <span>
                        <a class="text-gray-800 font-medium text-md"
                           href="{{$challenge->link}}">
                            Challenge: {{$challenge->title}}
                        </a>
                        @if($challenge->quick_pitch_id)
                            <span @click="quickPitch()" class="inline-flex items-center px-1 py-0.5 rounded-sm text-xs font-medium bg-primary-40 text-teal-800 ml-1 inline-block hover:cursor-pointer">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                </svg>
                                Quick Pitch
                            </span>
                        @endif
                    </span>
                    <span
                        onclick='Livewire.emit("openModal", "catalyst.challenge-quick-view-component", {{ json_encode(["proposalId" => $challenge->id]) }})'
                        x-tooltip.theme.teal="'Challenge Quick View'"
                        class="font-semibold cursor-pointer text-md hover:text-teal-600 ml-3 relative top-1">
                        <svg xmlns="http://www.w3.org/2000/svg" x-transition
                             class="w-6 h-6 hover:text-teal-600" viewBox="0 0 20 20"
                             fill="currentColor">
                          <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 110-2h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 112 0v1.586l2.293-2.293a1 1 0 011.414 1.414L6.414 15H8a1 1 0 110 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 110-2h1.586l-2.293-2.293a1 1 0 011.414-1.414L15 13.586V12a1 1 0 011-1z"
                                clip-rule="evenodd"/>
                        </svg>
                    </span>
                </h2>
                <div class="flex flex-row items-start flex-nowrap text-white mb-2">
                    <div
                        class="inline-block px-1 py-0.5 pb-2.5 text-xs font-semibold rounded-tr-sm rounded-br-2m bg-teal-800">
                        {{$challenge->formatted_amount_requested}}
                        <sub class="text-gray-200 block mt-0.5 italic">
                            Budget
                        </sub>
                    </div>
                    @if($challenge->fund?->status == 'governance')
                        <div class="inline-block ml-2" x-data="bookmarkButton" x-cloak>
                            <button type="button"
                                    onclick='Livewire.emit("openModal", "catalyst.proposal-quick-view-component", {{ json_encode(["proposalId" => $challenge->id]) }})'
                                    class="inline-flex gap-2 items-center px-2 py-1 border border-transparent shadow-sm text-sm leading-3 font-medium rounded-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                Bookmark
                                <svg x-show="!updateBookMarked(@js($challenge->id))" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                <svg x-show="updateBookMarked(@js($challenge->id))" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </header>

            <!-- body -->
            <div class="text-sm">
                <div class="font-normal max-w-lg"><x-markdown>{{$challenge->problem}}</x-markdown></div>
                <div class="flex flex-col gap-3 my-4">
                    <div class="">
                        <span class="font-bold">Proposed in Fund: </span>
                        <span>{{ $challenge->fund?->parent?->title}}</span>
                    </div>
                    @if($challenge->fund->amount && $challenge->amount_requested)
                        <div class="space-x-1 italic">
                            @if(!!$challenge->funded_at)
                                <span
                                    class="inline-block px-1.5 py-0.5 font-semibold text-white text-sm rounded-sm bg-teal-light-500">Approved</span>
                            @elseif($challenge->funding_status == 'pending')
                                <span
                                    class="inline-block px-1.5 py-0.5 font-semibold text-white text-sm rounded-sm bg-gray-500">vote pending</span>
                            @else
                                <span
                                    class="inline-block px-1.5 py-0.5 font-semibold text-white text-sm rounded-sm bg-gray-300">
                                    {{Str::replace('_', ' ', $challenge->fund_status)}}
                                </span>
                            @endif
                            <span>{{$challenge->funded_at ? 'Approved' : 'Budget'}} {{round((float)($challenge->amount_requested / $challenge->fund->amount) * 100, 3 ) . '%'}} of the
                                                    fund.</span>
                        </div>
                    @endif

                    <div class="flex flex-row-reverse -space-x-1 relative z-0 overflowhidden mt-3">
                        @foreach($challenge->users->reverse() as $catalystUser)
                            <div class="mr-auto" wire:key="{{$catalystUser->id}}"
                                 x-data="{ tooltip: '{{$catalystUser->name}}' }">
                                <a class="block" href="{{$catalystUser->link}}">
                                    @if($loop->first)
                                        <img
                                            class="h-10 w-10 relative -left-2 z-{{$loop->index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                            x-tooltip.theme.teal="tooltip"
                                            src="{{$catalystUser->gravatar}}"
                                            alt="{{$catalystUser->name}} gravatar"/>
                                    @else
                                        <img
                                            class="h-10 w-10 relative z-{{$loop->index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                            x-tooltip.theme.teal="tooltip"
                                            src="{{$catalystUser->gravatar}}"
                                            alt="{{$catalystUser->name}} gravatar"/>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="mt-auto">
        <div
            class="-mt-px flex divide-x {{!!$challenge->funded_at ? 'divide-teal-300' : 'divide-gray-300'}} {{ $challenge->funding_status == 'completed' ? 'divide-pink-400' : ''}}">
            <div class="flex items-center justify-start flex-1 w-0 gap-2 p-3">
                @if($challenge->ideascale_link)
                    <a href="{{$challenge['ideascale_link']}}" target="_blank"
                       x-data="{ tooltip: 'View challenge on cardano.ideascale.com' }"
                       class="hover:cursor-pointer">
                        <img x-tooltip.theme.teal="tooltip" class="rounded-sm w-7 h-7"
                             src="{{asset('img/ideascale-logo.png')}}"
                             alt="Ideascale logo">
                    </a>
                @endif

                @if($challenge->website)
                    <a href="{{$challenge->website}}" target="_blank"
                       x-data="{ tooltip: 'Open proposal website in a new tab.' }"
                       class="hover:cursor-pointer">
                        <svg x-tooltip.theme.teal="tooltip"
                             xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </a>
                @endif
            </div>

            @if($challenge->id)
                <div class="flex flex-1 w-0 -ml-px">
                    <div
                        class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div x-data="{ tooltip: 'Proposal Assessor Reviews' }">
                            <div x-tooltip.theme.teal="tooltip">
                                <livewire:ratings.model-average-rating-component
                                    :modelId="$challenge->id"
                                    wire:key="{{$challenge->id}}"
                                    theme="{{$challenge->funding_status == 'completed' ? 'pink': 'accent'}}"
                                    :modelType="\App\Models\Proposal::class"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </footer>
</div>
