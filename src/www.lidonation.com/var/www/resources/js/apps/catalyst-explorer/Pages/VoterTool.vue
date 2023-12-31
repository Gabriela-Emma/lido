<template>
    <Head title="Project Catalyst Voter Tool" />

  <header-component titleName0="catalyst" titleName1="Voter Tool"
                    subTitle="All Votes must be submitted in the official Catalyst Voting App. This is a research & planning tool only!"/>

  <main class="flex flex-col gap-2 bg-primary-20 bottom-8">
    <section class="container">
      <div class="flex flex-col py-8">
        <div class="flex items-center w-full h-10 lg:h-16">
          <Search :search="search" :key="searchRender" @search="(term) => search = term"></Search>
        </div>
        <div class="my-6">
          <div class="flex-1">

            <Pagination :links="props.filters?.links" :per-page="props.perPage" :total="props.filters?.total"
                        :from="props.filters?.from" :to="props.filters?.to"
                        @paginated="(payload) => currFilterGroupRef = payload" :custom="true"/>
          </div>
          <VoterToolFilters @filter="(filter) => filterRef = filter" :filterGroups="props.filters?.data"
                            :_filter="currentFilter"/>
        </div>
      </div>
    </section>

    <section class="container" v-if="!!props.proposals?.data.length">
      <div class="justify-items-end">
        <h2 v-if="currentChallenge?.label">
          Viewing Proposals in {{ currentChallenge.label }}
        </h2>
        <button type="button" @click="resetFilters"
                class="flex items-center justify-center gap-2 px-2 py-2 mb-6 ml-auto text-sm font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm md:gap-3 md:px-3 md:text-lg 2xl:text-xl hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
          Reset Filters
        </button>
      </div>

      <Proposals :proposals="props.proposals?.data"></Proposals>

      <div class="flex items-start justify-between w-full gap-16 my-16 xl:gap-24">
        <div class="flex-1">
          <Pagination :links="props.proposals?.links" :per-page="props.perPage" :total="props.proposals?.total"
                      :from="props.proposals?.from" :to="props.proposals?.to"
                      @perPageUpdated="(payload) => perPageRef = payload"
                      @paginated="(payload) => currPageRef = payload"/>
        </div>
      </div>
    </section>

    <section class='container my-16'>
      <BrowseByTaxonomy :taxonomy="'Tag'" :selected-id="taxonomyRef == 'Tag' ? selectedId : null"
                        @taxonomy="(payload) => taxonomyRef = payload"
                        @taxon="(payload) => tagsFilterRef = payload"/>

    </section>

    <section class="container mb-16">
      <h2 class="mt-6 text-4xl">
        Browse By Challenge in {{ fund.label }}
      </h2>
      <p>The community was asked to provide solutions to these challenges</p>

      <div class="grid grid-cols-1 gap-3 mt-5 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3 lg:gap-6 ">
        <ChallengeCard v-for="challenge in challenges" :challenge="challenge" :fund="fund"
                       @challenge="($e) => challengeFilterRef = $e"/>
      </div>
    </section>

    <section class='container mb-16'>
      <BrowseByTaxonomy :taxonomy="'Category'" :selected-id="taxonomyRef == 'Category' ? selectedId : null"
                        @taxonomy="(payload) => taxonomyRef = payload"
                        @taxon="(payload) => categoriesFilterRef = payload"/>
    </section>
  </main>
</template>

<script setup lang="ts">
import {computed, onBeforeUnmount, onMounted, ref, watch} from 'vue';
import {Head, router} from '@inertiajs/vue3';
import Fund from "@apps/catalyst-explorer/models/fund";
import FilterGroups from "@apps/catalyst-explorer/models/filter-groups";
import Proposal from "@apps/catalyst-explorer/models/proposal";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import {useProposalsStore} from "@apps/catalyst-explorer/stores/proposals-store";
import VoterToolFilters from "@apps/catalyst-explorer/modules/voterTool/VoterToolFilters.vue";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";
import BrowseByTaxonomy from "@apps/catalyst-explorer/modules/voterTool/BrowseByTaxonomy.vue";
import Proposals from "@apps/catalyst-explorer/modules/proposals/Proposals.vue";
import ChallengeCard from "@apps/catalyst-explorer/modules/voterTool/ChallengeCard.vue";
import Search from "@apps/catalyst-explorer/Components/Global/Search.vue";

const props = withDefaults(
    defineProps<{
      search?: string,
      currPage?: number,
      currFilterGroup?: number,
      filterPerPage?: number,
      perPage?: number,
      currentFilter?: string | null,
      challengeFilter?: number,
      challenges: Fund[],
      tagsFilter?: number | null,
      categoriesFilter?: number | null,
      fund?: Fund | null,
      filters: {
        links?: any [],
        total: number,
        to: number,
        from: number,
        data: FilterGroups[]
      }
      proposals?: {
        links?: [],
        total: number,
        to: number,
        from: number,
        data: Proposal[]
      };
    }>(), {
      search: '',
      currPage: 1,
      perPage: 24,
      locale: 'en',
      fund: null
    });

const currentChallenge = computed(() => {
  return props?.challenges.find(challenge => challenge?.id === props?.challengeFilter);
})
const selectedId = computed(() => {
  if (taxonomyRef.value == 'Tag') {
    return tagsFilterRef.value;
  } else {
    return categoriesFilterRef.value
  }
})

let searchRender = ref(0);
let search = ref(props.search);
let currPageRef = ref<number>(props.currPage);
let currFilterGroupRef = ref<number>(props.currFilterGroup);
let filterPerPageRef = ref<number>(props.filterPerPage);
let challengeFilterRef = ref<number>(props.challengeFilter);
let perPageRef = ref<number>(props.perPage);
let filterRef = ref(props.currentFilter);
let taxonomyRef = ref<string>(null);
let tagsFilterRef = ref<number>(props.tagsFilter);
let categoriesFilterRef = ref<number>(props.categoriesFilter);
const proposalStore = useProposalsStore();
proposalStore.viewType = 'card';

let handleResize = () => {
  proposalStore.viewType = 'card';
  if (window.innerWidth <= 640) {
    filterPerPageRef.value = 2;
    query();
  } else if (window.innerWidth <= 1024 && window.innerWidth > 640) {
    filterPerPageRef.value = 3;
    query();
  } else {
    filterPerPageRef.value = 4;
    query();
  }
}

watch([search, filterRef], () => {
  query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
  query();
});

watch([currFilterGroupRef, filterPerPageRef], () => {
  query();
});

watch([tagsFilterRef, categoriesFilterRef], () => {
  filterRef.value = null;
  search.value = null;
  challengeFilterRef.value = null;
  query();
});

watch([challengeFilterRef], () => {
  filterRef.value = null;
  search.value = null;
  query();
});

async function query() {
  const data = {};
  proposalStore.viewType = 'card'
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

  if (taxonomyRef.value == 'Tag') {
    data[VARIABLES.TAGS] = tagsFilterRef.value;
  }

  if (taxonomyRef.value == 'Category') {
    data[VARIABLES.CATEGORY] = categoriesFilterRef.value;
  }

  router.get(
      "/catalyst-explorer/voter-tool",
      data,
      {preserveState: true, preserveScroll: !challengeFilterRef.value && !taxonomyRef.value}
  );

  //@ts-ignore
  if (typeof window?.fathom !== 'undefined') {
    // @ts-ignore
    window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_GROUPS, 0);
  }
}

function resetFilters() {
  search.value = '';
  filterRef.value = null;
  currPageRef.value = null;
  perPageRef.value = props.perPage;
  currFilterGroupRef.value = null;
  challengeFilterRef.value = null;
  categoriesFilterRef.value = null
  tagsFilterRef.value = null;
  taxonomyRef.value = null;
  query();
}

onMounted(() => {
  window.addEventListener('resize', handleResize);
  handleResize();
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize);
});
</script>
