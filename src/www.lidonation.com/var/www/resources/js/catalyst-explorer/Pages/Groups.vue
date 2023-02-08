<template>
    <header-component titleName0="Catalyst" titleName1="Groups"
                      subTitle="Diverse, independent, and together inspiring the highest level of human collaboration." />

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => search=term"></Search>
<!--                    <div class="h-full">-->
<!--                        <button @click=""-->
<!--                                class="h-full text-xs lg:text-base hover:text-yellow-500 focus:outline-none flex flex-nowrap gap-1 items-center px-0.5 lg:px-2 border border-white border-l-0">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
<!--                                 stroke="currentColor" class="w-4 lg:w-6 w-4 lg:h-6">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round"-->
<!--                                      d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5"/>-->
<!--                            </svg>-->
<!--                            <span>Filters</span>-->
<!--                        </button>-->
<!--                    </div>-->
                </div>
            </div>
        </section>
        <section class="py-8 w-full relative container">
            <!-- Sorts and controls -->
            <div class="flex w-full items-center justify-end mb-3">
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

            <div class="flex flex-row relative w-full">
                <!-- Proposal Filters -->
                <div class="absolute left-0 lg:static z-10 bg-white shadow-lg lg:shadow-0">
                    <button type="button" @click=""
                            class="inline-flex absolute right-0 -top-9 lg:hidden items-center rounded-t-sm border border-transparent bg-teal-600 p-2 text-white hover:bg-teal-700 focus:outline-none focus:ring-0 focus:ring-teal-500 focus:ring-offset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                        </svg>
                    </button>

                    <!-- <ProposalFilter @filter="(payload) => filtersRef = payload"
                                    :filters="filtersRef"
                                    :show-filter="showFilters"></ProposalFilter> -->
                </div>

                <!-- Proposal lists -->
                <div class="flex-1 mx-auto">
                     <Groups :groups="props.groups.data"></Groups>
                </div>
            </div>
        </section>
    </div>


</template>

<script lang="ts" setup>
import { defineComponent, ref } from 'vue';
import { useGroupsStore } from '../stores/groups-store';
import { watch} from "vue";
import Filters from '../models/filters';
import Sort from '../models/sort';
import Group from '../models/group';
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";
import Groups from "../modules/groups/Groups.vue"
import Search from "../Shared/Components/Search.vue";
import Multiselect from '@vueform/multiselect';



const props = withDefaults(
    defineProps<{
        search?: string,
        sorts?: Sort[],
        sort?: string,
        groups: {
            links: [],
            data: Group[]
        }
    }>(), {
        sorts: () => [
            {
                label: 'Alphabetically: A to Z',
                value: 'name:desc',
            },
            {
                label: 'Alphabetically: Z to A',
                value: 'name:asc',
            },
            {
                label: 'Amount Awarded: High to Low',
                value: 'amount_awarded:desc',
            },
            {
                label: 'Amount Awarded: Low to High',
                value: 'amount_awarded:asc',
            },
        ]
    });

// Define a reactive variable for the search value
let search = ref(props.search);
let selectedSortRef = ref<string>(props.sort);


// Watch the search value for changes and trigger the query function
watch([search,selectedSortRef], (something) => {
    query();
}, {deep: true});

// Function to update the data with the new search and selectedsort value
function query() {
    const data = {};
    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }
    if (!!selectedSortRef.value && selectedSortRef.value.length > 3) {
        data[VARIABLES.SORTS] = selectedSortRef.value;
    }

// Perform a GET request to "/catalyst-explorer/people" with the updated data
router.get(
        "/catalyst-explorer/groups",
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
