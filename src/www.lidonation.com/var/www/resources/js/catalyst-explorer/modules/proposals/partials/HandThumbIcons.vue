<template>
    <div class="flex flex-col flex-none w-16 gap-2 px-1 py-2 rounded-sm" :class="{
        'bg-teal-light-100/50': proposal.vote?.vote === VOTEACTIONS.UPVOTE,
        'bg-red-100/80': proposal.vote?.vote === VOTEACTIONS.DOWNVOTE,
        'bg-slate-100': !proposal.vote
    }">
        <div class="flex gap-1 flex-nowrap">
            <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.UPVOTE, proposal)">
                <HandThumbUpIcon :class="[proposal.vote?.vote === VOTEACTIONS.UPVOTE ? 'text-teal-700' : 'text-gray-500']"
                    aria-hidden="true" class="w-6 h-6 text-gray-500 hover:text-yellow-700 hover:cursor-pointer" />
            </div>
            <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.DOWNVOTE, proposal)">
                <HandThumbDownIcon aria-hidden="true"
                    :class="[proposal?.vote?.vote === VOTEACTIONS.DOWNVOTE ? 'text-pink-800' : 'text-gray-500']"
                    class="w-6 h-6 hover:text-yellow-700 hover:cursor-pointer" />
            </div>
        </div>
        <slot></slot>
    </div>
</template>

<script lang="ts" setup>
import { VOTEACTIONS } from '../../../models/vote-actions';
import Proposal from '../../../models/proposal'
import { HandThumbUpIcon, HandThumbDownIcon } from '@heroicons/vue/20/solid';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import route from 'ziggy-js';
import axios from 'axios';
import ProposalAddGitRepo from '../ProposalAddGitRepo.vue';

const props = withDefaults(
    defineProps<{
        proposal: Proposal
    }>(), {});


let proposal = ref(props.proposal);
const emit = defineEmits<{
    (e: 'new-reaction', vote): void
    (e: "reaction-update", vote)
}>();


if (!proposal.value?.vote) {
    axios.get(route('catalystExplorer.votes.index', { proposal: props.proposal.id }), {})
        .then((res) => {
            proposal.value['vote'] = ref(res.data)
        });
}


function vote(vote: VOTEACTIONS, proposal: Proposal) {
    if (proposal.vote) {
        router.patch(
            route('catalystExplorer.votes.update', { vote: proposal.vote }),
            { vote },
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: async (component) => {
                    emit('reaction-update', vote);


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

                }
            }
        );
    }

}
</script>