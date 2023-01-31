<template>
    <div class="w-full">
        <p class="mb-3 text-slate-400">Budget Range</p>
        <div class="mb-8">
        <Slider
            :min="VARIABLES.MIN_BUDGET"
            :max="VARIABLES.MAX_BUDGET"
            :step="500"
            :format="function (value) {
                return `₳${$filters.number(value)}`
            }"
            tooltipPosition="bottom"
            v-model="rangeRef" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import Slider from '@vueform/slider'
import {defineEmits, ref, watch} from "vue";
import {VARIABLES} from "../../models/variables";

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

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', budgets: number[]): void
}>();

watch(rangeRef, (newBudgets, oldFund) => {
    emit('update:modelValue', newBudgets);
});


</script>
