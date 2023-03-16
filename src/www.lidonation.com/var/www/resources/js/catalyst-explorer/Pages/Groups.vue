<template>
    <header-component titleName0="catalyst" titleName1="groups"
                      subTitle="Diverse, independent, and together inspiring the highest level of human collaboration"/>

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => search=term"></Search>
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

            <!-- Groups lists -->
            <Groups :groups="props.groups.data"></Groups>

            <div class="flex-1 pb-16 mt-10">
                <Pagination :links="props.groups.links"
                            :per-page="props.perPage"
                            :total="props.groups?.total"
                            :from="props.groups?.from"
                            :to="props.groups?.to"
                            @perPageUpdated="(payload) => perPageRef = payload"
                            @paginated="(payload) => currPageRef = payload"/>
            </div>
        </section>
    </div>


</template>

<script lang="ts" setup>
import {ref} from 'vue';
import {watch} from "vue";
import Sort from '../models/sort';
import Group from '../models/group';
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";
import Groups from "../modules/groups/Groups.vue"
import Search from "../Shared/Components/Search.vue";
import Multiselect from '@vueform/multiselect';
import Pagination from "../Shared/Components/Pagination.vue";


const props = withDefaults(
    defineProps<{
        search?: string,
        sorts?: Sort[],
        sort?: string,
        currPage?: number,
        perPage?: number,
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
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);

// Watch the search value for changes and trigger the query function
watch([search, selectedSortRef], () => {
    currPageRef.value = null;
    query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
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
    if (!!selectedSortRef.value && selectedSortRef.value.length > 3) {
        data[VARIABLES.SORTS] = selectedSortRef.value;
    }

    router.get(
        "/catalyst-explorer/groups",
        data,
        {preserveState: true, preserveScroll: !currPageRef.value}
    );

    //@ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_GROUPS, 0);
    }

}

</script>
