<template>
    <Head title="Project Catalyst Proposals" />

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
                        :search="search" @clearSearch="search = ''" :show-filter="showFilters"></ProposalFilter>
                </div>

                <!-- Proposal lists -->
                <div class="flex-1 mx-auto"
                    :class="{ 'lg:pr-16 opacity-10 lg:opacity-100': showFilters, 'container': !showFilters }">
                    <Proposals :proposals="currentModel?.data?.data"></Proposals>

                    <div class="flex items-start justify-between w-full gap-16 my-16 xl:gap-24"
                        v-if="currentModel?.data?.data">
                        <div class="flex-1">
                            <Pagination :links="currentModel.data.links" :per-page="props.perPage"
                                :total="currentModel.data.total" :from="currentModel.data.from" :to="currentModel.data.to"
                                @perPageUpdated="(payload: number) => perPageRef = payload"
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
                                                {{ $filters.number(proposalMetrics.submittedProposals, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Submitted') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center" v-if="proposalMetrics.approvedProposals"
                                            key="countFunded">
                                            <span class="font-semibold">
                                                {{ $filters.number(proposalMetrics.approvedProposals, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Approved') }}
                                            </span>
                                        </div>
                                        <!-- <div class="flex flex-col text-center" v-if="proposalMetrics.completedProposals" key="countPaid">
                                            <span class="font-semibold">
                                                {{ $filters.number(proposalMetrics.completedProposals, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Fully Paid') }}
                                            </span>
                                        </div> -->
                                        <div class="flex flex-col text-center text-pink-500"
                                            v-if="proposalMetrics.completedProposals" key="completed">
                                            <span class="font-semibold">
                                                {{ $filters.number(proposalMetrics.completedProposals, 4) }}
                                            </span>
                                            <span class="text-xs">
                                                {{ $t('Completed') }}
                                            </span>
                                        </div>
                                        <div class="w-full h-[1px] md:h-full md:w-[1px] bg-slate-100 relative"
                                            v-if="(proposalMetrics.approvedProposals || proposalMetrics.completedProposals) && proposalMetrics.approvedProposals">
                                            <b
                                                class="absolute hidden px-2 py-1 text-xs text-center text-yellow-500 rounded-full md:inline-block -top-6 -left-10 w-28 bg-slate-800">
                                                {{ $t('Search Metrics') }}
                                            </b>
                                        </div>
                                        <div class="flex flex-col text-center" v-if="proposalMetrics.sumBudgetsUSD" key="sumBudget">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(proposalMetrics.sumBudgetsUSD, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Requested') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center" v-if="proposalMetrics.sumBudgetsADA"
                                            key="proposalMetrics.sumBudgetsADA">
                                            <span class="font-semibold">
                                                ₳{{ $filters.shortNumber(proposalMetrics.sumBudgetsADA, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                ₳ {{ $t('Requested') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-light-500"
                                            v-if="proposalMetrics.sumApprovedUSD" key="sumApproved">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(proposalMetrics.sumApprovedUSD, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Awarded') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-400"
                                            v-if="proposalMetrics.sumDistributedUSD" key="sumDistributed">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(proposalMetrics.sumDistributedUSD, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Distributed') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-light-500"
                                            v-if="proposalMetrics.sumApprovedADA" key="sumAdaApproved">
                                            <span class="font-semibold">
                                                ₳{{ $filters.shortNumber(proposalMetrics.sumApprovedADA, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                ₳ {{ $t('Awarded') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col text-center text-teal-400"
                                            v-if="proposalMetrics.sumDistributedADA" key="sumAdaDistributed">
                                            <span class="font-semibold">
                                                ₳{{ $filters.shortNumber(proposalMetrics.sumDistributedADA, 2) }}
                                            </span>
                                            <span class="text-xs">
                                                ₳ {{ $t('Distributed') }}
                                            </span>
                                        </div>
                                        <!-- <div class="flex flex-col text-center text-pink-500" v-if="proposalMetrics."
                                            key="sumCompleted">
                                            <span class="font-semibold">
                                                ${{ $filters.shortNumber(proposalMetrics., 2) }}
                                            </span>
                                            <span class="text-xs">
                                                $ {{ $t('Completed') }}
                                            </span>
                                        </div> -->
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
import { usePeopleStore } from "@apps/catalyst-explorer/stores/people-store";
import { storeToRefs } from 'pinia';
import { PlayCircleIcon } from '@heroicons/vue/20/solid';
import Sort from "@apps/catalyst-explorer/models/sort";
import Filters from "@/global/models/filters";
import { usePlayStore } from "@/global/stores/play-store";
import { useUserStore } from "@/global/stores/user-store";
import { useProposalsRankingStore } from "@apps/catalyst-explorer/stores/proposals-ranking-store";
import { useProposalsStore } from "@apps/catalyst-explorer/stores/proposals-store";
import { useFiltersStore } from "@/global/stores/filters-stores";
import { useBookmarksStore } from "@apps/catalyst-explorer/stores/bookmarks-store";
import axios from "@/global/utils/axios";
import ProposalFilter from "@apps/catalyst-explorer/modules/proposals/ProposalFilter.vue";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";
import Proposals from "@apps/catalyst-explorer/modules/proposals/Proposals.vue";
import ProposalViewTypes from "@apps/catalyst-explorer/modules/proposals/partials/ProposalViewTypes.vue";
import Search from "@apps/catalyst-explorer/Components/Global/Search.vue";
import Proposal from '../models/proposal';
import { Head, usePage } from '@inertiajs/vue3';
import page from '@/global/utils/page';

/// props and class properties
const props = withDefaults(
    defineProps<{
        search?: string,
        filters: Filters,
        sorts?: Sort[],
        sort?: string,
        currPage?: number,
        perPage?: number,
        locale: string,
        metrics: {
            sumApprovedUSD: number,
            sumApprovedADA: number,
            sumBudgetsUSD: number,
            sumBudgetsADA: number,
            sumDistributedADA: number,
            sumDistributedUSD: number,
            submittedProposals: number,
            approvedProposals: number,
            completedProposals: number,
        },
        filterCounts: {
            tagsCount: []
            fundsCount: []
            challengesCount: []
        },
        proposals: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Proposal[]
        },
        budgets:[]
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
let filtersRef = ref(props.filters);
let selectedSortRef = ref(props.sort);
let filterRenderKey = ref(0);
let searchRender = ref(0);
let currPageRef = ref(props.currPage);
let perPageRef = ref(props.perPage);

let preparingDownload = ref<boolean>(false);
let selectedDownloadFormat = ref(null);

let viewPlayer = computed(
    () => props.proposals?.data.length < 36 && props.proposals?.data.length > 0 && viewType.value == 'quickpitch'
);

// metrics count
let metricCountApproved = ref<number>(0);
let metricCountTotalPaid = ref<number>(0);
let metricCountCompleted = ref<number>(0);

// metrics Sum
let metricSumApproved = ref<number>(0);
let metricSumDistributed = ref<number>(0);
let metricSumCompleted = ref<number>(0);
let metricSumBudget = ref<number>(0);

// metrics Sum
let metricSumAdaApproved = ref<number>(0);
let metricSumAdaDistributed = ref<number>(0);
let metricSumAdaCompleted = ref<number>(0);
let metricSumAdaBudget = ref<number>(0);

////
// computed properties
////
/**
 * assert that every property on props.filters is truthy.
 */
const filtering = computed(() => {
    return getFiltering();
});

let showFilters = ref();
if (window.innerWidth <= 640) {
    showFilters.value = false;
} else {
    showFilters.value = true;
}

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
const { currentModel } = storeToRefs(filterStore);
const { canFetch } = storeToRefs(filterStore);

let quickpitchingRef = ref<boolean>(false);
let rankedViewingRef = ref<boolean>(false);
let cardViewingRef = ref<boolean>(false);

const bookmarksStore = useBookmarksStore();
bookmarksStore.loadCollections();

filterStore.setModel({
    data: props.proposals,
    filters: props.filters,
    sorts: selectedSortRef.value,
    search: search.value,
    model_type: 'proposal',
    props: {
        metrics: props.metrics,
        filterCounts: props.filterCounts,
        budgets:props.budgets,
    }
})
// getMetrics();

watch([selectedSortRef], () => {
    currPageRef.value = undefined;
    searchRender.value = Math.random();
    canFetch.value = true;
    currentModel.value.sorts = selectedSortRef.value
}, { deep: true });

let proposalMetrics = computed(()=>currentModel.value.props.metrics);
let proposalFilterCounts = computed(()=>currentModel.value.props.filterCounts);

watch([rankedViewingRef], () => {
    if (!selectedSortRef.value?.includes('ranking_total')) {
        selectedSortRef.value = 'ranking_total:desc';
    }
}, { deep: true });

watch([selectedPeople], () => {
    filtersRef.value.people = [...filtersRef.value.people ?? [], ...selectedPeople.value]
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


////
// initializers
////
// filters
function getFiltering() {
    if (props.filters?.cohort) {
        return true;
    } else if (props.filters?.funds?.length ?? 0) {
        return true;
    } else if (props.filters?.challenges?.length ?? 0) {
        return true;
    } else if (props.filters?.tags?.length ?? 0) {
        return true;
    } else if (props.filters?.people?.length ?? 0) {
        return true;
    } else if (props.filters?.groups?.length ?? 0) {
        return true;
    } else if (!!props.filters?.fundingStatus) {
        return true;
    } else if (!!props.filters?.projectStatus) {
        return true;
    }
    return false;
}

async function getMetrics() {
    const params = await filterStore.setParams();

    // get funded count
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/count/paid`, { params })
        .then((res: { data: number; }) => metricCountTotalPaid.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
    // get funded count
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/count/approved`, { params })
        .then((res: { data: number; }) => metricCountApproved.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
    // get completed count
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/count/completed`, { params })
        .then((res: { data: number; }) => metricCountCompleted.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });

    // get funded sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/approved`, { params })
        .then((res: { data: number; }) => metricSumApproved.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
    // get funded sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/distributed`, { params })
        .then((res: { data: number; }) => metricSumDistributed.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
    // get funded sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/completed`, { params })
        .then((res: { data: number; }) => metricSumCompleted.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });

    // get requested sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/budget`, { params })
        .then((res: { data: number; }) => metricSumBudget.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });

    // get funded ada sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/approved?currency=ADA`, { params })
        .then((res: { data: number; }) => metricSumAdaApproved.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
    // get funded ada sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/distributed?currency=ADA`, { params })
        .then((res: { data: number; }) => metricSumAdaDistributed.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
    // get funded ada sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/completed?currency=ADA`, { params })
        .then((res: { data: number; }) => metricSumAdaCompleted.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
    // get requested ada sum
    axios.get(`${page.props.ziggy.base_url}/catalyst-explorer/proposals/metrics/sum/budget?currency=ADA`, { params })
        .then((res: { data: number; }) => metricSumAdaBudget.value = res?.data)
        .catch((error: string) => {
            console.error(error);
        });
}

async function download(format: string) {
    preparingDownload.value = true;
    let data = await filterStore.setParams();
    if (format) {
        data['d'] = true;
        data['d_t'] = format;
    }

    const fileName = format == 'excel' ? 'proposals.xlsx' : `proposals.${format}`;
    const res = axios.get(`/${props.locale}/catalyst-explorer/export/proposals`, {
        responseType: 'blob',
        params: data,
    });
    res.then(function (res: { data: BlobPart; }) {
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
