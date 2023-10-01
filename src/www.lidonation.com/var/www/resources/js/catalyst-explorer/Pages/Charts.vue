<template>
    <header-component titleName0="catalyst" titleName1="by the Numbers"
        subTitle="View projects charts and filter results based on funds" />
    <section class="flex flex-col gap-2 bg-primary-20">
        <div class="container relative w-full">
            <div class="flex w-full items-center justify-end space-x-0.5 mt-4 gap-2">
                <div class="text-xs w-[240px] lg:w-[330px] lg:text-base">
                    <Multiselect placeholder="Funds" value-prop="value" label="label" v-model="selectedFundRef"
                        :options="fundsLabelValue" :classes="{
                            container: 'multiselect border-0 p-0.5 flex-wrap',
                            containerActive: 'shadow-none shadow-transparent box-shadow-none',
                        }" />
                </div>
            </div>
        </div>
    </section>
    <section class="relative bg-gray-100">
        <div class="container py-8">
            <div class="grid h-full grid-cols-1 grid-rows-1 gap-4 md:grid-cols-5 xl:grid-cols-8 xl:grid-rows-10">

                <!-- proposal metrics -->
                <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-600 xl:col-span-2 round-sm">
                    <LargestWinningProposal :fundId="selectedFundRef" />
                </div>
                <div class="relative col-span-1 row-span-1 px-3 py-5 bg-white round-sm">
                    <Over75k :fundId="selectedFundRef" />
                </div>
                <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-600 xl:col-span-2 round-sm">
                    <MembersAwarded :fundId="selectedFundRef" />
                </div>
                <!-- Total Funded Propoosals-->
                <div class="relative col-span-1 row-span-1 p-3 bg-blue-dark-500 md:col-span-2 xl:col-span-3 round-sm">
                    <div class="flex flex-row flex-wrap items-start justify-between h-full md:flex-nowrap">
                        <FundedAndCompleted :fundId="selectedFundRef" />
                    </div>
                </div>


                <!--  1 stake key 1 Vote Ranges -->
                <div
                    class="relative w-full col-span-1 row-span-6 p-3 bg-white md:col-span-3 round-sm xl:col-span-5 max-h-[60rem]">
                    <div class="relative flex flex-col justify-start h-full">
                        <WalletBalanceChart :attachment-link="attachmentLink"
                            :chartData1Registration1Vote$="chartData1Registration1Vote$" :chart-options="chartOptions" />
                    </div>
                </div>
                <!-- Wallet breakdowns registrations -->
                <div
                    class="w-full col-span-1 p-3 overflow-x-visible overflow-y-scroll bg-white md:col-span-2 xl:col-span-3 xl:row-span-6 round-sm max-h-[60rem]">
                    <RegistrationChart :ada-power-ranges="adaPowerRanges" />
                </div>

                <!-- votes casted breakdown -->
                <div class="w-full col-span-1 md:col-span-5 xl:col-span-8">
                    <VotesCastBreakdown :fund-id="selectedFundRef"/>
                </div>

                <!-- Number Grid -->
                <Suspense>
                    <div class="relative col-span-1 row-span-6 bg-white md:col-span-2 round-sm xl:col-span-3">
                        <VotingAggregates :fund-id="selectedFundRef" />
                    </div>

                    <template #fallback>
                        <div
                            class="relative col-span-1 row-span-6 bg-slate-200 md:col-span-4 round-sm xl:col-span-3 animate-pulse">
                            <div class="grid h-full grid-cols-2 ">
                            </div>
                        </div>
                    </template>
                </Suspense>
                <!-- The pie by Ada Power -->
                <div class="relative w-full col-span-1 row-span-6 p-3 bg-white md:col-span-3 xl:col-span-5 round-sm">
                    <div class="relative flex flex-col justify-start h-full">
                        <AdaPowerChart :attachmentLink="attachmentLink" :chart-data1-ada1-vote$="chartData1Ada1Vote$"
                            :chart-options="chartOptions" />
                    </div>
                </div>

                <!-- Yes Votes no Votes Sum -->
                <div class="relative col-span-1 row-span-1 md:col-span-5 xl:col-span-8">
                    <YesNoVotesSum :fundId="selectedFundRef" />
                </div>

                <!-- Top funded -->
                <div
                    class="relative col-span-1 row-span-6 p-3 bg-white md:col-span-3 xl:col-span-4 xl:row-span-10 round-sm">
                    <TopFundedTeams :fund-id="filters?.fundId" />
                </div>
                <div
                    class="relative col-span-1 row-span-6 p-3 bg-white md:col-span-2 xl:col-span-4 xl:row-span-10 round-sm">
                    <TopFundedProposals :fund="filters?.fundId" />
                </div>

                <!-- Live Tally -->
                <LiveTally :challenges="challenges" :fund-id="selectedFundRef" />
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import { router, usePage } from '@inertiajs/vue3';
import { watch, ref, defineAsyncComponent } from 'vue';
import { VARIABLES } from "../models/variables";
import { computed } from 'vue';
import Fund from '../models/fund';
import axios from '../../lib/utils/axios';
import route from 'ziggy-js';
import Challenge from '../models/challenge';
import Over75k from '../modules/charts/Over75k.vue';
import LargestWinningProposal from '../modules/charts/LargestWinningProposal.vue';
import FundedAndCompleted from '../modules/charts/FundedAndCompleted.vue';
import WalletBalanceChart from '../modules/charts/WalletBalanceChart.vue';
import MembersAwarded from '../modules/charts/MembersAwarded.vue';
import RegistrationChart from '../modules/charts/RegistrationChart.vue';
import AdaPowerChart from '../modules/charts/AdaPowerChart.vue';
import YesNoVotesSum from "@/catalyst-explorer/modules/charts/YesNoVotesSum.vue";
import VotesCastBreakdown from '../modules/charts/VotesCastBreakdown.vue';

const VotingAggregates = defineAsyncComponent(() =>
    import('../modules/charts/VotingAggrigates.vue')
)
const LiveTally = defineAsyncComponent(() =>
    import('../modules/charts/LiveTally.vue')
)

const props = withDefaults(
    defineProps<{
        funds: Fund[],
        challenges: Challenge[],
        filters?: {
            fundId: number,
        },
        locale: string,
    }>(), {});

const TopFundedTeams = defineAsyncComponent(() => import('../modules/charts/TopFundedTeams.vue'));
const TopFundedProposals = defineAsyncComponent(() => import('../modules/charts/TopFundedProposals.vue'));

let adaPowerRanges = ref<{ 'key': string, 'count': number, 'total': number }[]>([]);
let fundedOver75KCount = ref<number>(null);

let selectedFundRef = ref<number | string>(props.filters?.fundId);

let currPage$ = ref<number>(1);
let perPage$ = ref<number>(36);

const attachmentLink = ref<string>(null);
let talliesSum$ = ref<number>(null);

const fundsLabelValue = computed(() => {
  const fundObjects: { label: string; value: string | number; }[] = [];
  fundObjects.push({ 'label': 'All Funds', 'value': 'all' });

  props?.funds?.map((fund) => {
    fundObjects.push({ 'label': fund.title, 'value': fund.id });
  });

  return fundObjects;
});

getMetrics();
getAttachmentLink();

watch([selectedFundRef], () => {
    query();
}, { deep: true });


watch([currPage$, perPage$], () => {
    fundedOver75KCount.value = fundedOver75KCount.value;
});

const chartDataVotesCastScatter$ = ref<object>();
const chartData1Registration1Vote$ = ref<object>();
const chartData1Ada1Vote$ = ref<object>();
const chartOptions = ref<object>();

function query() {
    const data = getQueryData();
    router.get(
        `/${props.locale}/catalyst-explorer/charts`,
        data,
        { preserveState: false, preserveScroll: false }
    );
}

function getMetrics() {
    const params = getQueryData();

    // fetch adaRanges
    axios.get(route('catalystExplorer.metrics.adaPowerRanges'), { params })
        .then((res) => {
            adaPowerRanges.value = res?.data;

            let keyArr = [];
            let countArr = [];

            adaPowerRanges.value.forEach(power => {
                keyArr.push(power.key);
                countArr.push(power.count);
            });
            chartData1Registration1Vote$.value = {
                labels: keyArr,
                datasets: [
                    {
                        backgroundColor: [
                            '#a3899d', // 450 - 1k
                            '#917289', // 1k - 5k
                            '#7e5a75', // 5K - 10k
                            '#6c4262', // 10K - 25k

                            '#5a2b4e', // 25k - 50k
                            '#48143b', // 50k - 75k
                            '#39102f', // 75k - 100k

                            '#84c3da', // 100k - 250k
                            '#66b5d1', // 250k - 500k
                            '#50abcb', // 500k - 750k
                            '#3aa0c4', //750k - 1M

                            '#fce865', // 1M - 5M
                            '#fcdf23', // 5M - 10M
                            '#e2c609', // 10M - 15M

                            '#ff9319', // 15M - 21M
                            '#ff8700', // 30M - 45M
                            '#ff8700', // 30M-45M

                            '#4bb92f', // 45M - 75M
                            '#8d00ff', // 75M - 100M

                            // '#E4578A' // 9M - 10M
                        ],
                        data: countArr,
                    }
                ]
            }

            keyArr = [];
            countArr = [];
            adaPowerRanges.value.forEach(power => {
                keyArr.push(power.key);
                countArr.push(power.total);
            });
            chartData1Ada1Vote$.value = {
                labels: keyArr,
                datasets: [
                    {
                        backgroundColor: [
                            '#a3899d', // 450 - 1k
                            '#917289', // 1k - 5k
                            '#7e5a75', // 5K - 10k
                            '#6c4262', // 10K - 25k

                            '#5a2b4e', // 25k - 50k
                            '#48143b', // 50k - 75k
                            '#39102f', // 75k - 100k

                            '#84c3da', // 100k - 250k
                            '#66b5d1', // 250k - 500k
                            '#50abcb', // 500k - 750k
                            '#3aa0c4', //750k - 1M

                            '#fce865', // 1M - 5M
                            '#fcdf23', // 5M - 10M
                            '#e2c609', // 10M - 15M

                            '#ff9319', // 15M - 21M
                            '#ff8700', // 30M - 45M
                            '#ff8700', // 30M-45M

                            '#4bb92f', // 45M - 75M
                            '#8d00ff', // 75M - 100M

                            // '#E4578A' // 9M - 10M
                        ],
                        data: countArr,
                    }
                ]
            }

            chartDataVotesCastScatter$.value = {
                datasets: [{
                    label: 'Votes Cast',
                    fill: false,
                    borderColor: '#f87979',
                    backgroundColor: '#f87979',
                    data: [
                        {
                            x: 800,
                            y: 4
                        },
                        {
                            x: 700,
                            y: 4
                        },
                        {
                            x: 600,
                            y: 0
                        },
                        {
                            x: 600,
                            y: 4
                        },
                        {
                            x: 600,
                            y: 4
                        }
                    ]
                }]
            };
            chartOptions.value = {
                responsive: true,
                maintainAspectRatio: false
            }
        })
        .catch((error) => {
            console.error(error);
        });

    axios.get(route('catalystExplorerApi.talliesSum'), { params })
        .then((res) => {
            talliesSum$.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });

}

function getQueryData() {
    const data = {};
    if (selectedFundRef.value) {
        data[VARIABLES.FUNDS] = selectedFundRef.value;
    }

    return data;
}


function getAttachmentLink() {
    const params = getQueryData();

    axios.get(route('catalystExplorer.attachments.votingPowers'), { params })
        .then((res) => attachmentLink.value = res?.data)
        .catch((error) => {
            console.error(error);
        });
}


</script>

