<template>
    <div
        class="w-full">
        <Multiselect
            placeholder="Type"
            v-model="selectedRef"
            :options="filters"
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

const props = withDefaults(
    defineProps<{
        modelValue?: string,
        filters: {}
    }>(),
    {},
);
let selectedRef = ref(props.modelValue);

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', type: string): void
}>();

watch(selectedRef, (newType, oldFund) => {
    emit('update:modelValue', newType);
});
</script>
