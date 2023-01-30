<template>
    <header-component titleName0="Catalyst" titleName1="Proposals"
                      subTitle="search proposals and challenges by title, content, or author and co-authors."/>

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-16">
                    <ProposalSearch
                        :search="search"
                        @search="(term) => search=term"></ProposalSearch>

                    <div class="h-full">
                        <button @click="showFilters = !showFilters"
                                class="h-full hover:text-yellow-500 focus:outline-none flex flex-nowrap gap-1 items-center px-2 border border-white border-l-0"
                                :class="{
                                    'bg-slate-200 text-slate-600': !showFilters && !filtering,
                                    'border-teal-500': !showFilters && search,
                                    'border-white': !showFilters && !search,
                                    'border-teal-500 bg-teal-500 text-white': showFilters || filtering
                                }"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5"/>
                            </svg>
                            <span>Filters</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mt-4">
                    <div class="w-[204px]">
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
            </div>
        </section>
        <section class="py-8 w-full">
            <div class="flex flex-row gap-5 relative w-full">
                <ProposalFilter @filter="(payload) => filtersRef = payload"
                                :filters="filtersRef"
                                :show-filter="showFilters"></ProposalFilter>

                <div class="flex-1 mx-auto"
                     :class="{ 'pr-16': showFilters, 'container': !showFilters }">
                    <Proposals :proposals="props.proposals.data"></Proposals>
                </div>
            </div>
        </section>
        <section class="pt-4 pb-16 w-full">
            <div class="container">
                <ProposalPagination></ProposalPagination>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import {proposalsStore} from "../stores/proposals-store";
import {computed, ref, watch} from "vue";
import Proposal from "../models/proposal";
import Proposals from "../modules/proposals/Proposals.vue";
import ProposalSearch from "../modules/proposals/ProposalSearch.vue";
import {router} from '@inertiajs/vue3';
import ProposalFilter from "../modules/proposals/ProposalFilter.vue";
import ProposalPagination from "../modules/proposals/ProposalPagination.vue";
import Filters from "../models/filters";
import {every} from "lodash";
import Sort from "../models/sort";
import {VARIABLES} from "../models/variables";

/// props and class properties
const props = withDefaults(
    defineProps<{
        search?: string,
        filters?: Filters,
        sorts?: Sort[],
        sort?: Sort,
        proposals: {
            links: [],
            data: Proposal[]
        };
    }>(), {
        sorts: () => [
            {
                label: 'Budget: Low to High',
                value: 'amount_requested:asc',
            },
            {
                label: 'Budget: High to Low',
                value: 'amount_requested:desc',
            },
            {
                label: 'Rating: Low to High',
                value: 'ca_rating:asc',
            },
            {
                label: 'Rating: High to Low',
                value: 'ca_rating:desc',
            },
            {
                label: 'Yes Votes: Low to High',
                value: 'yes_votes_count:asc',
            },
            {
                label: 'Yes Votes: High to Low',
                value: 'yes_votes_count:desc',
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
let showFilters = ref(every(props.filters));
let filtersRef = ref<Filters>(props.filters);
let selectedSortRef = ref<Sort>(props.sort);

////
// computed properties
////
/**
 * assert that every property on props.filters is truthy.
 */
const filtering = computed(() => Object.values(props.filters).length > 0 && Object.values(props.filters).every(val => !!val));
watch([search, filtersRef, selectedSortRef], (something) => {
    console.log({filtersRef});
    query();
}, {deep: true});

////
// initializers
////
// filters

// proposals
const proposals = proposalsStore();

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

    if (filtersRef.value?.fundingStatus) {
        data[VARIABLES.FUNDING_STATUS] = filtersRef.value?.fundingStatus;
    }

    if (filtersRef.value?.tags) {
        data[VARIABLES.TAGS] = Array.from(filtersRef.value?.tags);
    }

    if (!!selectedSortRef.value) {
        data[VARIABLES.SORTS] = selectedSortRef.value;
    }

    if (!!filtersRef.value.budgets) {
        if (filtersRef.value.budgets[0] > VARIABLES.MIN_BUDGET || filtersRef.value.budgets[1] < VARIABLES.MAX_BUDGET) {
            data[VARIABLES.BUDGETS] = filtersRef.value.budgets;
        }
    }

    router.get(
        "/catalyst-explorer/proposals",
        data,
        {preserveState: true, preserveScroll: true}
    );
}
</script>
