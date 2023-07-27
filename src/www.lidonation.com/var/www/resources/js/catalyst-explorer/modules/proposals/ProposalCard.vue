<template>
    <div class="relative w-full h-full overflow-hidden bg-white border rounded-sm border-slate-100 proposal-drip">
        <ProposalUserQuickView v-if="profileQuickView"
            :profileQuickView="profileQuickView"
            @close="profileQuickView = null" />

        <ProposalQuickPitchCard v-if="(quickpitching || viewType=='quickpitch') && !!proposal.quickpitch"
            @profileQuickView="handleProfileQuickView($event)"
            @summary="quickpitching = false" :proposal="props.proposal" />

        <ProposalSummaryCard v-else
            @profileQuickView="handleProfileQuickView($event)"
            @quickpitch="quickpitching = true" :proposal="props.proposal" />
    </div>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import {ref, watch} from "vue";
import { useBookmarksStore } from "../../stores/bookmarks-store";
import { storeToRefs } from "pinia";
import { Ref } from "@vue/reactivity";
import ProposalSummaryCard from "./partials/ProposalSummaryCard.vue";
import ProposalQuickPitchCard from "./partials/ProposalQuickPitchCard.vue";
import ProposalUserQuickView from "./partials/ProposalUserQuickView.vue";
import { useProposalsStore } from "../../stores/proposals-store";

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
    }>(),
    {
        quickpitching: false,
        proposal: () => {
            return {} as Proposal;
        },
    },
);
let quickpitching = ref(props.quickpitching);

const bookmarksStore = useBookmarksStore();
const {modelIds$} = storeToRefs(bookmarksStore);

watch([viewType], (newValue, oldValue) => {
    quickpitching.value = viewType.value === 'quickpitch';
});

let profileQuickView = ref(null);
let handleProfileQuickView  = (user: Author) => {
    profileQuickView.value = user;
}
</script>
