<template>
    <div
        class="relative flex flex-col w-full h-full divide-y ">
        <div class="flex flex-col justify-start h-full gap-4 p-4">
            <header class="flex flex-col justify-center gap-y-1">
                <div class="relative flex justify-between gap-4">
                    <h2 class="flex items-start justify-between h-24 pr-6 xl:pr-8 overflow-clip line-clamp-3">
                        <span>
                            <a class="font-medium text-gray-800 text-md"
                               target="_blank"
                               :href="$utils.localizeRoute(`proposals/${proposal.slug}`)">
                                {{ proposal.title }}
                            </a>
                        </span>
                        <span v-if="!!proposal?.quickpitch" @click="emit('quickpitch')"
                            class="inline-flex items-center px-1 py-0.5 rounded-sm text-xs font-medium bg-primary-40 text-teal-800 ml-1 hover:cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                            Quick Pitch
                        </span>
                    </h2>

                    <div class="absolute flex flex-col gap-2 top-1 right-1">
                        <Link preserve-state preserve-scroll
                            :href="$utils.localizeRoute(`catalyst-explorer/proposals/${proposal.id}/bookmark`)" as="button"
                            :class="{
                                'bg-teal-600 hover:bg-slate-600 focus:ring-slate-300':isBookmarked,
                                'bg-slate-600 hover:bg-teal-600 focus:ring-teal-300':!isBookmarked
                            }"
                            class="inline-flex items-center rounded-md border border-transparent group p-0.5 text-sm font-medium leading-4 text-white shadow-sm focus:outline-none focus:ring-2  focus:ring-offset-2">
                            <BookmarkIcon class="w-4 h-4 "
                            :class="{
                                      'hover:text-slate-400':isBookmarked,
                                      'group-hover:text-teal-900':!isBookmarked
                                    }"
                            aria-hidden="true" />
                        </Link>

                    </div>
                </div>

                <div>
                    <ProposalBudget :proposal="proposal" />
                </div>
            </header>

            <div class="space-y-3 text-sm">
                <div class="font-normal drip-content">
                    <div v-if="proposal.solution"
                         v-html="$filters.markdown('**Solution:** ' + proposal.solution)"></div>
                    <div v-else v-html="$filters.markdown('**Problem:** ' + proposal.problem)"></div>
                </div>
                <div class="flex flex-row flex-wrap items-center gap-2 mb-2">
                    <div v-if="proposal.challenge?.label" class="inline gap-1">
                        <strong>{{  $t("Challenge") }}: </strong>
                        {{ proposal.challenge?.label }}
                    </div>
                    <div v-if="proposal.fund?.label" class="inline gap-1">
                        <strong>{{ proposal.fund?.label }}</strong>
                    </div>

                    <div class="flex items-center border rounded-sm border-slate-600">
                        <div class="py-0.5 px-1 text-xs">Funding Status</div>
                        <div class="inline-flex py-0.5 pr-0.5">
                            <ProposalFundingStatus :proposal="proposal" />
                        </div>
                    </div>

                    <div class="flex items-center border rounded-sm border-slate-600" v-if="proposal.fund?.status !== 'governance'">
                        <div class="px-1 py-0.5 text-xs">Project Status</div>
                        <div class="inline-flex py-0.5 pr-0.5">
                            <ProposalProjectStatus :proposal="proposal" />
                        </div>
                    </div>

                </div>
            </div>

            <ProposalAuthors :proposal="proposal" @profileQuickView="emit('profileQuickView', $event)"/>
        </div>

        <footer class="mt-auto divide-y">
            <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm">
                <div class="flex items-center justify-start flex-1 gap-2 p-2">
                    <div class="text-xs">
                        <a v-if="proposal?.ideascale_link" :href="proposal?.ideascale_link" target="_blank"
                           class="flex items-center gap-2 hover:cursor-pointer">
                            <img class="rounded-sm w-7 h-7"
                                 :src="$utils.assetUrl('img/ideascale-logo.png')"
                                 alt="Ideascale logo">
                                 <span class="text-xs">View on Ideascale</span>
                        </a>
                    </div>
                    <div>
                        <a v-if="proposal.website" :href="proposal.website" target="_blank"
                           class="hover:cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="relative w-full -ml-px" :class="{'hover:cursor-pointer hover:bg-teal-10': !user$}">
                    <div class="absolute top-0 left-0 w-full h-full"
                        :class="{'z-5': !user$}"
                        @click="loginUser()">
                    </div>
                    <div class="absolute top-0 left-0 flex flex-row items-center justify-center w-full h-full gap-2 px-1 py-2 rounded-sm flex-nowrap"
                    :class="{'z-5': user$}">
                        <div class="flex items-center gap-1 flex-nowrap">
                            <span>
                                Rank
                                <span>({{ ranking_total }})</span>
                            </span>
                            <div class="flex-1 w-1/2" @click.prevent="rankProposal(RANKACTIONS.THUMBSUP, props.proposal)">
                                <ChevronUpIcon :class="[rank?.rank === RANKACTIONS.THUMBSUP ? 'text-teal-light-500' : 'text-gray-400']"
                                aria-hidden="true" class="w-10 h-10 text-gray-400 hover:text-yellow-700 hover:cursor-pointer" />
                            </div>
                            <div class="flex-1 w-1/2" @click.prevent="rankProposal(RANKACTIONS.THUMBSDOWN, props.proposal)">
                                <ChevronDownIcon aria-hidden="true"
                                :class="[rank?.rank === RANKACTIONS.THUMBSDOWN ? 'text-pink-700' : 'text-gray-400']"
                                class="w-10 h-10 hover:text-yellow-700 hover:cursor-pointer" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm 2xl:text-md">
                <div class="flex items-center justify-start flex-1 gap-2 p-2">
                    <div class="text-xs">
                        {{  $t("Voted Yes") }}:
                    </div>
                    <div class="font-semibold">
                        ₳{{ $filters.shortNumber(proposal.yes_votes_count, 2) }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center gap-2 justify-end flex-1 py-2 px-1.5 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div class="text-xs">
                            {{  $t("Voted No") }}:
                        </div>
                        <div class="font-semibold">
                            ₳{{ $filters.shortNumber(proposal.no_votes_count) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm 2xl:text-md">
                <div class="flex flex-row flex-wrap items-center justify-start flex-1 gap-1 px-2 py-2" :class="{
                            'bg-teal-500': proposal.funding_status === 'funded',
                            'bg-slate-500': proposal.funding_status === 'over_budget',
                            'bg-slate-400': proposal.funding_status === 'not_approved'}">
                    <div class="text-xs text-slate-400">
                        {{  $t("Funding Status") }}:
                    </div>
                    <div class="inline-block px-1 py-0 text-xs font-semibold text-white capitalize rounded-sm">
                        {{ proposal.funding_status?.replace('_', ' ') }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center justify-end flex-1 gap-1 px-1 py-2 -mr-px text-xs font-medium text-gray-700 border border-transparent rounded-bl-sm bg-slate-200 hover:text-gray-500">
                            <span class="inline-block text-xs whitespace-nowrap">
                                Project Status:
                            </span>
                            <ProposalStatus :proposal="proposal" />
                    </div>
                </div>
            </div> -->
        </footer>
    </div>
</template>
<script lang="ts" setup>
import {inject, computed, watch, ref} from "vue";
import { router} from '@inertiajs/vue3';
import route from 'ziggy-js';
import Rating from 'primevue/rating';
import { Link } from '@inertiajs/vue3';
import {BookmarkIcon, ChevronUpIcon, ChevronDownIcon} from "@heroicons/vue/20/solid";
import { storeToRefs } from "pinia";
import Proposal from "../../../models/proposal";
import { RANKACTIONS } from '../../../models/rank-actions';
import ProposalFundingStatus from "./ProposalFundingStatus.vue"
import ProposalProjectStatus from "./ProposalProjectStatus.vue"
import ProposalBudget from "./ProposalBudget.vue";
import ProposalAuthors from "./ProposalAuthors.vue";

import { useBookmarksStore } from "../../../stores/bookmarks-store";
import {useProposalsRankingStore} from "../../../stores/proposals-ranking-store";
import { useUserStore } from "../../../../global/Shared/store/user-store";

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: {original_url: string}[]
}

const emit = defineEmits<{
    (e: 'quickpitch'): void,
    (e: 'profileQuickView', profile: Author): void,
}>();

const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        proposal: Proposal
    }>(),
    {
        proposal: () => {
            return {} as Proposal;
        },
    },
);

let ranking_total = ref(props.proposal.ranking_total);

const userStore = useUserStore();
userStore.setUser();
const {user$} = storeToRefs(userStore);

const proposalsRanking = useProposalsRankingStore();
let {ranks} = storeToRefs(proposalsRanking);
let rank = computed(() => {
    let filteredRanks = ranks.value.filter(r => r.model_id === props.proposal.id);
    return filteredRanks[0];
});

const bookmarksStore = useBookmarksStore();
const {modelIds$} = storeToRefs(bookmarksStore);

let isBookmarked  = computed<boolean>(() => modelIds$.value?.some(modelId => modelId == props.proposal.id));

function loginUser() {
    router.get(route('catalystExplorer.login.utility'));
}

async function rankProposal(rankValue: RANKACTIONS, proposal: Proposal) {
    // update ranking_total
    updateRankingTotal(rankValue)

    // store rankChoice
    await proposalsRanking.updateSaveRanking(rankValue, proposal, rank.value);
}

function updateRankingTotal(rankValue: number) {
    if(!!rank.value && rank.value.rank !== 0) {
        let change;
        if (rank.value.rank == 1) {
            change = (rankValue == 1) ? -1 : -2;
        } else if (rank.value.rank == -1) {
            change = (rankValue == -1) ? 1 : 2;
        }

        ranking_total.value = ranking_total.value + change;
    } else {
        ranking_total.value = props.proposal.ranking_total + rankValue;
    }
}
</script>
