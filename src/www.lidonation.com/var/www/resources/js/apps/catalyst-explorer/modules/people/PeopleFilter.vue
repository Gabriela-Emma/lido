<template>
    <div class="bg-white h-auto w-[260px] relative">
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
                    <Toggle onLabel="Funded Proposals" offLabel="All Proposals" v-model="filters.funded" :classes="{
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
                    <BudgetRangePicker v-model="filters.budgets" />
                </li>
                <li class="">
                    <Picker v-model:funds="filters.funds"
                    :customize-ui="{
                        'label': 'title',
                        'placeholder' : 'Limit to Fund(s)'
                    }"/>
                </li>
                <li class="">
                    <Picker v-model:tags="filters.tags"
                    :customize-ui="{
                        'label': 'title',
                        'placeholder': 'Limit to Tag(s)'
                    }"/>
                </li>
            </ul>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { Ref, ref, watch, defineEmits, computed } from "vue";
import Toggle from '@vueform/toggle';
import {useFiltersStore} from "@/global/stores/filters-stores";
import { storeToRefs } from "pinia";
import BudgetRangePicker from "@apps/catalyst-explorer/modules/proposals/BudgetRangePicker.vue";
import Picker from "@apps/catalyst-explorer/Components/Global/Picker.vue";
import Filters from "@apps/catalyst-explorer/models/filters";
import Fund from "@apps/catalyst-explorer/models/fund";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";

const props = withDefaults(
    defineProps<{
        funds?: Fund[],
        filters?: Filters,
        search?: string
        showFilter?: boolean,

    }>(), { showFilter: false });
let showClearAll = ref(false);
let filters:Ref<Filters> = ref(props.filters as Filters);
let search = ref(props.search);

const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const {canFetch} = storeToRefs(filterStore);


const filtering = computed(() => Object.values(props.filters).every(val => !!val) || props.showFilter);

const emit = defineEmits<{
    (e: 'filter', filters: Filters): void,
    (e: 'reRenderFilter'):void,
    (e: 'clearSearch'):void
}>();

watch([filters.value], (newValue, oldValue) => {
    emit('filter', filters.value);
    emit('reRenderFilter');
    emit('clearSearch');
},{});

function clearFilters() {
    filters.value.currentPage = 1 ;
    filters.value.funded = false;
    filters.value.budgets = [0, 4000000];
    filters.value.funds = [];
    search.value = ''
    filters.value.tags = [];
    canFetch.value = true;
    currentModel.value.filters = filters.value;
    currentModel.value.search = search.value;
    canFetch.value = true;
    currentModel.value.search = null;
}

// @ts-ignore
if (typeof window?.fathom !== 'undefined') {
    // @ts-ignore
    window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_PEOPLE, 0);
}
</script>
