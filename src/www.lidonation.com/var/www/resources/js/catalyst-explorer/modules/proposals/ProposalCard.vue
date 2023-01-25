<template>
    <div class="w-full h-40 p-4 bg-white">
        <h3>{{proposal.title}}</h3>
    </div>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";


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

</script>
