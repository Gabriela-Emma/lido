<template>
    <div class="w-full" v-if="!customOptions">
        <Multiselect
            :placeholder="customizeUi.placeholder"
            noOptionsText="Try typing more chars"
            noResultsText="Try typing more chars"
            v-model="selectedRef"
            value-prop="id"
            :label="customizeUi.label"
            mode="tags"
            @search-change=" currentInstance.store.search($event)"
            :minChars="3"
            @open = "currentInstance.store.load(selectedRef)"
            :options="currentInstance.options"
            :searchable="true"
            :closeOnSelect="false"
            :track-by = "customizeUi.label"
            :classes="{
                container: 'multiselect border-0 px-1 py-2 flex-wrap',
                containerActive: 'shadow-none shadow-transparent box-shadow-none',
                tagsSearch: 'w-full absolute top-0 left-0 inset-0 outline-none focus:ring-0 appearance-none custom-input border-0 text-base font-sans bg-white pl-1 rtl:pl-0 rtl:pr-1',
                tag: 'multiselect-tag bg-teal-500 whitespace-normal',
                tags: 'multiselect-tags px-2'
            }" />
    </div>

    <div v-else class="w-full">
        <Multiselect
        :placeholder="customizeUi.placeholder"
        v-model="selectedRef"
        :options="customOptions"
        :track-by="customizeUi.label"
        :searchable="true"
        :classes="{
                container: 'multiselect border-0 px-1 py-2 flex-wrap',
                containerActive: 'shadow-none shadow-transparent box-shadow-none',
                tagsSearch: 'w-full absolute top-0 left-0 inset-0 outline-none focus:ring-0 appearance-none custom-input border-0 text-base font-sans bg-white pl-1 rtl:pl-0 rtl:pr-1',
                tag: 'multiselect-tag bg-teal-500 whitespace-normal',
                tags: 'multiselect-tags px-2'
            }" />
    </div>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import { computed, ref, watch } from "vue";
import { StoreGeneric, storeToRefs } from "pinia";
import {useFiltersStore} from "@/global/stores/filters-stores";
import {useTagsStore} from "@apps/catalyst-explorer/stores/tags-store";
import {usePeopleStore} from "@apps/catalyst-explorer/stores/people-store";
import {useChallengesStore} from "@apps/catalyst-explorer/stores/challenges-store";
import {useGroupsStore} from "@apps/catalyst-explorer/stores/groups-store";
import {useFundsStore} from "@apps/catalyst-explorer/stores/funds-store";

const props = withDefaults(
    defineProps<{
        type?: string
        fundingStatus?: string
        groups?: number[]
        people?: number[]
        status?: string
        projectStatus?: string
        cohort?:string
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
const peopleStore = usePeopleStore();
const challengesStore = useChallengesStore();
const groupsStore = useGroupsStore();
const fundsStore = useFundsStore();
const filterStore = useFiltersStore();
const { currentModel } = storeToRefs(filterStore);
const {canFetch} = storeToRefs(filterStore);

const stores = {
    'groups': groupsStore,
    'people': peopleStore,
}

interface CurrentInstance {
    selectedRef: string | number[]
    store: StoreGeneric
    options: [] | {}
}

let excludedKeys = ref(['customOptions', 'customizeUi']);
let propKeys = ref(Object.keys(props).filter(key => !excludedKeys.value.includes(key)))
let propName = ref(propKeys.value.find((key:string) => props[key]!= null));
let selectedRef = ref(props[propName.value])


const currentInstance = computed(() => {
    let instance = {} as CurrentInstance;
    instance.selectedRef = selectedRef.value;

    if (!props.customOptions) {
        instance.store = stores[propName.value];
        instance.options = storeToRefs(instance.store)[propName.value].value
    } else {
        instance.store = stores[propName.value] ;
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

watch(currentModel.value, (oldValue,newValue) => {
    selectedRef.value = newValue.filters[`${propName.value}`]
});

</script>
