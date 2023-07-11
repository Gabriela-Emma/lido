<template>
    <div class="relative w-full h-full overflow-hidden bg-white border rounded-sm border-slate-100 proposal-drip">
        <ProposalUserQuickView v-if="profileQuickView"
            :profileQuickView="profileQuickView"
            @close="profileQuickView = null" />

        <ProposalSummaryCard v-if="!quickpitch"
            @profileQuickView="handleProfileQuickView($event)"
            @quickpitch="quickpitch = true" :proposal="props.proposal" />

        <ProposalQuickPitchCard v-else
            @profileQuickView="handleProfileQuickView($event)"
            @summary="quickpitch = false" :proposal="props.proposal" />
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
        quickpitch?: boolean,
    }>(),
    {
        quickpitch: false,
        proposal: () => {
            return {} as Proposal;
        },
    },
);
let quickpitch = ref(props.quickpitch);

let isBookmarked:Ref<boolean> = ref()

const bookmarksStore = useBookmarksStore();
const {models: bookmarkCollectionsModels$} = storeToRefs(bookmarksStore);

watch([bookmarkCollectionsModels$], (newValue, oldValue) => {
    isBookmarked.value =  bookmarkCollectionsModels$.value?.some(model => model.id === props.proposal.id);
});

let profileQuickView = ref(null);
let handleProfileQuickView  = (user: Author) => {
    profileQuickView.value = user;
}
</script>
