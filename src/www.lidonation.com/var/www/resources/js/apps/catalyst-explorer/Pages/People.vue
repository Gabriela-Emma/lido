<template>
    <header-component titleName0="catalyst" titleName1="proposers"
                      subTitle="Diverse, independent, and together inspiring the highest level of human collaboration" />

    <div class="flex flex-col gap-2 bg-primary-20" v-if="props.users?.data">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => search=term"></Search>
                </div>
            </div>
        </section>

        <section class="container relative w-full py-8">
            <!-- Sorts and controls -->
            <div class="flex items-center justify-end w-full mb-3">
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

            <div :class="{ 'gap-5': showFilters }" class="relative flex flex-row w-full">
                <!-- Proposal Filters -->
                <div class="absolute left-0 z-10 bg-white shadow-lg lg:static lg:shadow-0">
                    <button type="button"
                        class="absolute right-0 inline-flex items-center p-2 text-white bg-teal-600 border border-transparent rounded-t-sm -top-9 lg:hidden hover:bg-teal-700 focus:outline-none focus:ring-0 focus:ring-teal-500 focus:ring-offset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <PeopleFilter @filter="(payload) => filtersRef = payload"
                        @reRenderFilter="filterRenderKey = Math.random()"
                        @clearSearch="search = ''"
                        :filters="filtersRef"
                        :funds="props.funds"
                        :search="search" 
                        :show-filter="showFilters" 
                        :key="filterRenderKey"/>
                </div>

                <!-- Proposal lists -->
                <div class="flex-1 mx-auto">

                    <PeopleList :users="currentModel?.data?.data" />
        
                    <div class="flex-1 pb-16 container">
                        <Pagination :links="currentModel.data.links" :per-page="perPageRef"
                                :total="currentModel.data.total" :from="currentModel.data.from" :to="currentModel.data.to"
                                @perPageUpdated="(payload:number) => perPageRef = payload"
                                @paginated="(payload) => currPageRef = payload" />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import {computed, ref, watch} from "vue";
import Multiselect from '@vueform/multiselect';
import Search from "@apps/catalyst-explorer/Components/Global/Search.vue";
import Sort from "@apps/catalyst-explorer/models/sort";
import Filters from "@/global/models/filters";
import {router} from "@inertiajs/vue3";
import User from "@/global/models/user";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import PeopleList from "@apps/catalyst-explorer/modules/people/PeopleList.vue";

import { storeToRefs } from 'pinia';
import {useFiltersStore} from "@/global/stores/filters-stores";
import ProposalFilter from "@apps/catalyst-explorer/modules/proposals/ProposalFilter.vue";
import PeopleFilter from "@apps/catalyst-explorer/modules/people/PeopleFilter.vue";
import {useFundsStore} from "@apps/catalyst-explorer/stores/funds-store";
import Fund from "@apps/catalyst-explorer/models/fund";

const props = withDefaults(
    defineProps<{
        search?: string,
        funds: Fund[],
        filters: Filters,
        sorts?: Sort[],
        sort?: string,
        currPage?: number,
        perPage?: number,
        locale?: string,
        users: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: User[]
        }
    }>(), {
        sorts: () => [
            {
                label: 'Alphabetically: A to Z',
                value: 'name:asc',
            },
            {
                label: 'Alphabetically: Z to A',
                value: 'name:desc',
            },
            {
                label: 'Amount Awarded Ada: High to Low',
                value: 'amount_awarded_ada:desc',
            },
            {
                label: 'Amount Awarded Ada: Low to High',
                value: 'amount_awarded_ada:asc',
            },
            {
                label: 'Amount Awarded USD: High to Low',
                value: 'amount_awarded_usd:desc',
            },
            {
                label: 'Amount Awarded USD: Low to High',
                value: 'amount_awarded_usd:asc',
            },
        ]
    });

// Define a reactive variable for the search value
let search = ref(props.search);
let filtersRef = ref(props.filters);
let selectedSortRef = ref(props.sort);
let filterRenderKey = ref(0);
let searchRender = ref(0);
let currPageRef = ref(props.currPage);
let perPageRef = ref(props.perPage);

const filtering = computed(() => {
    return getFiltering();
});

let showFilters = ref(getFiltering() || true);

const filterStore = useFiltersStore();
const { currentModel, canFetch } = storeToRefs(filterStore);

filterStore.setModel({
    data: props.users,
    filters: props.filters,
    sorts: selectedSortRef.value,
    search: search.value,
    model_type: 'people',
})

watch([currPageRef, perPageRef], () => {
    filtersRef.value.currentPage = currPageRef.value;
    filtersRef.value.perPage = perPageRef.value;
}, { deep: true });


watch([selectedSortRef, filtersRef], () => {
    searchRender.value = Math.random();
    canFetch.value = true;
    currentModel.value.filters = filtersRef.value;
    currentModel.value.sorts = selectedSortRef.value;
}, { deep: true });

////
// initializers
////
// filters
function getFiltering() {
   if (props.filters?.funds?.length ?? 0 ) {
        return true;
    } else if (props.filters?.tags?.length ?? 0 ) {
        return true;
    }

    return false;
}
</script>
