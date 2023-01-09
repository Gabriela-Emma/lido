<x-modal formAction="saveIdea">
    <x-slot name="content">
        <div>
            <div class="flex flex-col gap-0 p-0.5">
                <section
                    class="py-3 rounded-sm rounded-tl-lg rounded-tr-lg bg-gradient-to-br from-primary-800 via-primary-600 to-accent-900">
                    <div class="px-4 text-white divide-y divide-primary-200">
                        <div class="relative items-start justify-start gap-1 p-2 md:flex md:flex-row items-centers">
                            <div
                                class="inline-flex font-medium text-gray-300 md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                {{$proposal->type}}:
                            </div>
                            <div class="text-lg font-bold md:text-2xl">
                                {{$proposal->title}}
                            </div>
                            <div onclick='Livewire.emit("closeModal", "catalyst.proposal-quick-view-component")'
                                 class="absolute top-0 right-0 p-0 ml-auto hover:cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6 md:h-8 md:w-8 hover:text-yellow-400" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        </div>
                        <div class="items-start justify-start gap-1 p-2 md:flex md:flex-row">
                            <div
                                class="inline-flex font-medium text-gray-300 min-w-full md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                Proposed Budget
                            </div>
                            <div class="text-2xl font-bold text-accent-400">
                                ${{ number_format($proposal->amount_requested, 0, '.', ',') }}
                            </div>
                        </div>
                        <div class="items-start justify-start gap-1 p-2 md:flex md:flex-row">
                            <div
                                class="inline-flex font-medium text-gray-300 min-w-full md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                Challenge question
                            </div>
                            <div>
                                {{$proposal->problem}}
                            </div>
                        </div>

                        <div class="items-start justify-start gap-1 p-2 md:flex md:flex-row">
                            <div
                                class="inline-flex font-medium text-gray-300 min-w-full md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                Why is it important?
                            </div>
                            <div>
                                {{$proposal->solution}}
                            </div>
                        </div>
                        <div class="items-start justify-start gap-1 p-2 md:flex md:flex-row">
                            <div
                                class="inline-flex font-medium text-gray-300 min-w-full md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                What does success look like?
                            </div>
                            <div>
                                {{$proposal->experience}}
                            </div>
                        </div>
                        <div class="items-start justify-start gap-1 p-2 md:flex md:flex-row">
                            <div
                                class="inline-flex font-medium text-gray-300 min-w-full md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                <span class="inline-block whitespace-normal">CA Reviews</span>
                            </div>
                            <a class="text-2xl font-normal text-white hover:primary-200" href="#discussions">
                                <livewire:ratings.model-average-rating-component
                                    :modelId="$proposal->id"
                                    wire:key="{{$proposal->id}}"
                                    :size="8"
                                    :modelType="\App\Models\Proposal::class"/>
                            </a>
                        </div>
                        <div class="items-start justify-start gap-1 p-2 md:flex md:flex-row">
                            <div
                                class="inline-flex font-medium text-gray-300 min-w-full md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                Team
                            </div>
                            <div>
                                @if($proposal->users)
                                    @if($proposal->users->isNotEmpty())
                                        <ul class="flex flex-wrap gap-4 mx-auto overflow-x-auto flex-nowrap">
                                            @foreach($proposal->users as $caUser)
                                                <li wire:key="{{$caUser->id}}">
                                                    <div class="flex flex-col items-center gap-4">
                                                        <a class="block" href="{{$caUser->link}}">
                                                            <img
                                                                class="flex w-12 h-12 mx-auto rounded-full lg:w-20 lg:h-20"
                                                                src="{{$caUser->bio_pic?->getUrl('thumbnail') ?? $caUser->gravatar}}"
                                                                alt="{{$caUser->name}} bio pic">
                                                        </a>
                                                        <div class="space-y-2">
                                                            <div class="text-xs font-medium text-center">
                                                                <h3 class="">
                                                                    <a class="block font-bold text-white"
                                                                       target="_blank"
                                                                       href="{{$caUser->link}}">
                                                                        {{$caUser->name}}
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="items-start justify-start gap-1 p-2 md:flex md:flex-row">
                            <div
                                class="inline-flex font-medium text-gray-300 min-w-full md:min-w-[8rem] xl:min-w-[13rem] capitalize">
                                Challenge
                            </div>
                            <div>
                                <span class="text-xl font-bold">{{$proposal->fund?->title}}</span>
                                <p class="text-base">{{$proposal->fund?->excerpt}}</p>
                                <div class="flex flex-row mt-2 text-base">
                                    <div class="p-2 border">
                                        <div class="text-gray-100">
                                            Challenge Budget
                                        </div>
                                        <div class="text-xl font-semibold">
                                            ${{ humanNumber($proposal->fund?->amount) }}
                                        </div>
                                    </div>
                                    <div class="p-2 -ml-px border">
                                        <div class="text-gray-100">
                                            Proposals in Challenge
                                        </div>
                                        <div class="text-xl font-semibold">
                                            {{$proposal->fund?->proposals_count}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                @isset($proposal->content)
                <section class="p-4 overflow-auto bg-gray-100">
                    <div x-data="{ active: null }" class="space-y-4">
                        <div x-data="{
                                id: 1,
                                get expanded() {
                                    return this.active === this.id
                                },
                                set expanded(value) {
                                    this.active = value ? this.id : null
                                },
                            }" role="region" class="">
                            <div>
                                <div
                                    x-on:click="expanded = !expanded"
                                    :aria-expanded="expanded"
                                    class="flex items-center justify-between w-full py-3 font-bold hover:cursor-pointer"
                                >
                                    <h2 class="mb-2 text-2xl xl:text-4xl decorate dark">
                                        Challenge Brief
                                        @if($proposal->ideascale_link)
                                            <a href="{{$proposal['ideascale_link']}}" target="_blank"
                                               x-data="{ tooltip: 'View proposal on cardano.ideascale.com' }"
                                               class="hover:cursor-pointer text-xs p-0.5 inline-flex flex-row items-center gap-2 ml-2">
                                                <span>view on ideascale</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        @endif
                                    </h2>
                                    <span x-show="expanded" aria-hidden="true" class="ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </span>
                                    <span x-show="!expanded" aria-hidden="true" class="ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div x-show="expanded" x-collapse>
                                <div>
                                    <x-markdown>{{$proposal->content}}</x-markdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endisset

                <section class="relative p-4" id="discussions">
                    @if($proposal->discussions->isNotEmpty())
                        <div x-data="{ active: null }" class="space-y-4">
                            <div x-data="{
                                id: 1,
                                get expanded() {
                                    return this.active === this.id
                                },
                                set expanded(value) {
                                    this.active = value ? this.id : null
                                },
                            }" role="region" class="">
                                <div>
                                    <div
                                        x-on:click="expanded = !expanded"
                                        :aria-expanded="expanded"
                                        class="flex items-center justify-between w-full py-3 font-bold hover:cursor-pointer">
                                        <h2 class="text-2xl xl:text-4xl decorate dark">
                                            {{ $snippets->communityAdvisorReviews }}
                                        </h2>
                                        <span x-show="expanded" aria-hidden="true" class="ml-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        <span x-show="!expanded" aria-hidden="true" class="ml-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <div x-show="expanded" x-collapse class="relative">
                                    <div class="relative">
                                        <x-public.discussions :model="$proposal" :editable="false" :expanded="true"></x-public.discussions>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>

                <section class="px-4 pb-4 mt-4">
                    <div x-data="{}"
                         class="p-3 text-white rounded-sm bg-gradient-to-tl from-primary-800 via-primary-600 to-accent-900">
                        <h2 class="mb-2 font-semibold">
                            <span class="inline-block"
                                  x-tooltip.theme.primary="'Primary Author @js($catalystUser->name) All Time Report Card'">
                                <span class="text-accent-500">{{$catalystUser->name}}</span> Report Card
                            </span>
                        </h2>
                        <div class="p-6 mt-6 bg-opacity-25 rounded-sm bg-gray-50">
                            <x-catalyst.users.profile-metrics
                                :catalystUser="$catalystUser"
                                :allTimeCaAverage="$allTimeCaAverage"
                                :allTimeCaRatingCount="$allTimeCaRatingCount"
                                :allTimeCaAverageGroups="$allTimeCaAverageGroups"

                                :allTimeFundingPerRound="$this->getChartData('allTimeFundingPerRound')"
                                :allTimeFundedPerRound="$this->getChartData('allTimeFundedPerRound')"
                                :allTimeAwardedPerRound="$this->getChartData('allTimeAwardedPerRound')"
                                :allTimeReceivedPerRound="$this->getChartData('allTimeReceivedPerRound')"
                                :allTimeProposedPerRound="$this->getChartData('allTimeProposedPerRound')"
                                :allTimeCompletedPerRound="$this->getChartData('allTimeCompletedPerRound')"></x-catalyst.users.profile-metrics>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="flex flex-row justify-center gap-3 py-6 bg-gray-200" x-data="voterTool">
                    <button type="button"
                        @click="up( {
                            id: {{$proposal->id}},
                            title: @js($proposal->title),
                            type: @js($proposal->type),
                            amount: {{$proposal->amount_requested}},
                            ideascale_link: '{{$proposal->ideascale_link}}',
                            link: '{{$proposal->link}}',
                            fundId: {{$proposal->fund->id}},
                            fundTitle: @js($proposal->fund->label),
                            fundAmount: {{$proposal->fund?->amount}},
                            proposalsCount: {{$proposal->fund?->proposals_count}},
                            fundHero: '{{$proposal->fund?->thumbnail_url}}'
                        } )"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm md:text-base 2xl:text-xl font-medium text-gray-700 bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                        <span x-show="!has({{$proposal->id}}, 'upvote')">Add to My Upvotes</span>
                        <span x-show="has({{$proposal->id}}, 'upvote')">Remove From My Upvotes</span>
                        <svg x-show="has({{$proposal->id}}, 'upvote')" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-accent-700" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                        </svg>
                        <svg x-show="!has({{$proposal->id}}, 'upvote')" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                    </button>
                    <button type="button"
                        @click="down( {
                            id: {{$proposal->id}},
                            title: @js($proposal->title),
                            type: @js($proposal->type),
                            amount: {{$proposal->amount_requested}},
                            ideascale_link: '{{$proposal->ideascale_link}}',
                            link: '{{$proposal->link}}',
                            fundId: {{$proposal->fund->id}},
                            fundTitle: @js($proposal->fund->label),
                            fundAmount: {{$proposal->fund?->amount}},
                            proposalsCount: {{$proposal->fund?->proposals_count}},
                            fundHero: '{{$proposal->fund?->thumbnail_url}}'
                        })"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm md:text-base 2xl:text-xl font-medium text-gray-700 bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        <span x-show="!has({{$proposal->id}}, 'downvote')">Add to My Downvotes</span>
                        <span x-show="has({{$proposal->id}}, 'downvote')">Remove From My Downvotes</span>

                        <svg x-show="has({{$proposal->id}}, 'downvote')" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-700" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z" />
                        </svg>
                        <svg x-show="!has({{$proposal->id}}, 'downvote')" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-row justify-center w-full py-2">
                    <div onclick='Livewire.emit("closeModal", "catalyst.proposal-quick-view-component")'
                         class="flex flex-row justify-center hover:cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 hover:text-yellow-400" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </footer>
        </div>
    </x-slot>
</x-modal>
