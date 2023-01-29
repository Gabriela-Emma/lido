<template>
    <div class="bg-white w-[260px] relative" v-if="filtering && showFilter !== false">
        <h2 class="font-medium flex flex-nowrap justify-between gap-8 border-b p-4">
            <span>
                Filters
            </span>
            <button
                @mouseenter="showClearAll = true"
                @mouseleave="showClearAll = false"
                class="text-slate-300 hover:text-yellow-500 focus:outline-none flex items-center gap-2">
                <span class="text-xs" v-if="showClearAll">Clear All</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </h2>
        <div>
            <ul class="divide-y border-b">
                <li class=" p-4">
                    <Toggle
                        onLabel="Funded Proposals"
                        offLabel="All Proposals"
                        v-model="filters.funded"
                        :classes="{
                          container: 'inline-block rounded-xl outline-none focus:ring focus:ring-teal-500 focus:ring-opacity-30 w-full',
                          toggle: 'flex w-full h-8 rounded-xl relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                          toggleOn: 'bg-teal-500 border-teal-500 justify-start text-white',
                          toggleOff: 'bg-slate-200 border-slate-200 justify-end text-slate-700',
                          handle: 'inline-block bg-white w-8 h-8 top-0 rounded-xl absolute transition-all',
                          handleOn: 'left-full transform -translate-x-full',
                          handleOff: 'left-0',
                          handleOnDisabled: 'bg-slate-100 left-full transform -translate-x-full',
                          handleOffDisabled: 'bg-slate-100 left-0',
                          label: 'text-center w-auto px-2 border-box whitespace-nowrap select-none',
                        }"
                    />
                </li>
                <li class="">
                    <FundPicker v-model="filters.funds" />
                </li>
                <li class="">
                    <ChallengePicker v-model="filters.challenges" />
                </li>
                <li class="">
                    <FundingStatusPicker
                        v-model="filters.fundingStatus"
                        :filters="{
                            o: 'Over Budget',
                            n: 'Not Approved'
                        }" />
                </li>

                <li class="">
                    <TagPicker v-model="filters.tags" />
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {ref, watch, defineEmits, computed} from "vue";
import Toggle from '@vueform/toggle'
import Filters from "../../models/filters";
import FundPicker from "../funds/FundPicker.vue";
import ChallengePicker from "../funds/ChallengePicker.vue";
import {useChallengesStore} from "../../stores/challenges-store";
import FundingStatusPicker from "../funds/FundingStatusPicker.vue";
import TagPicker from "./TagPicker.vue";
import {useTagsStore} from "../../stores/tags-store";

////
// props and class properties
/////////////////////////////
const props = withDefaults(
    defineProps<{
        filters?: Filters,
        showFilter?: boolean
    }>(), {showFilter: false});
let showClearAll = ref(false);
let filters = ref<Filters>(props.filters);

////
// computer properties
///////////////////////

/**
 * assert that every property on props.filters is truthy.
 */
const filtering = computed(() => Object.values(props.filters).every(val => !!val) || props.showFilter);

/**
 * Init Challenges
 */
const challengesStore = useChallengesStore();
challengesStore.filterChallenges({
    funds: props?.filters?.funds
});

/**
 * Init Tags
 */
const tagsStore = useTagsStore();
tagsStore.loadTags(props?.filters?.tags);

////
// events & watchers
//////////////////////
const emit = defineEmits<{
    (e: 'filter', filters: Filters): void
}>();

watch(filters, (newValue, oldValue) => {
    // if filtering fund, update challenge store
    if (newValue.funds?.length > 0) {
        challengesStore.filterChallenges({
            funds: newValue.funds
        });
    }

    // fire filter event
    emit('filter', newValue);
}, {deep: true});

</script>
