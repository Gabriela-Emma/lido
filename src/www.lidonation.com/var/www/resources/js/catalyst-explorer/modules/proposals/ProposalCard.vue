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
        class="bg-white border border-slate-100 flex flex-col divide-y bg-white rounded-sm w-full h-full relative proposal-drip overflow-clip">
        <div class="p-4 flex flex-col justify-start gap-4 h-full">
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
                        class="inline-block px-1 py-0.5 pb-2.5 text-xs xl:text-md font-semibold rounded-tl-sm rounded-bl-sm bg-accent-900">
                        {{ $filters.currency(proposal.amount_received) }}
                        <sub class="text-gray-200 block mt-0.5 italic">
                            Distributed
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
                    <div v-if="proposal.solution"
                         v-html="$filters.markdown('**Solution:** ' + proposal.solution)"></div>
                    <div v-else v-html="$filters.markdown('**Problem:** ' + proposal.problem)"></div>
                </div>
                <div class="flex flex-row flex-wrap gap-2 items-center">
                    <div v-if="proposal.challenge_label" class="inline gap-1">
                        <strong>Challenge: </strong>
                        {{ proposal.challenge_label }}
                    </div>
                    <div v-if="proposal.fund_label"
                         class="rounded-sm bg-slate-200 text-xs xl:text-sm text-slate-900 px-2 font-semibold py-0.5 inline gap-1">
                        {{ proposal.fund_label }}
                    </div>
                </div>
            </div>
            <div class="space-x-1 italic">
                <span class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm" :class="{
                    'bg-teal-600': proposal.funding_status === 'funded',
                    'bg-slate-500': proposal.funding_status === 'over_budget',
                    'bg-slate-300': proposal.funding_status === 'not_approved',
                }">
                    {{ proposal.funding_status?.replace('_', ' ') }}
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

            <div class="relative z-0 flex flex-row-reverse mt-auto -space-x-1">
                <div class="mr-auto" v-for="(author, index) in authors">
                    <a class="block" :href="author.name">
                        <img
                            v-if="index === 0"
                            class="h-10 w-10 relative -left-2 z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                            :src="author.avatar"
                            :alt="`${author.name} gravatar`"/>
                        <img v-else
                             class="h-10 w-10 relative z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                             :src="author.avatar"
                             :alt="`${author.name} gravatar`"/>
                    </a>
                </div>
            </div>
        </div>

        <footer class="mt-auto divide-y">
            <div class="-mt-px grid grid-cols-2 divide-x text-xs xl:text-sm">
                <div class="flex items-center justify-start flex-1 gap-2 p-2">
                    <div class="text-xs">
                        <a v-if="proposal.ideascale_link" :href="proposal.ideascale_link" target="_blank"
                           class="hover:cursor-pointer">
                            <img class="rounded-sm w-7 h-7"
                                 :src="$utils.assetUrl('img/ideascale-logo.png')"
                                 alt="Ideascale logo">
                        </a>
                    </div>
                    <div>
                        <a v-if="proposal.website" :href="proposal.website" target="_blank"
                           class="hover:cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="flex flex-1 w-full -ml-px">
                    <div
                        class="flex items-center justify-center flex-1 py-2 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div class="flex gap-1 items-center">
                            <div class="text-sm font-semibold">
                                {{$filters.number(proposal.ca_rating)?.toFixed(2)}}
                            </div>
                            <div>
                                <Rating :modelValue="proposal.ca_rating" :stars="5" :readonly="true" :cancel="false">
                                    <template #onicon>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                             class="w-4 h-4 text-teal-500">
                                            <path
                                                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                                        </svg>
                                    </template>
                                    <template #officon>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>

                                    </template>
                                </Rating>
                            </div>
                            <div class="text-slate-400 text-xs">
                                ({{ proposal.ratings_count }})
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="-mt-px grid grid-cols-2 divide-x text-xs xl:text-sm 2xl:text-md">
                <div class="flex items-center justify-center flex-1 gap-2 p-2">
                    <div class="text-xs">
                        Voted Yes:
                    </div>
                    <div class="font-semibold">
                        ₳{{ $filters.number(proposal.yes_votes_count) }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center gap-2 justify-center flex-1 py-2 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div class="text-xs">
                            Voted No:
                        </div>
                        <div class="font-semibold">
                            ₳{{ $filters.number(proposal.no_votes_count) }}
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import Rating from 'primevue/rating';
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
