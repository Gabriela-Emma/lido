<template>
    <div class="grid h-full grid-cols-1 grid-rows-1 gap-4 md:grid-cols-5 xl:grid-cols-10 xl:grid-rows-10">

        <!-- votes metrics -->
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-teal-600 round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                        {{ $filters.shortNumber(votesCastedAverage) ?? '-' }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
                    Average Votes Casted
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-white round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                        {{ $filters.shortNumber(votesCastedMode) ?? '-' }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
                    Mode Votes Casted
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-teal-600 round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                        {{ $filters.shortNumber(votesCastedMedian, 2) ?? '-' }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
                    Median Votes Casted
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-white round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                        {{ $filters.shortNumber(totalRegisteredAndVoted, 2) ?? '-' }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
                    Total Registered and voted
                </dt>
            </dl>
        </div>
        <div class="col-span-1 md:col-span-1 xl:col-span-2 row-span-1 px-3 py-5 bg-teal-600 round-sm">
            <dl class="flex flex-col text-xs xl:text-base justify-between h-full">
                <dd>
                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                        {{ $filters.shortNumber(totalRegisteredAndNeverVoted, 2) ?? '-' }}
                    </div>
                </dd>
                <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
                    Total Registered but didn't vote
                </dt>
            </dl>
        </div>
        


        <!--  votes casted pie -->
        <div class="col-span-1 row-span-6 p-3 bg-white md:col-span-3 round-sm xl:col-span-6 max-h-[60rem]">
            <div class="relative flex flex-col justify-start h-full">
                <VotesCastedChart :chartDataVotesCasted$="chartDataVotesCasted$"
                    :chart-options="chartOptions"/>
            </div>
        </div>
        <!-- votes casted breakdown -->
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
let votesCastedAverage = ref(null);
let votesCastedMode = ref(null);
let votesCastedMedian = ref(null);
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

const chartDataVotesCasted$ = ref<object>();
const chartOptions = ref<object>();

function query() {
    let params = getQueryData()
    axios.get(route('catalystExplorer.metrics.votesCastedAverage'), { params })
        .then((res) => {
            votesCastedAverage.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });
    axios.get(route('catalystExplorer.metrics.votesCastedMode'), { params })
        .then((res) => {
            votesCastedMode.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });
    axios.get(route('catalystExplorer.metrics.votesCastedMedian'), { params })
        .then((res) => {
            votesCastedMedian.value = res?.data;
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

    axios.get(route('catalystExplorer.metrics.votesCastedRanges'), { params })
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

            chartDataVotesCasted$.value = {
                labels: keyArr,
                datasets: [
                    {
                        backgroundColor: [
                            '#a3899d', // 0 -1
                            '#917289', // 2-10
                            '#7e5a75', // 11 - 25
                            '#6c4262', // 26 - 50

                            '#5a2b4e', // 51 - 150
                            '#48143b', // 151 - 300
                            '#39102f', // 301 - 600

                            '#84c3da', // 601 - 900
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