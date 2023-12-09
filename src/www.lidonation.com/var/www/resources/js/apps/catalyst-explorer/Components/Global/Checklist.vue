<template>
    <div class="flex-wrap px-2 pb-2 overflow-scroll max-h-96">
        <p class="sticky top-0 w-full py-2 pl-3 mb-3 text-gray-400 bg-white">Limit to {{ propName }}</p>
        <TransitionGroup tag="ul" list-enter-active list-leave-active=" transition: all 0.5s ease" list-enter-from
            list-leave-to="">
            <ul class="flex flex-col items-start w-full mx-2 " v-for="(item, index) in currentInstance.options" :key="item[customizeUi.label]">
                <div class="relative flex flex-row items-start justify-start w-full pt-2 pr-2 flex-nowrap hover-cursor-pointer hover:bg-slate-50">
                    <input :id="item[customizeUi.label]" type="checkbox" :value="item.id" v-model="selectedRef"
                        class="w-4 h-4 text-teal-500 bg-gray-100 border-gray-300 rounded focus:ring-teal-500">
                    <label :for="item[customizeUi.label]" class="flex items-start justify-between w-full font-medium text-gray-900 ms-2">
                        {{ item[customizeUi.label] }} <span class="text-gray-600 ">({{ item.count ?? 0 }})</span>
                    </label>
                </div>
                <div class="w-full py-1 pr-2" v-if="index!= currentInstance.options.length-1">
                    <div class="w-full border-t border-gray-200" />
                </div>
            </ul>

            <div v-if="!currentInstance.options.length" class="flex flex-col items-start mb-2 ml-2" v-for="index in 9" :key="index">
                <div class="flex animate-pulse">
                    <div class="h-3 w-3 bg-gray-300  dark:bg-gray-600 mb-2.5 mr-2"></div>
                    <div class="w-32 h-3.5 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
                <div class="w-full py-1">
                    <div class="w-full border-t border-gray-200" />
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref, watch } from "vue";
import { StoreGeneric, storeToRefs } from "pinia";
import { useFiltersStore } from "@/global/stores/filters-stores";
import { useTagsStore } from "@apps/catalyst-explorer/stores/tags-store";
import { useChallengesStore } from "@apps/catalyst-explorer/stores/challenges-store";
import { useFundsStore } from "@apps/catalyst-explorer/stores/funds-store";
import { TransitionChild, TransitionRoot } from "@headlessui/vue";


const props = withDefaults(
    defineProps<{
        funds?: number[]
        challenges?: number[]
        tags?: number[]
        customOptions?: {}
        customizeUi?: {
            label?: string
            placeholder?: string
        }
    }>(),
    {
        customOptions: null,
        customizeUi: null
    },
);

const tagsStore = useTagsStore();
const challengesStore = useChallengesStore();
const fundsStore = useFundsStore();
const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const { canFetch } = storeToRefs(filterStore);

const stores = {
    'funds': fundsStore,
    'tags': tagsStore,
    'challenges': challengesStore
}

interface CurrentInstance {
    selectedRef: string | number[]
    store: StoreGeneric
    options: [] | {}
}

let excludedKeys = ref(['customOptions', 'customizeUi']);
let propKeys = ref(Object.keys(props).filter(key => !excludedKeys.value.includes(key)))
let propName = ref(propKeys.value.find((key: string) => props[key] != null));
let selectedRef = ref(props[propName.value])


const currentInstance = computed(() => {
    let instance = {} as CurrentInstance;
    instance.selectedRef = selectedRef.value;

    if (!props.customOptions) {
        instance.store = stores[propName.value];
        instance.options = storeToRefs(instance.store)[propName.value].value
    } else {
        instance.store = stores[propName.value];
        instance.options = props.customOptions;
    }

    return instance;
})

watch([selectedRef], () => {
    canFetch.value = true;
    currentModel.value.filters[`${propName.value}`] = selectedRef.value
    if (propName.value == 'funds' && selectedRef?.value.length > 0) {
        challengesStore.filterChallenges({
            funds: selectedRef.value
        });
    }
}, { deep: true });

watch(currentModel.value, (oldValue, newValue) => {
    selectedRef.value = newValue.filters[`${propName.value}`]
});

</script>

<style>
.hover-cursor-pointer:hover {
    cursor: pointer;
}
</style>