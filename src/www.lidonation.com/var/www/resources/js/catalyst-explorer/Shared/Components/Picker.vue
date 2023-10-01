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
            @search-change="propName !== 'funds' ? currentInstance.store.search({ $event }) : currentInstance.store.load({ $event })"
            :minChars="3" 
            :options="currentInstance.options" 
            :searchable="true" 
            :closeOnSelect="false" 
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
import { computed, defineEmits, ref, watch, watchEffect } from "vue";
import { StoreGeneric, storeToRefs } from "pinia";
import { usePeopleStore } from "../../stores/people-store";
import { useTagsStore } from '../../stores/tags-store';
import { useChallengesStore } from '../../stores/challenges-store';
import { useGroupsStore } from '../../stores/groups-store';
import { useFundsStore } from '../../stores/funds-store';
import { useFiltersStore } from '../../../global/Shared/store/filters-stores';
import { Nullable } from 'primevue/ts-helpers';

const props = withDefaults(
    defineProps<{
        funds?: number[]
        challenges?: number[]
        type?: string
        fundingStatus?: string
        tags?: number[]
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
    'funds': fundsStore,
    'groups': groupsStore,
    'people': peopleStore,
    'tags': tagsStore,
    'challenges': challengesStore
}

interface CurrentInstance {
    selectedRef: string | number[]
    store?: StoreGeneric
    options: [] | {}
}

let excludedKeys = ref(['customOptions', 'customizeUi']);
let propKeys = ref(Object.keys(props).filter(key => !excludedKeys.value.includes(key)))
let propName = ref(propKeys.value.find((key) => !!props[key]));
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
}, { deep: true }) 

</script>
