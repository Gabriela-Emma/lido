<template>
    <header-component titleName0="catalyst" titleName1="Voter Tool"
        subTitle="All Votes must be submitted in the official Catalyst Voting App. This is a research & planning tool only!" />
    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container flex flex-col">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search :search="search" :key="searchRender" @search="(term) => search = term"></Search>
                </div>
                <div>
                    <div class="text-left 2x:w-3/5 search-groups-wrapper" role="radiogroup"
                        :aria-labelledby="$id('radio-group-label')" x-id="['radio-group-label']">
                        <!-- Radio Group Label -->
                        <label :id="$id('radio-group-label')" role="none" class="hidden">Proposal Groups: <span
                                x-text="value"></span></label>

                        <div class="flex flex-row flex-wrap gap-2 mt-2 search-groups">
                            <!--QuickPitch Proposals Option -->
                            <a href="{{localizeRoute('projectCatalyst.voterTool', null, ['group' => 'quickPitchProposals'])}}"
                                role="radio" class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">Quick Pitches</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Proposals with Quick Pitches.
                                    </span>
                                </span>
                            </a>

                            <!--Impact Proposals Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">Impact Proposals</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Self reported as having social & environmental impact
                                    </span>
                                </span>
                            </div>

                            <!--Ideafest Proposals Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">Ideafest Proposals</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Projects presented at Ideafest!
                                    </span>
                                </span>
                            </div>


                            <!--Cardano Catalyst Women Proposals Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">Women Proposals</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Proposals By Women
                                    </span>
                                </span>
                            </div>

                            <!--Small Proposals Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">Small Proposals</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        {{ 'Proposals with budgets <= 10K' }} </span>
                                    </span>
                            </div>

                            <!--Large Proposals Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">Large Proposals</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Proposals with budgets >= 25K
                                    </span>
                                </span>
                            </div>

                            <!--100K Proposals Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')"> >= 100K Proposals</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Proposals with budgets >= 100K
                                    </span>
                                </span>
                            </div>

                            <!-- Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">First Timers</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Proposals from first time members!
                                    </span>
                                </span>
                            </div>

                            <!-- One Timers Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">One Timers</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Members with only 1 proposal
                                    </span>
                                </span>
                            </div>

                            <!-- Completed Proposals Option -->
                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

                                <span class="ml-3 text-gray-600">
                                    <!-- Primary Label -->
                                    <p :id="$id('radio-option-label')">Completed Proposers</p>

                                    <span :id="$id('radio-option-description')" class="mt-2 text-sm">
                                        Teams that have completed at least 1 proposal
                                    </span>
                                </span>
                            </div>

                            <div role="radio"
                                class="flex cursor-pointer border rounded-sm shadow p-4 w-full lg:w-[initial]">
                                <!-- Checked Indicator -->
                                <span :class="{ 'bg-teal-600': isSelected($options) }"
                                    class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                                    aria-hidden="true"></span>

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
            </div>
        </section>

        <section class="container">
            <h2 class="mt-6 text-4xl">
                Challenges in {{ fund.label }}
            </h2>
            <p>The community was asked to provide solutions to these challenges</p>

            <div class="container grid grid-cols-1 gap-3 mt-5 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3 lg:gap-6">
                <div v-for="challenge in challenges" class="relative flex flex-col overflow-hidden bg-white border border-gray-200 rounded-lg group">
                    <div class="bg-gray-200 aspect-w-2 aspect-h-2 group-hover:opacity-75 sm:aspect-none sm:h-60">
                        <img :alt="challenge.title"
                            class="object-cover object-center w-full h-full sm:w-full sm:h-full">
                    </div>
                    <div class="flex flex-col flex-1 p-4 space-y-2">
                        <h3 class="text-xl font-medium text-gray-900">
                            <a :href="challenge.link">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ challenge.title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">{{ '$challenge -> excerpt' }}</p>
                        <div class="flex flex-col justify-end flex-1">
                            <p class="text-base italic text-gray-700">{{ challenge.proposals_count }}
                                proposals</p>
                            <p class="text-lg font-medium text-gray-900">
                                Budget: <span class="font-bold">{{ $filters.currency(challenge.amount, fund.currency) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <main class="container relative z-20 catalyst-proposals-research-wrapper">

    </main>
</template>

<script setup lang="ts">
import Search from '../Shared/Components/Search.vue';
const props = withDefaults(
    defineProps<{
        search?: string,
        currPage?: number,
        perPage?: number,
        locale: string,
        challenges,
        fund
    }>(), {});

let search, searchRender

let isSelected = (t) => {
    return t
}

let $id = (t) => {
    return t
}
</script>