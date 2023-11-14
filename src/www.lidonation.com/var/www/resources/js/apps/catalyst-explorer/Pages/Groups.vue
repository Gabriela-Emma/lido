<template>
    <header-component titleName0="catalyst" titleName1="groups"
                      subTitle="Diverse, independent, and together inspiring the highest level of human collaboration"/>

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => (search = term)"></Search>
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

            <!-- Groups lists -->
            <Groups :groups="currentModel?.data?.data"></Groups>

            <div class="flex-1 pb-16 mt-10">
                <Pagination :links="currentModel.data.links"
                            :per-page="props.perPage"
                            :total="currentModel.data.total"
                            :from="currentModel.data.from"
                            :to="currentModel.data.to"
                            @perPageUpdated="(payload) => perPageRef = payload"
                            @paginated="(payload) => currPageRef = payload"
                />
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import {ref} from 'vue';
import {watch} from "vue";
import Multiselect from '@vueform/multiselect';
import { storeToRefs } from 'pinia';
import Sort from "@apps/catalyst-explorer/models/sort";
import {useFiltersStore} from "@/global/stores/filters-stores";
import Search from "@apps/catalyst-explorer/Components/Global/Search.vue";
import Group from "@apps/catalyst-explorer/models/group";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";

const props = withDefaults(
    defineProps<{
        search?: string|null,
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
        search: null,
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
let search = ref(props.search || null);
let selectedSortRef = ref<string|null>(props.sort || null);
let currPageRef = ref<number|null>(props.currPage || null);
let perPageRef = ref<number|null>(props.perPage || null);
const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const { canFetch } = storeToRefs(filterStore);

filterStore.setModel({
    data: props.groups,
    sorts: selectedSortRef.value,
    search: search.value,
    model_type: 'group'
})

// Watch the search value for changes and trigger the query function
watch([ selectedSortRef], (newValue,oldValue) => {
    currPageRef.value = null;
    canFetch.value = true;
    currentModel.value.sorts = selectedSortRef.value;
}, {deep: true});
</script>
