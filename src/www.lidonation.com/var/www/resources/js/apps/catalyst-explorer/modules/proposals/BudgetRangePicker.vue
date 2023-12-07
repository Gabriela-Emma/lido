<template>
    <div class="w-full">
        <div class="relative">
            <button v-if="showClearRange" @click="resetValues" @mouseenter="clearRange = true"
                @mouseleave="clearRange = false"
                class="absolute right-0 flex items-center gap-1 text-slate-300 hover:text-yellow-500 focus:outline-none">
                <span class="text-xs" v-if="clearRange">clear</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <p class="mb-3 text-slate-400"> {{ $t("Budget") }}</p>
        <div class="mb-8">
            <Slider :min="min ?? VARIABLES.MIN_BUDGET" :max="max ?? VARIABLES.MAX_BUDGET" :step="500" :format="function (value) {
                return `${$filters.shortNumber(value)}`
            }" tooltipPosition="bottom" v-model="rangeRef" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import Slider from '@vueform/slider'
import { defineEmits, ref, watch, onMounted } from "vue";
import { VARIABLES } from "../../models/variables";
import { storeToRefs } from 'pinia';
import { useFiltersStore } from '@/global/stores/filters-stores';

const props = withDefaults(
    defineProps<{
        // @todo why does this complain when assigned a type number
        modelValue?: any[]
    }>(),
    {
        modelValue: () => ([
            VARIABLES.MIN_BUDGET,
            VARIABLES.MAX_BUDGET
        ])
    },
);
let rangeRef = ref(props.modelValue);
let showClearRange = ref(false);
let clearRange = ref(false);
const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const min = parseInt(currentModel.value.filters.budgets[0]) ?? null;
const max = parseInt(currentModel.value.filters.budgets[1]) ?? null;


////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', budgets?: number[]): void
}>();

watch(rangeRef, (newBudgets, oldFund) => {
    emit('update:modelValue', newBudgets);
    if (newBudgets[0] !== VARIABLES.MIN_BUDGET || newBudgets[1] !== VARIABLES.MAX_BUDGET) {
        showClearRange.value = true;
    }
});

onMounted(() => {
    if (rangeRef.value[0] !== VARIABLES.MIN_BUDGET || rangeRef.value[1] !== VARIABLES.MAX_BUDGET) {
        showClearRange.value = true;
    } else {
        showClearRange.value = false;
    }
});

const resetValues = () => {
    rangeRef.value = [VARIABLES.MIN_BUDGET, VARIABLES.MAX_BUDGET];
    showClearRange.value = false;
};
</script>
