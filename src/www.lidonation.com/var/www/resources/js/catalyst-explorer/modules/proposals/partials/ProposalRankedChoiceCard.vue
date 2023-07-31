<template>
<div class="flex flex-row w-full gap-2 py-1">
    <div class="relative flex flex-col items-center w-12 gap-1 px-1 py-1 h-30" :class="{'hover:cursor-pointer hover:bg-teal-10': !user$}">
        <div class="absolute top-0 left-0 w-full h-full"
            :class="{'z-5': !user$}" @click="loginUser()">
        </div>
        <div class="absolute top-0 left-0 flex flex-col items-center justify-center w-full h-full gap-1 rounded-r-sm"
        :class="{'z-5': user$}">
            <div class="text-center" @click="rankProposal(RANKACTIONS.THUMBSUP, props.proposal)">
                <ChevronUpIcon :class="[rank?.rank === RANKACTIONS.THUMBSUP ? 'text-teal-light-500' : 'text-gray-400']"
                    aria-hidden="true" class="w-10 h-8 text-gray-400 hover:text-yellow-700 hover:cursor-pointer" />
            </div>
            <div class="text-lg text-center">
                {{ proposal.ranking_total ?? 0 }}
            </div>
            <div class="text-center" @click="rankProposal(RANKACTIONS.THUMBSDOWN, props.proposal)">
                <ChevronDownIcon aria-hidden="true"
                    :class="[rank?.rank === RANKACTIONS.THUMBSDOWN ? 'text-pink-700' : 'text-gray-400']"
                    class="w-10 h-8 hover:text-yellow-700 hover:cursor-pointer" />
            </div>
        </div>
    </div>

    <div class="flex flex-col w-full gap-1 pr-4">
        <div class="w-full">
            <h2 class="w-full">
                <span>
                    <a class="font-medium text-gray-800 text-md"
                        target="_blank"
                        :href="$utils.localizeRoute(`proposals/${proposal.slug}`)">
                        {{ proposal.title }}
                    </a>
                </span>
            </h2>
            <div class="w-full space-y-3 text-sm">
                <div class="text-base font-normal drip-content">
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
        </div>
        <div class="relative w-full mt-2">
            <ProposalBudget v-if="proposal" :proposal="proposal" />
        </div>

         <!-- <ProposalAuthors :proposal="proposal" @profileQuickView="emit('profileQuickView', $event)"/> -->

    <!-- <div class='absolute right-0 -bottom-1 details-toggle-wrapper'>
        <button type="button"
            @click="emit('summary')"
            class="inline-flex items-center px-5 py-3 border border-transparent shadow-sm shadow-inner text-sm leading-4 font-medium rounded-sm rounded-tl-[6rem] rounded-bl-[3rem] rounded-tr-[12rem] text-slate-600 bg-slate-200 hover:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-400">
            Details
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-3 ml-2 w-3s">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
            </svg>
        </button>
    </div> -->
    </div>
</div>

</template>
<script lang="ts" setup>
import { computed, inject, ref } from "vue";
import Proposal from "../../../models/proposal";
import ProposalBudget from "./ProposalBudget.vue";
import ProposalAuthors from "./ProposalAuthors.vue";
import { ChevronDownIcon, ChevronUpIcon } from "@heroicons/vue/20/solid";
import { storeToRefs } from "pinia";
import { useProposalsRankingStore } from "../../../stores/proposals-ranking-store";
import { RANKACTIONS } from "../../../models/rank-actions";
import { router } from "@inertiajs/vue3";
import route from "ziggy-js";
import { useUserStore } from "../../../../global/Shared/store/user-store";
import ProposalFundingStatus from "./ProposalFundingStatus.vue";
import ProposalProjectStatus from "./ProposalProjectStatus.vue";

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

const emit = defineEmits<{
    (e: 'summary'): void,
    (e: 'profileQuickView', profile: Author): void,
}>();

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: {original_url: string}[]
}

const regex: RegExp = /[a-zA-Z]/g;
const quickPitchId = props.proposal?.quickpitch;
const quickpitchProvider = computed(() => quickPitchId.match(regex) ? "youtube" : "vimeo" );

const proposalsRanking = useProposalsRankingStore();
let {ranks} = storeToRefs(proposalsRanking);
let rank = computed(() => {
    let filteredRanks = ranks.value.filter(r => r.model_id === props.proposal.id);
    return filteredRanks[0];
});

const userStore = useUserStore();
userStore.setUser();
const {user$} = storeToRefs(userStore);

function loginUser() {
    router.get(route('catalystExplorer.login.utility'));
}

function rankProposal(rankValue: RANKACTIONS, proposal: Proposal) {
    if (rank?.value?.model_id == proposal.id){
        router.patch(
            route('catalystExplorer.ranks.update', {rank: rank.value.id}),
            {rankValue},
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: async (component) => {
                    await proposalsRanking.loadRankings(user$.value.id);
                }
            }
        );
    } else {
        router.post(
            route('catalystExplorer.ranks.store'),
            {rankValue, proposal: proposal.id},
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: async (component) => {
                    await proposalsRanking.loadRankings(user$.value.id);
                }
            }
        );
    }

}
</script>
