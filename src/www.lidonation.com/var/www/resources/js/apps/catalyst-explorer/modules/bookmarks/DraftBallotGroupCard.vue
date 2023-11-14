<template>
    <div class="relative">
        <div class="px-5">
            <div class="flex flex-wrap gap-3 mb-4">

                <h2 class="text-sm md:text-md lg:text-2xl">{{ group.title }}</h2>
                <div class="flex items-center divide-x space-x-3 gap-1.5 text-xs lg:text-base">
                    <div>
                        <span class="mr-1">Items: </span>
                        <span>{{ group.items.length }}</span>
                    </div>

                    <div class="flex flex-row gap-1 space-x-3">
                        <div class="flex flex-row flex-1 w-1/2">
                            <span class="mr-1">total: </span>
                            <span>{{ totalLikes + totalUnlikes }}</span>
                        </div>
                        <div class="flex flex-row flex-1 w-1/2">
                            <HandThumbUpIcon aria-hidden="true" class="w-5 h-5 mr-1 text-gray-500" />
                            <span>{{ totalLikes }}</span>
                        </div>
                        <div class="flex flex-row flex-1 w-1/2">
                            <HandThumbDownIcon aria-hidden="true" class="w-5 h-5 mr-1 text-gray-500" />
                            <span> {{ totalUnlikes }}</span>
                        </div>
                    </div>

                    <div class="ml-2">
                        <span class="mr-1">Pot: </span>
                        <span>{{ $filters.currency(group.amount, group.fund?.currency, 'en-US', 4) }}</span>
                    </div>
                    <div class="flex items-center ml-2 font-bold lg:text-lg" :class="{
                        'text-teal-600': allotedBudget <= group.amount,
                        'text-red-600': allotedBudget > group.amount
                    }">
                        <span class="mr-1">Available Allotment: </span>
                        <span>{{ $filters.currency(group.amount - allotedBudget, group.fund?.currency, 'en-US', 4) }}</span>
                    </div>
                </div>
            </div>
            <div class="relative border rounded-md border-slate-200 bg-slate-50">
                <small
                    class="absolute bg-slate-50 rounded-sm -top-2 border border-slate-200 left-3 px-1 py-0.5 text-sm">Rationale
                    for this group</small>
                <textarea rows="8" name="rationale" id="rationale" v-model="rationale"
                    class="block w-full py-1.5 text-gray-900 pt-4 custom-input border-0 border-transparent round-sm bg-slate-50 ring-0 placeholder:text-gray-400 focus:ring-2 transition-all focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6 mt-0" />
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-7">
            <div class="relative col-span-4 overflow-x-visible">
                <div v-if="profileQuickView" class="absolute overflow-auto shadow-md w-96 h-[29rem] xl:right-3 xl:top-12">
                    <ProposalUserQuickView :profileQuickView="profileQuickView" @close="profileQuickView = null" />
                </div>
                <ul role="list"
                    class="mt-8 py-3 overflow-y-auto overflow-x-visible border border-l-0 border-gray-200 divide-y divide-gray-200 max-h-[33rem]">
                    <li class="ml-4" v-for="item in group.items" :key="item?.model?.id">
                        <div class="flex justify-start gap-1 px-4 py-4 lg:gap-0 hover:bg-gray-50">

                            <HandThumbIcons :proposal="item.model" @new-reaction="updateChart($event, item?.model)"
                                @reaction-update="updateChart($event, item?.model)" :key="updateIcons">
                                <div class="flex items-center gap-1">
                                    <TrashIcon @click.prevent="removeItem(item?.id)" aria-hidden="true"
                                        class="w-5 h-5 text-gray-500 hover:text-teal-600 hover:cursor-pointer" />
                                    <svg aria-hidden="true"
                                        class="inline w-5 h-5 text-slate-600 animate-spin fill-red-700"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        v-if="deletingItem && item.id === deletingId">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill" />
                                    </svg>
                                </div>
                            </HandThumbIcons>

                            <div class="flex items-center flex-1 sm:px-6">
                                <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                                    <div class="relative">
                                        <div class="flex flex-col text-md">
                                            <h4 class="text-sm font-medium xl:font-semibold xl:text-lg">
                                                <a :href="item?.model?.link" target="_blank"
                                                    class="text-sm font-medium xl:font-semibold xl:text-lg text-slate-700">
                                                    {{ item?.model?.title }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="mt-1">
                                            <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                <div class="flex items-center gap-2">
                                                    <div>{{ $t("Budget") }}</div>
                                                    <div class="font-semibold text-slate-700">
                                                        {{ $filters.currency(item?.model?.amount_requested,
                                                            item?.model?.currency) }}
                                                    </div>
                                                </div>
                                                <ProposalAuthors :proposal="item.model"
                                                    @profileQuickView="handleProfileQuickView($event)" :size="5" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-span-3 hideen lg:block">
                <div class="flex flex-col justify-center h-full px-10 py-5">
                    <Pie ref="pieChart" :data="chartData" :options="options" />
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import { DraftBallotGroup } from '../../models/draft-ballot';
import { TrashIcon, HandThumbUpIcon, HandThumbDownIcon } from '@heroicons/vue/20/solid';
import Proposal from '../../models/proposal';
import { VOTEACTIONS } from '../../models/vote-actions';
import route from 'ziggy-js';
import { watch, ref, Ref, computed } from 'vue';
import { debounce, cloneDeep } from 'lodash';
import { Chart as ChartJS, ArcElement, Tooltip, Legend, ChartOptions } from 'chart.js'
import { Pie } from 'vue-chartjs'
import { useBookmarksStore } from '../../stores/bookmarks-store';
import { storeToRefs } from 'pinia';
import { useUserStore } from '@/global/stores/user-store';
import ProposalAuthors from '../proposals/partials/ProposalAuthors.vue';
import ProposalUserQuickView from '../proposals/partials/ProposalUserQuickView.vue';
import HandThumbIcons from '../proposals/partials/HandThumbIcons.vue';

const props = defineProps<{
    group: DraftBallotGroup<Proposal>
}>();

const likes = ref(0);
const unlikes = ref(0);
const bookmarksStore = useBookmarksStore();
const userStore = useUserStore();
const { user$ } = storeToRefs(userStore);
const { collections$: storeCollections$, draftBallot$ } = storeToRefs(bookmarksStore);

const onLocal: Ref<boolean> = ref(false);
const inLastTenMins: Ref<boolean> = ref(false);
const collectionHash = ref(draftBallot$.value?.hash);
const pieChart = ref(null);
let updateIcons = ref(0);

let rationale = ref(props.group?.rationale?.content);
let canDelete: Ref<boolean> = ref();
let allotedBudget = computed(() => {
    return props.group?.items?.filter(
        (item) => item.model?.vote?.vote === VOTEACTIONS.UPVOTE
    ).reduce((acc, item) => (acc + item.model.amount_requested), 0);
});

let profileQuickView = ref(null);
let deletingItem = ref(false);
let deletingId = ref(null);

let handleProfileQuickView = (user: Author) => {
    profileQuickView.value = user;
}

ChartJS.register(ArcElement, Tooltip, Legend);
const chartData = ref(getChart());
const options: ChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
        },
        title: {
            display: false
        }
    }
};

watch([onLocal, inLastTenMins], () => {
    canDelete.value = (onLocal.value && inLastTenMins.value) || user$.value?.id === draftBallot$.value?.user_id;
});

watch(rationale, debounce(() => saveRationale(), 700));

function removeItem(id: number) {
    if (canDelete) {
        deletingItem.value = true;
        deletingId.value = id;
        axios.delete(route('catalyst-explorer.bookmarkItem.delete', { bookmarkItem: id }))
            .then((res) => {
                if(res.status === 200){
                    bookmarksStore.deleteItem(id, collectionHash.value);
                    bookmarksStore.loadDraftBallot();
                }
            })
            .catch((error) => {
                if (error.response && error.response.status === 403) {
                    console.error(error);
                }
            });
    }
}

function saveRationale() {
    router.post(
        route('catalyst-explorer.draftBallot.storeRationale', { draftBallot: draftBallot$.value?.hash }),
        { rationale: rationale.value, group_id: props.group?.id, title: props.group?.title },
        {
            preserveScroll: true,
            preserveState: true,
            replace: true
        }
    );
}

const totalLikes = computed(() => {
    return likes.value + props.group?.items?.reduce((acc, item) => {
        return acc + (item.model?.vote?.vote === VOTEACTIONS.UPVOTE ? 1 : 0);
    }, 0) || 0;
});

const totalUnlikes = computed(() => {
    return unlikes.value + props.group?.items?.reduce((acc, item) => {
        return acc + (item.model?.vote?.vote === VOTEACTIONS.DOWNVOTE ? 1 : 0);
    }, 0) || 0;
});



function getChart() {
    return {
        labels: [
            'Allotted',
            (props.group?.amount - allotedBudget.value) > 0 ? 'Pot Balance Left' : 'Over Budget By'
        ],
        datasets: [
            {
                backgroundColor: [
                    (props.group?.amount - allotedBudget.value) > 0 ? '#1d7898' : '#cd4e7c',
                    (props.group?.amount - allotedBudget.value) > 0 ? '#d6d3d1' : '#9f3c60',
                ],
                data: [
                    allotedBudget.value,
                    (props.group?.amount - allotedBudget.value)
                ]
            }
        ]
    }
}

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: { original_url: string }[]
}

let updateChart = async (vote, proposal) => {
    if (proposal.vote) {
        updateIcons.value = updateIcons.value + 1
        await bookmarksStore.loadDraftBallot();
        if (vote === VOTEACTIONS.UPVOTE) {
            likes.value = likes.value === 1 ? 1 : 0;
            unlikes.value = 0;
        } else if (vote === VOTEACTIONS.DOWNVOTE) {
            unlikes.value = unlikes.value === 1 ? 1 : 0;
            likes.value = 0;
        }
        setTimeout(() => {
            chartData.value = cloneDeep(getChart());
            pieChart.value?.chart.update('active');
        }, 100);

    } else {
        updateIcons.value = updateIcons.value + 1
        await bookmarksStore.loadDraftBallot();
        setTimeout(() => {
            chartData.value = cloneDeep(getChart());
            pieChart.value?.chart.update('active');
        }, 100);

    }
}
</script>
