<template>
    <div class="w-full">
        <p class="mb-3 text-slate-400">Budget Range</p>
        <div class="mb-8">
        <Slider
            :min="1"
            :max="3000000"
            :step="100"
            :format="$filters.currency"
            tooltipPosition="bottom"
            v-model="rangeRef" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import Slider from '@vueform/slider'
import {defineEmits, ref, watch} from "vue";

const props = withDefaults(
    defineProps<{
        modelValue?: number[]
    }>(),
    {
        modelValue: () => ([0, 0])
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
