<template>
    <Head title="Cardano Project Catalyst" />

    <section class="">
        <div class="flex flex-col gap-4 h-screen p-20">
            <div class="flex flex-col gap-4">
                <h2 class="text-teal-500 font-bold text-[60px] text-start">{{ animatedText }}</h2>

            <p class="text-[14px] text-blue-dark-500 mt-8 mb-4 w-[50%]">
                Project Catalyst propels collaborative innovation
                to new heights and fuels Cardano ecosystem expansion by
                connecting people with groundbreaking ideas to a funding source,
                collaborating with and voted for by the Cardano community, and
                spearheaded by the Cardano treasury.
            </p>
            <a
                href="https://docs.projectcatalyst.io/about-project-catalyst/what-is-project-catalyst"
                class="bg-teal-900 text-white py-2 px-8 rounded-lg w-[9%]"
                >Read more</a
            >
            </div>

            <div class="w-[100%] flex flex-col mt-20">
            <div class="mb-16">
                <h2  class="text-eggplant-500 font-bold text-[48px] mb-4">Idea journey</h2>
                <p   class="text-blue-dark-500 text-[14px]">
                    See how an idea comes to life within Project Catalyst.
                </p>
            </div>
            <div class="grid grid-cols-5 gap-8">

                <div class="flex flex-col rounded-[15px] shadow-lg bg-primary-20 p-8 text-center">
                    <h3 class="text-[20px] mb-4 text-teal-500">Submission</h3>
                    <p class="text-[16px]">Participants submit initial proposals for ideas to solve challenges. A set amount of ada is allocated to the new funding round.</p>
                </div>

                <div class="flex flex-col rounded-[15px] shadow-lg bg-primary-20 p-8 text-center">
                    <h3 class="text-[20px] mb-4 text-teal-500 ">Community reviews</h3>
                    <p class="text-[16px]">Community members share ideas and insights to refine the proposals.</p>
                </div>

                <div class="flex flex-col rounded-[15px] shadow-lg bg-primary-20 p-8 text-center">
                    <h3 class="text-[20px] mb-4 text-teal-500">Community voting</h3>
                    <p class="text-[16px]">Community members vote using the Project Catalyst voting app. Votes are weighted based on voter's token holding.</p>
                </div>

                <div class="flex flex-col rounded-[15px] shadow-lg bg-primary-20 p-8 text-center">
                    <h3 class="text-[20px] mb-4 text-teal-500">Voting results</h3>
                    <p class="text-[16px]">Votes are tallied and the results revealed. Voters and community reviewers receive their rewards.</p>
                </div>

                <div class="flex flex-col rounded-[15px] shadow-lg bg-primary-20 p-8 text-center">
                    <h3 class="text-[20px] mb-4 text-teal-500">Project onboarding</h3>
                    <p class="text-[16px]">Projects receive funding along with guidance to deliver them. Regular reports to the community ensure everything goes to plan.</p>
                </div>

            </div>
        </div>
        </div>

        <section class="my-16 bg-primary-20 p-20">
            <div class="grid grid-cols-4 gap-8">
                <div class="bg-teal-900 rounded-[15px] p-4">
                    <LargestWinningProposal :fundId="selectedFundRef" />
                </div>

                <div class="bg-teal-500/70 rounded-[15px] p-4">
                    <Over75k :fundId="selectedFundRef" />
                </div>

                <div class="bg-eggplant-500 rounded-[15px] p-4">
                    <MembersAwarded :fundId="selectedFundRef" />
                </div>

                <div class="bg-blue-dark-500 rounded-[15px] p-4">
                    <FundedAndCompleted :fundId="selectedFundRef" />
                </div>
            </div>

            <div class="flex flex-row justify-between gap-8 w-full p-3 mt-16">
                <div class="rounded-lg max-h-[60rem]">
                    <WalletBalanceChart
                        :attachment-link="attachmentLink"
                        :chartData1Registration1Vote$="
                            chartData1Registration1Vote$
                        "
                        :chart-options="chartOptions"
                    />
                </div>

                <div class="rounded-lg max-h-[60rem]">
                    <RegistrationChart :ada-power-ranges="adaPowerRanges" />
                </div>
            </div>

            <div class="flex flex-row justify-between gap-8">
                <!-- The pie by Ada Power -->
                <div class="relative w-full p-3 bg-white round-sm">
                    <div class="relative flex flex-col justify-start h-full">
                        <AdaPowerChart
                            :attachmentLink="attachmentLink"
                            :chart-data1-ada1-vote$="chartData1Ada1Vote$"
                            :chart-options="chartOptions"
                        />
                    </div>
                </div>
                <Suspense>
                    <div class="bg-white">
                        <VotingAggregates :fund-id="selectedFundRef" />
                    </div>

                    <template #fallback>
                        <div
                            class="bg-slate-200 md:col-span-4 round-sm animate-pulse"
                        >
                            <div class="grid h-full grid-cols-2"></div>
                        </div>
                    </template>
                </Suspense>
            </div>

            <div class="flex flex-row items-center justify-center mt-10">
                <a
                    class="px-8 py-4 rounded-[15px] bg-blue-dark-500 text-white menu-link text-lg"
                    :class="{
                        'text-yellow-500': $page.component.startsWith('Charts'),
                    }"
                    :href="route('catalyst-explorer.charts')"
                >
                    {{ $t("See more charts") }}
                </a>
            </div>
        </section>

        <div class="bg-teal-10 flex flex-row w-[60%] gap-8 m-auto mb-8">
            <img
                width="360"
                height="360"
                src="../../../../../public/img/speaker.jpg"
                alt="Speaker"
            />
            <div class="p-12">
                <h2 class="text-[40px] font-title text-blue-dark-500 mb-12">
                    Weekly Town Hall
                </h2>
                <p class="text-[24px] text-blue-dark-500/90 mb-8">
                    Join Project Catalyst team and community for our weekly town
                    hall followed by an open space with break out rooms.
                </p>
                <a
                    href="https://zoom.us/meeting/register/tJEtduyupzMvHNUczCQwfFJGcXzmw2lDwkIf#/registration"
                    class="bg-blue-dark-500 text-white py-2 px-8 rounded-lg"
                    >Join us</a
                >
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import { computed, watch, ref, defineAsyncComponent, onMounted } from "vue";
import route from "ziggy-js";
import Challenge from "@apps/catalyst-explorer/models/challenge";
import Over75k from "@apps/catalyst-explorer/modules/charts/Over75k.vue";
import LargestWinningProposal from "@apps/catalyst-explorer/modules/charts/LargestWinningProposal.vue";
import FundedAndCompleted from "@apps/catalyst-explorer/modules/charts/FundedAndCompleted.vue";
import WalletBalanceChart from "@apps/catalyst-explorer/modules/charts/WalletBalanceChart.vue";
import MembersAwarded from "@apps/catalyst-explorer/modules/charts/MembersAwarded.vue";
import RegistrationChart from "@apps/catalyst-explorer/modules/charts/RegistrationChart.vue";
import AdaPowerChart from "@apps/catalyst-explorer/modules/charts/AdaPowerChart.vue";
import { VARIABLES } from "@apps/catalyst-explorer/models/variables";
import axios from "@/global/utils/axios";
import Fund from "@apps/catalyst-explorer/models/fund";
import { storeToRefs } from "pinia";
import { useFundsStore } from "../stores/funds-store";
import BrowseByTaxonomy from "@apps/catalyst-explorer/modules/voterTool/BrowseByTaxonomy.vue";

const VotingAggregates = defineAsyncComponent(
    () => import("@apps/catalyst-explorer/modules/charts/VotingAggrigates.vue")
);

const props = withDefaults(
    defineProps<{
        funds: Fund[];
        challenges: Challenge[];
        categoriesFilter?: number | null,
        tagsFilter?: number | null,
        filters?: {
            fundId: number;
        };
        locale: string;
    }>(),
    {
        categoriesFilter: null,
    }
);


let adaPowerRanges = ref<{ key: string; count: number; total: number }[]>([]);
let fundedOver75KCount = ref<number>(null);

let selectedFundRef = ref<number | string>(props.filters?.fundId);

let currPage$ = ref<number>(1);
let perPage$ = ref<number>(36);

const attachmentLink = ref<string>(null);
let talliesSum$ = ref<number>(null);

getMetrics();
getAttachmentLink();

watch(
    [selectedFundRef],
    () => {
        query();
    },
    { deep: true }
);

watch([currPage$, perPage$], () => {
    fundedOver75KCount.value = fundedOver75KCount.value;
});

const chartDataVotesCastScatter$ = ref<object>();
const chartData1Registration1Vote$ = ref<object>();
const chartData1Ada1Vote$ = ref<object>();
const chartOptions = ref<object>();

function query() {
    const data = getQueryData();
    router.get(`/${props.locale}/catalyst-explorer/charts`, data, {
        preserveState: false,
        preserveScroll: false,
    });
}

function getMetrics() {
    const params = getQueryData();

    // fetch adaRanges
    axios
        .get(route("catalyst-explorer.metrics.adaPowerRanges"), { params })
        .then((res) => {
            adaPowerRanges.value = res?.data;

            let keyArr = [];
            let countArr = [];

            adaPowerRanges.value.forEach((power) => {
                keyArr.push(power.key);
                countArr.push(power.count);
            });
            chartData1Registration1Vote$.value = {
                labels: keyArr,
                datasets: [
                    {
                        backgroundColor: [
                            "#a3899d", // 450 - 1k
                            "#917289", // 1k - 5k
                            "#7e5a75", // 5K - 10k
                            "#6c4262", // 10K - 25k

                            "#5a2b4e", // 25k - 50k
                            "#48143b", // 50k - 75k
                            "#39102f", // 75k - 100k

                            "#84c3da", // 100k - 250k
                            "#66b5d1", // 250k - 500k
                            "#50abcb", // 500k - 750k
                            "#3aa0c4", //750k - 1M

                            "#fce865", // 1M - 5M
                            "#fcdf23", // 5M - 10M
                            "#e2c609", // 10M - 15M

                            "#ff9319", // 15M - 21M
                            "#ff8700", // 30M - 45M
                            "#ff8700", // 30M-45M

                            "#4bb92f", // 45M - 75M
                            "#8d00ff", // 75M - 100M

                            // '#E4578A' // 9M - 10M
                        ],
                        data: countArr,
                    },
                ],
            };

            keyArr = [];
            countArr = [];
            adaPowerRanges.value.forEach((power) => {
                keyArr.push(power.key);
                countArr.push(power.total);
            });
            chartData1Ada1Vote$.value = {
                labels: keyArr,
                datasets: [
                    {
                        backgroundColor: [
                            "#a3899d", // 450 - 1k
                            "#917289", // 1k - 5k
                            "#7e5a75", // 5K - 10k
                            "#6c4262", // 10K - 25k

                            "#5a2b4e", // 25k - 50k
                            "#48143b", // 50k - 75k
                            "#39102f", // 75k - 100k

                            "#84c3da", // 100k - 250k
                            "#66b5d1", // 250k - 500k
                            "#50abcb", // 500k - 750k
                            "#3aa0c4", //750k - 1M

                            "#fce865", // 1M - 5M
                            "#fcdf23", // 5M - 10M
                            "#e2c609", // 10M - 15M

                            "#ff9319", // 15M - 21M
                            "#ff8700", // 30M - 45M
                            "#ff8700", // 30M-45M

                            "#4bb92f", // 45M - 75M
                            "#8d00ff", // 75M - 100M

                            // '#E4578A' // 9M - 10M
                        ],
                        data: countArr,
                    },
                ],
            };

            chartDataVotesCastScatter$.value = {
                datasets: [
                    {
                        label: "Votes Cast",
                        fill: false,
                        borderColor: "#f87979",
                        backgroundColor: "#f87979",
                        data: [
                            {
                                x: 800,
                                y: 4,
                            },
                            {
                                x: 700,
                                y: 4,
                            },
                            {
                                x: 600,
                                y: 0,
                            },
                            {
                                x: 600,
                                y: 4,
                            },
                            {
                                x: 600,
                                y: 4,
                            },
                        ],
                    },
                ],
            };
            chartOptions.value = {
                responsive: true,
                maintainAspectRatio: false,
            };
        })
        .catch((error) => {
            console.error(error);
        });

    axios
        .get(route("catalystExplorerApi.talliesSum"), { params })
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

    axios
        .get(route("catalyst-explorer.attachments.votingPowers"), { params })
        .then((res) => (attachmentLink.value = res?.data))
        .catch((error) => {
            console.error(error);
        });
}
const originalText = "Project Catalyst";
const animatedText = ref("");

const animateText = () => {
    const textArray = originalText.split("");
    let currentIndex = 0;

    const intervalId = setInterval(() => {
        animatedText.value += textArray[currentIndex];
        currentIndex++;

        if (currentIndex === textArray.length) {
            clearInterval(intervalId);
        }
    }, 50); // Add a new letter every 1000 milliseconds (1 second)
    return {
        animatedText,
    };
};

const funds = () => {
    const {funds} = storeToRefs(useFundsStore())

    return funds
}

onMounted(() => {
    animateText();
    funds();
});

</script>
