<template>
    <Head title="Cardano Project Catalyst"/>

    <section class="py-16">
        <div class="container">
            <div class="flex flex-row gap-8 items-center justify-between py-16">
                <div class="flex flex-col gap-4">
                    <h2 class="text-teal-500 font-bold text-[24px] sm:text-[36px] xl:text-[60px] text-start">
                        {{ animatedText }}
                    </h2>

                    <p class="xl:text-[14px] text-[12px] text-blue-dark-500 mt-8 mb-4 w-[80%] xl:w-[50%]">
                        Project Catalyst propels collaborative innovation to new
                        heights and fuels Cardano ecosystem expansion by
                        connecting people with groundbreaking ideas to a funding
                        source, collaborating with and voted for by the Cardano
                        community, and spearheaded by the Cardano treasury.
                    </p>
                    <!-- <a
                        href="https://docs.projectcatalyst.io/about-project-catalyst/what-is-project-catalyst"
                        class="bg-teal-900 text-white py-2 rounded-sm w-[15%] text-center"
                        target="_blank"
                    >Read more</a
                    > -->
                </div>
                <div class="w-40 rounded-sm lg:w-32 xl:w-100">
                    <img
                        alt="catalyst explorer logo"
                        src="/img/catalyst-explorer-logo.jpg"
                    />
                </div>
            </div>

            <div class="w-[100%] flex flex-col border-t-2 border-eggplant-600 py-16">
                <div class="mb-10">
                    <h2 class="text-eggplant-500 font-bold text-[48px] mb-4">
                        Idea journey
                    </h2>
                    <p class="text-blue-dark-500 text-[14px]">
                        See how an idea comes to life within Project Catalyst.
                    </p>
                </div>
                <div class="grid xl:grid-cols-5 sm:grid-cols-3 xs:grid-cols-1 gap-8">
                    <div
                        class="flex flex-col rounded-sm shadow-md bg-primary-20 p-8 text-center"
                    >
                        <h3 class="text-[20px] mb-4 text-teal-500">
                            Submission
                        </h3>
                        <p class="text-[16px]">
                            Participants submit initial proposals for ideas to
                            solve challenges. A set amount of ada is allocated
                            to the new funding round.
                        </p>
                    </div>

                    <div
                        class="flex flex-col rounded-sm shadow-md bg-primary-20 p-8 text-center"
                    >
                        <h3 class="text-[20px] mb-4 text-teal-500">
                            Community reviews
                        </h3>
                        <p class="text-[16px]">
                            Community members share ideas and insights to refine
                            the proposals.
                        </p>
                    </div>

                    <div
                        class="flex flex-col rounded-sm shadow-md bg-primary-20 p-8 text-center"
                    >
                        <h3 class="text-[20px] mb-4 text-teal-500">
                            Community voting
                        </h3>
                        <p class="text-[16px]">
                            Community members vote using the Project Catalyst
                            voting app. Votes are weighted based on voter's
                            token holding.
                        </p>
                    </div>

                    <div
                        class="flex flex-col rounded-sm shadow-md bg-primary-20 p-8 text-center"
                    >
                        <h3 class="text-[20px] mb-4 text-teal-500">
                            Voting results
                        </h3>
                        <p class="text-[16px]">
                            Votes are tallied and the results revealed. Voters
                            and community reviewers receive their rewards.
                        </p>
                    </div>

                    <div
                        class="flex flex-col rounded-sm shadow-md bg-primary-20 p-8 text-center"
                    >
                        <h3 class="text-[20px] mb-4 text-teal-500">
                            Project onboarding
                        </h3>
                        <p class="text-[16px]">
                            Projects receive funding along with guidance to
                            deliver them. Regular reports to the community
                            ensure everything goes to plan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="flex flex-col gap-1 mb-16">
                <h1 class="text-2xl font-semibold lg:text-3xl 2xl:text-4xl text-slate-900">
                    Catalyst <span class="text-teal-600"> by the Numbers</span>
                </h1>
                <p class="text-slate-600">
                    View projects charts and filter results based on funds
                </p>
            </div>

            <div class="grid xl:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-8">
                <div class="bg-teal-900 rounded-sm p-4">
                    <LargestWinningProposal :fundId="selectedFundRef"/>
                </div>

                <div class="bg-teal-500/70 rounded-sm p-4">
                    <Over75k :fundId="selectedFundRef"/>
                </div>

                <div class="bg-eggplant-500 rounded-sm p-4">
                    <MembersAwarded :fundId="selectedFundRef"/>
                </div>

                <div class="bg-blue-dark-500 rounded-sm p-4">
                    <FundedAndCompleted :fundId="selectedFundRef"/>
                </div>
            </div>

            <div class="flex xl:flex-row flex-col justify-between gap-8 w-full mt-8">
                <div class="rounded-sm max-h-[60rem] bg-white xl:w-[60%] p-4">
                    <WalletBalanceChart
                        :attachment-link="attachmentLink"
                        :chartData1Registration1Vote$="
                            chartData1Registration1Vote$
                        "
                        :chart-options="chartOptions"
                    />
                </div>

                <div class="rounded-sm max-h-[60rem] bg-white xl:w-[40%] p-4">
                    <RegistrationChart :ada-power-ranges="adaPowerRanges"/>
                </div>
            </div>

            <div class="flex xl:flex-row flex-col justify-between gap-8 mt-8">
                <div class="rounded-sm max-h-[60rem] bg-white p-4 xl:w-[60%]">
                    <AdaPowerChart
                        :attachmentLink="attachmentLink"
                        :chart-data1-ada1-vote$="chartData1Ada1Vote$"
                        :chart-options="chartOptions"
                    />
                </div>
                <Suspense>
                    <div class="bg-white xl:w-[40%]">
                        <VotingAggregates :fund-id="selectedFundRef"/>
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

            <div class="flex flex-row items-center justify-center mt-16">
                <a
                    class="px-8 py-4 rounded-sm bg-blue-dark-500 text-white menu-link text-lg"
                    :class="{
                        'text-yellow-500': $page.component.startsWith('Charts'),
                    }"
                    :href="route('catalyst-explorer.charts')"
                >
                    {{ $t("See more numbers") }}
                </a>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container">
            <div class="bg-teal-10 flex flex-col xl:flex-row gap-8 m-auto">
                <img
                    width="360"
                    height="360"
                    src="../../../../../public/img/speaker.png"
                    alt="Speaker"
                    class="hidden xl:block"
                />
                <div class="p-4 xl:p-12 flex flex-col item-center justify-center">
                    <h2 class="text-[24px] xl:text-[40px] text-blue-dark-500 mb-12 text-center xl:text-start">
                        Weekly Town Hall
                    </h2>
                    <p class="text-[16px] text-center xl:text-start xl:text-[24px] text-blue-dark-500/90 mb-8">
                        Join Project Catalyst team and community for our weekly town
                        hall followed by an open space with break out rooms.
                    </p>
                    <div class="flex flex-row items-center justify-center xl:items-start xl:justify-start gap-2.5 w-full">
                        <a
                            href="https://bit.ly/3rCicSR"
                            target="_blank"
                            class="bg-blue-dark-500 text-white py-2 px-5 rounded-sm items-center inline-flex gap-1.5">
                            <span>Register for the next meeting</span>
                            <ArrowTopRightOnSquareIcon class="w-4 h-4"/>
                        </a>
                        <a
                            href="https://forms.gle/rQrrZSCVEyekF8sG9"
                            target="_blank"
                            class="border-2 border-blue-dark-500 text-blue-dark-500 py-2 items-center px-5 inline-flex gap-1.5 rounded-sm"
                        >
                            <span>Signup to Host breakout room</span>
                            <ArrowTopRightOnSquareIcon class="w-4 h-4"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-primary-20/60">
        <div class="container">
            <div class="mb-8">
                <h2 class="font-bold text-[48px] mb-1">
                    Catalyst <span class="text-teal-500">Posts</span>
                </h2>
                <p>Latest news and articles from our library</p>
            </div>

            <ul class="grid xl:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1">
                <li v-for="post in posts" :key="post.id"
                    class="border-2 -m-px xl:-ml-px border-eggplant-500 p-4 flex flex-col justify-start">
                    <img v-if="post.image" :src="post.image" alt="Post Image" class="w-full object-cover mb-2">

                    <div class="flex flex-col justify-between flex-1">
                        <div>
                            <h2 class="text-2xl font-bold hover:text-teal-500 mb-4">{{ post.title }}</h2>
                            <h3 class="text-xl font-normal">{{ post.subtitle }}</h3>
                        </div>

                        <div class="flex flex-row items-center gap-2 mt-4">
                            <p class="text-sm bg-teal-10 rounded-sm px-2">{{ post.published_at }}</p>
                            <div class="flex flex-row items-center gap-2 text-sm bg-teal-10 rounded-sm px-2">
                                <img v-if="post.author_gravatar" :src="post.author_gravatar" alt="Author avatar"
                                     class="w-4 h-4 rounded-full">
                                <p>{{ post.author }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="flex flex-row items-center text-base text-black/60 gap-3 mt-1">
                        <p>Continue reading</p>
                        <ArrowRightIcon class="w-10 h-6"/>
                    </a>
                </li>
            </ul>

            <div class="mt-10">
                <a
                    class="px-8 py-4 rounded-sm bg-blue-dark-500 text-white inline-flex flex-row gap-0.5 text-lg"
                    href="/tags/project-catalyst">
                    <span>{{ $t("See more Catalyst news & content") }}</span>
                    <ArrowRightIcon class="w-10 h-6"/>
                </a>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import {Head, router, Link} from "@inertiajs/vue3";
import {watch, ref, defineAsyncComponent, onMounted} from "vue";
import {ArrowRightIcon} from "@heroicons/vue/24/solid";
import {ArrowTopRightOnSquareIcon} from "@heroicons/vue/24/solid";
import route from "ziggy-js";
import Challenge from "@apps/catalyst-explorer/models/challenge";
import Over75k from "@apps/catalyst-explorer/modules/charts/Over75k.vue";
import LargestWinningProposal from "@apps/catalyst-explorer/modules/charts/LargestWinningProposal.vue";
import FundedAndCompleted from "@apps/catalyst-explorer/modules/charts/FundedAndCompleted.vue";
import WalletBalanceChart from "@apps/catalyst-explorer/modules/charts/WalletBalanceChart.vue";
import MembersAwarded from "@apps/catalyst-explorer/modules/charts/MembersAwarded.vue";
import RegistrationChart from "@apps/catalyst-explorer/modules/charts/RegistrationChart.vue";
import AdaPowerChart from "@apps/catalyst-explorer/modules/charts/AdaPowerChart.vue";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import axios from "axios";
import Fund from "@apps/catalyst-explorer/models/fund";

const VotingAggregates = defineAsyncComponent(
    () => import("@apps/catalyst-explorer/modules/charts/VotingAggrigates.vue")
);

const props = withDefaults(
    defineProps<{
        funds: Fund[];
        challenges: Challenge[];
        filters?: {
            fundId: number;
        };
        locale: string;
    }>(),
    {}
);

let adaPowerRanges = ref<{ key: string; count: number; total: number }[]>([]);
let fundedOver75KCount = ref<number>(null);

let selectedFundRef = ref<number | null>(props.filters?.fundId);

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
    {deep: true}
);

// watch([currPage$, perPage$], () => {
//     fundedOver75KCount.value = fundedOver75KCount.value;
// });

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
        .get(route("catalyst-explorer.metrics.adaPowerRanges"), {params})
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
        .get(route("catalystExplorerApi.talliesSum"), {params})
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
        .get(route("catalyst-explorer.attachments.votingPowers"), {params})
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

const posts = ref([]);

//get the title and content from the post array

const fetchPosts = async () => {
    axios
        .get(route("catalystExplorerApi.posts"))
        .then((res) => {
            const allPosts = res.data;
            posts.value = allPosts.slice(0, 4);
        })
        .catch((error) => {
            console.log(error);
        });
};

onMounted(() => {
    animateText();
    fetchPosts();
});
</script>
