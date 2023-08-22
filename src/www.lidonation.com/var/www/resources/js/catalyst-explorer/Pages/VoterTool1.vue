<template>
    <header-component titleName0="catalyst" titleName1="Voter Tool"
        subTitle="All Votes must be submitted in the official Catalyst Voting App. This is a research & planning tool only!" />

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="container py-8">
            <div class="flex flex-col ">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search :search="search" :key="searchRender" @search="(term) => search = term"></Search>
                </div>
                <div class="my-6">
                    <div class="flex-1">
                        <Pagination :links="props.filters?.links" :per-page="props.perPage" :total="props.filters?.total"
                            :from="props.filters?.from" :to="props.filters?.to"
                            @paginated="(payload) => currFilterGroupRef = payload" :custom="true"/>
                    </div>
                    <VoterToolFilters @filter="(filter) => filterRef = filter" :filterGroups="props.filters?.data" />
                </div>
            </div>
        </section>

        <TransitionChild appear :show="!!props.proposals?.data.length" enter="ease-out duration-700">
            <section class="container" v-if="!!props.proposals?.data.length">
                <Proposals :proposals="props.proposals?.data"></Proposals>
                <div class="flex items-start justify-between w-full gap-16 my-16 xl:gap-24">
                    <div class="flex-1">
                        <Pagination :links="props.proposals?.links" :per-page="props.perPage"
                            :total="props.proposals?.total" :from="props.proposals?.from" :to="props.proposals?.to"
                            @perPageUpdated="(payload) => perPageRef = payload"
                            @paginated="(payload) => currPageRef = payload" />
                    </div>
                </div>
            </section>
        </TransitionChild>

        <section class="container">
            <h2 class="mt-6 text-4xl">
                Challenges in {{ fund.label }}
            </h2>
            <p>The community was asked to provide solutions to these challenges</p>

            <div class="grid grid-cols-1 gap-3 mt-5 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3 lg:gap-6">
                <ChallengeCard v-for="challenge in challenges" :challenge="challenge" :fund="fund" />
            </div>
        </section>
    </div>
    <main class="container relative z-20 catalyst-proposals-research-wrapper">

    </main>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import Search from '../Shared/Components/Search.vue';
import Proposal from '../models/proposal';
import Proposals from '../modules/proposals/Proposals.vue';
import Pagination from '../Shared/Components/Pagination.vue';
import { VARIABLES } from '../models/variables';
import { router } from '@inertiajs/vue3';
import Fund from '../models/fund';
import ChallengeCard from "../modules/voterTool/ChallengeCard.vue"
import VoterToolFilters from '../modules/voterTool/VoterToolFilters.vue'
import FilterGroups from '../models/filter-groups';

const props = withDefaults(
    defineProps<{
        search?: string,
        currPage?: number,
        currFilterGroup?: number,
        filterPerPage?: number,
        perPage?: number,
        locale: string,
        challenges: Fund[],
        fund: Fund,
        filters: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: FilterGroups[]
        }
        proposals?: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Proposal[]
        };
    }>(), {});

let searchRender = ref(0);

let search = ref(props.search);
let currPageRef = ref<number>(props.currPage);
let currFilterGroupRef = ref<number>(props.currFilterGroup);
let filterPerPageRef = ref<number>(props.filterPerPage);
let perPageRef = ref<number>(props.perPage);
let filterRef = ref(null);

// Watch the search value for changes and trigger the query function
watch([search, filterRef], () => {
    currPageRef.value = null;
    query();
}, { deep: true });

watch([currPageRef, perPageRef], () => {
    query();
});

watch([currFilterGroupRef, filterPerPageRef], () => {
    query();
});

// Function to update the data with the new search and selectedsort value
function query() {
    const data = {};
    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }
    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }
    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }
    if (filterRef.value) {
        data[VARIABLES.FILTER_GROUP] = filterRef.value;
    }

    if (currFilterGroupRef.value) {
        data[VARIABLES.CURRENT_FILTER_GROUPS] = currFilterGroupRef.value;
    }

    if (filterPerPageRef.value) {
        data[VARIABLES.FILTER_GROUPS_PER_PAGE] = filterPerPageRef.value;
    }

    router.get(
        "/catalyst-explorer/voter-tool",
        data,
        { preserveState: true, preserveScroll: !currPageRef.value }
    );

    //@ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_GROUPS, 0);
    }

}
let isSelected = (t) => {
    return t
}

let $id = (t) => {
    return t
}
</script>