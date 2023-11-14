<template>
    <div
        class="w-full">
        <Multiselect
            placeholder="Limit to Group(s)"
            noOptionsText="Try typing more chars"
            noResultsText="Try typing more chars"
            v-model="selectedRef"
            value-prop="id"
            label="name"
            mode="tags"
            @search-change="search"
            :minChars="3"
            :options="groups"
            :searchable="true"
            :closeOnSelect="false"
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
import {storeToRefs} from "pinia";
import {useGroupsStore} from "../../stores/groups-store";

const props = withDefaults(
    defineProps<{
        modelValue?: number[]
    }>(),
    {},
);
let selectedRef = ref(props.modelValue);
const groupsStore = useGroupsStore();
const {groups} = storeToRefs(groupsStore);

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', group: number[]): void
}>();

watch(selectedRef, (newGroup, oldFund) => {
    emit('update:modelValue', newGroup);
});

////
// Actions
////////////////
function search(search) {
    groupsStore.search({search})
}
</script>
