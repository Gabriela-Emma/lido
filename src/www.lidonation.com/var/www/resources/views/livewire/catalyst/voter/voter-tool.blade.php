<div class="relative z-20 catalyst-proposals-research-wrapper" id="voter-tool-wrapper">
    @livewire('catalyst.catalyst-sub-menu-component')
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-20 flex flex-col block gap-3 sm:flex-row">
                <span class='z-20 font-light'>{{__('Catalyst') }}</span>
                <span class='z-20 font-black text-teal-600'>{{__('Voter Tool') }}</span>
            </span>
        </x-slot>
        <h2 class="font-medium">
            {{ $snippets->allVotesMustBeSubmittedInTheApp}}
        </h2>

        @if($snippets)
            <x-markdown>{{$snippets[0]?->content}}</x-markdown>
        @endif
    </x-public.page-header>

    <section class="relative py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row items-center justify-end gap-4 py-4">
            </div>
        </div>
    </section>

    <section class="relative py-8 bg-scroll bg-gray-100 bg-center bg-cover bg-pool-bw-light bg-blend-hard-light"
             aria-labelledby="quick-links-title">
        <div class="container">
            <div class="bg-white shadow-sm">
                <div class="relative px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div
                        wire:loading.class.remove="hidden" wire:loading.delay.shortest.class="absolute"
                        class="sticky left-0 z-10 flex items-center justify-center hidden w-full h-0 p-0 overflow-visible top-1/2">
                        <div class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                            <svg
                                class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-primary-600"
                                viewBox="0 0 24 24"></svg>
                        </div>
                    </div>

                    <div class="space-y-8 sm:space-y-16">
                        <section class="flex flex-col gap-8 text-center">
                            <div class="flex flex-col gap-1"  x-data="{}">
                                <span class="inline-flex ml-auto text-sm italic font-medium hover:cursor-pointer hover:text-teal-600"
                                      @click="@this.set('proposals', null); @this.set('search', null); @this.set('searchGroup', null);">Reset</span>
                                <div class="flex items-center h-16">
                                    <div class="flex w-full h-full min-w-full rounded-sm shadow-sm">
                                        <div class="relative flex-grow w-full h-full focus-within:z-10">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20"
                                                     stroke="currentColor"
                                                     fill="none">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                            </div>
                                            <input wire:model.debounce.600ms="search"
                                                   x-bind:search="search"
                                                   name="searchProposals"
                                                   id="searchProposals"
                                                   {{!!$searchGroup ? 'disabled' : ''}}
                                                   class="block w-full h-full pl-10 transition duration-150 ease-in-out border rounded-sm form-input focus:bg-white sm:text-sm sm:leading-5 {{!!$searchGroup ? 'bg-gray-300' : 'bg-white'}}"
                                                   placeholder="{{__('Search name, proposal, challenge, topic, or favorite color')}}" />
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span x-text="searchGroup"></span>
                                                <button @click="@this.set('proposals', null); @this.set('search', null);"
                                                        class="text-gray-300 hover:text-red-600 focus:outline-none">
                                                    <x-icons.x-circle class="w-5 h-5 stroke-current"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="text-left 2x:w-3/5 search-groups-wrapper"
                                    x-data="{
                                        value: @entangle('searchGroup'),
                                        select(option) { this.value = option },
                                        isSelected(option) { return this.value === option },
                                        hasRovingTabindex(option, el) {
                                            if (this.value === null && Array.from(el.parentElement.children).indexOf(el) === 0) return true
                                            return this.isSelected(option)
                                        },
                                        selectNext(e) {
                                            let el = e.target
                                            let siblings = Array.from(el.parentElement.children)
                                            let index = siblings.indexOf(el)
                                            let next = siblings[index === siblings.length - 1 ? 0 : index + 1]

                                            next.click(); next.focus();
                                        },
                                        selectPrevious(e) {
                                            let el = e.target
                                            let siblings = Array.from(el.parentElement.children)
                                            let index = siblings.indexOf(el)
                                            let previous = siblings[index === 0 ? siblings.length - 1 : index - 1]

                                            previous.click(); previous.focus();
                                        },
                                    }"
                                    @keydown.down.stop.prevent="selectNext"
                                    @keydown.right.stop.prevent="selectNext"
                                    @keydown.up.stop.prevent="selectPrevious"
                                    @keydown.left.stop.prevent="selectPrevious"
                                    role="radiogroup"
                                    :aria-labelledby="$id('radio-group-label')"
                                    x-id="['radio-group-label']" >
                                    <!-- Radio Group Label -->
                                    <label :id="$id('radio-group-label')" role="none" class="hidden">Proposal Groups: <span x-text="value"></span></label>

                                    <div class="flex flex-row flex-wrap gap-2 mt-2 search-groups">
                                        <!--QuickPitch Proposals Option -->
                                        <a
                                            href="{{localizeRoute('projectCatalyst.voterTool', null, ['group' => 'quickPitchProposals'])}}"
                                            x-data="{ option: 'quickPitchProposals' }"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">Quick Pitches</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Proposals with Quick Pitches.
                                                </span>
                                            </span>
                                        </a>

                                        <!--Impact Proposals Option -->
                                        <div
                                            x-data="{ option: 'impactProposals' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">Impact Proposals</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Self reported as having social & environmental impact
                                                </span>
                                            </span>
                                        </div>

                                        <!--Ideafest Proposals Option -->
                                        <div
                                            x-data="{ option: 'ideafestProposals' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">Ideafest Proposals</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Projects presented at Ideafest!
                                                </span>
                                            </span>
                                        </div>


                                        <!--Cardano Catalyst Women Proposals Option -->
                                        <div
                                            x-data="{ option: 'womanProposals' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">Women Proposals</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Proposals By Women
                                                </span>
                                            </span>
                                        </div>

                                        <!--Small Proposals Option -->
                                        <div
                                            x-data="{ option: 'smallProposals' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">Small Proposals</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Proposals with budgets <= 10K
                                                </span>
                                            </span>
                                        </div>

                                        <!--Large Proposals Option -->
                                        <div
                                            x-data="{ option: 'largeProposals' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">Large Proposals</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Proposals with budgets >= 25K
                                                </span>
                                            </span>
                                        </div>

                                        <!--100K Proposals Option -->
                                        <div
                                            x-data="{ option: '100KProposals' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')"> >= 100K Proposals</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Proposals with budgets >= 100K
                                                </span>
                                            </span>
                                        </div>

                                        <!-- Option -->
                                        <div
                                            x-data="{ option: 'firstTimers' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]"
                                        >
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">First Timers</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Proposals from first time members!
                                                </span>
                                            </span>
                                        </div>

                                        <!-- One Timers Option -->
                                        <div
                                            x-data="{ option: 'oneTimers' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">One Timers</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Members with only 1 proposal
                                                </span>
                                            </span>
                                        </div>

                                        <!-- Completed Proposals Option -->
                                        <div
                                            x-data="{ option: 'completedProposers' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">Completed Proposers</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Teams that have completed at least 1 proposal
                                                </span>
                                            </span>
                                        </div>

                                        <div
                                            x-data="{ option: 'allStars' }"
                                            @click="select(option)"
                                            @keydown.enter.stop.prevent="select(option)"
                                            @keydown.space.stop.prevent="select(option)"
                                            :aria-checked="isSelected(option)"
                                            :tabindex="hasRovingTabindex(option, $el) ? 0 : -1"
                                            :aria-labelledby="$id('radio-option-label')"
                                            :aria-describedby="$id('radio-option-description')"
                                            x-id="['radio-option-label', 'radio-option-description']"
                                            role="radio"
                                            class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                            <!-- Checked Indicator -->
                                            <span
                                                :class="{ 'bg-teal-600': isSelected(option) }"
                                                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="ml-3 text-gray-600">
                                                <!-- Primary Label -->
                                                <p :id="$id('radio-option-label')">All Stars</p>

                                                <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                                    Scored a perfect 5/5 PA Rating
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!empty($proposals))
                                @if($searchGroup === 'quickPitchProposals')
                                    <div class="relative bg-slate-50 border rounded-sm">
                                        <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
                                            <div class="pr-16 sm:px-16 sm:text-center">
                                                <p class="font-medium text-slate-400">
                                                        <span>
                                                            Are you a proposer? Link your
                                                        </span>
                                                    <span class="block sm:ml-2 sm:inline-block">
                                                          <a href="{{$settings->quick_pitch_link}}"
                                                             target="_blank"
                                                             class="font-semibold underline flex flex-row gap-2 items-center">
                                                            <span>quickpitch</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                            </svg>
                                                          </a>
                                                        </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="grid grid-cols-1 gap-4 text-left lg:grid-cols-2 xl:grid-cols-3">
                                    @foreach($proposals as $proposal)
                                        <div class="" wire:key="proposal-drip-{{$proposal->id}}">
                                            @if($proposal->type=='challenge')
                                                <x-catalyst.challenges.drip
                                                    :view="$searchGroup === 'quickPitchProposals' ? 'pitch' : 'detail' "
                                                    :challenge="$proposal" />
                                            @else
                                                <x-catalyst.proposals.drip
                                                    :proposal="$proposal"
                                                    :view="$searchGroup === 'quickPitchProposals' ? 'pitch' : 'detail' " />
                                            @endif
                                        </div>
                                    @endforeach

                                    <div id="bookmarkResults" x-cloak x-data="{
                                            bookmarking: false,
                                            bookmarked: false,
                                            label: null,
                                            searchArgs: @js($searchArgs),
                                            async bookmarkResults() {
                                                this.bookmarked = false;
                                                this.bookmarking = true;
                                                this.searchArgs['label'] = this.label;
                                                const res = await window.axios.post(`//${window.location.host}/project-catalyst/proposals/search/bookmarks`, this.searchArgs);
                                                if (res.data && res.data.length > 0) {
                                                    Alpine.store('vt').upserts(res.data);
                                                }
                                                this.bookmarking = false;
                                                this.bookmarked = true;
                                            }
                                        }"
                                         class="p-8 bg-primary-30 w-full col-span-1 lg:grid-cols-2 xl:col-span-3 w-full relative overflow-hidden">
                                        <div class="hidden pointer-events-none sm:block sm:absolute sm:inset-y-0 sm:h-full sm:w-full" aria-hidden="true">
                                            <div class="relative h-full w-full p-2">
                                                <svg class="absolute right-full transform translate-y-[12%] translate-x-1/4 lg:translate-x-1/3" width="404" height="640" fill="none" viewBox="0 0 404 640">
                                                    <defs>
                                                        <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                                            <rect x="0" y="0" width="4" height="4" class="text-teal-50" fill="currentColor" />
                                                        </pattern>
                                                    </defs>
                                                    <rect width="404" height="640" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
                                                </svg>
                                                <svg class="absolute left-full transform -translate-y-3/4 -translate-x-1/4 md:-translate-y-[85%] lg:-translate-x-1/2" width="404" height="640" fill="none" viewBox="0 0 404 640">
                                                    <defs>
                                                        <pattern id="5d0dd344-b041-4d26-bec4-8d33ea57ec9b" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                                            <rect x="0" y="0" width="4" height="4" class="text-teal-50" fill="currentColor" />
                                                        </pattern>
                                                    </defs>
                                                    <rect width="404" height="640" fill="url(#5d0dd344-b041-4d26-bec4-8d33ea57ec9b)" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="" @bookmark-proposals.window="bookmarking = false" x-show="">
                                            <div x-show="bookmarking"
                                                 class="left-0 z-10 flex items-start justify-center w-full h-full absolute">
                                                <div
                                                    class="flex items-center justify-center w-16 h-16 p-3 bg-white rounded-full lg:h-24 lg:w-24 bg-opacity-90">
                                                    <svg
                                                        class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-primary-600"
                                                        viewBox="0 0 24 24"></svg>
                                                </div>
                                            </div>

                                            <div class="text-center" id="bookmark-helper" x-show="bookmarked">
                                                <h1 class="text-2xl tracking-tight font-bold text-gray-900 sm:tracking-tight md:text-4xl md:tracking-tight">
                                                    <span class="block xl:inline">All {{count($proposals ?? [])}} proposals <span class="block text-teal-800 xl:inline">successfully</span><br />
                                                        added to your</span>
                                                    <a class="inline" href="{{localizeRoute('projectCatalyst.voterTool')}}">bookmarks</a>.
                                                </h1>
                                            </div>

                                            <div class="text-center" id="bookmark-helper" x-show="!bookmarked">
                                                <h1 class="text-2xl tracking-tight font-bold text-gray-900 sm:tracking-tight md:text-4xl md:tracking-tight">
                                                    <span class="block text-teal-800 xl:inline">Bookmark</span>
                                                    <span class="block xl:inline"> all <span x-text="searchArgs?.count || 0"></span> matching proposals</span>
                                                </h1>
                                                <div class="mt-1 max-w-md mx-auto flex flex-col md:flex-row md:justify-center md:mt-4 gap-4 items-center">
                                                    <div class="border border-primary-700 w-full rounded-sm px-3 py-2 focus-within:ring-1 focus-within:ring-primary-600 focus-within:border-primary-600 text-left">
                                                        <label for="name" class="block text-xs font-semibold text-teal-900">Label (optional)</label>
                                                        <input type="text" name="name" id="name" placeholder="List Label or Title" x-model="label"
                                                               class="block custom-input w-full border-0 p-0 text-teal-900 placeholder-primary-100 bg-transparent focus:ring-0 sm:text-sm">
                                                    </div>

                                                    <div class="rounded-md shadow-xs w-full lg:w-auto h-full flex">
                                                        <a
                                                            :disable="searchArgs.count > 80"
                                                            :class="{
                                                                'disable bg-slate-600 hover:cursor-not-allowed pointer-events-none': searchArgs.count > 80
                                                            }"
                                                            @click.prevent="bookmarkResults()"
                                                            href="#bookmarkResults" class="h-full flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-sm text-white hover:text-yellow-500 bg-teal-800 hover:bg-teal-600 md:py-3 md:text-lg md:px-4">
                                                            Bookmark
                                                        </a>
                                                    </div>

                                                    <div class="absolute -bottom-1 w-full p-2" x-show="searchArgs.count > 80">
                                                        <p class="text-teal-900 font-medium text-xs">
                                                            Anonymous bulk bookmark creation is limited to 80 at a time.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @empty($search)
                                        <div class="paginator  col-span-1 lg:grid-cols-2 xl:col-span-3 flex justify-center ">
                                            {{ $this->getSearchGroupPaginator()->links() }}
                                        </div>
                                    @endempty
                            @endif
                        </section>

                        @if($proposals)
                            <x-public.divider></x-public.divider>
                        @endif

                        <section>
                            <h2 class="mt-6 text-4xl">
                                Challenges in {{$fund->label}}
                            </h2>
                            <p>The community was asked to provide solutions to these challenges</p>

                            <div
                                class="grid grid-cols-1 gap-3 mt-5 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3 lg:gap-6">
                                @foreach($challenges as $challenge)
                                    <div
                                        class="relative flex flex-col overflow-hidden bg-white border border-gray-200 rounded-lg group">
                                        <div
                                            class="bg-gray-200 aspect-w-2 aspect-h-2 group-hover:opacity-75 sm:aspect-none sm:h-60">
                                            <img
                                                srcset="{{$challenge->hero?->getSrcset('thumbnail')}}"
                                                alt="{{$challenge->title}}'s hero image"
                                                class="object-cover object-center w-full h-full sm:w-full sm:h-full">
                                        </div>
                                        <div class="flex flex-col flex-1 p-4 space-y-2">
                                            <h3 class="text-xl font-medium text-gray-900">
                                                <a href="{{$challenge->link}}">
                                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                                    {{$challenge->title}}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500">{{$challenge->excerpt}}</p>
                                            <div class="flex flex-col justify-end flex-1">
                                                <p class="text-base italic text-gray-700">{{$challenge->proposals_count}}
                                                    proposals</p>
                                                <p class="text-lg font-medium text-gray-900">
                                                    Budget: <span class="font-bold">{{$challenge->formatted_amount}}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    <div class="mt-8">
                        <x-catalyst.raw-data-menu />
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
