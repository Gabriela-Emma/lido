<template>
<div class="quick-pitch-wrapper">
    <div
        class="w-full quick-pitch-video"
        id="quick-pitch-{{$proposal.id}}"
        x-ref="quickPitch"
        data-plyr-provider="youtube"
        data-plyr-embed-id="{{$proposal.quickpitch}}"></div>

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
