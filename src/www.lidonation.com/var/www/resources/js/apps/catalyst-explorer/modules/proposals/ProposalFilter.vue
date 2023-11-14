<template>
    <div class="bg-white w-[260px] relative" v-if="filtering && showFilter !== false">
        <h2 class="relative flex justify-between gap-8 p-4 font-medium border-b flex-nowrap">
            <span>
                {{ $t("Filters") }}
            </span>
            <button @mouseenter="showClearAll = true" @mouseleave="showClearAll = false" @click="clearFilters"
                    class="flex items-center gap-2 text-slate-300 hover:text-yellow-500 focus:outline-none">
                <span class="text-xs" v-if="showClearAll">Clear All</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </h2>
        <div>
            <ul class="border-b divide-y">
                <li class="p-4 ">
                    <p class="mb-3 text-slate-400">{{ $t("Funding Status") }}</p>
                    <Toggle onLabel="Funded Proposals" offLabel="All Proposals" v-model="currentModel.filters['funded']" :classes="{
                        container: 'inline-block rounded-xl outline-none focus:ring focus:ring-teal-500 focus:ring-opacity-30 w-full',
                        toggle: 'flex w-full h-8 rounded-xl relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                        toggleOn: 'bg-teal-500 border-teal-500 justify-start text-white',
                        toggleOff: 'bg-slate-200 border-slate-200 justify-end text-slate-700',
                        handle: 'inline-block bg-white w-8 h-8 top-0 rounded-xl absolute transition-all',
                        handleOn: 'left-full transform -translate-x-full',
                        handleOff: 'left-0',
                        handleOnDisabled: 'bg-slate-100 left-full transform -translate-x-full',
                        handleOffDisabled: 'bg-slate-100 left-0',
                        label: 'text-center w-auto px-2 border-box whitespace-nowrap select-none',
                    }" />
                </li>
                <li class="p-4">
                    <BudgetRangePicker v-model="currentModel.filters.budgets" />
                </li>
                <li class="">
                    <Picker v-model:type="currentModel.filters.type"
                            :customize-ui="{
                        'placeholder': 'Type'
                    }"
                            :custom-options="{
                        p: 'Only Proposals',
                        c: 'Only Challenges',
                        b: 'Both Proposals & Challenges'
                    }" />
                </li>

                <li class="">
                    <Picker v-model:funds="currentModel.filters.funds"
                            :customize-ui="{
                        'label': 'title',
                        'placeholder' : 'Limit to Fund(s)'
                    }"/>
                </li>
                <li class="">
                    <Picker v-model:challenges="currentModel.filters.challenges"
                            :customize-ui="{
                        'label': 'title',
                        'placeholder': 'Limit to Challenge(s)'
                    }"/>
                </li>

                <li class="">
                    <Picker v-model:fundingStatus="currentModel.filters.fundingStatus"
                            :customize-ui="{
                        'placeholder': 'Funding Status'
                    }"
                            :custom-options="{
                        o: 'Over Budget',
                        n: 'Not Approved',
                        f: 'Funded',
                        p: 'Fully Paid'
                    }" />
                </li>

                <li class="">
                    <Picker v-model:tags="currentModel.filters.tags"
                            :customize-ui="{
                        'label': 'title',
                        'placeholder': 'Limit to Tag(s)'
                    }"/>
                </li>

                <li class="">
                    <Picker v-model:groups="currentModel.filters.groups"
                            :customize-ui="{
                        'label': 'name',
                        'placeholder': 'Limit to Group(s)'
                    }"/>
                </li>

                <li class="">
                    <Picker v-model:people="currentModel.filters.people"
                            :customize-ui="{
                        'label': 'name',
                        'placeholder': 'Limit to Person(s)'
                    }"/>
                </li>

                <li class="">
                    <Picker v-model:projectStatus="currentModel.filters.projectStatus "
                            :customize-ui="{
                        'placeholder': 'Project Status'
                    }"
                            :custom-options="{
                        c: 'Complete',
                        i: 'In Progress',
                        u: 'Unfunded',
                        // p: 'Paused'
                    }" />
                </li>

                <li class="p-4 ">
                    <p class="mb-3 text-slate-400">{{ $t("Opensource") }}</p>
                    <Toggle onLabel="Opensource Proposals" offLabel="All Proposals" v-model="currentModel.filters['opensource']" :classes="{
                        container: 'inline-block rounded-xl outline-none focus:ring focus:ring-teal-500 focus:ring-opacity-30 w-full',
                        toggle: 'flex w-full h-8 rounded-xl relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                        toggleOn: 'bg-teal-500 border-teal-500 justify-start text-white',
                        toggleOff: 'bg-slate-200 border-slate-200 justify-end text-slate-700',
                        handle: 'inline-block bg-white w-8 h-8 top-0 rounded-xl absolute transition-all',
                        handleOn: 'left-full transform -translate-x-full',
                        handleOff: 'left-0',
                        handleOnDisabled: 'bg-slate-100 left-full transform -translate-x-full',
                        handleOffDisabled: 'bg-slate-100 left-0',
                        label: 'text-center w-auto px-2 border-box whitespace-nowrap select-none',
                    }" />
                </li>

                <li class="p-4 bg-stone-100">
                    <span class="block text-lg font-medium xl:text-xl">
                        {{ $t("Community Filters") }}
                    </span>
                    <p class="block py-1 mb-2 text-xs border-b">
                        {{ $t("These filters are not based on primary catalyst data but rather self assembled datasets by community groups") }}.
                        {{ $t("noValidation") }}.
                    </p>
                    <Picker v-model:cohort="(currentModel.filters.cohort )"
                            :customize-ui="{'placeholder':'Community Cohort'}"
                            :custom-options="{
                        im: 'Impact Proposals',
                        wo: 'Women Proposals',
                        id: 'Ideafest Proposals',
                        qp: 'Quick Pitches',
                    }" />
                </li>

            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, watch, defineEmits, computed } from "vue";
import Toggle from '@vueform/toggle'
import { storeToRefs } from "pinia";
import {useFiltersStore} from "@/global/stores/filters-stores";
import Filters from "@apps/catalyst-explorer/models/filters";
import Picker from "@apps/catalyst-explorer/Components/Global/Picker.vue";
import BudgetRangePicker from "@apps/catalyst-explorer/modules/proposals/BudgetRangePicker.vue";
import { Ref } from "vue";
import { watchEffect } from "vue";

////
// props and class properties
/////////////////////////////
const props = withDefaults(
    defineProps<{
        search?: string
        filters?: Filters,
        showFilter?: boolean,

    }>(), { showFilter: false });
let showClearAll = ref(false);
let filters:Ref<Filters> = ref(props.filters as Filters);
let search = ref(props.search);

const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const {canFetch} = storeToRefs(filterStore);

////
// computer properties
///////////////////////

/**
 * assert that every property on props.filters is truthy.
 */
const filtering = computed(() => Object.values(props.filters).every(val => !!val) || props.showFilter);


////
// events & watchers
//////////////////////
const emit = defineEmits<{
    (e: 'filter', filters: Filters): void,
    (e: 'reRenderFilter'):void,
    (e: 'clearSearch'):void
}>();

watch([() => currentModel.value.filters.funded, () => currentModel.value.filters.funded], (newValue, oldValue) => {
    canFetch.value = true;
},{immediate:true});

function clearFilters() {
    filters.value.currentPage = 1 ;
    filters.value.funded = false;
    filters.value.opensource = false;
    filters.value.fundingStatus = '';
    filters.value.projectStatus = '';
    filters.value.cohort = '';
    filters.value.type = "p";
    filters.value.budgets = [0, 2000000];
    filters.value.funds = [];
    search.value = ''
    filters.value.challenges = [];
    filters.value.tags = [];
    filters.value.people = [];
    filters.value.groups = [];
    canFetch.value = true;
    currentModel.value.filters = filters.value;
    currentModel.value.search = search.value;
    canFetch.value = true;
    currentModel.value.search = null;
}

</script>
