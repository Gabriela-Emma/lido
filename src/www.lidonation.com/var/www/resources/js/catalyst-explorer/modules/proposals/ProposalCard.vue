<style scoped lang="scss">
.proposal-drip {
    .drip-content p {
        @apply mt-0 inline;
        display: inline;
    }

    .drip-content img{
        display: none !important;
    }

    .drip-content strong {
        font-weight: normal !important;
    }
}
</style>
<template>
    <div class="relative w-full h-full overflow-hidden bg-white border rounded-sm border-slate-100 proposal-drip">
        <ProposalSummaryCard v-if="!quickpitch" @quickpitch="quickpitch = true" :proposal="props.proposal" />
        <ProposalQuickPitchCard v-else @summary="quickpitch = false" :proposal="props.proposal" />
    </div>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import {ComputedRef, computed, inject, ref, watch} from "vue";
import { Link } from '@inertiajs/vue3';
import { useBookmarksStore } from "../../stores/bookmarks-store";
import { storeToRefs } from "pinia";
import { Ref } from "@vue/reactivity";
import ProposalSummaryCard from "./ProposalSummaryCard.vue";
import ProposalQuickPitchCard from "./ProposalQuickPitchCard.vue";

const $utils: any = inject('$utils');
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

</script>
