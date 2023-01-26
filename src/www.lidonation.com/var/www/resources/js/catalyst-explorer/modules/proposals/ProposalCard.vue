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
        class="w-full p-4 bg-white border flex flex-col gap-3 bg-white rounded-sm w-full h-full relative proposal-drip overflow-clip">
        <header class="flex flex-col justify-center gap-y-1">
            <h2 class="flex items-start justify-between h-16">
                <span>
                    <a class="font-medium text-gray-800 text-md"
                       target="_blank"
                       :href="$utils.localizeRoute(`proposals/${proposal.slug}`)">
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
        <div class="text-sm space-y-3">
            <div class="font-normal drip-content">
                <div v-if="proposal.solution" v-html="$filters.markdown('**Solution:** ' + proposal.solution)"></div>
                <div v-else v-html="$filters.markdown('**Problem:** ' + proposal.problem)"></div>
            </div>
            <div class="flex flex-row flex-wrap gap-2 items-center">
                <div v-if="proposal.challenge_label" class="inline gap-1">
                    <strong>Challenge: </strong>
                    {{proposal.challenge_label}}
                </div>
                <div v-if="proposal.fund_label"
                     class="rounded-sm bg-slate-200 text-xs xl:text-sm text-slate-900 px-2 font-semibold py-0.5 inline gap-1">
                    {{proposal.fund_label}}
                </div>
            </div>
        </div>
        <div class="space-x-1 italic">
            <span class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm" :class="{
                'bg-teal-600': proposal.funding_status === 'funded',
                'bg-slate-500': proposal.funding_status === 'over_budget',
                'bg-slate-300': proposal.funding_status === 'not_approved',
            }">
                {{proposal.funding_status?.replace('_', ' ')}}
            </span>
<!--            @elseif(!!$proposal->funded_at)-->
<!--            <span-->
<!--                class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-teal-light-500">funded</span>-->
<!--            @elseif($proposal->funding_status == 'pending')-->
<!--            <span-->
<!--                class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-gray-600">vote pending</span>-->
<!--            @else-->
<!--            <span-->
<!--                class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm {{$proposal->funding_status == 'over_budget' ? 'bg-slate-400' : 'bg-slate-300'}}">-->
<!--            {{Str::replace('_', ' ', $proposal->funding_status)}}-->
<!--        </span>-->
<!--            @endif-->

<!--            @if($proposal->is_impact_proposal)-->
<!--            <span-->
<!--                class="inline-block px-1.5 py-0.5 font-semibold text-gray-800 text-xs rounded-sm bg-accent-500">-->
<!--        impact proposal-->
<!--    </span>-->
<!--            @endif-->

<!--            <span>{{$proposal->funded_at ? 'Awarded' : 'Requested'}} {{round((float)($proposal->amount_requested / $proposal->fund->amount) * 100, 3 ) . '%'}} of the-->
<!--    fund.</span>-->
        </div>

        <div class="relative z-0 flex flex-row-reverse mt-3 -space-x-1">
            <div class="mr-auto" v-for="(author, index) in authors">
                <a class="block" :href="author.name">
                    <img
                        v-if="index === 0"
                        class="h-10 w-10 relative -left-2 z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                        :src="author.avatar"
                        :alt="`${author.name} gravatar`" />
                    <img v-else
                        class="h-10 w-10 relative z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                         :src="author.avatar"
                         :alt="`${author.name} gravatar`" />
                </a>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import {computed} from "vue";

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

// console.log('props.proposal.users::', props.proposal.users);

// computer properties
const authors = computed(() => {
    return props.proposal.users?.reverse().map((user) => {
        return {
            ...user,
            avatar: user.media?.length > 0 ? user.media[0]?.original_url : user.profile_photo_url
        }
    })
});

</script>
