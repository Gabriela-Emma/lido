<template>
    <div class="p-3 bg-white h-full">
        <div class="bg-primary-20 p-3">
            <div class="flex flex-col md:flex-row md:justify-between">
                <h2 class="mb-0 xl:text-3xl block">{{widgetLabel}} Proposals</h2>
                <FundingTypeSelectorVue/>
            </div>
            <p v-if="!loadingProposals && !emptyDataProposals">Across {{ proposals?.[0]?.fund?.parent?.label }}</p>
            <div class="relative text-xl flex gap-4 items-center" v-if="!loadingProposals && emptyDataProposals">
                <p>That's all we know.</p>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 fill-red-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="relative m-2" v-if="loadingProposals">
                <ul
                    role="list"
                    class="divide-y divide-gray-200 max-h-[39rem] overflow-y-auto"
                >
                    <li v-for="index in 8" :key="index"><PulseLoading/></li>
                </ul>
        </div>
        <div class="relative m-2" v-if="!loadingProposals && !emptyDataProposals">
            <ul
                role="list"
                class="divide-y divide-gray-200 max-h-[39rem] overflow-y-auto"
            >
                <li v-for="proposal in proposals" v-if="proposals">
                    <a
                        :href="proposal.link"
                        class="block hover:bg-gray-50"
                        target="_blank"
                    >
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div
                                    class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4"
                                >
                                    <div class="flex flex-col">
                                        <p
                                            class="text-xl font-medium truncate text-gray-600">
                                            {{ proposal.title }}
                                        </p>
                                        <ProposalAuthors :size="6" :proposal="proposal" />
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                            <p
                                                class="text-lg md:text-xl 2xl:text-2xl text-gray-900"
                                            >
                                                {{
                                                    $filters.currency(
                                                        proposal.amount_requested,
                                                        proposal.currency,
                                                        'en-US', 2
                                                    )
                                                }}
                                            </p>
                                            <p
                                                class="mt-2 flex items-center text-sm text-gray-500"
                                            >
                                                {{ proposal.fund?.label }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { Ref, ref, watch, onMounted, computed } from "vue";
import Proposal from "../../models/proposal";
import axios from "axios";
import route from "ziggy-js";
import { VARIABLES } from "../../models/variables";
import ProposalAuthors from "../proposals/partials/ProposalAuthors.vue";
import PulseLoading from "./PulseLoading.vue";
import {useChartsWidgetStore} from "../../stores/chart-widgets-store";
import { storeToRefs } from "pinia";
import FundingTypeSelectorVue from "./FundingTypeSelector.vue";

const props = withDefaults(
    defineProps<{
        fund: number;
    }>(),
    {}
);

const chartWidgets = useChartsWidgetStore();
chartWidgets.getTopProposals(props.fund);
const {proposals, loadingProposals, emptyDataProposals, chartsProposalsOptions, selectedValue} = storeToRefs(chartWidgets);


onMounted(() => {
    chartWidgets.updateSelectedFundId(props.fund);
})

const widgetLabel = computed(() => {
    const selectedOption = chartsProposalsOptions.value.find(
        option => option.value === selectedValue.value
    );
    return selectedOption ? selectedOption.label : '';
})


watch(
    () => props.fund,
    () => {
        chartWidgets.updateSelectedFundId(props.fund);
        chartWidgets.getTopProposals(props.fund);
    }
);

</script>
