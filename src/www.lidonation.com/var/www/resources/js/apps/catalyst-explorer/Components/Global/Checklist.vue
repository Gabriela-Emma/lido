<template>
    <div class="flex-wrap px-2 pb-2 overflow-scroll max-h-96">
        <div class="border-t"></div>
        <p class="sticky top-0 w-full pl-3 mb-3 text-gray-400 bg-white py-2">Limit to {{ propName }}</p>
        <TransitionRoot :show="!!currentInstance.options.length" enter-active-class="transition duration-300 ease-out" enter-from-class="transform scale-95 opacity-0"
            enter-to-class="duration-75 transform scale-100 opacity-300" leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
            <div class="flex items-center mb-4 ml-2" v-for="item in currentInstance.options">
                <input id="default-checkbox" type="checkbox" :value="item.id" v-model="selectedRef"
                    class="w-4 h-4 text-teal-500 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 ">
                <label for="default-checkbox" class="font-medium text-gray-900 ms-2">
                    {{ item[customizeUi.label] }}
                </label>
            </div>
        </TransitionRoot>
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
