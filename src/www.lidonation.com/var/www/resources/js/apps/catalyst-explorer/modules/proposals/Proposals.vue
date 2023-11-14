<template>
    <div v-if="viewType === 'ranked'" class="flex flex-col gap-0.5">
        <template v-for="proposal in proposals">
            <ProposalCard v-if="proposal?.id" :key="proposal.id" :proposal="proposal"></ProposalCard>
        </template>
    </div>
    <div v-else
        class="grid grid-cols-1 gap-3 mx-auto md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 max-w-7xl 2xl:max-w-full">
        <template v-for="proposal in proposals">
            <ProposalCard v-if="proposal?.id" :key="proposal.id" :proposal="proposal"></ProposalCard>
        </template>
    </div>
</template>

<script lang="ts" setup>
import ProposalCard from "./ProposalCard.vue";
import Proposal from "../../models/proposal";
import { storeToRefs } from "pinia";
import { useProposalsStore } from "../../stores/proposals-store";

const proposalsStore = useProposalsStore();
let {viewType} = storeToRefs(proposalsStore);

withDefaults(
    defineProps<{
        proposals: Proposal[]
    }>(),
    {
        proposals: () => [],
    },
);

</script>
