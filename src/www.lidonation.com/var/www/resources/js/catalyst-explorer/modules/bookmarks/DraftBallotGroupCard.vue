<template>
<div>
    <div class="px-5">
        <div class="flex flex-wrap gap-3 mb-4">
            <h2 class="text-sm md:text-md lg:text-2xl">{{ group.title }}</h2>
            <div class="flex items-center divide-x space-x-3 divide-gray-200 gap-1.5 text-xs lg:text-base">
                <div>
                    <span class="mr-1">Items: </span>
                    <span>{{ group.items.length }}</span>
                </div>
                <div class="ml-2">
                    <span class="mr-1">Pot: </span>
                    <span>{{ group.amount }}</span>
                </div>
                <div class="flex items-center ml-2 font-bold lg:text-lg" :class="{
                    'text-teal-600': allotedBudget <= group.amount,
                    'text-red-600': allotedBudget > group.amount
                }">
                    <span class="mr-1">Available Allotment: </span>
                    <span>{{ group.amount - allotedBudget }}</span>
                </div>
            </div>
        </div>
        <div class="relative border rounded-md border-slate-200 bg-slate-50">
            <small class="absolute bg-slate-50 rounded-sm -top-2 border border-slate-200 left-3 px-1 py-0.5 text-sm z-10">Rationale for this group</small>
            <textarea rows="8" name="rationale" id="rationale" v-model="rationale"
            class="block w-full py-1.5 text-gray-900 pt-4 custom-input border-0 border-transparent round-sm bg-slate-50 ring-0 placeholder:text-gray-400 focus:ring-2 transition-all focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6 mt-0" />
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-7">
        <div class="col-span-4">
            <ul role="list" class="mt-8 py-3 overflow-auto border border-l-0 border-gray-200 divide-y divide-gray-200 max-h-[33rem]">
                <li class="ml-4" v-for="item in group.items" :key="item?.model?.id">
                    <div class="flex justify-start gap-1 px-4 py-4 lg:gap-0 hover:bg-gray-50">
                        <div class="flex flex-col flex-none w-16 gap-2 px-1 py-2 rounded-sm" :class="{
                            'bg-teal-light-100/50': item.model.vote?.vote === VOTEACTIONS.UPVOTE,
                            'bg-red-100/80': item.model.vote?.vote === VOTEACTIONS.DOWNVOTE,
                            'bg-slate-100': !item.model.vote
                        }">
                            <div class="flex gap-1 flex-nowrap">
                                <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.UPVOTE, item.model)">
                                    <HandThumbUpIcon :class="[item.model.vote?.vote === VOTEACTIONS.UPVOTE ? 'text-teal-700' : 'text-gray-500']"
                                    aria-hidden="true" class="w-6 h-6 text-gray-500 hover:text-yellow-700 hover:cursor-pointer" />
                                </div>
                                <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.DOWNVOTE, item.model)">
                                    <HandThumbDownIcon aria-hidden="true"
                                    :class="[item?.model?.vote?.vote === VOTEACTIONS.DOWNVOTE ? 'text-pink-800' : 'text-gray-500']"
                                    class="w-6 h-6 hover:text-yellow-700 hover:cursor-pointer" />
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <TrashIcon @click.prevent="removeItem(item?.id)" aria-hidden="true"
                                class="w-5 h-5 text-gray-500 hover:text-teal-600 hover:cursor-pointer" />
                            </div>
                        </div>
                        <div class="flex items-center flex-1 sm:px-6">
                            <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                                <div class="">
                                    <div class="flex flex-col text-md">
                                        <a :href="item?.model?.link" target="_blank" class="text-sm font-medium xl:font-semibold xl:text-lg text-slate-700">
                                            {{ item?.model?.title }}
                                        </a>
                                    </div>
                                    <div class="mt-1">
                                        <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                            <div class="flex items-center gap-1">
                                                <div>{{ $t("Budget") }}</div>
                                                <div class="font-semibold text-slate-700">
                                                    {{ $filters.currency(item?.model?.amount_requested, item?.model?.currency) }}
                                                </div>
                                                <ProposalAuthors :proposal="item.model" @profileQuickView="handleProfileQuickView($event)"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="relative">
                <ProposalUserQuickView v-if="profileQuickView"
                    :profileQuickView="profileQuickView"
                    @close="profileQuickView = null" />
            </div>
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
import {TrashIcon, HandThumbUpIcon, HandThumbDownIcon} from '@heroicons/vue/20/solid';
import Proposal from '../../models/proposal';
import { VOTEACTIONS } from '../../models/vote-actions';
import route from 'ziggy-js';
import { watch, ref, Ref, computed } from 'vue';
import { debounce, cloneDeep } from 'lodash';
import { Chart as ChartJS, ArcElement, Tooltip, Legend, ChartOptions } from 'chart.js'
import { Pie } from 'vue-chartjs'
import { useBookmarksStore } from '../../stores/bookmarks-store';
import { storeToRefs } from 'pinia';
import { useUserStore } from '../../../global/Shared/store/user-store';
import ProposalAuthors from '../proposals/partials/ProposalAuthors.vue';
import ProposalUserQuickView from '../proposals/partials/ProposalUserQuickView.vue';

const props = defineProps<{
    group: DraftBallotGroup<Proposal>
}>();

const bookmarksStore = useBookmarksStore();
const userStore = useUserStore();
const {user$} = storeToRefs(userStore);
const {collections$: storeCollections$, draftBallot$} = storeToRefs(bookmarksStore);

const onLocal:Ref<boolean> = ref(false);
const inLastTenMins:Ref<boolean>= ref(false);
const collectionHash = ref(draftBallot$.value?.hash);
const pieChart = ref(null);

let rationale = ref(props.group?.rationale?.content);
let canDelete: Ref<boolean> =  ref();
let allotedBudget = computed(() => {
    return props.group?.items?.filter(
        (item) => item.model?.vote?.vote === VOTEACTIONS.UPVOTE
    ).reduce((acc, item) => ( acc + item.model.amount_requested), 0);
});

let profileQuickView = ref(null);

let handleProfileQuickView  = (user: Author) => {
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

watch([onLocal,inLastTenMins], () => {
    canDelete.value = (onLocal.value && inLastTenMins.value) || user$.value?.id === draftBallot$.value?.user_id;
});

watch(rationale, debounce(() => saveRationale(), 700));

function removeItem (id: number) {
    if (canDelete) {
        axios.delete(route('catalystExplorer.bookmarkItem.delete', {bookmarkItem: id}))
        .then((res) => {
            bookmarksStore.deleteItem( id, collectionHash.value);
            bookmarksStore.loadDraftBallot();
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
        route('catalystExplorer.draftBallot.storeRationale', {draftBallot: draftBallot$.value?.hash}),
        {rationale: rationale.value, group_id: props.group?.id, title: props.group?.title},
        {
            preserveScroll: true,
            preserveState: true,
            replace: true
        }
    );
}


function vote(vote: VOTEACTIONS, proposal: Proposal) {
    if (proposal.vote){
        router.patch(
            route('catalystExplorer.votes.update', {vote: proposal.vote.id}),
            {vote},
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: async (component) => {
                    await bookmarksStore.loadDraftBallot();
                    setTimeout(() => {
                        chartData.value = cloneDeep(getChart());
                        pieChart.value?.chart.update('active');
                    }, 100);
                }
            }
        );
    } else {
        router.post(
            route('catalystExplorer.votes.store'),
            {vote, proposal: proposal.id},
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: async (component) => {
                    await bookmarksStore.loadDraftBallot();
                    setTimeout(() => {
                        chartData.value = cloneDeep(getChart());
                        pieChart.value?.chart.update('active');
                    }, 100);
                }
            }
        );
    }

}

function getChart()
{
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
    media: {original_url: string}[]
}
</script>
