<template>
    <header-component titleName0="catalyst" titleName1="groups"
        subTitle="Diverse, independent, and together inspiring the highest level of human collaboration" />

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search :search="search" @search="(term) => search = term"></Search>
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
        <section class="relative w-full py-8 " >
            <!-- Sorts and controls -->
            <div class="flex items-center justify-end w-full mb-3 lg:pr-16" >
                <div class="text-xs w-[240px] lg:w-[320px] lg:text-base " :class="{ 'mr-2': !showFilters }">
                    <Multiselect placeholder="Sort" value-prop="value" label="label" v-model="selectedSortRef"
                        :options="sorts" :classes="{
                            container: 'multiselect border-0 p-0.5 flex-wrap',
                            containerActive: 'shadow-none shadow-transparent box-shadow-none',
                        }" />
                </div>
            </div>

            <!-- Groups lists -->
            <div  class="relative flex flex-row w-full" :class="{ 'gap-5': showFilters }">
                <div class="absolute left-0 z-10 bg-white shadow-lg lg:static lg:shadow-0">
                    <button type="button" @click="showFilters = !showFilters"
                        class="absolute right-0 inline-flex items-center p-2 text-white bg-teal-600 border border-transparent rounded-t-sm -top-9 lg:hidden hover:bg-teal-700 focus:outline-none focus:ring-0 focus:ring-teal-500 focus:ring-offset-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <GroupFilters :show-filter="showFilters" />
                </div>
                <div class="flex-1 mx-auto"
                    :class="{ 'lg:pr-16 opacity-10 lg:opacity-100': showFilters, 'container': !showFilters }">

                    <Groups :groups="currentModel?.data?.data"></Groups>
                    <div class="flex items-start justify-between w-full gap-16 my-16 xl:gap-24"
                        v-if="currentModel?.data?.data">
                        <div class="flex-1">
                            <Pagination :links="currentModel.data.links" :per-page="props.perPage"
                                :total="currentModel.data.total" :from="currentModel.data.from" :to="currentModel.data.to"
                                @perPageUpdated="(payload) => perPageRef = payload"
                                @paginated="(payload) => currPageRef = payload" />
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { watch } from "vue";
import Sort from '../models/sort';
import Group from '../models/group';
import { router } from "@inertiajs/vue3";
import { VARIABLES } from "../models/variables";
import Groups from "../modules/groups/Groups.vue"
import Search from "../Shared/Components/Search.vue";
import Multiselect from '@vueform/multiselect';
import Pagination from "../Shared/Components/Pagination.vue";
import { useFiltersStore } from '../../global/Shared/store/filters-stores';
import { storeToRefs } from 'pinia';
import GroupFilters from '../modules/groups/GroupFilters.vue'
import Filters from "../models/filters";


const props = withDefaults(
    defineProps<{
        search?: string,
        sorts?: Sort[],
        sort?: string,
        currPage?: number,
        perPage?: number,
        filters?:Filters
        groups: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Group[]
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
let selectedSortRef = ref<string>(props.sort);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);
const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const { canFetch } = storeToRefs(filterStore);

filterStore.setModel({
    data: props.groups,
    filters:props.filters,
    sorts: selectedSortRef.value,
    search: search.value,
    model_type: 'group'
})

let showFilters = ref(false);
let filtering = ref(false);

// Watch the search value for changes and trigger the query function
watch([selectedSortRef], (newValue, oldValue) => {
    currPageRef.value = null;
    canFetch.value = true;
    currentModel.value.sorts = selectedSortRef.value;
}, { deep: true });

</script>
