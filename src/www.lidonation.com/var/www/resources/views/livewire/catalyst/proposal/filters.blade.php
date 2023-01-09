<div class="flex relative flex-col gap-2 justify-between w-full">
    @if(count($this->activeSelectFilters) > 0)
        <div class="px-2 py-4 bg-gray-50">
            <h2 class="text-base font-semibold">
                {{$snippets->resultsFilteredBy}}:
            </h2>

            <div class="flex flex-row flex-wrap gap-2">
                @foreach($this->columns as $index => $column)
                    @foreach($this->activeSelectFilters[$index] ?? [] as $key => $value)
                        <button wire:click="removeSelectFilter('{{ $index }}', '{{ $key }}')"
                                x-on:click="$refs.select.value=''"
                                class="inline-flex items-center px-2 py-2 space-x-2 h-6 text-xs font-semibold tracking-wide text-gray-700 uppercase bg-gray-300 rounded-sm hover:text-white hover:bg-pink-400 focus:outline-none">
                            <span class="">{{ $this->getDisplayValue($index, $value) }}</span>
                            <x-icons.x-circle/>
                        </button>
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
    <div wire:loading class="absolute top-0 right-0 z-50 w-full h-full bg-white bg-opacity-75 pointer-events-none">
        <div class="flex flex-col justify-center items-center w-full h-full">
            <x-icons.cog class="w-9 h-9 text-gray-400 animate-spin"/>
        </div>
    </div>

    <div class="mb-4 w-full">
        <div class="flex flex-wrap items-center p-4 border" x-data="{ sortOrder: 'asc' }">
            <div class="flex mb-2 w-full min-w-full text-xs text-gray-600">
                {{__('Sort')}}
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button"
                        @click="sortOrder = (sortOrder == 'desc' ? 'asc' : 'desc'); @this.set('sortBy', 'title'); @this.set('sortOrder', sortOrder);"
                        class="inline-flex gap-1 items-center px-3 py-2 text-gray-700 bg-white rounded-sm border border-gray-100 hover:text-teal-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="text-sm font-medium leading-4">
                        {{__('Title')}}
                    </span>
                    @if($sortBy === 'title')
                        <span>
                           @include('livewire.catalyst.proposal.sort-direction')
                       </span>
                    @endif
                </button>
                <button type="button"
                        @click="sortOrder = (sortOrder == 'desc' ? 'asc' : 'desc'); @this.set('sortBy', 'amount_requested'); @this.set('sortOrder', sortOrder);"
                        class="inline-flex gap-1 items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 bg-white rounded-sm border border-gray-100 hover:text-teal-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span>{{__('Amount')}}</span>
                    @if($sortBy === 'amount_requested')
                        <span>
                       @include('livewire.catalyst.proposal.sort-direction')
                   </span>
                    @endif
                </button>
                <button type="button"
                        @click="sortOrder = (sortOrder == 'desc' ? 'asc' : 'desc'); @this.set('sortBy', 'yes_votes_count'); @this.set('sortOrder', sortOrder);"
                        class="inline-flex gap-1 items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 bg-white rounded-sm border border-gray-100 hover:text-teal-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span>{{__('Yes Votes')}}</span>
                    @if($sortBy === 'yes_votes_count')
                        <span>
                          @include('livewire.catalyst.proposal.sort-direction')
                       </span>
                    @endif
                </button>
            </div>
        </div>
    </div>

    <div class="flex items-center w-full h-16">
        @if($this->searchableColumns()->count())
            <div class="flex w-full h-full rounded-sm shadow-sm">
                <div class="relative flex-grow w-full h-full focus-within:z-10">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor"
                             fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input wire:model.debounce.500ms="search"
                           class="block pl-10 w-full h-full bg-white rounded-sm border transition duration-150 ease-in-out form-input focus:bg-white sm:text-sm sm:leading-5"
                           placeholder="{{__('Search in')}} {{ $this->searchableColumns()->map->label->join(', ') }}"/>
                    <div class="flex absolute inset-y-0 right-0 items-center pr-3">
                        <button wire:click="$set('search', null)"
                                class="text-gray-300 hover:text-red-600 focus:outline-none">
                            <x-icons.x-circle class="w-5 h-5 stroke-current"/>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="py-4 w-full">
        <div class="flex flex-wrap items-center p-4 border" x-data="{ toggle: false }">
            <div class="flex mb-2 w-full min-w-full text-xs text-gray-600">
                {{$snippets->fundedProposals}}
            </div>
            <!-- Enabled: "bg-primary-600", Not Enabled: "bg-gray-200" -->
            <button type="button"
                    @click="toggle = !toggle; @this.set('fundedProposalsFilter', toggle)"
                    :class="[!!toggle ? 'bg-primary-400' : 'bg-gray-200']"
                    class="inline-flex relative flex-shrink-0 w-20 h-9 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    role="switch" aria-checked="false" aria-labelledby="fundedProposalsFilter">
                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                <span aria-hidden="true"
                      :class="[!!toggle ? 'translate-x-11 border-primary-400' : 'translate-x-0 border-gray-300']"
                      class="inline-block w-8 h-8 bg-white rounded-full ring-0 shadow transition transform pointer-events-none"></span>
            </button>
            <span class="ml-3" id="funded-proposals-label">
                <input wire:change="setFundedProposalsFilter()" type="hidden" :value="toggle"
                       wire:model="fundedProposalsFilter" name="fundedProposalsFilter" id="fundedProposalsFilter">
                <label for="fundedProposalsFilter" class="text-sm font-medium text-gray-900">
                    <span>
                        {{$snippets->showing}}: </span>
                    <span class="font-semibold" x-show="!!toggle">
                        {{$snippets->fundedProposals}}
                    </span>
                    <span x-show="!toggle">
                        {{$snippets->allProposals}}
                    </span>
                </label>
            </span>
        </div>
    </div>

    <div class="flex flex-col gap-4 w-full">
        @foreach($this->columns as $index => $column)
            @isset($column['filterable'])
                @if( is_iterable($column['filterable']) )
                    <div class="overflow-hidden" :wire:key="$index">
                        @include('datatables::filters.select', ['index' => $index, 'name' => $column['label'], 'options' => $column['filterable']])
                    </div>
                @endif
            @endisset
        @endforeach
    </div>

    <div class="py-4 w-full">
        <div class="flex flex-wrap items-center p-4 border" x-data="{ toggle: false }">
            <div class="flex mb-2 w-full min-w-full text-xs text-gray-600">
                {{$snippets->overBudget}}
            </div>
            <button type="button"
                    @click="toggle = !toggle; @this.set('overBudgetProposalsFilter', toggle)"
                    :class="[!!toggle ? 'bg-primary-400' : 'bg-gray-200']"
                    class="inline-flex relative flex-shrink-0 w-20 h-9 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    role="switch" aria-checked="false" aria-labelledby="overBudgetProposalsFilter">
                <span aria-hidden="true"
                      :class="[!!toggle ? 'translate-x-11 border-primary-400' : 'translate-x-0 border-gray-300']"
                      class="inline-block w-8 h-8 bg-white rounded-full ring-0 shadow transition transform pointer-events-none"></span>
            </button>
            <span class="ml-3" id="overbuget-proposals-label">
                <input wire:change="setOverBudgetProposalsFilter()" type="hidden" :value="toggle"
                       wire:model="overBudgetProposalsFilter" name="overBudgetProposalsFilter"
                       id="overBudgetProposalsFilter">
                <label for="overBudgetProposalsFilter" class="text-sm font-medium text-gray-900">
                    <span>
                        {{$snippets->showing}}: </span>
                    <span class="font-semibold" x-show="!!toggle">
                        {{$snippets->overBudgetProposals}}
                    </span>
                    <span x-show="!toggle">
                        {{$snippets->allProposals}}
                    </span>
                </label>
            </span>
        </div>
    </div>
</div>
