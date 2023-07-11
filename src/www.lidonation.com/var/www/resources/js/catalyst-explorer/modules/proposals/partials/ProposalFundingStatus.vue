<template>
    <span class="w-full h-full space-x-1 italic">
        <span v-if="proposal.funding_status == 'complete'"
            class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-pink-400">fully paid</span>
        <span v-else-if="proposal.funding_status == 'pending'"
            class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-gray-600">vote pending</span>
        <span v-else-if="proposal.funding_status == 'funded'"
            class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-gray-600">funded</span>
        <span v-else class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-slate-400">
            Unfunded
        </span>
    </span>
</template>

<script lang="ts" setup>
import Proposal from '../../../models/proposal';

defineProps<{
    proposal: Proposal
}>()
</script>
