<template>
    <header-component titleName0="catalyst" titleName1="Voter Tool"
        subTitle="All Votes must be submitted in the official Catalyst Voting App. This is a research & planning tool only!" />

    <main class="flex flex-col gap-2 bg-primary-20 bottom-8">
        <section class="container py-8">
            <div class="flex flex-col ">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search :search="search" :key="searchRender" @search="(term) => search = term"></Search>
                </div>
                <div class="my-6">
                    <div class="flex-1">
                        <Pagination :links="props.filters?.links" :per-page="props.perPage" :total="props.filters?.total"
                            :from="props.filters?.from" :to="props.filters?.to"
                            @paginated="(payload) => currFilterGroupRef = payload" :custom="true" />
                    </div>
                    <VoterToolFilters @filter="(filter) => filterRef = filter" :filterGroups="props.filters?.data"
                        :_filter="currentFilter" />
                </div>
            </div>
        </section>

        <section class="container" v-if="!!props.proposals?.data.length">
            <Proposals :proposals="props.proposals?.data"></Proposals>
            <div class="flex items-start justify-between w-full gap-16 my-16 xl:gap-24">
                <div class="flex-1">
                    <Pagination :links="props.proposals?.links" :per-page="props.perPage" :total="props.proposals?.total"
                        :from="props.proposals?.from" :to="props.proposals?.to"
                        @perPageUpdated="(payload) => perPageRef = payload"
                        @paginated="(payload) => currPageRef = payload" />
                </div>
            </div>
        </section>

        <section class="container mb-16">
            <h2 class="mt-6 text-4xl">
                Challenges in {{ fund.label }}
            </h2>
            <p>The community was asked to provide solutions to these challenges</p>

            <div class="grid grid-cols-1 gap-3 mt-5 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3 lg:gap-6 ">
                <ChallengeCard v-for="challenge in challenges" :challenge="challenge" :fund="fund" @challenge="($e) => challengeFilterRef = $e"/>
            </div>
        </section>
    </main>
</template>

<script setup lang="ts">
import { ref, watch, computed } from 'vue';
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
        currentFilter?: string,
        challengeFilter?: number,
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
    }>(), {
});

let searchRender = ref(0);
let search = ref(props.search);
let currPageRef = ref<number>(props.currPage);
let currFilterGroupRef = ref<number>(props.currFilterGroup);
let filterPerPageRef = ref<number>(props.filterPerPage);
let challengeFilterRef = ref<number>(props.challengeFilter);
let perPageRef = ref<number>(props.perPage);
let filterRef = ref(props.currentFilter);
let screenSize = parseInt(localStorage.getItem('screenSize')) ?? null;


if (!screenSize) {
    localStorage.setItem('screenSize', window.innerWidth.toString())
    if (window.innerWidth <= 640) {
        filterPerPageRef.value = 2;
        query();
    } else if (window.innerWidth <= 1024 && window.innerWidth > 640) {
        filterPerPageRef.value = 3;
        query();
    } else {
        filterPerPageRef.value = 7;
        query();
    }
}


// Watch the search value for changes and trigger the query function
watch([search, filterRef], () => {
    query();
}, { deep: true });

watch([currPageRef, perPageRef], () => {
    query();
});

watch([currFilterGroupRef, filterPerPageRef], () => {
    query();
});

watch([challengeFilterRef], () => {
    filterRef.value = null;
    search.value = null;
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

    if (challengeFilterRef.value) {
        data[VARIABLES.CHALLENGES] = challengeFilterRef.value;
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
</script>
