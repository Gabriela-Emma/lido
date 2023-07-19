<template>
    <div
        class="relative flex flex-col w-full h-full divide-y ">
        <div class="flex flex-col justify-start h-full gap-4 p-4">
            <header class="flex flex-col justify-center gap-y-1">
                <div class="relative flex justify-between gap-4">
                    <h2 class="flex items-start justify-between h-24 pr-6 xl:pr-8 overflow-clip line-clamp-3">
                        <span>
                            <a class="font-medium text-gray-800 text-md"
                               target="_blank"
                               :href="$utils.localizeRoute(`proposals/${proposal.slug}`)">
                                {{ proposal.title }}
                            </a>
                        </span>
                        <span v-if="!!proposal?.quickpitch" @click="emit('quickpitch')"
                            class="inline-flex items-center px-1 py-0.5 rounded-sm text-xs font-medium bg-primary-40 text-teal-800 ml-1 hover:cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                            Quick Pitch
                        </span>
                    </h2>

                    <div class="absolute flex flex-col gap-2 top-1 right-1">
                        <Link preserve-state preserve-scroll
                            :href="$utils.localizeRoute(`catalyst-explorer/proposals/${proposal.id}/bookmark`)" as="button"
                            :class="{
                                'bg-teal-600 hover:bg-slate-600 focus:ring-slate-300':isBookmarked,
                                'bg-slate-600 hover:bg-teal-600 focus:ring-teal-300':!isBookmarked
                            }"
                            class="inline-flex items-center rounded-md border border-transparent group p-0.5 text-sm font-medium leading-4 text-white shadow-sm focus:outline-none focus:ring-2  focus:ring-offset-2">
                            <BookmarkIcon class="w-4 h-4 "
                            :class="{
                                      'hover:text-slate-400':isBookmarked,
                                      'group-hover:text-teal-900':!isBookmarked
                                    }"
                            aria-hidden="true" />
                        </Link>

                    </div>
                </div>

                <div>
                    <ProposalBudget :proposal="proposal" />
                </div>
            </header>

            <div class="space-y-3 text-sm">
                <div class="font-normal drip-content">
                    <div v-if="proposal.solution"
                         v-html="$filters.markdown('**Solution:** ' + proposal.solution)"></div>
                    <div v-else v-html="$filters.markdown('**Problem:** ' + proposal.problem)"></div>
                </div>
                <div class="flex flex-row flex-wrap items-center gap-2 mb-2">
                    <div v-if="proposal.challenge?.label" class="inline gap-1">
                        <strong>{{  $t("Challenge") }}: </strong>
                        {{ proposal.challenge?.label }}
                    </div>
                    <div v-if="proposal.fund?.label" class="inline gap-1">
                        <strong>{{ proposal.fund?.label }}</strong>
                    </div>

                    <div class="flex items-center border rounded-sm border-slate-600">
                        <div class="py-0.5 px-1 text-xs">Funding Status</div>
                        <div class="inline-flex py-0.5 pr-0.5">
                            <ProposalFundingStatus :proposal="proposal" />
                        </div>
                    </div>

                    <div class="flex items-center border rounded-sm border-slate-600" v-if="proposal.fund?.status !== 'governance'">
                        <div class="px-1 py-0.5 text-xs">Project Status</div>
                        <div class="inline-flex py-0.5 pr-0.5">
                            <ProposalProjectStatus :proposal="proposal" />
                        </div>
                    </div>

                </div>
            </div>

            <ProposalAuthors :proposal="proposal" @profileQuickView="emit('profileQuickView', $event)"/>
        </div>

        <footer class="mt-auto divide-y">
            <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm">
                <div class="flex items-center justify-start flex-1 gap-2 p-2">
                    <div class="text-xs">
                        <a v-if="proposal?.ideascale_link" :href="proposal?.ideascale_link" target="_blank"
                           class="flex items-center gap-2 hover:cursor-pointer">
                            <img class="rounded-sm w-7 h-7"
                                 :src="$utils.assetUrl('img/ideascale-logo.png')"
                                 alt="Ideascale logo">
                                 <span class="text-xs">View on Ideascale</span>
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

                <div class="flex justify-end flex-1 w-full -ml-px">
                    <div
                        class="flex items-center justify-center flex-1 py-2 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div class="flex items-center gap-1">
                            <div class="text-sm font-semibold">
                                {{ $filters.shortNumber(proposal.ca_rating)?.toFixed(2) }}
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
                            <div class="text-xs text-slate-400">
                                ({{ proposal.ratings_count }})
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm 2xl:text-md">
                <div class="flex items-center justify-start flex-1 gap-2 p-2">
                    <div class="text-xs">
                        {{  $t("Voted Yes") }}:
                    </div>
                    <div class="font-semibold">
                        ₳{{ $filters.shortNumber(proposal.yes_votes_count, 2) }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center gap-2 justify-end flex-1 py-2 px-1.5 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div class="text-xs">
                            {{  $t("Voted No") }}:
                        </div>
                        <div class="font-semibold">
                            ₳{{ $filters.shortNumber(proposal.no_votes_count) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm 2xl:text-md">
                <div class="flex flex-row flex-wrap items-center justify-start flex-1 gap-1 px-2 py-2" :class="{
                            'bg-teal-500': proposal.funding_status === 'funded',
                            'bg-slate-500': proposal.funding_status === 'over_budget',
                            'bg-slate-400': proposal.funding_status === 'not_approved'}">
                    <div class="text-xs text-slate-400">
                        {{  $t("Funding Status") }}:
                    </div>
                    <div class="inline-block px-1 py-0 text-xs font-semibold text-white capitalize rounded-sm">
                        {{ proposal.funding_status?.replace('_', ' ') }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center justify-end flex-1 gap-1 px-1 py-2 -mr-px text-xs font-medium text-gray-700 border border-transparent rounded-bl-sm bg-slate-200 hover:text-gray-500">
                            <span class="inline-block text-xs whitespace-nowrap">
                                Project Status:
                            </span>
                            <ProposalStatus :proposal="proposal" />
                    </div>
                </div>
            </div> -->
        </footer>
    </div>
</template>
<script lang="ts" setup>
import Proposal from "../../../models/proposal";
import Rating from 'primevue/rating';
import {inject, computed, watch} from "vue";
import {BookmarkIcon} from "@heroicons/vue/20/solid";
import { Link } from '@inertiajs/vue3';
import { useBookmarksStore } from "../../../stores/bookmarks-store";
import { storeToRefs } from "pinia";
import ProposalFundingStatus from "./ProposalFundingStatus.vue"
import ProposalProjectStatus from "./ProposalProjectStatus.vue"
import ProposalBudget from "./ProposalBudget.vue";
import ProposalAuthors from "./ProposalAuthors.vue";

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: {original_url: string}[]
}

const emit = defineEmits<{
    (e: 'quickpitch'): void,
    (e: 'profileQuickView', profile: Author): void,
}>();

const $utils: any = inject('$utils');
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

const bookmarksStore = useBookmarksStore();
const {modelIds$} = storeToRefs(bookmarksStore);

let isBookmarked  = computed<boolean>(() => modelIds$.value?.some(modelId => modelId == props.proposal.id));
</script>
