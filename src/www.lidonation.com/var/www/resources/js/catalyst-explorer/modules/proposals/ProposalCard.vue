<style scoped lang="scss">
    .proposal-drip {
        .drip-content p {
            @apply mt-0 inline;
            display: inline;
        }
    }
</style>
<template>
    <div
        class="w-full p-4 bg-white border flex flex-col bg-white rounded-sm w-full h-full relative proposal-drip overflow-clip">
        <header class="flex flex-col justify-center gap-y-1">
            <h2 class="flex items-start justify-between h-16">
                <span>
                    <a class="font-medium text-gray-800 text-md"
                       target="_blank"
                       :href="proposal.title">
                        {{ proposal.title }}
                    </a>
                </span>
            </h2>
            <div class="flex flex-row flex-nowrap mb-2 text-white">

                <div
                    v-if="proposal.amount_received > 0.00"
                    class="inline-block px-1 py-0.5 pb-2.5 text-xs xl:text-sm font-semibold rounded-tl-sm rounded-bl-sm bg-accent-900">
                    {{ $filters.currency(proposal.amount_received) }}
                    <sub class="text-gray-200 block mt-0.5 italic">
                        Received
                    </sub>
                </div>

                <div
                    class="inline-block px-1 py-0.5 pb-2.5 text-xs xl:text-sm font-semibold rounded-tr-sm rounded-br-2m bg-teal-800">
                    {{ $filters.currency(proposal.amount_requested) }}
                    <sub class="text-gray-200 block mt-0.5 italic">
                        Requested
                    </sub>
                </div>
            </div>
        </header>
        <div class="text-sm">
            <div class="max-w-lg font-norma drip-content">
                <div v-if="proposal.solution" v-html="$filters.markdown('**Solution:** ' + proposal.solution)"></div>
                <div v-else v-html="$filters.markdown('**Problem:** ' + proposal.problem)"></div>
            </div>
        </div>
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

// computer properties
// const markdownToHtml = computed(() => {
//     return marked(this.markdown);
// });

</script>
