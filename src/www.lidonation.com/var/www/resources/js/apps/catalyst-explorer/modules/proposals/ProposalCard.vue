<template>
    <div class="relative w-full h-full overflow-hidden bg-white border rounded-sm border-slate-100 proposal-drip">
        <ProposalUserQuickView v-if="profileQuickView"
            :profileQuickView="profileQuickView"
            @close="profileQuickView = null" />

        <ProposalQuickPitchCard v-if="(quickpitching || (viewType=='quickpitch' && showWithStore)) && !!proposal.quickpitch"
            @profileQuickView="handleProfileQuickView($event)"
            @summary="changeCardMode" :proposal="props.proposal" />

        <ProposalRankedChoiceCard v-else-if="viewType=='ranked' && showRankedCard"
            @profileQuickView="handleProfileQuickView($event)"
            :proposal="props.proposal" />

        <ProposalSummaryCard v-else
            @profileQuickView="handleProfileQuickView($event)"
            @quickpitch="quickpitching = true" :proposal="props.proposal" />
    </div>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import {ref, watch} from "vue";
import {useBookmarksStore} from "@apps/catalyst-explorer/stores/bookmarks-store";
import { storeToRefs } from "pinia";
import { Ref } from "@vue/reactivity";
import ProposalSummaryCard from "./partials/ProposalSummaryCard.vue";
import ProposalQuickPitchCard from "./partials/ProposalQuickPitchCard.vue";
import ProposalUserQuickView from "./partials/ProposalUserQuickView.vue";
import { useProposalsStore } from "../../stores/proposals-store";
import ProposalRankedChoiceCard from "./partials/ProposalRankedChoiceCard.vue";

const proposalsStore = useProposalsStore();
let {viewType} = storeToRefs(proposalsStore);

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: {original_url: string}[]
}

const props = withDefaults(
    defineProps<{
        proposal: Proposal,
        quickpitching?: boolean,
        showRankedCard: boolean,
    }>(),
    {
        quickpitching: false,
        proposal: () => {
            return {} as Proposal;
        },
        showRankedCard: true,
    },
);
let quickpitching = ref(props.quickpitching);
let showWithStore = ref(true);
let changeCardMode = () => {
    quickpitching.value = false;
    showWithStore.value = false;

}

const bookmarksStore = useBookmarksStore();
const {modelIds$} = storeToRefs(bookmarksStore);

watch([viewType], (newValue, oldValue) => {
    quickpitching.value = viewType.value === 'quickpitch';
    viewType.value === 'quickpitch' ? showWithStore.value = true : showWithStore.value = false;

});

let profileQuickView = ref(null);
let handleProfileQuickView  = (user: Author) => {
    profileQuickView.value = user;
}
</script>
