<template>
    <div class="h-full p-3 bg-white">
        <div class="bg-primary-20 p-3">
            <div class="flex flex-col md:flex-row md:justify-between">
                <h2 class="mb-0 xl:text-3xl block">{{widgetLabel}} Teams</h2>
                <FundingTypeSelectorVue/>
            </div>
            <p v-if="!loadingTeams && !emptyDataTeams">Across {{ fund.label }}</p>
            <div class="relative text-xl flex gap-4 items-center" v-if="!loadingTeams && emptyDataTeams">
                <p>That's all we know.</p>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 fill-red-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="relative m-2" v-if="loadingTeams">
                <ul
                    role="list"
                    class="divide-y divide-gray-200 max-h-[28rem] overflow-y-auto"
                >
                    <li v-for="index in 6" :key="index"><PulseLoading/></li>
                </ul>
        </div>
        <div class="relative m-2" v-if="!loadingTeams && !emptyDataTeams">
            <ul role="list" class="divide-y divide-gray-200 max-h-[28rem] overflow-y-auto">
                <li v-for="proposer in proposers" v-if="proposers">
                    <a :href="$utils.localizeRoute(`project-catalyst/users/${proposer?.id}`)"
                        class="block hover:bg-gray-50" target="_blank">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <img class="relative inline-block w-10 h-10 rounded-full ring-2 ring-white"
                                        :src="proposer?.profile_photo_url" :alt="proposer.name" />
                                </div>
                                <div class="flex-1 min-w-0 px-4 md:grid md:grid-cols-2 md:gap-4">
                                    <div class="flex items-center justify-start">
                                        <p class="text-xl font-medium text-gray-600 truncate ">
                                            {{ proposer.name }}
                                        </p>
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                            <p class="text-lg text-gray-900 md:text-xl 2xl:text-2xl">
                                                {{ $filters.currency(parseInt(proposer?.amount_requested), fund?.currency)
                                                }}
                                            </p>
                                            <p class="flex items-center mt-2 text-sm text-gray-500">
                                                {{ fund?.label }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Ref, computed, ref, watch, onMounted } from 'vue';
import axios from 'axios';
import route from 'ziggy-js';
import { inject } from "vue";
import { VARIABLES } from "../../models/variables";
import Fund from '../../models/fund';
import Profile from '../../models/profile';
import {useChartsWidgetStore} from "../../stores/chart-widgets-store";
import { storeToRefs } from "pinia";
import FundingTypeSelectorVue from "./FundingTypeSelector.vue";
import PulseLoading from "./PulseLoading.vue";

const $utils: any = inject('$utils');

const props = defineProps<{
    fundId: number
}>()

const chartWidgets = useChartsWidgetStore();
chartWidgets.getProposerData(props.fundId);
const {proposers, proposerData, loadingTeams, emptyDataTeams, chartsProposalsOptions, selectedValue} = storeToRefs(chartWidgets);

onMounted(() => {
    chartWidgets.updateSelectedFundId(props.fundId);
})

const widgetLabel = computed(() => {
    const selectedOption = chartsProposalsOptions.value.find(
        option => option.value === selectedValue.value
    );
    return selectedOption ? selectedOption.label : '';
})

watch(
    () => props.fundId,
    () => {
        chartWidgets.updateSelectedFundId(props.fundId);
        chartWidgets.getTopProposals(props.fundId);
    }
);


let numberRange = computed(() => Array.from({ length: 5 }, (_, index) => index + 1));
let fund = computed((): Fund => proposerData.value?.fund);


</script>
