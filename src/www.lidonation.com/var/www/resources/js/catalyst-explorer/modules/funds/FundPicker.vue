<style scoped lang="scss">
.proposal-drip {
    .drip-content p {
        @apply mt-0 inline;
        display: inline;
    }
}
</style>
<template>
    <div
        class="w-full">
        <Multiselect
            v-model="selectedRef"
            value-prop="id"
            label="title"
            mode="tags"
            placeholder="Limit to Funds"
            :loading="funds.length <= 0"
            :options="funds"
            :classes="{
                container: 'multiselect border-0 px-1 py-2',
                containerActive: 'shadow-none shadow-transparent box-shadow-none',
                tag: 'multiselect-tag bg-teal-500',
            }"
        />
    </div>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import {defineEmits, ref, watch} from "vue";
import {useFundsStore} from "../../stores/funds-store";
import {storeToRefs} from "pinia";
import Fund from "../../models/fund";

const props = withDefaults(
    defineProps<{
        modelValue?: Fund
    }>(),
    {},
);
let selectedRef = ref(props.modelValue);
const fundsStore = useFundsStore();
const {funds} = storeToRefs(fundsStore);

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', fund: Fund): void
}>();

watch(selectedRef, (newFund, oldFund) => {
    emit('update:modelValue', newFund);
});
</script>
