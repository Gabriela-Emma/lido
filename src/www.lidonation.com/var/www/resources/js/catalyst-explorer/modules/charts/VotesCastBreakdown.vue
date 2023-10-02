<template>
    <div class="grid h-full grid-cols-1 grid-rows-1 gap-4 md:grid-cols-5 xl:grid-cols-10 xl:grid-rows-10">

        <!-- votes metrics -->
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-teal-600 text-white round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                        <span v-if="votesCastAverage > 0">
                            {{ $filters.shortNumber(votesCastAverage) ?? '-' }}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate">
                    Average # of votes cast
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-teal-900 text-white round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                        <span v-if="votesCastMode > 0">
                            {{ $filters.shortNumber(votesCastMode) ?? '-' }}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate">
                    Mode: most frequent # of votes cast
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-teal-light-400 text-blue-dark-500 round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                        <span v-if="votesCastMedian > 0">
                            {{ $filters.shortNumber(votesCastMedian) ?? '-' }}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate">
                    Median # of votes cast
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-white round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                        <span v-if="totalRegisteredAndVoted > 0">
                            {{ $filters.shortNumber(totalRegisteredAndVoted, 2) ?? '-' }}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
                    Total confirm voters
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-blue-dark-500 text-white round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                        <span v-if="totalRegisteredAndNeverVoted > 0">
                            {{ $filters.shortNumber(totalRegisteredAndNeverVoted, 2) ?? '-' }}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate">
                    Total registered but didn't vote
                </dt>
            </dl>
        </div>

        <!--  votes cast pie -->
        <div class="col-span-1 row-span-6 p-3 bg-white md:col-span-3 round-sm xl:col-span-6 max-h-[60rem]">
            <div class="relative flex flex-col justify-start h-full">
                <VotesCastedChart :chartDataVotesCasted$="chartDataVotesCast$"
                    :chart-options="chartOptions"/>
            </div>
        </div>
        <!-- votes cast breakdown -->
        <div
            class="col-span-1 p-3 overflow-x-visible overflow-y-scroll bg-white md:col-span-2 xl:col-span-4 xl:row-span-6 round-sm max-h-[60rem]">
            <VotesCastedBreakdownChart :votes-ranges="votesRanges" :loading-votes-ranges="loadingVotesRanges"/>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, watch } from 'vue';
import { VARIABLES } from '../../models/variables';
import axios from 'axios';
import route from 'ziggy-js';
import VotesCastedChart from './VotesCastedChart.vue';
import VotesCastedBreakdownChart from './VotesCastedBreakdownChart.vue'

const props = defineProps<{
    fundId: number
}>()

let loadingVotesRanges = ref(true);
let votesCastAverage = ref(null);
let votesCastMode = ref(null);
let votesCastMedian = ref(null);
let votesRanges = ref<{ 'key': string, 'count': number, 'total': number }[]>([]);
let totalRegisteredAndVoted = ref(null);
let totalRegisteredAndNeverVoted = ref(null);

query();

function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

const chartDataVotesCast$ = ref<object>();
const chartOptions = ref<object>();

function query() {
    let params = getQueryData()
    axios.get(route('catalystExplorer.metrics.votesCastAverage'), { params })
        .then((res) => {
            votesCastAverage.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });
    axios.get(route('catalystExplorer.metrics.votesCastMode'), { params })
        .then((res) => {
            votesCastMode.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });
    axios.get(route('catalystExplorer.metrics.votesCastMedian'), { params })
        .then((res) => {
            votesCastMedian.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });
    axios.get(route('catalystExplorer.metrics.totalRegisteredAndVoted'), { params })
        .then((res) => {
            totalRegisteredAndVoted.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });

    axios.get(route('catalystExplorer.metrics.totalRegisteredAndNeverVoted'), { params })
        .then((res) => {
            totalRegisteredAndNeverVoted.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });

    axios.get(route('catalystExplorer.metrics.votesCastRanges'), { params })
        .then((res) => {
            votesRanges.value = res?.data;

            let keyArr = [];
            let countArr = [];

            votesRanges.value.forEach(power => {
                keyArr.push(power.key);
                countArr.push(power.count);
            });

            // reset loadingVotesRanges
            loadingVotesRanges.value = false;

            chartDataVotesCast$.value = {
                labels: keyArr,
                datasets: [
                    {
                        backgroundColor: [
                            '#ee5e5f', // 0 -1
                            '#9999ff', // 2-10
                            '#ffd77d', // 11 - 25
                            '#00ffe6', // 26 - 50

                            '#00b50b', // 51 - 150
                            '#48143b', // 151 - 300
                            '#d2bc14', // 301 - 600

                            '#000000', // 601 - 900
                            '#66b5d1', // 900 <
                        ],
                        data: countArr,
                    }
                ]
            };
            chartOptions.value = {
                responsive: true,
                maintainAspectRatio: false
            }
        })
        .catch((error) => {
            console.error(error);
        });
}

watch(() => props.fundId, () => {
    query();
})
</script>
