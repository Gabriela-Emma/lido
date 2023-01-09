<div class="relative z-10 catalyst-proposals-research-wrapper">
    @livewire('catalyst.catalyst-sub-menu-component')
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-20 flex flex-col block gap-3 sm:flex-row">
                <span class='z-20 font-light'>{{__('Cardano') }}</span>
                <span class='z-20 font-black text-teal-600'>{{__('Projects') }}</span>
            </span>
        </x-slot>
        <h2 class="font-medium">
            {{ $snippets->prePayingForFutureInnovations}}
        </h2>

        @if($snippets)
            <x-markdown>{{$snippets[0]?->content}}</x-markdown>
        @endif
    </x-public.page-header>

{{--    <section class="relative">--}}
{{--        <div class="container">--}}
{{--            <nav class="flex space-x-1" aria-label="Tabs">--}}
{{--                <a href="{{localizeRoute('catalystDashboard')}}"--}}
{{--                   class="px-4 py-2 mb-1 font-medium text-white rounded-sm lg:text-xl bg-teal-600 hover:text-yellow-500">--}}
{{--                    {{ $snippets->dashboard}}--}}
{{--                </a>--}}

{{--                <div--}}
{{--                    class="px-4 py-2 font-medium rounded-t-sm lg:text-xl bg-teal-600 text-accent-500"--}}
{{--                    aria-current="page">--}}
{{--                    {{ $snippets->projects }}--}}
{{--                </div>--}}

{{--                <a href="{{localizeRoute('catalystUsers')}}"--}}
{{--                   class="px-4 py-2 mb-1 font-medium text-white rounded-sm lg:text-xl bg-teal-600 hover:text-yellow-500">--}}
{{--                    {{ $snippets->people }}--}}
{{--                </a>--}}

{{--                <a href="{{localizeRoute('voterTool')}}"--}}
{{--                   class="px-4 py-2 mb-1 font-medium text-white rounded-sm lg:text-xl bg-teal-600 hover:text-yellow-500">--}}
{{--                    Voter Tool--}}
{{--                </a>--}}
{{--            </nav>--}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="relative py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row items-center gap-4">
                <x-catalyst.proposals.stats
                    :challengesCount="$challengesCount"
                    :approvedChallengesCount="$approvedChallengesCount"
                    :totalProposals="$totalProposals"
                    :totalAwardedAmount="$totalAwardedAmount"
                    :fundedProposalsCount="$fundedProposalsCount"
                    :completedProposalsCount="$completedProposalsCount"
                ></x-catalyst.proposals.stats>
            </div>
        </div>
    </section>

    <section class="relative py-6 bg-white">
        <div class="container flex flex-col gap-6 md:grid md:grid-cols-7">
            <!-- filters -->
            <div class="col-span-2 proposal-filters" x-data="{showFilters: false, search: null}">
                <div class="flex flex-col gap-2 md:sticky md:top-6 md:gap-4">
                    <!-- search -->
                    <div class="flex items-center w-full h-16">
                        <div class="flex w-full h-full rounded-sm shadow-sm">
                            <div class="relative flex-grow w-full h-full focus-within:z-10">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor"
                                         fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input wire:model.debounce.600ms="search"
                                       x-bind:search="search"
                                       name="searchProposals"
                                       id="searchProposals"
                                       class="block w-full h-full pl-10 transition duration-150 ease-in-out bg-white border rounded-sm form-input focus:bg-white sm:text-sm sm:leading-5"
                                       placeholder="{{__('Search')}}"/>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <button @click="search = null; @this.set('search', null)"
                                            class="text-gray-300 hover:text-red-600 focus:outline-none">
                                        <x-icons.x-circle class="w-5 h-5 stroke-current"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row justify-end block mb-4 text-sm md:hidden">
                        <span x-show="!showFilters"
                              class="inline-block font-semibold text-teal-600 hover:cursor-pointer"
                              @click="showFilters = !showFilters" x-show="!showFilters">
                            More filters
                        </span>
                        <span x-show="showFilters"
                              class="inline-block font-semibold text-teal-600 hover:cursor-pointer"
                              @click="showFilters = !showFilters" x-show="!showFilters">
                            Hide filters
                        </span>
                    </div>

                    <!-- funded proposal toggle -->
                    <div class="w-full" :class="{'md:block':showFilters, 'hidden md:block':!showFilters}">
                        <div class="flex flex-wrap items-center p-4 border"
                             x-data="{ toggle: @entangle('fundedProposalsFilter') }">
                            <div class="flex w-full min-w-full mb-2 text-xs text-gray-600">
                                {{ $snippets->fundedProposals}}
                            </div>
                            <!-- Enabled: "bg-primary-600", Not Enabled: "bg-gray-200" -->
                            <button type="button"
                                    @click="toggle = !toggle; @this.set('fundedProposalsFilter', toggle)"
                                    :class="[!!toggle ? 'bg-primary-400' : 'bg-gray-200']"
                                    class="relative inline-flex flex-shrink-0 w-20 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer h-9 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                    role="switch" aria-checked="false" aria-labelledby="fundedProposalsFilter">
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span aria-hidden="true"
                                      :class="[!!toggle ? 'translate-x-11 border-primary-400' : 'translate-x-0 border-gray-300']"
                                      class="inline-block w-8 h-8 transition transform bg-white rounded-full shadow pointer-events-none ring-0"></span>
                            </button>
                            <span class="ml-3" id="funded-proposals-label">
                                <input wire:change="setFundedProposalsFilter()" type="hidden" :value="toggle"
                                       wire:model="fundedProposalsFilter" name="fundedProposalsFilter"
                                       id="fundedProposalsFilter">
                                <label for="fundedProposalsFilter" class="text-sm font-medium text-gray-900">
                                    <span>{{ $snippets->showing}}: </span>
                                    @if($this->fundedProposalsFilter)
                                        <span class="font-semibold">
                                            {{ $snippets->fundedProposals}}
                                        </span>
                                    @else
                                        <span>
                                            {{ $snippets->allProposals }}
                                        </span>
                                    @endif
                                </label>
                            </span>
                        </div>
                    </div>

                    <!-- completed proposal toggle -->
                    <div class="w-full" :class="{'md:block':showFilters, 'hidden md:block':!showFilters}">
                        <div class="flex flex-wrap items-center p-4 border"
                             x-data="{ toggle: @entangle('completedProposalsFilter') }">
                            <div class="flex w-full min-w-full mb-2 text-xs text-gray-600">
                                {{ $snippets->completedProjects}}
                            </div>
                            <!-- Enabled: "bg-pink-600", Not Enabled: "bg-gray-200" -->
                            <button type="button"
                                    @click="toggle = !toggle; @this.set('completedProposalsFilter', toggle)"
                                    :class="[!!toggle ? 'bg-pink-400' : 'bg-gray-200']"
                                    class="relative inline-flex flex-shrink-0 w-20 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer h-9 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                    role="switch" aria-checked="false" aria-labelledby="completedProposalsFilter">
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span aria-hidden="true"
                                      :class="[!!toggle ? 'translate-x-11 border-pink-600' : 'translate-x-0 border-gray-300']"
                                      class="inline-block w-8 h-8 transition transform bg-white rounded-full shadow pointer-events-none ring-0"></span>
                            </button>
                            <span class="ml-3" id="funded-proposals-label">
                                <input type="hidden" :value="toggle"
                                       wire:model="completedProposalsFilter"
                                       name="completedProposalsFilter"
                                       id="completedProposalsFilter">
                                <label for="completedProposalsFilter" class="text-sm font-medium text-gray-900">
                                    <span>{{ $snippets->showing}}: </span>
                                    @if($this->completedProposalsFilter)
                                        <span class="font-semibold">
                                            {{ $snippets->completedProjects}}
                                        </span>
                                    @else
                                        <span>
                                            {{ $snippets->allProposals }}
                                        </span>
                                    @endif
                                </label>
                            </span>
                        </div>
                    </div>

                    <!-- Impact proposal toggle -->
                    <div class="w-full" :class="{'md:block':showFilters, 'hidden md:block':!showFilters}">
                        <div class="flex flex-wrap items-center p-4 border"
                             x-data="{ toggle: @entangle('impactProposalsFilter') }">
                            <div class="flex w-full min-w-full mb-2 text-xs text-gray-600">
                                {{ $snippets->impactProjects}}
                            </div>
                            <!-- Enabled: "bg-gray-800", Not Enabled: "bg-gray-200" -->
                            <button type="button"
                                    @click="toggle = !toggle; @this.set('impactProposalsFilter', toggle)"
                                    :class="[!!toggle ? 'bg-accent-500' : 'bg-gray-200']"
                                    class="relative inline-flex flex-shrink-0 w-20 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer h-9 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-600"
                                    role="switch" aria-checked="false" aria-labelledby="impactProposalsFilter">
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span aria-hidden="true"
                                      :class="[!!toggle ? 'translate-x-11 border-accent-600' : 'translate-x-0 border-gray-300']"
                                      class="inline-block w-8 h-8 transition transform bg-white rounded-full shadow pointer-events-none ring-0"></span>
                            </button>
                            <span class="ml-3" id="funded-proposals-label">
                                <input type="hidden" :value="toggle"
                                       wire:model="impactProposalsFilter"
                                       name="impactProposalsFilter"
                                       id="impactProposalsFilter">
                                <label for="impactProposalsFilter" class="text-sm font-medium text-gray-900">
                                    <span>{{ $snippets->showing}}: </span>
                                    @if($this->impactProposalsFilter)
                                        <span class="font-semibold">
                                            {{ $snippets->impactProjects}}
                                        </span>
                                    @else
                                        <span>
                                            {{ $snippets->allProposals }}
                                        </span>
                                    @endif
                                </label>
                            </span>
                        </div>
                    </div>

                    <!-- over budget proposal toggle -->
                    <div class="w-full" :class="{'md:block':showFilters, 'hidden md:block':!showFilters}">
                        <div class="flex flex-wrap items-center p-4 border"
                             x-data="{ toggle: @entangle('overBudgetProposalsFilter') }">
                            <div class="flex w-full min-w-full mb-2 text-xs text-gray-600">
                                {{ $snippets->overBudget }}
                            </div>
                            <button type="button"
                                    @click="toggle = !toggle; @this.set('overBudgetProposalsFilter', toggle)"
                                    :class="[!!toggle ? 'bg-primary-400' : 'bg-gray-200']"
                                    class="relative inline-flex flex-shrink-0 w-20 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer h-9 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                    role="switch" aria-checked="false" aria-labelledby="overBudgetProposalsFilter">
                            <span aria-hidden="true"
                                  :class="[!!toggle ? 'translate-x-11 border-primary-400' : 'translate-x-0 border-gray-300']"
                                  class="inline-block w-8 h-8 transition transform bg-white rounded-full shadow pointer-events-none ring-0"></span>
                            </button>
                            <span class="ml-3" id="overbuget-proposals-label">
                            <input wire:change="setOverBudgetProposalsFilter()" type="hidden" :value="toggle"
                                   wire:model="overBudgetProposalsFilter" name="overBudgetProposalsFilter"
                                   id="overBudgetProposalsFilter">
                            <label for="overBudgetProposalsFilter" class="text-sm font-medium text-gray-900">
                                <span>{{ $snippets->showing }}: </span>
                                @if($this->overBudgetProposalsFilter)
                                    <span class="font-semibold">
                                        {{ $snippets->overBudgetProposals }}
                                    </span>
                                @else
                                    <span>
                                        {{ $snippets->allProposals }}
                                    </span>
                                @endif
                            </label>
                        </span>
                        </div>
                    </div>

                    <!-- fund filter -->
                    <div wire:ignore class="fund-filter" x-data="{
                            multiple: true,
                            value: @entangle('fundFilter'),
                            options: {{ $funds->map( fn($f) => (['value' => $f->id, 'label' => $f->title ]) ) }},
                            init() {
                                this.$nextTick(() => {
                                    let choices = new Choices(
                                        this.$refs.select,
                                        {
                                            position: 'bottom',
                                            placeholderValue: 'Select Fund(s)',
                                            removeItemButton: true
                                        }
                                    );

                                    let refreshChoices = () => {
                                        let selection = this.multiple ? this.value : [this.value];

                                        choices.clearStore()
                                        choices.setChoices(this.options.map(({ value, label }) => ({
                                            value,
                                            label,
                                            selected: selection.includes(value),
                                        })));
                                    }

                                    refreshChoices();

                                    this.$refs.select.addEventListener('change', () => {
                                        this.value = choices.getValue(true);
                                        this.filters = this.value.map( (c) => (c.value));
                                    })

                                    this.$watch('value', () => refreshChoices());
                                    this.$watch('options', () => refreshChoices());
                                })
                            }
                        }">
                        <select x-ref="select" :multiple="multiple"></select>
                    </div>

                    <!-- challenge filter -->
                    <div wire:ignore class="challenge-filter" x-data="{
                            multiple: true,
                            value: @entangle('challengeFilter'),
                            funds: @entangle('fundFilter'),
                            get options() {
                                const options = {{ $challenges->map( fn($c) => (['value' => $c->id, 'label' => $c->title, 'fundId' => $c->parent_id ]) ) }};
                                if (!this.funds.length) {
                                    return options;
                                }
                                return options.filter((c) => this.funds.includes(c.fundId)) || options;
                            },
                            init() {
                                this.$nextTick(() => {
                                    let choices = new Choices(
                                        this.$refs.select,
                                        {
                                            position: 'bottom',
                                            placeholderValue: 'Select Challenge(s)',
                                            removeItemButton: true
                                        }
                                    );

                                    let refreshChoices = () => {
                                        let selection = this.multiple ? this.value : [this.value];

                                        choices.clearStore()
                                        choices.setChoices(this.options.map(({ value, label }) => ({
                                            value,
                                            label,
                                            selected: selection.includes(value),
                                        })));
                                    }

                                    refreshChoices();

                                    this.$refs.select.addEventListener('change', () => {
                                        this.value = choices.getValue(true);
                                        this.filters = this.value.map( (c) => (c.value));
                                    })

                                    this.$watch('value', () => refreshChoices());
                                    this.$watch('options', () => refreshChoices());
                                })
                            }
                        }">
                        <select x-ref="select" :multiple="multiple"></select>
                    </div>



                    <!-- type filter -->
                    <div wire:ignore class="type-filter" x-data="{
                            multiple: false,
                            value: @entangle('proposalTypeFilter'),
                            options: [
                                {value: 'all', label: 'Showing: Proposals & Challenge Settings'},
                                {value: 'proposal', label: 'Showing: Proposals'},
                                {value: 'challenge', label: 'Showing: Challenge Settings'}
                           ],
                            init() {
                                this.$nextTick(() => {
                                    let choices = new Choices(
                                        this.$refs.select,
                                        {
                                            position: 'bottom',
                                            placeholderValue: 'Select Type',
                                            removeItemButton: false,
                                            searchEnabled: false,
                                            shouldSort: false
                                        }
                                    );

                                    let refreshChoices = () => {
                                        let selection = this.multiple ? this.value : [this.value];

                                        choices.clearStore()
                                        choices.setChoices(this.options.map(({ value, label }) => ({
                                            value,
                                            label,
                                            selected: selection.includes(value),
                                        })));
                                    }

                                    refreshChoices();

                                    this.$refs.select.addEventListener('change', () => {
                                        this.value = choices.getValue(true);
                                        this.filters = this.value.map( (c) => (c.value));
                                    })

                                    this.$watch('value', () => refreshChoices());
                                    this.$watch('options', () => refreshChoices());
                                })
                            }
                        }">
                        <select x-ref="select" :multiple="multiple"></select>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="relative col-span-5 proposal-results">
                <div
                    wire:loading.class.remove="hidden" wire:loading.delay.shortest.class="absolute"
                    class="sticky left-0 z-10 flex items-center justify-center hidden w-full h-0 p-0 overflow-visible top-2/3">
                    <div
                        class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                        <svg
                            class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-primary-600"
                            viewBox="0 0 24 24"></svg>
                    </div>
                </div>

                <div class="relative p-2 mb-2 border" x-data="{
                    sortBy: @entangle('sortBy'),
                    sortOrder: @entangle('sortOrder')
                }">
                    <div class="relative inline-block px-2 text-xs font-medium text-gray-600 bg-white 2xl:text-sm -top-6">
                        Sorts & Filters
                    </div>
                    <div class="flex flex-row flex-wrap gap-2 -mt-5 font-semibold">
                        <button
                            wire:click="sortBy('amount_requested')"
                            type="button"
                            :class="{
                                'bg-teal-300 text-white border-teal-400': sortBy === 'amount_requested'
                            }"
                            class="inline-flex items-center px-2.5 py-0.5 border rounded-sm text-sm font-medium text-gray-600 hover:bg-primary-100 hover:text-white">
                            <span x-show="sortBy === 'amount_requested'" x-cloak>
                                <svg x-show="sortOrder === 'asc'"
                                     class="-ml-0.5 mr-1.5 h-4 w-4 "
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                <svg x-show="sortOrder === 'desc'"
                                     xmlns="http://www.w3.org/2000/svg"
                                     class="-ml-0.5 mr-1.5 h-4 w-4"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                                </svg>
                            </span>
                            <template x-if="sortBy === 'none'">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-200"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                            </template>
                            Budget
                        </button>

                        <button
                            wire:click="sortBy('ca_rating')"
                            type="button"
                            :class="{
                                'bg-teal-300 text-white border-teal-400': sortBy === 'ca_rating'
                            }"
                            class="inline-flex items-center px-2.5 py-0.5 border rounded-sm text-sm font-medium text-gray-600 hover:bg-teal-100 hover:text-white">
                            <span x-show="sortBy === 'ca_rating'" x-cloak>
                                <svg x-show="sortOrder === 'asc'"
                                     class="-ml-0.5 mr-1.5 h-4 w-4 "
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                <svg x-show="sortOrder === 'desc'"
                                     xmlns="http://www.w3.org/2000/svg"
                                     class="-ml-0.5 mr-1.5 h-4 w-4 "
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                                </svg>
                            </span>

                            <template x-if="sortBy === 'none'">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-200"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                            </template>
                            CA Rating
                        </button>

                        <span class="inline-flex ml-auto text-sm italic font-medium hover:cursor-pointer hover:text-teal-600"
                              @click="@this.set('sortBy', 'none'); @this.set('sortOrder', 'none');">Reset</span>

                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @foreach($proposals as $proposal)
                        <div class="col-span-1 flex flex-col" wire:key="{{$proposal->id}}">
                            @if($proposal->type=='challenge')
                                <x-catalyst.challenges.drip :challenge="$proposal"/>
                            @else
                                <x-catalyst.proposals.drip :proposal="$proposal" />
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 paginator ">
                    {{ $this->getPaginator()?->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
