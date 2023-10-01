<template>
    <header-component titleName0="catalyst" titleName1="Proposals"
        subTitle='search proposals and challenges by title, content, or author and co-authors' />

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search :search="search" :key="searchRender" @search="(term) => search = term"></Search>
                    <div class="h-full">
                        <button @click="showFilters = !showFilters"
                            class="h-full text-xs lg:text-base hover:text-yellow-500 focus:outline-none flex flex-nowrap gap-1 items-center px-0.5 lg:px-2 border border-white border-l-0"
                            :class="{
                                'bg-slate-200 text-slate-600': !showFilters && !filtering,
                                'border-teal-500': !showFilters && search,
                                'border-white': !showFilters && !search,
                                'border-teal-500 bg-teal-500 text-white': showFilters || filtering
                            }">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 lg:w-6 lg:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5" />
                            </svg>
                            <span>{{ $t('Filters') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="relative w-full py-8">
            <!-- Sorts and controls -->
            <div :class="{ 'lg:pr-16 opacity-10 lg:opacity-100': showFilters, 'container': !showFilters }"
                class="flex w-full items-center justify-end space-x-0.5 mb-3 gap-2">

                <ProposalViewTypes class="mr-4"></ProposalViewTypes>

                <button @click="openIdeascaleLinks" v-if="props.proposals.total <= 35"
                    class="bg-white rounded-sm px-2 py-2.5 text-gray-400 flex-wrap hover:text-yellow-500">Open Ideascale
                    Links</button>
                <div class="flex flex-col text-center text-pink-500" v-if="filtering || search">
                    <span>
                        <div class="text-xs w-[140px] lg:text-base">
                            <Multiselect placeholder="Download" value-prop="value" mode="single" :filterResults="false"
                                :clear-on-select="true" :close-on-select="true" :loading="preparingDownload"
                                :disabled="preparingDownload" label="label" @select="(opt) => selectedDownloadFormat = opt"
                                :options="[
                                    {
                                        label: 'excel (.xlsx)',
                                        value: 'excel',
                                    },
                                    {
                                        label: 'csv (.csv)',
                                        value: 'csv',
                                    },
                                    {
                                        label: 'tsv (.tsv)',
                                        value: 'tsv',
                                    },
                                    {
                                        label: 'ods (.ods)',
                                        value: 'ods',
                                    },
                                    {
                                        label: 'xls (.xls)',
                                        value: 'xls',
                                    },
                                ]" :classes="{
                                    container: 'multiselect border-0 p-0.5 flex-wrap',
                                    containerActive: 'shadow-none shadow-transparent box-shadow-none',
                                }" />
                        </div>
                    </span>
                </div>
                <div class="text-xs w-[240px] lg:w-[330px] lg:text-base">
                    <Multiselect placeholder="Sort" value-prop="value" label="label" v-model="selectedSortRef"
                        :options="sorts" :classes="{
                            container: 'multiselect border-0 p-0.5 flex-wrap',
                            containerActive: 'shadow-none shadow-transparent box-shadow-none',
                        }" />
                </div>
            </div>


            <div :class="{ 'gap-5': showFilters }" class="relative flex flex-row w-full">
                <!-- Proposal Filters -->
                <div class="absolute left-0 z-10 bg-white shadow-lg lg:static lg:shadow-0">
                    <button type="button" @click="showFilters = !showFilters"
                        class="absolute right-0 inline-flex items-center p-2 text-white bg-teal-600 border border-transparent rounded-t-sm -top-9 lg:hidden hover:bg-teal-700 focus:outline-none focus:ring-0 focus:ring-teal-500 focus:ring-offset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>  

                    <ProposalFilter @filter="(payload) => filtersRef = payload"
                        @reRenderFilter="filterRenderKey = Math.random()" :filters="filtersRef" :key="filterRenderKey"
                        :search="search" @clearSearch="search = null" :show-filter="showFilters"></ProposalFilter>
                </div>

                <!-- Proposal lists -->
                <div class="flex-1 mx-auto"
                    :class="{ 'lg:pr-16 opacity-10 lg:opacity-100': showFilters, 'container': !showFilters }">
                    <Proposals :proposals="currentModel?.data?.data"></Proposals>

                    <div class="flex items-start justify-between w-full gap-16 my-16 xl:gap-24" v-if="currentModel?.data?.data">
                        <div class="flex-1">
                            <Pagination :links="currentModel.data.links" :per-page="props.perPage"
                                :total="currentModel.data.total" :from="currentModel.data.from" :to="currentModel.data.to"
                                @perPageUpdated="(payload) => perPageRef = payload"
                                @paginated="(payload) => currPageRef = payload" />
                        </div>
                    </div>

                    <div class="sticky bottom-8">
                        <div class="sticky flex justify-center mb-6" v-if="viewPlayer">
                            <button v-if="!showPlayer" @click="playStore.startPlaying(props.proposals?.data)"
                                class="flex flex-row items-center p-2 m-1 text-center transform bg-yellow-500 rounded-full text-l hover:text-white">
                                <span class="font-bold">Play all {{ props.proposals?.data.length }} quickpitches</span>
                                <span>
                                    <PlayCircleIcon class="w-8 h-8 ml-2 text-slate-700 hover:text-white"
                                        aria-hidden="true" />
                                </span>
                            </button>
                        </div>
                        <footer class="">
                            <div class="flex justify-center">
                                <div
                                    class="relative px-4 py-3 text-sm text-white rounded-full shadow-xl bg-slate-800 lg:text-md xl:text-lg">
                                    <TransitionGroup tag="div" name="fade"
                                        class="inline-flex flex-wrap justify-center h-full gap-1 mx-auto space-x-2 divide-x-reverse md:flex-nowrap md:gap-2 divide-slate-100 md:space-x-4">
                                        <div class="flex flex-col text-center" key="countTotal">
                                            <span class="font-semibold">
                                                {{ $filters.number(props.proposals.total, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Submitted') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center" v-if="metricCountApproved" key="countFunded">
                                            <span class="font-semibold">
                                                {{ $filters.number(metricCountApproved, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Approved') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center" v-if="metricCountTotalPaid" key="countPaid">
                                            <span class="font-semibold">
                                                {{ $filters.number(metricCountTotalPaid, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Fully Paid') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-pink-500" v-if="metricCountCompleted"
                                            key="completed">
                                            <span class="font-semibold">
                                                {{ $filters.number(metricCountCompleted, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Completed') }}
                                            </span>
                                        </div>
                                        <div class="w-full h-[1px] md:h-full md:w-[1px] bg-slate-100 relative"
                                            v-if="(metricCountApproved || metricCountCompleted) && metricSumApproved">
                                            <b
                                                class="absolute hidden px-2 py-1 text-xs text-center text-yellow-500 rounded-full md:inline-block -top-6 -left-10 w-28 bg-slate-800">
                                                {{ $t('Search metrics') }}
                                            </b>
                                        </div>
                                        <div class="flex flex-col text-center" v-if="metricSumBudget" key="sumBudget">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(metricSumBudget, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Requested') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center" v-if="metricSumAdaBudget"
                                            key="metricSumAdaBudget">
                                            <span class="font-semibold">
                                                ₳{{ $filters.shortNumber(metricSumAdaBudget, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                ₳ {{ $t('Requested') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-light-500" v-if="metricSumApproved"
                                            key="sumApproved">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(metricSumApproved, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Awarded') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-400" v-if="metricSumDistributed"
                                            key="sumDistributed">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(metricSumDistributed, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Distributed') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-light-500" v-if="metricSumAdaApproved"
                                            key="sumAdaApproved">
                                            <span class="font-semibold">
                                                ₳{{ $filters.shortNumber(metricSumAdaApproved, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                ₳ {{ $t('Awarded') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-400" v-if="metricSumAdaDistributed"
                                            key="sumAdaDistributed">
                                            <span class="font-semibold">
                                                ₳{{ $filters.shortNumber(metricSumAdaDistributed, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                ₳ {{ $t('Distributed') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-pink-500" v-if="metricSumCompleted"
                                            key="sumCompleted">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(metricSumCompleted, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Completed') }}
                                            </span>
                                        </div>
                                    </TransitionGroup>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import { computed, ref, watch } from "vue";
import Proposal from "../models/proposal";
import Proposals from "../modules/proposals/Proposals.vue";
import { router, usePage } from '@inertiajs/vue3';
import ProposalFilter from "../modules/proposals/ProposalFilter.vue";
import Filters from "../models/filters";
import Sort from "../models/sort";
import { VARIABLES } from "../models/variables";
import Search from "../Shared/Components/Search.vue";
import Pagination from "../Shared/Components/Pagination.vue";
import axios from 'axios';
import { usePeopleStore } from '../stores/people-store';
import { storeToRefs } from 'pinia';
import ProposalViewTypes from '../modules/proposals/partials/ProposalViewTypes.vue';
import { useProposalsStore } from '../stores/proposals-store';
import { useBookmarksStore } from '../stores/bookmarks-store';
import { useProposalsRankingStore } from '../stores/proposals-ranking-store';
import { useUserStore } from '../../global/Shared/store/user-store';
import { usePlayStore } from '../../global/Shared/store/play-store';
import { PlayCircleIcon, StopCircleIcon } from '@heroicons/vue/20/solid';
import { useFiltersStore } from '../../global/Shared/store/filters-stores';

/// props and class properties
const props = withDefaults(
    defineProps<{
        search?: string,
        filters?: Filters,
        sorts?: Sort[],
        sort?: string,
        currPage?: number,
        perPage?: number,
        locale: string,
        proposals: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Proposal[]
        };
    }>(), {
    sorts: () => [
        {
            label: 'Votes Cast: Low to High',
            value: 'votes_cast:asc',
        },
        {
            label: 'Votes Cast: High to Low',
            value: 'votes_cast:desc',
        },
        {
            label: 'Budget: High to Low',
            value: 'amount_requested:desc',
        },
        {
            label: 'Budget: Low to High',
            value: 'amount_requested:asc',
        },
        {
            label: 'Community Ranking: High to Low',
            value: 'ranking_total:desc',
        },
        {
            label: 'Community Ranking: Low to High',
            value: 'ranking_total:asc',
        },
        {
            label: 'Payments Received: High to Low',
            value: 'amount_received:desc',
        },
        {
            label: 'Project Length: High to Low',
            value: 'project_length:desc',
        },
        {
            label: 'Project Length: Low to High',
            value: 'project_length:asc',
        },
        {
            label: 'Payments Received: Low to High',
            value: 'amount_received:asc',
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
        },
        {
            label: 'Rating: High to Low',
            value: 'ca_rating:desc',
        },
        {
            label: 'Rating: Low to High',
            value: 'ca_rating:asc',
        },
    ]
});
let search = ref(props.search);
let filtersRef = ref<Filters>(props.filters);
let selectedSortRef = ref<string>(props.sort);
let filterRenderKey = ref(0);
let searchRender = ref(0);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);

let preparingDownload = ref<boolean>(false);
let selectedDownloadFormat = ref<string>(null);

let viewPlayer = computed(
    () => props.proposals?.data.length < 36 && props.proposals?.data.length > 0 && viewType.value == 'quickpitch'
)

// metrics count
let metricCountApproved = ref<number>(null);
let metricCountTotalPaid = ref<number>(null);
let metricCountCompleted = ref<number>(null);

// metrics Sum
let metricSumApproved = ref<number>(null);
let metricSumDistributed = ref<number>(null);
let metricSumCompleted = ref<number>(null);
let metricSumBudget = ref<number>(null);

// metrics Sum
let metricSumAdaApproved = ref<number>(null);
let metricSumAdaDistributed = ref<number>(null);
let metricSumAdaCompleted = ref<number>(null);
let metricSumAdaBudget = ref<number>(null);

////
// computed properties
////
/**
 * assert that every property on props.filters is truthy.
 */
const filtering = computed(() => {
    return getFiltering();
});

let showFilters = ref(getFiltering() || true);

const playStore = usePlayStore();
let { showPlayer } = storeToRefs(playStore);

const userStore = useUserStore();
userStore.setUser();

const peopleStore = usePeopleStore();
peopleStore.load(props?.filters?.people);
const { selectedPeople } = storeToRefs(peopleStore);

const proposalsRanking = useProposalsRankingStore();
proposalsRanking.loadRankings();

const proposalsStore = useProposalsStore();
let { viewType } = storeToRefs(proposalsStore);

const filterStore = useFiltersStore();
const {currentModel} = storeToRefs(filterStore)

let quickpitchingRef = ref<boolean>(false);
let rankedViewingRef = ref<boolean>(false);
let cardViewingRef = ref<boolean>(false);

const bookmarksStore = useBookmarksStore();
bookmarksStore.loadCollections();

filterStore.setModel({ data: props.proposals, filters: props.filters })
currentModel.value.data = props.proposals;
currentModel.value.filters = filtersRef.value

watch([search, filtersRef, selectedSortRef], () => {
    currPageRef.value = null;
    query();
    searchRender.value = Math.random();
}, { deep: true });

watch([currPageRef, perPageRef, quickpitchingRef, rankedViewingRef], () => {
    query();
});

watch([rankedViewingRef], () => {
    if (!selectedSortRef.value.includes('ranking_total')) {
        selectedSortRef.value = 'ranking_total:desc';
    }
}, { deep: true });

watch([selectedPeople], () => {
    filtersRef.value.people = [...filtersRef.value.people, ...selectedPeople.value]
});

watch([viewType], () => {
    quickpitchingRef.value = viewType.value === 'quickpitch';
    rankedViewingRef.value = viewType.value === 'ranked';
    cardViewingRef.value = viewType.value === 'card';
});

watch(selectedDownloadFormat, () => {
    if (selectedDownloadFormat.value != null) {
        download(selectedDownloadFormat.value);
    }
});

getMetrics();

////
// initializers
////
// filters
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
    const data = getQueryData();
    getMetrics();
    // router.get(
    //     `/${props.locale}/catalyst-explorer/proposals`,
    //     data,
    //     { preserveState: true, preserveScroll: !currPageRef.value }
    // );

    // @ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_PROPOSALS, 0);
    }

    
}

function getMetrics() {
    const params = getQueryData();

    // get funded count
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/count/paid`, { params })
        .then((res) => metricCountTotalPaid.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
    // get funded count
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/count/approved`, { params })
        .then((res) => metricCountApproved.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
    // get completed count
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/count/completed`, { params })
        .then((res) => metricCountCompleted.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    // get funded sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/approved`, { params })
        .then((res) => metricSumApproved.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
    // get funded sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/distributed`, { params })
        .then((res) => metricSumDistributed.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
    // get funded sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/completed`, { params })
        .then((res) => metricSumCompleted.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    // get requested sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/budget`, { params })
        .then((res) => metricSumBudget.value = res?.data)
        .catch((error) => {
            console.error(error);
        });




    // get funded ada sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/approved?currency=ADA`, { params })
        .then((res) => metricSumAdaApproved.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
    // get funded ada sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/distributed?currency=ADA`, { params })
        .then((res) => metricSumAdaDistributed.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
    // get funded ada sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/completed?currency=ADA`, { params })
        .then((res) => metricSumAdaCompleted.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
    // get requested ada sum
    window.axios.get(`${usePage().props.base_url}/catalyst-explorer/proposals/metrics/sum/budget?currency=ADA`, { params })
        .then((res) => metricSumAdaBudget.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}

function getQueryData() {
    const data = {};
    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }
    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }

    if (!!rankedViewingRef.value) {
        data[VARIABLES.RANKED_VIEW] = '';
    }

    if (!!quickpitchingRef.value) {
        data[VARIABLES.QUICKPITCHES] = '';
    }

    if ( !!cardViewingRef.value ) {
        data[VARIABLES.CARD_VIEW] = '';
    }

    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }

    if (filtersRef.value?.funded) {
        data[VARIABLES.FUNDED_PROPOSALS] = 1;
    }

    if (filtersRef.value?.opensource) {
        data[VARIABLES.OPENSOURCE_PROPOSALS] = 1;
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

    return data;
}

function download(format) {
    preparingDownload.value = true;
    let data = getQueryData();
    if (format) {
        data['d'] = true;
        data['d_t'] = format;
    }

    const fileName = format == 'excel' ? 'proposals.xlsx' : `proposals.${format}`;
    const res = axios.get(`/${props.locale}/catalyst-explorer/export/proposals`, {
        responseType: 'blob',
        params: data,
    });
    res.then(function (res) {
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', fileName);
        document.body.appendChild(link);
        link.click();
        preparingDownload.value = false;
    });
}

function openIdeascaleLinks() {
    const proposals = props.proposals.data;
    let index = 0;

    function openNextTab() {
        if (index < proposals.length) {
            const proposal = proposals[index];
            if (proposal.ideascale_link && proposal.ideascale_link.trim() !== "") {
                window.open(proposal.ideascale_link, "_blank");
            }
            index++;
            setTimeout(openNextTab, 300);
        }
    }

    openNextTab();
}
</script>
<style>
.item {
    width: 100%;
    height: 30px;
    background-color: #f3f3f3;
    border: 1px solid #666;
    box-sizing: border-box;
}

/* 1. declare transition */
.fade-move,
.fade-enter-active,
.fade-leave-active {
    transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
}

/* 2. declare enter from and leave to state */
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scaleY(0.01) translate(30px, 0);
}

/* 3. ensure leaving items are taken out of layout flow so that moving
      animations can be calculated correctly. */
.fade-leave-active {
    position: absolute;
}
</style>
