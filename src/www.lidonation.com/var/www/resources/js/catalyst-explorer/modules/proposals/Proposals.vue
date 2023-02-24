<template>
    <div
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-3 max-w-7xl 2xl:max-w-full mx-auto">
        <template v-for="proposal in proposals">
            <ProposalCard v-if="proposal?.id" :key="proposal.id" :proposal="proposal"></ProposalCard>
        </template>
    </div>
</template>

<script lang="ts" setup>

import ProposalCard from "./ProposalCard.vue";
import Proposal from "../../models/proposal";

const props = withDefaults(
    defineProps<{
        proposals: Proposal[]
    }>(),
    {
        proposals: () => [],
    },
);

</script>
