<template>
    <header-component titleName0="Catalyst" titleName1="Proposals"
                      subTitle="search proposals and challenges by title, content, or author and co-authors."/>

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => search=term"></Search>
                    <div class="h-full">
                        <button @click="showFilters = !showFilters"
                                class="h-full text-xs lg:text-base hover:text-yellow-500 focus:outline-none flex flex-nowrap gap-1 items-center px-0.5 lg:px-2 border border-white border-l-0"
                                :class="{
                                    'bg-slate-200 text-slate-600': !showFilters && !filtering,
                                    'border-teal-500': !showFilters && search,
                                    'border-white': !showFilters && !search,
                                    'border-teal-500 bg-teal-500 text-white': showFilters || filtering
                                }"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-4 lg:w-6 w-4 lg:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5"/>
                            </svg>
                            <span>Filters</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-8 w-full relative">
            <!-- Sorts and controls -->
            <div :class="{ 'lg:pr-16 opacity-10 lg:opacity-100': showFilters, 'container': !showFilters }"
                 class="flex w-full items-center justify-end mb-3">
                <div class="text-xs w-[240px] lg:w-[320px] lg:text-base">
                    <Multiselect
                        placeholder="Sort"
                        value-prop="value"
                        label="label"
                        v-model="selectedSortRef"
                        :options="sorts"
                        :classes="{
                                container: 'multiselect border-0 p-0.5 flex-wrap',
                                containerActive: 'shadow-none shadow-transparent box-shadow-none',
                            }"
                    />
                </div>
            </div>

            <div :class="{ 'gap-5': showFilters }"
                 class="flex flex-row relative w-full">
                <!-- Proposal Filters -->
                <div class="absolute left-0 lg:static z-10 bg-white shadow-lg lg:shadow-0">
                    <button type="button" @click="showFilters = !showFilters"
                            class="inline-flex absolute right-0 -top-9 lg:hidden items-center rounded-t-sm border border-transparent bg-teal-600 p-2 text-white hover:bg-teal-700 focus:outline-none focus:ring-0 focus:ring-teal-500 focus:ring-offset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                        </svg>
                    </button>

                    <ProposalFilter @filter="(payload) => filtersRef = payload"
                                    :filters="filtersRef"
                                    :show-filter="showFilters"></ProposalFilter>
                </div>

                <!-- Proposal lists -->
                <div class="flex-1 mx-auto"
                     :class="{ 'lg:pr-16 opacity-10 lg:opacity-100': showFilters, 'container': !showFilters }">
                    <Proposals :proposals="proposals.data"></Proposals>
                </div>
            </div>
        </section>
        <section class="pt-4 pb-16 w-full">
            <div class="container">
                <ProposalPagination v-model="proposals.current_page"
                                    ></ProposalPagination>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import {computed, onBeforeMount, ref, watch} from "vue";
import Multiselect from '@vueform/multiselect';
import {router} from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { PaginationData } from '@splidejs/splide';
import {every} from "lodash";

import Proposals from "../modules/proposals/Proposals.vue";
import Proposal from "../models/proposal";
import ProposalFilter from "../modules/proposals/ProposalFilter.vue";
import ProposalPagination from "../modules/proposals/ProposalPagination.vue";

import Pagination from "../models/pagination";
import PaginationLink from "../models/pagination-link"
import Filters from "../models/filters";
import Sort from "../models/sort";
import {VARIABLES} from "../models/variables";

import Search from "../Shared/Components/Search.vue";

import {useProposalsStore} from "../stores/proposals-store";

/// props and class properties
const props = withDefaults(
    defineProps<{
        search?: string,
        filters?: Filters,
        sorts?: Sort[],
        sort?: string,
        proposals?: Pagination,
    }>(), {
        sorts: () => [
            {
                label: 'Budget: High to Low',
                value: 'amount_requested:desc',
            },
            {
                label: 'Budget: Low to High',
                value: 'amount_requested:asc',
            },
            {
                label: 'Payments Received: High to Low',
                value: 'amount_received:desc',
            },
            {
                label: 'Payments Received: Low to High',
                value: 'amount_received:asc',
            },
            {
                label: 'Rating: High to Low',
                value: 'ca_rating:desc',
            },
            {
                label: 'Rating: Low to High',
                value: 'ca_rating:asc',
            },
            {
                label: 'Yes Votes: High to Low',
                value: 'yes_votes_count:desc',
            },
            {
                label: 'Yes Votes: Low to High',
                value: 'yes_votes_count:asc',
            },
            {
                label: 'No Votes: Low to High',
                value: 'no_votes_count:asc',
            },
            {
                label: 'No Votes: High to Low',
                value: 'no_votes_count:desc',
            }
        ]
    });
let search = ref(props.search);
let filtersRef = ref<Filters>(props.filters);
let selectedSortRef = ref<string>(props.sort);
let proposals = ref<Pagination>(props.proposals);


////
// computed properties
////
/**
 * assert that every property on props.filters is truthy.
 */
const filtering = computed(() => {
    return getFiltering();
});

let showFilters = ref(getFiltering());

watch([proposals, search, filtersRef, selectedSortRef], (something) => {
    query();
}, {deep: true});

////
// initializers
////
onBeforeMount(() => {
    const proposalsStore = useProposalsStore();
    proposalsStore.loadProposals(proposals.value); // proposals
    proposalsStore.loadFilters(filtersRef.value); //filters
});

function getFiltering() {
    if (props.filters.cohort) {
        return true;
    } else if (props.filters.funds?.length > 0) {
        return true;
    } else if (props.filters.challenges?.length > 0) {
        return true;
    } else if (props.filters.tags?.length > 0) {
        return true;
    } else if (props.filters.people.length > 0) {
        return true;
    } else if (props.filters.groups.length > 0) {
        return true;
    } else if (!!props.filters.fundingStatus) {
        return true;
    } else if (!!props.filters.projectStatus) {
        return true;
    }
    return false;
}

function query() {
    const data = {};
    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }

    if (filtersRef.value?.funded) {
        data[VARIABLES.FUNDED_PROPOSALS] = 1;
    }

    if (filtersRef.value?.funds) {
        data[VARIABLES.FUNDS] = Array.from(filtersRef.value?.funds);
    }

    if (filtersRef.value?.challenges) {
        data[VARIABLES.CHALLENGES] = Array.from(filtersRef.value?.challenges);
    }

    if (filtersRef.value?.cohort) {
        data[VARIABLES.COHORT] = filtersRef.value?.cohort;
    }

    if (filtersRef.value?.fundingStatus) {
        data[VARIABLES.FUNDING_STATUS] = filtersRef.value?.fundingStatus;
    }

    if (filtersRef.value?.projectStatus) {
        data[VARIABLES.STATUS] = filtersRef.value?.projectStatus;
    }

    if (filtersRef.value?.type) {
        data[VARIABLES.TYPE] = filtersRef.value?.type;
    }

    if (filtersRef.value?.tags) {
        data[VARIABLES.TAGS] = Array.from(filtersRef.value?.tags);
    }

    if (filtersRef.value?.people) {
        data[VARIABLES.PEOPLE] = Array.from(filtersRef.value?.people);
    }

    if (filtersRef.value?.groups) {
        data[VARIABLES.GROUPS] = Array.from(filtersRef.value?.groups);
    }

    if (!!selectedSortRef.value && selectedSortRef.value.length > 3) {
        data[VARIABLES.SORTS] = selectedSortRef.value;
    }

    if (!!filtersRef.value.budgets) {
        if (filtersRef.value.budgets[0] > VARIABLES.MIN_BUDGET || filtersRef.value.budgets[1] < VARIABLES.MAX_BUDGET) {
            data[VARIABLES.BUDGETS] = filtersRef.value.budgets;
        }
    }

    router.get(
        `/catalyst-explorer/proposals/?p=${proposals.value.current_page}`,
        data,
        {preserveState: true, preserveScroll: true}
    );


    //@ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.PROPOSALS_TRACKER_ID, 0);
    }
}
</script>
