@props([
    'proposal',
    'embedded' => false
])
<div class="flex flex-col col-span-1 text-white">
    <div class="flex items-center justify-between w-full p-4 space-x-4">
        <div class="w-full">
            @if($proposal->amount_requested &&  $proposal->fund->amount)
                <div class="flex w-full">
                    <x-catalyst.proposals.status :showPercentage="false" :proposal="$proposal" />
                </div>
            @endif

            <div class="flex flex-row flex-no-wrap justify-between w-full gap-4">
                <h2 class="font-semibold max-w-[80%] inline-flex flex-wrap">
                    @if(!$embedded)
                        <a class="inline-flex hover:text-black"
                           href="{{url('proposals/' . $proposal->slug)}}">
                            <span class="text-white">
                                {{$proposal->title}}
                            </span>
                        </a>
                    @else
                        <span class="inline-flex text-white">
                            {{$proposal->title}}
                        </span>
                    @endif
                </h2>
                <div class="flex justify-end flex-grow">
                    @if($proposal?->team?->logo)
                        <img class="w-16 h-16 rounded-full"
                             srcset="{{$proposal->team->logo?->getSrcset('thumbnail')}}"
                             alt="{{$proposal->team->name}}'s logo">
                    @else
                        <img class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full"
                             src="https://www.gravatar.com/avatar/{{md5($proposal->slug)}}?d=retro&r=r"
                             alt=""/>
                    @endif
                </div>
            </div>

            <div class="2xl:h[80px]">
                <div class="flex flex-row flex-no-wrap mb-2">
                    @if($proposal->amount_received > 0.00)
                        <div
                            class="inline-block px-2 py-0.5 pb-3 text-sm font-semibold rounded-tl-sm rounded-bl-sm bg-pink-600">
                            {{$proposal->currency_symbol}}{{ number_format($proposal->amount_received, 2, '.', ',') }}
                            <sub class="text-gray-200 block mt-0.5 italic">
                                Received
                            </sub>
                        </div>
                    @endif
                    <div
                        class="inline-block px-2 py-0.5 pb-3 text-sm font-semibold rounded-tr-sm rounded-br-2m bg-accent-700">
                        {{$proposal->currency_symbol}}{{ number_format($proposal->amount_requested, 2, '.', ',') }}
                        <sub class="text-gray-200 block mt-0.5 italic">
                            Requested
                        </sub>
                    </div>
                    @if($embedded)
                        @if($proposal->ideascale_link)
                            <a href="{{$proposal['ideascale_link']}}" target="_blank"
                               x-data="{ tooltip: 'View proposal on cardano.ideascale.com' }"
                               class="inline-flex items-center px-2.5 py-1.5 ml-3 border border-primary-50 text-xs font-medium-xs rounded-xs text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 hover:text-yellow-500">
                                <img x-tooltip.theme.primary="tooltip" class="w-5 h-5 rounded-sm"
                                     src="{{asset('img/ideascale-logo.png')}}"
                                     alt="Ideascale logo">
                                <span class="inline-block mx-2 sm:text-md xl:text-lg">View on ideascale</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endif
                    @endif
                </div>

                @if($proposal->discussions?->isNotEmpty())
                    <div class="w-full p-2 mt-8 mb-4 bg-teal-800/50">
                        <b class="text-sm text-slate-300">
                            Community Review Results ({{$proposal->discussions->first()?->community_reviews?->count()}} reviewers)
                        </b>
                        <div class="flex flex-col gap-2">
                            @foreach($proposal->discussions as $discussion)
                                <div class="flex items-center justify-between gap-2 flex-nowrap">
                                    <div>
                                        {{$discussion->title}}
                                    </div>
                                    <div>
                                        <?php $mataKey = match ($discussion->title) {
                                             'Impact Alignment' => 'aligment_score',
                                             'Feasibility' => 'feasibility_score',
                                             'Value for money' => 'auditability_score',
                                             default => null
                                        } ?>
                                        <x-public.stars theme='text-white' :size="5"
                                        :amount="floor($proposal?->meta_data?->{$mataKey} ?? $discussion->rating)" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($proposal->solution)
                    <div
                        class="my-3 text-white bg-teal-700rounded-sm">
                        <b class="text-sm text-slate-300">
                            {{ $snippets->solution}}
                        </b>
                        <x-markdown>{{$proposal->solution}}</x-markdown>
                    </div>
                @endif

                <div>
                    <b class="text-sm text-slate-300">Problem:</b>
                    <x-markdown>{{$proposal->problem}}</x-markdown>
                </div>



                {{-- <div class="flex flex-col gap-2 my-4 text-sm">
                    <div>
                        <span class="font-bold text-gray-300">
                            {{$snippets->challenge }}: </span>
                        <span>{{ $proposal->fund->label }}</span>
                    </div>

                </div> --}}
            </div>
        </div>
    </div>

    <div class="px-4 divide-y divide-primary-200">
        {{-- <div class="flex flex-row items-center justify-start gap-1 py-1 border-t border-primary-200">
            <div class="text-sm font-medium text-gray-300">
                {{$snippets->communityAdvisorReviews}}:
            </div>
            <a class="font-normal text-white hover:text-white" href="#discussions">
                <livewire:ratings.model-average-rating-component
                    :modelId="$proposal->id"
                    wire:key="{{$proposal->id}}"
                    :modelType="\App\Models\Proposal::class"/>
            </a>
        </div> --}}
        @if($proposal->yes_votes_count_formatted)
        <div
            class="grid items-center justify-start grid-cols-2 py-2 space-x-2 text-sm">
            <div class="flex flex-row gap-2">
                <div class="font-medium text-gray-300">
                    Yes Votes:
                </div>
                <div>
                    {{$proposal->yes_votes_count_formatted}}
                </div>
            </div>
            <div class="flex flex-row gap-2">
                <div class="font-medium text-gray-300">
                    No Votes:
                </div>
                <div>
                    {{$proposal->no_votes_count_formatted}}
                </div>
            </div>
        </div>
        @endif
        @if($proposal->meta_data?->unique_wallets)
            <div
                class="flex flex-row items-center justify-start py-2 text-sm">
                <div class="flex flex-row gap-2">
                    <div class="font-medium text-gray-300">
                        Unique Wallets:
                    </div>
                    <div>
                        {{$proposal->meta_data?->unique_wallets}}
                    </div>
                </div>
            </div>
        @endif
        <hr class="my-0 border-primary-200"/>
    </div>
</div>
