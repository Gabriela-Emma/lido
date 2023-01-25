<template>
    <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-3 max-w-7xl 2xl:max-w-full mx-auto">
        <ProposalCard v-for="proposal in proposals" :proposal="proposal"></ProposalCard>
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
