<template>
    <transition enter-active-class="transition duration-100 ease-out" enter-from-class="translate-y-1 opacity-0"
        enter-to-class="translate-y-0 opacity-100" leave-active-class="transition duration-100 ease-in"
        leave-from-class="translate-y-0 opacity-100" leave-to-class="translate-y-1 opacity-0">
        <div class="bg-primary-10  w-[260px] relative" v-if="showFilter !== false">
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
                    <li class="p-4">
                        <BudgetRangePicker v-model="currentModel.filters.budgets" />
                    </li>
                    <li class="p-4">
                        <p class="mb-3 text-slate-400">{{ $t("Funding Status") }}</p>
                        <Toggle onLabel="Funded Proposals" offLabel="All Proposals" v-model="currentModel.filters.funded"
                            :classes="{
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
                    <li>
                        <Picker v-model:funds="currentModel.filters.funds" :customize-ui="{
                            'label': 'title',
                            'placeholder': 'Funding Round(s)'
                        }" />
                    </li>
                    <li class="">
                        <Picker v-model:tags="currentModel.filters.tags" :customize-ui="{
                            'label': 'title',
                            'placeholder': 'Limit to Tag(s)'
                        }" />
                    </li>
                </ul>
            </div>
        </div>
    </transition>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useFiltersStore } from '../../../global/Shared/store/filters-stores';
import Picker from '../../Shared/Components/Picker.vue';
import BudgetRangePicker from '../proposals/BudgetRangePicker.vue';
import Toggle from '@vueform/toggle/src/Toggle';
import { ref, watch } from 'vue';

const props = defineProps<{
    showFilter: boolean,
}>()

let showClearAll = ref(false);
let clearFilters = () => {
    canFetch.value = true;
    currentModel.value.filters = [];
}

const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const { canFetch } = storeToRefs(filterStore);

watch([currentModel.value.filters],() => {
    canFetch.value = true;
},{deep:true})
</script>