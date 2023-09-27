<template>
    <div class="w-full">
        <Multiselect placeholder="Limit to Person(s)" 
            noOptionsText="Try typing more chars"
            noResultsText="Try typing more chars" 
            v-model="currentInstance.selectedRef" 
            value-prop="id" 
            label="name" 
            mode="tags"
            @search-change="currentInstance.store.search({$event})" 
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

    <div v-if="customOptions"
        class="w-full">
        <Multiselect
            placeholder="Type"
            v-model="currentInstance.selectedRef"
            :options="customOptions"
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
import { computed, defineEmits, ref, watch } from "vue";
import { storeToRefs } from "pinia";
import { usePeopleStore } from "../../stores/people-store";
import { useTagsStore } from '../../stores/tags-store';
import { useChallengesStore } from '../../stores/challenges-store';
import { useGroupsStore } from '../../stores/groups-store';
import { useFundsStore } from '../../stores/funds-store';

const props = withDefaults(
    defineProps<{
        funds?: number[]
        challenges?:number[]
        type?:string
        fundingStatus?:string
        tags?:string[]
        groups?: string[]
        people?: string[]
        status?:string
        customOptions?:{}
        customizeUi?:boolean
    }>(),
    {
        customOptions:null,
        customizeUi:false
    },
);

const tagsStore = useTagsStore();
const { tags } = storeToRefs(tagsStore);
const peopleStore = usePeopleStore();
const challengesStore = useChallengesStore();
const groupsStore = useGroupsStore();
const fundsStore = useFundsStore();

const stores =  {
    'fundsStore': fundsStore,
    'groupsStore' : groupsStore,
    'peopleStore': peopleStore
}


interface CurrentInstance {
    selectedRef:string | number[]
    store?:any
    options:[] | {}
}

let excludedKeys = ['customOptions', 'customizeUi'];
let propKeys = Object.keys(props).filter(key => !excludedKeys.includes(key))
let propName = propKeys.find((key) => !!props[key]);

const currentInstance = computed(() => {
    let instance = {} as CurrentInstance;
    instance.selectedRef = props[propName];

    if(!props.customOptions){
        instance.store = stores[propName];
        instance.options = storeToRefs(instance.store)
        return instance;
    }else{
        instance.store = stores[propName];
        instance.options = props.customOptions;
        return instance;
    }
})   



// let selectedRef = ref(props.modelValue);
// const peopleStore = usePeopleStore();
// const { people, selectedPeople } = storeToRefs(peopleStore);

// ////
// // events & watchers
// ////
const emit = defineEmits<{
    (e: `update:${typeof propName}`, selected): void
}>();

watch([currentInstance.value.selectedRef], (selected, old) => {
    emit(`update:${typeof propName}`, selected);
},{deep:true});

// ////
// // Actions
// ////////////////
// function search(search) {
//     peopleStore.search({ search })
// }
</script>
