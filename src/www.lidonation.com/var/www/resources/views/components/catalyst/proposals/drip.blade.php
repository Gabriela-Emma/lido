@props([
    'proposal',
    'view' => 'detail'
])
<div
    x-data="proposalDrip" data-view="{{$view}}" data-proposal='@json($proposal->toJs())' x-ref="proposalDrip"
    class="flex flex-col border bg-white rounded-sm w-full h-full divide-y relative proposal-drip overflow-clip
        {{ !!$proposal->funded_at ? 'border-teal-600' : '' }}
        {{ $proposal->status == 'complete' ? 'border-pink-400' : 'not-completed' }}
        {{ !!$proposal->funded_at ? 'divide-teal-300' : 'divide-gray-300'}}
        {{ $proposal->status == 'complete' ? 'divide-pink-400' : ''}}">
    @if($proposal->quick_pitch_id)
        <div :class="{'hidden': !pitching}"
             class="absolute w-full h-full z-10 flex flex-col justify-start gap-8 bg-white/[.98]">
            <x-catalyst.proposals.quickpitch :proposal="$proposal" />
        </div>
    @endif

    <div class="flex flex-col w-auto gap-6 p-6 md:flex-row md:items-center md:justify-between z-0">
        <div class="flex-1">
            <!-- Header -->
            <header class="flex flex-col justify-center gap-y-1">
                <h2 class="flex items-start justify-between" x-data="{}">
                    <span>
                        <a class="font-medium text-gray-800 text-md"
                           href="{{$proposal->link}}">
                            {{$proposal->title}}
                        </a>
                        @if($proposal->quick_pitch_id)
                        <span @click="quickPitch()" class="inline-flex items-center px-1 py-0.5 rounded-sm text-xs font-medium bg-primary-40 text-teal-800 ml-1 inline-block hover:cursor-pointer">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                            Quick Pitch
                        </span>
                        @endif
                    </span>
                    <span
                        onclick='Livewire.emit("openModal", "catalyst.proposal-quick-view-component", {{ json_encode(["proposalId" => $proposal->id]) }})'
                        x-tooltip.theme.teal="'Proposal Quick View'"
                        class="font-semibold cursor-pointer text-gray-500 text-md hover:text-teal-600 ml-3 relative top-1 flex flex-row flex-nowrap gap-1 items-center">
                        <span class="text-xs">Quickview</span>

                        <svg xmlns="http://www.w3.org/2000/svg" x-transition
                             class="w-6 h-6 hover:text-teal-600" viewBox="0 0 20 20"
                             fill="currentColor">
                          <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 110-2h4a1 1 0 011 1v4a1 1 0 11-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 112 0v1.586l2.293-2.293a1 1 0 011.414 1.414L6.414 15H8a1 1 0 110 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 110-2h1.586l-2.293-2.293a1 1 0 011.414-1.414L15 13.586V12a1 1 0 011-1z"
                                clip-rule="evenodd"/>
                        </svg>
                    </span>
                </h2>
                <div x-data="{ tooltip: 'Updated {{$proposal->funding_updated_at}}' }"
                     class="flex flex-row flex-nowrap mb-2 text-white">
                    @if($proposal->amount_received > 0.00)
                        <div
                            x-tooltip.theme.accent="tooltip"
                            class="inline-block px-1 py-0.5 pb-2.5 text-xs font-semibold rounded-tl-sm rounded-bl-sm bg-accent-900">
                            {{ $proposal->formatted_amount_received }}
                            <sub class="text-gray-200 block mt-0.5 italic">
                                Received
                            </sub>
                        </div>
                    @endif
                    <div
                        class="inline-block px-1 py-0.5 pb-2.5 text-xs font-semibold rounded-tr-sm rounded-br-2m bg-teal-800">
                        {{ $proposal->formatted_amount_requested }}
                        <sub class="text-gray-200 block mt-0.5 italic">
                            Requested
                        </sub>
                    </div>

                    @if($proposal->fund?->status == 'governance')
                    <div class="inline-block ml-2" x-data="bookmarkButton" x-cloak>
                        <button type="button"
                                onclick='Livewire.emit("openModal", "catalyst.proposal-quick-view-component", {{ json_encode(["proposalId" => $proposal->id]) }})'
                                class="inline-flex items-center gap-2 px-2 py-1 text-sm font-medium leading-3 text-white bg-pink-600 border border-transparent rounded-sm shadow-sm hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Bookmark
                            <svg x-show="!updateBookMarked(@js($proposal->id))" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            <svg x-show="updateBookMarked(@js($proposal->id))" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
            </header>

            <!-- body -->
            <div class="text-sm">
                <div class="max-w-lg font-normal">
                    @if(!empty($proposal->solution))
                        <x-markdown>
                            **Solution:** {{$proposal->solution}}
                        </x-markdown>
                    @else
                        <x-markdown>
                            {{$proposal->problem}}
                        </x-markdown>
                    @endif
                </div>
                <div class="flex flex-col gap-3 my-4">
                    <div class="flex flex-row gap-3">
                        @if($proposal->fund?->parent)
                        <span>
                            <span class="font-bold">Fund: </span>
                            <span>{{ $proposal->fund?->parent?->label}}</span>
                        </span>
                        @endif

                        <span>
                            <span class="font-bold">Challenge: </span>
                            <span>{{ $proposal->fund->label}}</span>
                        </span>
                    </div>

                    @if($proposal->fund->amount && $proposal->amount_requested)
                        <x-catalyst.proposals.status :proposal="$proposal" />
                    @endif

                    <div class="relative z-0 flex flex-row-reverse mt-3 -space-x-1 overflowhidden">
                        @foreach($proposal->users->reverse() as $catalystUser)
                            <div class="mr-auto" wire:key="{{$proposal->id}}-{{$catalystUser->id}}" x-data="{ tooltip: '{{$catalystUser->name}}'}">
                                <a class="block" href="{{$catalystUser->link}}">
                                    @if($loop->first)
                                        <img
                                            class="h-10 w-10 relative -left-2 z-{{$loop->index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                            x-tooltip.theme.teal="tooltip"
                                            src="{{$catalystUser->thumbnail_url ?? $catalystUser->gravatar}}"
                                            alt="{{$catalystUser->name}} gravatar"/>
                                    @else
                                        <img
                                            class="h-10 w-10 relative z-{{$loop->index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                            x-tooltip.theme.teal="tooltip"
                                            src="{{$catalystUser->thumbnail_url ?? $catalystUser->gravatar}}"
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
            class="-mt-px flex divide-x {{!!$proposal->funded_at ? 'divide-teal-300' : 'divide-gray-300'}} {{ $proposal->status == 'complete' ? 'divide-pink-400' : ''}}">
            <div class="flex items-center justify-start flex-1 w-0 gap-2 p-3">
                @if($proposal->ideascale_link)
                    <a href="{{$proposal['ideascale_link']}}" target="_blank"
                       x-data="{ tooltip: 'View proposal on cardano.ideascale.com' }"
                       class="hover:cursor-pointer">
                        <img x-tooltip.theme.teal="tooltip" class="rounded-sm w-7 h-7"
                             src="{{asset('img/ideascale-logo.png')}}"
                             alt="Ideascale logo">
                    </a>
                @endif

                @if($proposal->website)
                    <a href="{{$proposal->website}}" target="_blank"
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

            @if($proposal->id)
                <div class="flex flex-1 w-0 -ml-px">
                    <div
                        class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div x-data="{ tooltip: 'Proposal Assessor Reviews' }">
                            <div x-tooltip.theme.teal="tooltip">
                                <livewire:ratings.model-average-rating-component
                                    :modelId="$proposal->id"
                                    wire:key="{{$proposal->id}}"
                                    theme="{{$proposal->status == 'complete' ? 'pink': 'accent'}}"
                                    :modelType="\App\Models\Proposal::class"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </footer>
</div>
