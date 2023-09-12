<template>
    <header-component titleName0="catalyst" titleName1="by the Numbers"
        subTitle="View projects charts and filter results based on funds" />
    <section class="flex flex-col gap-2 bg-primary-20">
        <div class="container relative w-full">
            <div class="flex w-full items-center justify-end space-x-0.5 mt-4 gap-2">
                <div class="text-xs w-[240px] lg:w-[330px] lg:text-base">
                    <Multiselect placeholder="All Funds" value-prop="value" label="label" v-model="selectedFundRef"
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
            <div class="grid h-full grid-cols-1 grid-rows-1 gap-4 md:grid-cols-3 xl:grid-cols-5 xl:grid-rows-6">
                <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-600 round-sm">
                    <dl class="relative flex flex-col justify-between h-full">
                        <div class="absolute top-0 right-0 px3">
                            <a v-if="amount_requested > 0" type="button" :href="link ?? null"
                                class="inline-flex items-center px-1.5 py-1 border border-white hover:border-accent-700 shadow-xs text-xs font-semibold rounded-sm text-white bg-transparent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-600 hover:bg-accent-600">
                                View
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                        <dd class="pointer-events-none">
                            <div class="relative text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                                <div v-if="amount_requested > 0">
                                    ${{ $filters.shortNumber(amount_requested) }}
                                </div>
                                <div v-else>
                                    0
                                </div>
                            </div>
                        </dd>
                        <dt class="mt-3 text-lg font-medium text-gray-200 truncate pointer-events-none">
                            Largest Winning Proposal
                        </dt>
                    </dl>
                </div>

                <div class="relative col-span-1 row-span-1 px-3 py-5 bg-white round-sm">
                    <dl class="flex flex-col justify-between h-full">
                        <dd>
                            <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl text-blue-dark-500">
                                {{ $filters.number(fundedOver75KCount) }}
                            </div>
                        </dd>
                        <dt class="mt-3 text-lg font-medium truncate text-blue-dark-500">
                            Funded >= 75K
                        </dt>
                    </dl>
                </div>

                <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-600 round-sm">
                    <dl class="flex flex-col justify-between h-full">
                        <dd>
                            <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                                {{ $filters.number(membersAwardedFundingCount) }}
                            </div>
                        </dd>
                        <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                            Members Awarded Funding
                        </dt>
                    </dl>
                </div>

                <div class="relative col-span-1 row-span-1 p-3 bg-blue-dark-500 md:col-span-3 xl:col-span-2 round-sm">
                    <div class="flex flex-row flex-wrap items-start justify-between h-full md:flex-nowrap">
                        <div>
                            <dl class="flex flex-col justify-between">
                                <dd>
                                    <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                                        {{ fullyDisbursedProposalsCount }}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Proposals with Fully Disbursed Funds
                                </dt>
                            </dl>
                        </div>

                        <div class="ml-auto md:mt-auto">
                            <dl class="flex flex-col justify-between text-right">
                                <dd>
                                    <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                                        {{ $filters.number(completedProposalsCount) }}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Completed Proposals
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="relative w-full col-span-1 row-span-6 p-3 bg-white md:col-span-3 round-sm">
                    <div class="relative flex flex-col justify-start h-full">
                        <div class="flex flex-wrap items-start justify-between">
                            <div class="text-teal-600">
                                <h2 class="mb-0 xl:text-3xl">
                                    1 stake key 1 Vote Ranges
                                </h2>
                                <p>Pie chart of wallet balance</p>
                            </div>
                            <div v-if="attachementLink">
                                <Attachment :attachementLink="attachementLink"/>
                            </div>
                        </div>

                        <div class="my-auto" v-if="chartData1Ada1Vote$">
                            <AdaPowerRangesPie :chartData="chartData1Ada1Vote$" :options="chartOptions" />
                        </div>
                    </div>
                </div>

                <div
                    class="w-full col-span-1 p-3 overflow-x-visible overflow-y-scroll bg-white md:col-span-3 xl:col-span-2 xl:row-span-6 round-sm">
                    <div class="text-blue-dark-500">
                        <h2 class="mb-0 xl:text-3xl">
                            Wallet Voting Ada Power Breakdowns
                        </h2>
                        <p>Ranges of wallet balance</p>
                    </div>
                    <div class="relative w-full mt-8">
                        <ul role="list" class="divide-y divide-gray-200 max-h-[42rem] overflow-y-auto">
                            <li v-for="(range) in adaPowerRanges" class="flex items-center justify-start w-full gap-4 py-4">
                                <div
                                    class="flex items-center justify-center w-20 h-20 p-2 text-center rounded-full bg-slate-300">
                                    <span class="text-base">{{ range['key'] }} ₳</span>
                                </div>

                                <div class="">
                                    <p class="text-lg lg:text-xl xl:text-2xl 2xl:text-3xl text-slate-500">
                                        {{ range['count'] }} <span
                                            class="text-slate-300 text-md lg:text-lg xl:text-2xl 2xl:text-2xl">Wallets</span>
                                    </p>
                                </div>

                                <div class="pr-2 ml-auto">
                                    <p class="text-md lg:text-lg xl:text-2xl text-slate-500">
                                        <span class="mr-2 text-slate-400">₳</span>{{ $filters.shortNumber(range['total'],
                                            2) }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="w-full col-span-1 p-3 overflow-y-visible bg-white md:col-span-3 xl:col-span-5 xl:row-span-12 round-sm">
                    <div class="text-blue-dark-500">
                        <h2 class="flex items-end gap-2 mb-0 xl:text-3xl">
                            <span>Proposal Live Tally</span>
                            <span v-if="tallyUpdatedAt" class="text-xl font-bold text-teal-500">
                                Last updated:
                                <timeago :datetime="tallyUpdatedAt" />
                            </span>
                        </h2>
                        <p>
                            This shows how many wallets have expressed an opinion for a proposal.
                            <!-- This shows how many times a proposal has been voted on. -->
                            We won't know the yes or no vote until after the voting period ends.
                        </p>
                    </div>

                    <div class="py-4">
                        <div class="h-16 my-4 border border-r-0 rounded-sm">
                            <div class="flex flex-wrap w-full gap-2">
                                <div class="flex flex-1 max-w-[24rem] border-r">
                                    <ChallengePicker v-model="challengesRef" />
                                </div>
                                <div class="flex flex-1 w-full">
                                    <Search :search="search$" @search="(term) => search$ = term"></Search>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative w-full my-8" v-if="tallies$">
                        <div
                            class="pb-10 my-8 -mx-4 overflow-y-visible ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-sm">
                            <table class="min-w-full divide-y divide-slate-300">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 sm:pl-4">
                                            <div class="flex gap-0.5 items-center flex-nowrap hover:cursor-pointer w-16 justify-start text-left"
                                                @click="toggleOrder()">
                                                <span>{{ $t("Tally") }}</span>
                                                <span class="flex items-center gap-1 text-teal-600 flex-nowrap">
                                                    <span>
                                                        <ChevronUpDownIcon class="w-4 h-4" />
                                                    </span>
                                                    <span>{{ order$ }}</span>
                                                </span>
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-4">
                                            {{ $t("Proposal") }}
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:w-32 text-slate-900 sm:pl-4">
                                            {{ $t("Budget") }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200 text-slate-900">
                                    <tr v-for="tally in tallies$?.data">
                                        <td
                                            class="w-16 py-4 pl-4 text-sm text-left max-w-0 sm:w-auto sm:max-w-none sm:pl-4">
                                            {{ tally.tally }}
                                        </td>

                                        <td class="w-full py-4 pl-4 pr-3 text-sm max-w-0 sm:w-auto sm:max-w-none sm:pl-4">
                                            <a target="_blank" :href="tally?.model?.link">{{ tally?.model?.title }}</a>
                                        </td>

                                        <td class="w-full py-4 pl-4 pr-3 text-sm max-w-0 sm:w-32 sm:max-w-none sm:pl-4">
                                            <span class="block">
                                                {{ $filters.currency(tally?.model?.amount_requested,
                                                    tally?.model?.fund?.currency, 'en-US', 2) }}
                                            </span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="flex items-center justify-between w-full gap-16 my-16 xl:gap-24">
                                <div class="flex-1 w-full px-6">
                                    <Pagination :links="tallies$.links" :per-page="perPage$" :total="tallies$?.total"
                                        :from="tallies$?.from" :to="tallies$?.to"
                                        @perPageUpdated="(payload) => (perPage$ = payload) && getTallies()"
                                        @paginated="(payload) => (currPage$ = payload) && getTallies()" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="relative w-full col-span-1 row-span-6 p-3 bg-white md:col-span-3 round-sm">
                    <div class="relative flex flex-col justify-start h-full">
                        <div class="flex flex-wrap items-start justify-between">
                            <div class="text-teal-600">
                                <h2 class="mb-0 xl:text-3xl">
                                    Vote Tallies
                                </h2>
                                <p>
                                    Votes cast as of <timeago :datetime="tallyUpdatedAt" />
                                </p>
                            </div>
                        </div>

                        <div class="my-auto" v-if="chartDataVotesCastScatter$">
                            <VoteTallyScatterChart :chartData="chartDataVotesCastScatter$" :options="chartOptions" />
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import { router, usePage } from '@inertiajs/vue3';
import { watch, ref } from 'vue';
import AdaPowerRangesPie from "../modules/charts/AdaPowerRangesPie.vue";
import Attachment from '../modules/charts/Attachment.vue';
import { VARIABLES } from "../models/variables";
import { computed } from 'vue';
import Proposal from '../models/proposal';
import Fund from '../models/fund';
import axios from '../../lib/utils/axios';
import route from 'ziggy-js';
import Pagination from '../Shared/Components/Pagination.vue';
import { ChevronUpDownIcon } from '@heroicons/vue/20/solid';
import Search from '../Shared/Components/Search.vue';
import ChallengePicker from '../modules/funds/ChallengePicker.vue';
import Challenge from '../models/challenge';


const props = withDefaults(
    defineProps<{
        funds: Fund[],
        challenges: Challenge[],
        filters?: {
            fundId: number,
        },
        locale: string,
    }>(), {});

let adaPowerRanges = ref<{ 'key': string, 'count': number, 'total': number }[]>([]);
let largestFundedProposalObject = ref<Proposal>(null);
let fundedOver75KCount = ref<number>(null);
let membersAwardedFundingCount = ref<number>(null);
let fullyDisbursedProposalsCount = ref<number>(null);
let completedProposalsCount = ref<number>(null);
let challengesRef = ref<Challenge[]>(props.challenges);

const baseUrl = usePage().props.base_url;

let selectedFundRef = ref<number>(props.filters.fundId);

let amount_requested = ref<number>(0);
let link = ref<string>('');

let tallies$ = ref<{
    links: [],
    total: number,
    to: number,
    from: number,
    data: any[]
}>(null);

let currPage$ = ref<number>(1);
let perPage$ = ref<number>(36);
let order$ = ref<string>('asc');
let search$ = ref<string>(null);
let tallyUpdatedAt = ref<string>(null);
const attachementLink = ref<string>(null);

const fundsLabelValue = computed(() => {
    return props?.funds?.map((fund) => {
        return { 'label': fund.title, 'value': fund.id }
    })
});

getMetrics();
getTallies();
getUpdatedDate();
getAttachmentLink();

watch([search$], () => {
    getTallies();
}, { deep: true });

watch([challengesRef], () => {
    getTallies();
}, { deep: true });

watch([selectedFundRef], () => {
    query();
}, { deep: true });

watch([largestFundedProposalObject], () => {
    amount_requested.value = largestFundedProposalObject.value.amount_requested;
    link.value = largestFundedProposalObject.value.link;
});

watch([currPage$, perPage$], () => {
    fundedOver75KCount.value = fundedOver75KCount.value;
});

const chartDataVotesCastScatter$ = ref<object>();
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

    // get largest funded
    axios.get(`${usePage().props.base_url}/catalyst-explorer/charts/metrics/largestFundedProposalObject`, { params })
        .then((res) => largestFundedProposalObject.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    // proposals funded over 75k
    axios.get(`${usePage().props.base_url}/catalyst-explorer/charts/metrics/fundedOver75KCount`, { params })
        .then((res) => fundedOver75KCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    // count members awarded funding
    axios.get(`${usePage().props.base_url}/catalyst-explorer/charts/metrics/membersAwardedFundingCount`, { params })
        .then((res) => membersAwardedFundingCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    // count fully disbursed proposals
    axios.get(`${usePage().props.base_url}/catalyst-explorer/charts/metrics/fullyDisbursedProposalsCount`, { params })
        .then((res) => fullyDisbursedProposalsCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    // count completed proposals
    axios.get(`${usePage().props.base_url}/catalyst-explorer/charts/metrics/completedProposalsCount`, { params })
        .then((res) => completedProposalsCount.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

    // fetch adaRanges
    axios.get(`${usePage().props.base_url}/catalyst-explorer/charts/metrics/adaPowerRanges`, { params })
        .then((res) => {
            adaPowerRanges.value = res?.data;

            let keyArr = [];
            let countArr = [];

            adaPowerRanges.value.forEach(power => {
                keyArr.push(power.key);
                countArr.push(power.count);
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
}

function getQueryData() {
    const data = {};
    if (selectedFundRef.value) {
        data[VARIABLES.FUNDS] = selectedFundRef.value;
    }

    return data;
}

function toggleOrder() {
    if (order$.value === 'asc') {
        order$.value = 'desc';
    } else {
        order$.value = 'asc';
    }

    getTallies();
}

function getTallies() {
    axios.get(
        route('catalystExplorerApi.tallies'),
        {
            params: {
                p: currPage$.value,
                pp: perPage$.value,
                o: order$.value,
                s: search$.value,
                c: challengesRef.value?.map((challenge) => (challenge.id || challenge))
            }
        })
        .then((res) => {
            tallies$.value = res?.data;
            perPage$.value = res?.data?.per_page;
            currPage$.value = res?.data?.page;
        })
        .catch((error) => {
            console.error(error);
        });


}
function getUpdatedDate() {
    axios.get(route('catalystExplorerApi.talliesDate'))
        .then((res) => {
            tallyUpdatedAt.value = res?.data?.updated_at;
        });
}

function getAttachmentLink() {
    const params = getQueryData();

    axios.get(route('catalystExplorer.attachment'), { params })
        .then((res) => attachementLink.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

}


</script>

