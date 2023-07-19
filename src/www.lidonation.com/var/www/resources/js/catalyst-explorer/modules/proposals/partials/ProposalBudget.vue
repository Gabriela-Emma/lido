<template>
    <div class="flex flex-col gap-2">
        <div class="grid flex-1 h-3 rounded-md bg-slate-400 grid-cols-100">
            <div class="h-3 p-1 text-xs font-semibold bg-teal-600 rounded-l-md text-teal-light-800"
                :style="{  gridColumn: `span ${Math.ceil(challengePercentage)} / span ${Math.ceil(challengePercentage)}`, }"></div>
        </div>
        <div class="flex justify-between gap-4 text-sm flex-nowrap">
            <div class="flex items-center gap-2">
                <span>
                    Budget
                </span>
                <span class="font-bold text-md xl:text-lg">
                    {{ $filters.currency(proposal.amount_requested, proposal.currency) }} ({{ challengePercentage.toFixed(2) }}%)
                </span>
            </div>
            <div class="flex gap-2">
                <span>Pot</span>
                <span>
                    {{ $filters.currency(proposal.challenge?.amount, proposal?.currency) }}
                </span>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Proposal from "../../../models/proposal";
import { ComputedRef, computed } from "vue";

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

const challengePercentage: ComputedRef<number> = computed(
    () =>
        ( (props.proposal?.amount_requested / props.proposal?.challenge?.amount) * 100 ) ?? 0
);

</script>
