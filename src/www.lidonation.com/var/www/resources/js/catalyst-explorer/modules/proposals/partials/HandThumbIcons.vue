<template>
    <div class="flex gap-1 flex-nowrap">
        <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.UPVOTE, proposal)">
            <HandThumbUpIcon :class="[proposal?.vote?.vote === VOTEACTIONS.UPVOTE ? 'text-teal-700' : 'text-gray-500']"
                aria-hidden="true" class="w-6 h-6 text-gray-500 hover:text-yellow-700 hover:cursor-pointer" />
        </div>
        <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.DOWNVOTE, proposal)">
            <HandThumbDownIcon aria-hidden="true"
                :class="[proposal?.vote?.vote === VOTEACTIONS.DOWNVOTE ? 'text-pink-800' : 'text-gray-500']"
                class="w-6 h-6 hover:text-yellow-700 hover:cursor-pointer" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { VOTEACTIONS } from '../../../models/vote-actions';
import Proposal from '../../../models/proposal'
import { HandThumbUpIcon, HandThumbDownIcon } from '@heroicons/vue/20/solid';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import route from 'ziggy-js';

const props = withDefaults(
    defineProps<{
        proposal: Proposal
    }>(), {});

const likes = ref(0);
const unlikes = ref(0);


const emit = defineEmits<{
    (e: 'new-reaction', vote): void
    (e:"reaction-update", vote)
}>();

function vote(vote: VOTEACTIONS, proposal: Proposal) {
    if (proposal.vote) {
        router.patch(
            route('catalystExplorer.votes.update', { vote: proposal.vote.id }),
            { vote },
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: async (component) => {
                    emit('reaction-update', vote);
                    // await bookmarksStore.loadDraftBallot();
                    // if (vote === VOTEACTIONS.UPVOTE) {
                    //     likes.value = likes.value === 1 ? 1 : 0;
                    //     unlikes.value = 0;
                    // } else if (vote === VOTEACTIONS.DOWNVOTE) {
                    //     unlikes.value = unlikes.value === 1 ? 1 : 0;
                    //     likes.value = 0;
                    // }
                    // setTimeout(() => {
                    //     chartData.value = cloneDeep(getChart());
                    //     pieChart.value?.chart.update('active');
                    // }, 100);
                }
            }
        );
    } else {
        router.post(
            route('catalystExplorer.votes.store'),
            { vote, proposal: proposal.id },
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: async (component) => {
                    emit('new-reaction', vote)
                    // await bookmarksStore.loadDraftBallot();
                    // setTimeout(() => {
                    //     chartData.value = cloneDeep(getChart());
                    //     pieChart.value?.chart.update('active');
                    // }, 100);
                }
            }
        );
    }

}
</script>