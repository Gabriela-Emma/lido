<template>
    <header-component titleName0="catalyst" titleName1="by the Numbers"
        subTitle="View projects charts and filter results based on funds"/>
    <section class="flex flex-col gap-2 bg-primary-20">
        <section class="relative w-full px-8">
            <div class="flex w-full items-center justify-end space-x-0.5 mt-4 mb-4 gap-2">
                <div class="text-xs w-[240px] lg:w-[330px] lg:text-base">
                    <Multiselect placeholder="All Funds" value-prop="value" label="label" v-model="selectedFundRef"
                        :options="fundsLabelValue" :classes="{
                            container: 'multiselect border-0 p-0.5 flex-wrap',
                            containerActive: 'shadow-none shadow-transparent box-shadow-none',
                        }" />
                </div>
            </div>
            <div class="">
                <div class="grid grid-cols-1 md:grid-cols-3 grid-rows-1 xl:grid-cols-5 xl:grid-rows-4 gap-4 h-full">
                    <div class="bg-teal-600 relative px-3 py-5 col-span-1 row-span-1 round-sm">
                        <dl class="flex flex-col justify-between h-full relative">
                            <div class="px3 absolute right-0 top-0">
                                <a v-if="props.largestFundedProposalObject?.amount_requested > 0"
                                    type="button"
                                    :href="props.largestFundedProposalObject?.link"
                                    class="inline-flex items-center px-1.5 py-1 border border-white hover:border-accent-700 shadow-xs text-xs font-semibold rounded-sm text-white bg-transparent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-600 hover:bg-accent-600">
                                    View
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                            <dd class="pointer-events-none">
                                <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white relative">
                                    <div v-if="props.largestFundedProposalObject?.amount_requested > 0">
                                        ${{$filters.shortNumber(props.largestFundedProposalObject?.amount_requested)}}
                                    </div>
                                    <div v-else>
                                        0
                                    </div>
                                </div>
                            </dd>
                            <dt class="text-lg font-medium text-gray-200 truncate mt-3 pointer-events-none">
                                Largest Winning Proposal
                            </dt>
                        </dl>
                    </div>

                    <div class="bg-white relative px-3 py-5 col-span-1 row-span-1 round-sm">
                        <dl class="flex flex-col justify-between h-full">
                            <dd>
                                <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-blue-dark-500">
                                    {{props.fundedOver75KCount}}
                                </div>
                            </dd>
                            <dt class="text-lg font-medium text-blue-dark-500 truncate mt-3">
                                Funded >= 75K
                            </dt>
                        </dl>
                    </div>

                    <div class="bg-teal-600 relative px-3 py-5 col-span-1 row-span-1 round-sm">
                        <dl class="flex flex-col justify-between h-full">
                            <dd>
                                <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white">
                                    {{props.membersAwardedFundingCount}}
                                </div>
                            </dd>
                            <dt class="text-lg font-medium text-gray-200 truncate mt-3">
                                Members Awarded Funding
                            </dt>
                        </dl>
                    </div>

                    <div class="bg-blue-dark-500 col-span-1 md:col-span-3 xl:col-span-2 relative p-3 row-span-1 round-sm">
                        <div class="flex flex-row flex-wrap md:flex-nowrap justify-between items-start h-full">
                            <div>
                                <dl class="flex flex-col justify-between">
                                    <dd>
                                        <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white">
                                            {{props.fullyDisbursedProposalsCount}}
                                        </div>
                                    </dd>
                                    <dt class="text-lg font-medium text-gray-200 truncate mt-3">
                                        Proposals with Fully Disbursed Funds
                                    </dt>
                                </dl>
                            </div>

                            <div class="ml-auto md:mt-auto">
                                <dl class="flex flex-col justify-between text-right">
                                    <dd>
                                        <div class="text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-white">
                                            {{props.completedProposalsCount}}
                                        </div>
                                    </dd>
                                    <dt class="text-lg font-medium text-gray-200 truncate mt-3">
                                        Completed Proposals
                                    </dt>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-3 w-full relative bg-white p-3 row-span-4 round-sm">
                        <div class="h-full flex flex-col justify-start relative">
                            <div class="text-teal-600">
                                <h2 class="xl:text-3xl mb-0">
                                    1 stake key 1 Vote Ranges
                                </h2>
                                <p>Pie chart of wallet balance</p>
                            </div>

                            <div class="my-auto">
                                <AdaPowerRangesPie :chartData="chartData" :options="chartOptions" />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-3 xl:col-span-2 xl:row-span-4 bg-white p-3 w-full round-sm">
                        <div class="text-blue-dark-500">
                            <h2 class="xl:text-3xl mb-0">
                                Wallet Voting Ada Power Breakdowns
                            </h2>
                            <p>Ranges of wallet balance</p>
                        </div>
                        <div class="relative w-full">
                            <ul role="list" class="divide-y divide-gray-200">
                                    <li v-for="(value, range) in props.adaPowerRanges"
                                        class="flex py-4 gap-4 items-center w-full justify-start">
                                        <div class="rounded-full w-20 h-20 p-2 flex justify-center items-center bg-slate-300 text-center">
                                            <span class="text-base">{{range}} ₳</span>
                                        </div>

                                        <div class="">
                                            <p class="text-lg lg:text-xl xl:text-2xl 2xl:text-3xl text-slate-500">
                                                {{value['0']}} <span class="text-slate-300 text-md lg:text-lg xl:text-2xl 2xl:text-2xl">Wallets</span>
                                            </p>
                                        </div>

                                        <div class="ml-auto pr-2">
                                            <p class="text-md lg:text-lg xl:text-2xl text-slate-500">
                                                <span class="text-slate-400 mr-2">₳</span>{{ $filters.shortNumber(value['1'], 2)}}
                                            </p>
                                        </div>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import { router, usePage } from '@inertiajs/vue3';
import { watch, ref } from 'vue';
import {storeToRefs} from "pinia";
import AdaPowerRangesPie from "../modules/charts/AdaPowerRangesPie.vue"
import {useFundsStore} from "../stores/funds-store"
import { VARIABLES } from "../models/variables";
import { computed } from 'vue';
import Proposal from '../models/proposal'

const props = withDefaults(
    defineProps<{
        adaPowerRanges?: any,
        largestFundedProposalObject: Proposal,
        fundedOver75KCount: number,
        membersAwardedFundingCount: number,
        fullyDisbursedProposalsCount: number,
        completedProposalsCount: number,
        filters?: {
            fund: string,
        },
        locale: string,
    }>(), {});

const {funds} = storeToRefs(useFundsStore());
const fundsLabelValue = computed(() => {
    return funds.value.map((fund) => {
        return { 'label': fund.title, 'value': fund.slug}
    })
})
let selectedFundRef = ref<string>(props.filters.fund);

const adaPowersLabels = computed(() => {
        const key = Object.entries(props.adaPowerRanges).map(([key, value]) => key);
        return key;
    });

const adaPowersData = computed(() => {
    const value = Object.entries(props.adaPowerRanges).map(([key, value]) => value['0']);
    return value;
});

let chartData = {
    labels: adaPowersLabels.value,
    datasets: [
        {
            backgroundColor: ['#a3899d','#917289','#7e5a75','#6c4262','#5a2b4e','#48143b','#401235','#66b5d1','#50abcb','#3aa0c4','#2596be','#fce33b','#fcdf23','#fcdc0b','#e2c609','#ff8700','#4bb92f','#8d00ff','#E4578A'],
            data: adaPowersData.value
        }
    ]
}

let chartOptions = {
    responsive: true,
    maintainAspectRatio: false
}

watch([selectedFundRef], () => {
    query();
}, { deep: true });

function query() {
    const data = getQueryData();
    router.get(
        `/${props.locale}/catalyst-explorer/charts`,
        data,
        { preserveState: false, preserveScroll: false }
    );
}

function getQueryData() {
    const data = {};
    if (selectedFundRef.value) {
        data[VARIABLES.FUNDS] = selectedFundRef.value;
    }

    return data;
}
</script>
