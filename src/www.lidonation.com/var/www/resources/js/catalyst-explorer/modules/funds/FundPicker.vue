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
            @search-change="fundsStore.loadFunds()"
            :searchable="true"
            :options="funds"
            :classes="{
                container: 'multiselect border-0 px-1 py-2 flex-wrap',
                containerActive: 'shadow-none shadow-transparent box-shadow-none',
                tagsSearch: 'w-full absolute top-0 left-0 inset-0 outline-none focus:ring-0 appearance-none custom-input border-0 text-base font-sans bg-white pl-1 rtl:pl-0 rtl:pr-1',
                tag: 'multiselect-tag bg-teal-500 whitespace-normal',
                tags: 'multiselect-tags px-2'
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
        modelValue?: number[]
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
    (e: 'update:modelValue', fund: number[]): void
}>();

watch(selectedRef, (newFund, oldFund) => {
    emit('update:modelValue', newFund);
});
</script>
