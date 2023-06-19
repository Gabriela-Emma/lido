<template>
    <div class="bg-white w-[260px] relative" v-if="filtering && showFilter !== false">
        <h2 class="relative flex justify-between gap-8 p-4 font-medium border-b flex-nowrap">
            <span>
                {{  $t("Filters") }}
            </span>
            <button
                @mouseenter="showClearAll = true"
                @mouseleave="showClearAll = false"
                @click="clearFilters"
                class="flex items-center gap-2 text-slate-300 hover:text-yellow-500 focus:outline-none">
                <span class="text-xs" v-if="showClearAll">Clear All</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </h2>
        <div>
            <ul class="border-b divide-y">
                <li class="p-4 ">
                    <p class="mb-3 text-slate-400">{{ $t("Funding Status") }}</p>
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
                <li class="p-4">
                    <BudgetRangePicker v-model="filters.budgets" />
                </li>
                <li class="">
                    <ProposalTypePicker
                        v-model="filters.type"
                        :filters="{
                            p: 'Only Proposals',
                            c: 'Only Challenges'
                        }" />
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
                            n: 'Not Approved',
                            f: 'Funded',
                            p: 'Fully Paid'
                        }" />
                </li>

                <li class="">
                    <TagPicker v-model="filters.tags" />
                </li>

                <li class="">
                    <GroupsPicker v-model="filters.groups" />
                </li>

                <li class="">
                    <PersonPicker v-model="filters.people" />
                </li>

                <li class="">
                    <ProposalStatusPicker
                        v-model="filters.projectStatus"
                        :filters="{
                            c: 'Complete',
                            i: 'In Progress',
                            u: 'Unfunded',
                            // p: 'Paused'
                        }" />
                </li>

                <li class="p-4 bg-stone-100">
                    <span class="block text-lg font-medium xl:text-xl">
                        {{ $t("Community Filters") }}
                    </span>
                    <p class="block py-1 mb-2 text-xs border-b">
                        {{ $t("These filters are not based on primary catalyst data but rather self assembled datasets by community groups") }}.
                        {{ $t("noValidation") }}.
                    </p>
                    <CohortPicker
                        v-model="filters.cohort"
                        :filters="{
                            im: 'Impact Proposals',
                            wo: 'Women Proposals',
                            id: 'Ideafest Proposals',
                            qp: 'Quick Pitches',
                        }" />
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
import BudgetRangePicker from "./BudgetRangePicker.vue";
import PersonPicker from "../people/PersonPicker.vue";
import {usePeopleStore} from "../../stores/people-store";
import CohortPicker from "./CohortPicker.vue";
import ProposalStatusPicker from "./ProposalStatusPicker.vue";
import {useGroupsStore} from "../../stores/groups-store";
import GroupsPicker from "../groups/GroupsPicker.vue";
import ProposalTypePicker from "../funds/ProposalTypePicker.vue";

////
// props and class properties
/////////////////////////////
const props = withDefaults(
    defineProps<{
        filters?: Filters,
        showFilter?: boolean,
        search?:string
    }>(), {showFilter: false});
let showClearAll = ref(false);
let filters = ref<Filters>(props.filters);
let search = ref<string>(props.search);


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

/**
 * Init People
 */
const peopleStore = usePeopleStore();
peopleStore.loadPeople(props?.filters?.people);

/**
 * Init Groups
 */
const groupsStore = useGroupsStore();
groupsStore.loadGroups(props?.filters?.groups);

////
// events & watchers
//////////////////////
const emit = defineEmits<{
    (e: 'filter', filters: Filters): void,
    (e: 'reRenderFilter'),
    (e: 'clearSearch')
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

function clearFilters() {
    filters.value.currentPage = 1;
    filters.value.funded = false;
    filters.value.fundingStatus = null;
    filters.value.projectStatus = null;
    filters.value.cohort = null;
    filters.value.type = "p";
    filters.value.budgets = [0, 2000000];
    filters.value.funds = [];
    filters.value.challenges = [];
    filters.value.tags = [];
    filters.value.people = [];
    filters.value.groups = [];

    emit('reRenderFilter');
    if (search) {
        emit('clearSearch');
    }
}

</script>
